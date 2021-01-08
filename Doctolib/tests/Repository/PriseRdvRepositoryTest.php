<?php

namespace App\Tests\Repository;

use App\Entity\PriseRdv;
use App\Repository\PriseRdvRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PriseRdvRepositoryTest extends KernelTestCase{ //Kernel récupère le container et donc le repository
    private $repository;  //ce qu'on veut tester ici

    public function setUp(){
        self::bootKernel();
        $this->repository=self::$container->get(PriseRdvRepository::class);
    }

    public function testFindAll(){
        $priseRdvs = $this->repository->findAll();
        $this->assertCount(0, $priseRdvs);
    }

    public function testFind(){
        $id=5;
        $priseRdv = $this->repository->find($id);
        $this->assertEquals(null, $priseRdv);
    }

    public function testFindOneBy(){
        $priseRdvs = $this->repository->findOneByDate(new \DateTime('2020-12-15 14:30:00'));
        $this->assertEquals(0, $priseRdvs);
    }
    
    public function testFindBy(){
        $priseRdvs = $this->repository->findByDate(new \DateTime('2020-12-15 14:30:00'));
        $this->assertCount(0, $priseRdvs);
    }
}   