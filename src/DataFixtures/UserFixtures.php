<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractFixtures
{

    private const JSON_FILENAME = 'users.json';

    public function loadDummy(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < 100; $i++) {

            $entity = new User();
            $entity->setName("User $i");
            $entity->setRole("ROLE_USER");

            $manager->persist($entity);
            $this->addReference(User::class . "_" . $i, $entity);
        }

        $manager->flush();

    }

    public function loadDemo(ObjectManager $manager): void
    {
        $list = $this->loadJson(self::JSON_FILENAME);

        foreach ($list as $i => $item) {

            $entity = new User();
            $entity->setName($item['name']);
            $entity->setRole($item['role']);

            $manager->persist($entity);
            $this->addReference(User::class . "_" . $i, $entity);

        }

        $manager->flush();
    }

}