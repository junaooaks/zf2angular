<?php

namespace User\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;

use User\Entity\Users;

class LoadUser extends AbstractFixture{
    
    public function load(ObjectManager $manager) {
        
        $user = new Users();
        
        $user->setNome("junior oaks")
             ->setEmail("junaooaks@gmail.com")
             ->setPassword(123456)
             ->setActive(true);
        
        $manager->persist($user);
        $manager->flush();
        
    }
}
