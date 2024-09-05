<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

abstract class AbstractFixtures extends Fixture
{

    protected ParameterBagInterface $params;
    protected string $projectDir;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->projectDir = $params->get('kernel.project_dir');
    }

    protected function loadJson(string $file): array
    {
        $filepath = $this->projectDir . '/resources/fixtures/' . $file;
        if (!file_exists($this->projectDir . '/resources/fixtures/' . $file)) {
            throw new \Exception('Fixtures file ' . $filepath . ' not found');
        }
        $jsonData = file_get_contents($filepath);
        return json_decode($jsonData, true);
    }

    abstract public function load(ObjectManager $manager): void;
}
