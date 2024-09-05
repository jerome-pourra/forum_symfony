<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {

        $list = $this->loadJson('users.json');

        foreach ($list as $item) {
            $user = new User();
            $user->setName($item['name']);
            $user->setRole($item['role']);
            // TODO : set subjets and messages
            // $user->setSubjets(new ArrayCollection());
            // $user->setMessages(new ArrayCollection());
            $manager->persist($user);
        }

        $manager->flush();

    }
}