<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        $userFixtures = new UserFixtures($this->params);
        $userFixtures->load($manager);
    }
}
