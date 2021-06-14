<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Bid;
use App\Entity\User;
use App\Repository\BidRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pusher\Pusher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;


class BidDataPersister implements ContextAwareDataPersisterInterface
{

    private BidRepository $bidRepository;
    private EntityManagerInterface $entityManager;
    private Security $security;
    private Pusher $pusher;

    public function __construct(BidRepository $bidRepository, EntityManagerInterface $entityManager, Security $security, Pusher $pusher)
    {
        $this->bidRepository = $bidRepository;
        $this->entityManager = $entityManager;

        $this->security = $security;
        $this->pusher = $pusher;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Bid;
    }

    public function persist($data, array $context = []): Response
    {
        if ($this->checkUser($data)) {
            if ($this->isOfferExpired($data)) {
                return new Response(json_encode(['message' => "Offer Ended"]), 401);
            }
            if ($this->checkOwnerIsBuyer($data)) {
                return new Response(json_encode(['message' => "Operation Not Possible"]), 401);
            }
            if ($data->getPrice() > $data->getProduct()->getCurrentPrice() + $data->getProduct()->getMaxBidPrice() ||
                $data->getPrice() < $data->getProduct()->getCurrentPrice() + $data->getProduct()->getMinBidPrice()) {
                return new Response(json_encode(['message' => "Bid price must be enter  " . ($data->getProduct()->getCurrentPrice() + $data->getProduct()->getMinBidPrice()) .
                    " And " . ($data->getProduct()->getCurrentPrice() + $data->getProduct()->getMaxBidPrice())]), 406);
            }
            if ($data->getUser()->getBalance() >= $data->getPrice()) {
                $this->returnMoney($data);
                $data->getUser()->setBalance(($data->getUser()->getBalance() - $data->getPrice()));
                $data->getProduct()->setCurrentPrice($data->getPrice());
                $this->entityManager->persist($data);
                $this->entityManager->flush();
                $pushuerData['username'] = $data->getUser()->getUsername();
                $pushuerData['price'] = $data->getPrice();
                $this->pusher->trigger('channel-bid', 'bid-add', $pushuerData);
                return new Response(json_encode(['message' => "Bid Has Been Added"]), 201);
            }
            return new Response(json_encode(['message' => "Your Balance less than : " . $data->getPrice()]), 406);
        } else {
            return new Response(json_encode(['message' => "this operation Not available!!"]), 401);
        }

    }

    public function checkUser($data): bool
    {
        if ($data->getUser() == $this->security->getUser()) {
            return true;
        }
        return false;
    }

    public function isOfferExpired($data): bool
    {
        if (new \DateTime('now') > $data->getProduct()->getEndedAt()) {
            return true;
        }
        return false;
    }

    public function checkOwnerIsBuyer($data): bool
    {
        if ($data->getUser() == $data->getProduct()->getSeller()) {
            return true;
        }
        return false;
    }


    public function returnMoney($data)
    {
        $prevBid = $data->getProduct()->getBids()[count($data->getProduct()->getBids()) - 1];
        $user = $data->getUser();
        if ($prevBid != null && $user != $prevBid->getUser()) {
            $this->returnMoneyToPrevUser($prevBid->getUser(), $data->getProduct());
        } else {
            $balancePrevUser = $user->getBalance();
            $lastBidSpent = 0;
            if (sizeof($user->getBids()) > 0) {
                foreach ($user->getBids() as $bid) {
                    if ($bid->getProduct() == $data->getProduct()) {
                        $lastBidSpent = $bid->getPrice();
                    }
                }
                $user->setBalance($balancePrevUser + $lastBidSpent);
            }
        }

    }

    public function returnMoneyToPrevUser($prevUser, $product)
    {
        $lastBidSpent = 0;
        if (sizeof($prevUser->getBids()) > 0) {
            foreach ($prevUser->getBids() as $bid) {
                if ($bid->getProduct() == $product) {
                    $lastBidSpent = $bid->getPrice();
                }
            }
            $prevUser->setBalance($prevUser->getBalance() + $lastBidSpent);
        }
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}