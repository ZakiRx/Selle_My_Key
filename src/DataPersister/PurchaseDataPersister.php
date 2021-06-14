<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Order;
use App\Entity\Purchase;

class PurchaseDataPersister implements ContextAwareDataPersisterInterface
{

    public function supports($data, array $context = []): bool
    {
        return  $data instanceof  Purchase;
    }

    public function persist($data, array $context = [])
    {
        $order = new Order();
        $order->setCreatedAt(new \DateTime('now'));
        $order->setSeller($data->getBid()->getSeller());
        $order->setStatus("confirme");
        $order->setPurchase($data);
        dd($order);

    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}