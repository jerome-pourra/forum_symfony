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
    protected int $dummyCount = 1000;

    public function loadDummy(ObjectManager $manager): void
    {

        for ($i = 0; $i < $this->dummyCount; $i++) {

            $userRef = $this->getRandomReference(User::class);
            $subjectRef = $this->getRandomReference(Subject::class);

            $entity = new Message();
            $entity->setContent($this->faker->sentence($this->faker->numberBetween(10, 100), true));
            $entity->setUser($userRef);
            $entity->setSubject($subjectRef);
            $entity->setCreatedAt($this->faker->dateTimeBetween($subjectRef->getCreatedAt(), 'now'));

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