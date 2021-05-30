<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{

    /**
     * @Route(path="/api/login",name="login",methods={"POST"})
     */
    public function  login(Request  $request):JsonResponse{
        $user=$this->getUser();
        return $this->json(array(
            "username"=>$user->getUsername(),
            "roles"=>$user->getRoles()
        ));
    }
}