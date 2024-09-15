<?php

namespace App\DataFixtures;
use App\DataFixtures\AbstractFixtures;
use App\Entity\Enums\Subjects\StatusEnum;
use App\Entity\Subject;
use App\Entity\User;
use App\Utils\EnumTools;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends AbstractFixtures implements DependentFixtureInterface
{

    private const JSON_FILENAME = 'subject.json';
    protected int $dummyCount = 500;

    public function loadDummy(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < $this->dummyCount; $i++) {

            $entity = new Subject();
            $entity->setTitle("Ceci est le titre du sujet $i");
            $entity->setStatus(EnumTools::getRandomEnumValue(StatusEnum::class));
            $entity->setUser($this->getRandomReference(User::class));

            $manager->persist($entity);
            $this->addReference(Subject::class . "_" . $i, $entity);
        }

        $manager->flush();

    }

    public function loadDemo(ObjectManager $manager): void
    {
        $list = $this->loadJson(self::JSON_FILENAME);

        foreach ($list as $item) {

            $entity = new Subject();
            $entity->setTitle($item['title']);
            $entity->setUser($this->getReference(User::class . '_' . $item['user']));

            $manager->persist($entity);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

}