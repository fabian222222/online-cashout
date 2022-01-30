<?php 

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class Register implements ContextAwareDataPersisterInterface
{

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
    }

    public function supports($data, array $context = []):bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        $this->hashPassword($data);
        $this->em->persist($data);
        $this->em->flush();

        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->em->remove($data);
        $this->em->flush();

    }

    public function hashPassword(User $user){
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
    }
}

?>