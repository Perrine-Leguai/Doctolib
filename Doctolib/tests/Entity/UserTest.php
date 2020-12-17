<?php

namespace App\Tests\Entity;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PseudoTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator=self::$container->get("validator");
    }

    private function getUser(string $pseudo=null, string $mdp){
        $user=(new User)->setUsername($pseudo)->setPassword($mdp);
        return $user;
    }
///////////////////////////////GETTES AND SETTERS
    public function testGandSPseudo(){
        $user= $this->getUser('Jeanjean', '1111');
        $user->setUsername('Jeanjean');
        $this->assertEquals('Jeanjean', $user->getUsername());
    }

    public function testGandSMdp(){
        $user= $this->getUser('Jeanjean', '1111');
        $user->setPassword('1111');
        $this->assertEquals('1111', $user->getPassword());
    }
///////////////////////////////ASSERTS

}