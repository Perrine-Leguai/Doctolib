<?php

namespace App\DataFixtures;

use App\Repository\DocteurRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    public function __construct(DocteurRepository $repo){
        $this->repository = $repo;
    }
    public function load(ObjectManager $manager)
    {
        $sup = $this->repository->findAll();
        foreach($sup as $s){
            $manager->remove($c);
        }

        $manager->flush();
    }
}
