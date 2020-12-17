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
////////////////////////// GETTERS AND SETTERS
    public function testGandSNom(){
        $specialite= $this->getSpecialite('pédiatrie');
        $specialite->setNom('pédiatrie');
        $this->assertEquals('pédiatrie', $specialite->getNom());
    }

////////////////////////// ASSERTS
    public function testNomRempli(){
        $specialite= $this->getSpecialite("");
        $errors = $this->validator->validate($specialite);
        $this->assertCount(1, $errors);
        $this->assertEquals("Le libellé est obligatoire.", $errors[0]->getMessage(), "Test echec sur le methode : testNotValidBlankPrenom");
    }

}
?>