<?php

namespace App\Tests\Repository;

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


}   