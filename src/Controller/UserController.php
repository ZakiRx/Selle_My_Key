<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWSProvider\JWSProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController
{
    private Security $security;
    private UserRepository $userRepository;
    private JWTEncoderInterface $JWTEncoder;
    private JWSProviderInterface $JWSProvider;
    private TokenStorageInterface $tokenStorage;

    public function __construct(Security $security,UserRepository $userRepository,JWTEncoderInterface  $JWTEncoder,JWSProviderInterface  $JWSProvider,TokenStorageInterface $tokenStorage )
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->JWTEncoder = $JWTEncoder;
        $this->JWSProvider = $JWSProvider;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(): ?User
    {
        return  $this->userRepository->findOneBy(["username"=>$this->security->getUser()->getUsername()]);
    }
}
