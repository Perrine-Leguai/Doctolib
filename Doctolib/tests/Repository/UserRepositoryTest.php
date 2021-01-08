<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase{ //Kernel récupère le container et donc le repository
    private $repository;  //ce qu'on veut tester ici

    public function setUp(){
        self::bootKernel();
        $this->repository=self::$container->get(UserRepository::class);
    }
////////////////////////REPOSITORY
    public function testFindAll(){
        $users = $this->repository->findAll();
        $this->assertCount(0, $users);
    }

    public function testFind(){
        $id=5;
        $user = $this->repository->find($id);
        $this->assertEquals(null, $user);
    }

    public function testFindOneBy(){
        $users = $this->repository->findOneByUsername('cardiologie');
        $this->assertEquals(0, $users);
    }
    
    public function testFindBy(){
        $users = $this->repository->findByUsername('cardiologie');
        $this->assertCount(0, $users);
    }
////////////////////////REPOSITORY


}   