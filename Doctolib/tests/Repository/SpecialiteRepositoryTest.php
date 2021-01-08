<?php

namespace App\Tests\Repository;

use App\Entity\Specialite;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpecialiteRepositoryTest extends KernelTestCase{ //Kernel récupère le container et donc le repository
    private $repository;  //ce qu'on veut tester ici

    public function setUp(){
        self::bootKernel();
        $this->repository=self::$container->get(SpecialiteRepository::class);
    }

    public function testFindAll(){
        $specialites = $this->repository->findAll();
        $this->assertCount(0, $specialites);
    }

    public function testFind(){
        $id=5;
        $specialite = $this->repository->find($id);
        $this->assertEquals(null, $specialite);
    }

    public function testFindOneBy(){
        $specialites = $this->repository->findOneByNom('cardiologie');
        $this->assertEquals(0, $specialites);
    }
    
    public function testFindBy(){
        $specialites = $this->repository->findByNom('cardiologie');
        $this->assertCount(0, $specialites);
    }
////////////////////////MANAGER

    public function testManagerPersist(){
        $specialite = (new Specialite)->setNom('cardiologie');
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($specialite);
        $manager->flush();

        $this->assertCount(1, $this->repository->findAll());
    }

    public function testManagerRemove(){
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $id=1;
        $specialite = $this->repository->find($id);
        $manager->remove($specialite);
        $manager->flush();

        $this->assertCount(0, $this->repository->findAll());

    }

    public function testUpdate(){
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $specialite = (new Specialite)->setNom('cardiologie');
        $manager->persist($specialite);
        $manager->flush();
        $this->assertCount(1, $this->repository->findAll());

        $specialite->setNom('Pneumologie');
        $manager->flush();
        $this->assertCount(1, $this->repository->findByNom('Pneumologie'));

    }

}   