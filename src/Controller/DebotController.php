<?php


namespace App\Controller;


use App\Entity\Debot;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class DebotController
{
    /**
     * @var Security
     */
    private Security $security;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    public function __construct(Security $security,UserRepository $userRepository)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request)
    {
        $debot=$request->attributes->get('data');
        if($debot instanceof  Debot){
            if($debot->getResult()=="succeeded"){
                $user= $this->userRepository->findOneBy(["username"=>$this->security->getUser()->getUsername()]);
                $user->setBalance($user->getBalance()+$debot->getBalance());
                return new Response(json_encode(['message' => "Payment succeeded "]), 200);
            }
            return new Response(json_encode(['message' => "Payment failed "]), 400);
        }
        else{
            return new Response(json_encode(['message' => "Somthing not right  "]), 400);
        }

    }
}