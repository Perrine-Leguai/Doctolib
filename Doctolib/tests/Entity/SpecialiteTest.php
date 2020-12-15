<?php

namespace App\Tests\Entity;

use App\Entity\Specialite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpecialiteTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator=self::$container->get("validator");
    }

    private function getSpecialite(string $nom){
        $specialite=(new Specialite)->setNom($nom);
        return $specialite;
    }

    public function testGandSNom(){
        $specialite= $this->getSpecialite('pédiatrie');
        $specialite->setNom('pédiatrie');
        $this->assertEquals('pédiatrie', $specialite->getNom());
    }
}
?>