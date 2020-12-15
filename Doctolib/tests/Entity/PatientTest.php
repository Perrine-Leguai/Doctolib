<?php

namespace App\Tests\Entity;

use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator=self::$container->get("validator");
    }

    private function getPatient(int $numeroCarteVitale,string $nom, string $prenom, string $adresse, int  $codePostal, string $ville, string $email, string $telephone=null){
        $patient=(new Patient)->setNumeroCarteVitale($numeroCarteVitale)->setNom($nom)->setPrenom($prenom)->setAdresse($adresse)->setCodePostal($codePostal)->setVille($ville)->setEmail($email)->setTelephone($telephone);
        return $patient;
    }

    public function testGandSNumeroCarteVitale(){
        $patient = $this->getPatient(192115915412315, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910);
        $patient->setNumeroCarteVitale(192115915412315);
        $this->assertEquals(192115915412315, $patient->getNumeroCarteVitale());
    }

    public function testGandSNom(){
        $patient = $this->getPatient(192115915412315, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910);
        $patient->setNom('dupont');
        $this->assertEquals('dupont', $patient->getNom());
    }

    public function testGandSPrenom(){
        $patient = $this->getPatient(192115915412315, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910);
        $patient->setPrenom('jeanjean');
        $this->assertEquals('jeanjean', $patient->getPrenom());
    }

    public function testGandSAdresse(){
        $patient = $this->getPatient(192115915412315, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910);
        $patient->setAdresse('26 rue du pré');
        $this->assertEquals('26 rue du pré', $patient->getAdresse());
    }

    public function testGandSCodePostal(){
        $patient = $this->getPatient(192115915412315, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910);
        $patient->setCodePostal(21850);
        $this->assertEquals(21850, $patient->getCodePostal());
    }

    public function testGandSVille(){
        $patient = $this->getPatient(192115915412315, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910);
        $patient->setVille('Saint Apollinaire');
        $this->assertEquals('Saint Apollinaire', $patient->getVille());
    }

    public function testGandSEmail(){
        $patient = $this->getPatient(192115915412315, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910);
        $patient->setEmail('jeanjean@dupont.org');
        $this->assertEquals('jeanjean@dupont.org', $patient->getEmail());
    }

    public function testGandSTelephone(){
        $patient = $this->getPatient(192115915412315, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910);
        $patient->setTelephone(607080910);
        $this->assertEquals(607080910, $patient->getTelephone());
    }

    
}