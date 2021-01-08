<?php

namespace App\Tests\Repository;

use App\Entity\Docteur;
use App\DataFixtures\AppFixtures;
use App\Repository\DocteurRepository;
use App\DataFixtures\TestDocteurFixture;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DocteurRepositoryTest extends KernelTestCase{ //Kernel récupère le container et donc le repository

use FixturesTrait;

    private $repository;  //ce qu'on veut tester ici

    public function setUp(){
        self::bootKernel();
        $this->repository=self::$container->get(DocteurRepository::class);
    }

    public function testFindAll(){
        $this->loadFixtures([TestDocteurFixture::class]);
        $docteurs = $this->repository->findAll();
        $this->assertCount(5, $docteurs);
    }

    public function testFind(){
        $id=5;
        $docteur = $this->repository->find($id);
        $this->assertEquals(null, $docteur);
    }

    public function testFindOneBy(){
        $docteurs = $this->repository->findOneByNom('Leguai');
        $this->assertEquals(0, $docteurs);
    }
    
    public function testFindBy(){
        $docteurs = $this->repository->findByNom('Leguai');
        $this->assertCount(0, $docteurs);
    }

    protected function tearDown(){
        $this->loadFIxtures([AppFixtures::class]);
    }
}   