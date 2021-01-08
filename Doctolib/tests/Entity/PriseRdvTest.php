<?php

namespace App\Tests\Entity;


use App\Entity\PriseRdv;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;




class PriseRdvTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator=self::$container->get("validator");
    }

    private function getPriseRdv(\Datetime $date=null){
        $priseRdv=(new PriseRdv)->setDate($date);
        return $priseRdv;
    }
////////////////////////// SETTETRS AND GETTERS
    public function testGandSDate(){
        $priseRdv= $this->getPriseRdv(new \DateTime("2020-11-05"));
        $priseRdv->setDate(new \DateTime("2020-11-05"));
        $this->assertEquals(new \DateTime("2020-11-05"), $priseRdv->getDate());
    }

////////////////////////// ASSERTS
    public function testDateIsValide(){
        $priseRdv = $this->getPriseRdv(null);
        $errors = $this->validator->validate($priseRdv);
        $this->assertCount(1, $errors);        
        $this->assertEquals("La date de rdv est obligatoire.", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidBlankPrenom");
    }
}