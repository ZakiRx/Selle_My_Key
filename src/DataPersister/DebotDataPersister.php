<?php

namespace App\DataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Debot;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;


class DebotDataPersister implements  ContextAwareDataPersisterInterface
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

    public function supports($data, array $context = []): bool
    {
        return  $data instanceof  Debot;
    }

    public function persist($data, array $context = [])
    {
        if($data->getResult()=="succeeded"){
           $user= $this->userRepository->findOneBy(["username"=>$this->security->getUser()->getUsername()]);
           $user->setBalance($user->getBalance()+$data->getBalance());
            return new Response(json_encode(['message' => "Payment succeeded "]), 200);
        }
        return new Response(json_encode(['message' => "Payment failed "]), 400);

    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}