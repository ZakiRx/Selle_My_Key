<?php


namespace App\EventListener;


use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{

    private UserRepository $userRepository;

    public function __construct(UserRepository  $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }
        $data['data'] = array(
            'userId' => $this->userRepository->findOneBy(["username"=>$user->getUsername()])->getId(),
        );

        $event->setData($data);
    }
}