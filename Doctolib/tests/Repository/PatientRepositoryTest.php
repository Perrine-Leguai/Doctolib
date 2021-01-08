<?php

namespace App\Tests\Repository;

use App\Entity\Patient;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientRepositoryTest extends KernelTestCase{ //Kernel récupère le container et donc le repository
    private $repository;  //ce qu'on veut tester ici

    public function setUp(){
        self::bootKernel();
        $this->repository=self::$container->get(PatientRepository::class);
    }

    public function testFindAll(){
        $patients = $this->repository->findAll();
        $this->assertCount(0, $patients);
    }

    public function testFind(){
        $id=5;
        $patient = $this->repository->find($id);
        $this->assertEquals(null, $patient);
    }

    public function testFindOneBy(){
        $patients = $this->repository->findOneByNom('Leguai');
        $this->assertEquals(0, $patients);
    }
    
    public function testFindBy(){
        $patients = $this->repository->findByNom('Leguai');
        $this->assertCount(0, $patients);
    }
}   