<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractFixtures
{

    private const JSON_FILENAME = 'users.json';
    protected int $dummyCount = 50;

    public function loadDummy(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < $this->dummyCount; $i++) {

            $entity = new User();
            $entity->setName($this->faker->firstName($this->faker->randomElement));
            $entity->setRole("ROLE_USER");

            // 25% chance of setting a signature
            if ($this->faker->boolean(25)) {
                $entity->setSignature($this->faker->sentence());
            }

            $entity->setCreatedAt($this->faker->dateTimeBetween('-1 years', 'now'));

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