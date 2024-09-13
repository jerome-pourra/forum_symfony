<?php

namespace App\DataFixtures;
use App\DataFixtures\AbstractFixtures;
use App\Entity\Subject;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends AbstractFixtures implements DependentFixtureInterface
{

    private const JSON_FILENAME = 'subject.json';

    public function loadDummy(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < 100; $i++) {

            $entity = new Subject();
            $entity->setTitle("Ceci est le titre du sujet $i");
            $entity->setUser($this->getRandomReference(User::class));

            $manager->persist($entity);
            $this->addReference(Subject::class . "_" . $i, $entity);
        }

        $manager->flush();

    }

    // public function loadDemo(ObjectManager $manager): void
    // {
    // }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

}