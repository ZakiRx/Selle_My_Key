<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Order;
use App\Entity\Purchase;
use Doctrine\ORM\EntityManagerInterface;

class PurchaseDataPersister implements ContextAwareDataPersisterInterface
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    public function supports($data, array $context = []): bool
    {
        return  $data instanceof  Purchase;
    }

    public function persist($data, array $context = [])
    {
        $data->setUpdatedAt(new \DateTime('now'));
        $data->setCreatedAt(new \DateTime('now'));

        $order = new Order();
        $order->setCreatedAt(new \DateTime('now'));
        $order->setSeller($data->getBid()->getProduct()->getSeller());
        $order->setStatus("confirme");
        $this->entityManager->persist($data);
        $order->setPurchase($data);
        $this->entityManager->persist($order);
        $this->entityManager->flush();



    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}