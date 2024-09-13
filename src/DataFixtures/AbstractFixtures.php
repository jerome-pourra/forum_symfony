<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractFixtures extends Fixture
{

    private ObjectManager $manager;
    private KernelInterface $kernel;
    protected int $dummyCount = 50;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function loadDummy(ObjectManager $manager): void
    {
        return;
    }

    public function loadDemo(ObjectManager $manager): void
    {
        return;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $env = $this->kernel->getEnvironment();
        match ($env) {
            'dev' => $this->loadDummy($manager),
            'demo' => $this->loadDemo($manager),
            default => throw new \Exception("Unsupported fixtures environment: $env"),
        };
    }

    protected function loadJson(string $file): array
    {
        $filepath = dirname(dirname(__DIR__)) . '/resources/fixtures/' . $file;
        if (!file_exists($filepath)) {
            throw new \Exception("Fixtures file $filepath not found");
        }
        $jsonData = file_get_contents($filepath);
        return json_decode($jsonData, true);
    }

    protected function getTotalReferences(string $className): int
    {
        $count = 0;
        foreach ($this->referenceRepository->getReferences() as $key => $reference) {
            if (str_starts_with($key, $className . "_")) {
                $count++;
            }
        }
        return $count;
    }

    protected function getRandomReference(string $className): mixed
    {
        $totalReferences = $this->getTotalReferences($className);
        if ($totalReferences === 0) {
            throw new \Exception("No references found for class: $className");
        }
        $randomIndex = rand(0, $totalReferences - 1);
        return $this->getReference($className . "_" . $randomIndex);
    }

}