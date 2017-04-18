<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userAdmin = $this->createActiveUser('admin', 'admin', ['ROLE_ADMIN']);
        $userModerator = $this->createActiveUser('moderator', 'moderator', ['ROLE_MOD']);
        $userKornelijus = $this->createActiveUser('user', 'user');

        $manager->persist($userAdmin);
        $manager->persist($userModerator);
        $manager->persist($userKornelijus);

        $manager->flush();
    }

    private function createActiveUser($username, $plainPassword, $roles = ['ROLE_USER']):User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setRoles($roles);
        $user->setFrozen(false);
        $user->setPublic(true);

        $encodedPassword = $this->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);

        return $user;
    }

    private function encodePassword($user, $plainPassword):string
    {

        $encoder = $this->container->get('security.password_encoder');
        $encodedPassword = $encoder->encodePassword($user, $plainPassword);

        return $encodedPassword;
    }
}