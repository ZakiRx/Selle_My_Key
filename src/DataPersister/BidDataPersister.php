<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Bid;
use App\Repository\BidRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


class BidDataPersister implements ContextAwareDataPersisterInterface
{

    private BidRepository $bidRepository;
    private EntityManagerInterface $entityManager;

    public  function __construct(BidRepository  $bidRepository,EntityManagerInterface $entityManager)
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
        if($data->getUser()==$data->getProduct()->getSeller()){
            return new Response(json_encode(['message'=>"Operation Not Possible"]),401);
        }
        if($data->getPrice()>$data->getProduct()->getCrrentPrice()){

               $data->getProduct()->setCrrentPrice($data->getPrice());
                $this->entityManager->persist($data);
                $this->entityManager->flush();
                return new Response(json_encode(['message'=>"Bid Has Been Added"]),201);
        }
       return new Response( json_encode(['message'=>"Bid must be over than  ".$data->getProduct()->getCrrentPrice()]),406);
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}