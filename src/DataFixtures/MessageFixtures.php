<?php

namespace App\DataFixtures;
use App\DataFixtures\AbstractFixtures;
use App\Entity\Message;
use App\Entity\Subject;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends AbstractFixtures implements DependentFixtureInterface
{

    private const JSON_FILENAME = 'messages.json';

    public function loadDummy(ObjectManager $manager): void
    {

        for ($i = 0; $i < 500; $i++) {
            $entity = new Message();
            $entity->setContent("Ceci est le contenu du message $i");
            $entity->setUser($this->getRandomReference(User::class));
            $entity->setSubject($this->getRandomReference(Subject::class));

            $manager->persist($entity);
        }

        $manager->flush();

    }

    public function loadDemo(ObjectManager $manager): void
    {
        $list = $this->loadJson(self::JSON_FILENAME);

        foreach ($list as $item) {

            $entity = new Message();
            $entity->setContent($item['content']);
            $entity->setUser($this->getReference(User::class . '_' . $item['user']));
            $entity->setSubject($this->getReference(Subject::class . '_' . $item['Subject']));

            $manager->persist($entity);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            SubjectFixtures::class,
        ];
    }

}