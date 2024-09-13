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
    protected int $dummyCount = 50;

    public function loadDummy(ObjectManager $manager): void
    {

        for ($i = 0; $i < $this->dummyCount; $i++) {
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
            $entity->setSubject($this->getReference(Subject::class . '_' . $item['subject']));

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