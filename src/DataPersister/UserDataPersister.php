<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private UserPasswordEncoderInterface $encoder;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordEncoderInterface $encoder,EntityManagerInterface  $entityManager)
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
    }

    public function supports($data, array $context = []): bool
    {
        return  $data instanceof  User;
    }

    public function persist($data, array $context = [])
    {
        if($data->getPassword()){
            $data->setPassword(
                $this->encoder->encodePassword($data,$data->getPassword())
            );
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }
    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}