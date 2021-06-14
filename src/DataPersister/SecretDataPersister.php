<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Secret;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class SecretDataPersister implements  ContextAwareDataPersisterInterface
{

    public function supports($data, array $context = []): bool
    {
        return  $data instanceof  Secret;
    }

    public function persist($data, array $context = [])
    {
        Stripe::setApiKey('sk_test_51J2IzxCCXlvNqL8W6vuylPvxs8m24QR7J29yWtvX1zTTP0Pek1IyHa4DSxUQvuhMDIdr5etOKWLYTaGa1Hn9gigt00vzlfydNn');
        $intent = PaymentIntent::create([
            'amount' => $data->getAmount(),
            'currency' => 'usd',
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);
        return json_encode(array('client_secret' => $intent->client_secret));
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}