<?php


namespace App\Controller;


use App\Entity\Secret;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostSecretController
{
    public function __invoke(Request $request):Response
    {
        $secret=$request->attributes->get('data');
        if($secret instanceof Secret){
            Stripe::setApiKey('sk_test_51J2IzxCCXlvNqL8W6vuylPvxs8m24QR7J29yWtvX1zTTP0Pek1IyHa4DSxUQvuhMDIdr5etOKWLYTaGa1Hn9gigt00vzlfydNn');
            $intent = PaymentIntent::create([
                'amount' => $secret->getAmount(),
                'currency' => 'usd',
                // Verify your integration in this guide by including this parameter
                'metadata' => ['integration_check' => 'accept_a_payment'],
            ]);

            return new Response(json_encode(['secret' =>  $intent->client_secret]), 200);
        }
        else{
           return new Response(json_encode(['error' =>  "something not right"]), 400);
        }

    }

}