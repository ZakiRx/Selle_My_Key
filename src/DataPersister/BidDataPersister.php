<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Bid;
use App\Entity\User;
use App\Repository\BidRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


class BidDataPersister implements ContextAwareDataPersisterInterface
{

    private BidRepository $bidRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(BidRepository $bidRepository, EntityManagerInterface $entityManager)
    {
        $this->bidRepository = $bidRepository;
        $this->entityManager = $entityManager;

    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Bid;
    }

    public function persist($data, array $context = [])
    {
       if($this->isOfferExpired($data)){
           return new Response(json_encode(['message' => "Offer Ended"]), 401);
       }
       if( $this->checkOwnerIsBuyer($data)){
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
            return new Response(json_encode(['message' => "Bid Has Been Added"]), 201);
        }
        return new Response(json_encode(['message' => "Your Balance less than : " . $data->getPrice()]), 406);
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