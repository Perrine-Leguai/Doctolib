<?php

namespace App\Tests\Entity;

use App\Entity\Docteur;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DocteurTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator=self::$container->get("validator");
    }

    private function getDocteur(int $numeroOrdre,string $nom, string $prenom, string $adresseTravail, int  $codePostal, string $ville, string $email, string $telephone=null, string $lienSiteInternet=null){
        $docteur=(new Docteur)->setNumeroOrdre($numeroOrdre)->setNom($nom)->setPrenom($prenom)->setAdresseTravail($adresseTravail)->setCodePostal($codePostal)->setVille($ville)->setEmail($email)->setTelephone($telephone)->setLienSiteInternet($lienSiteInternet);
        return $docteur;
    }

    public function testGandSNumeroOrdre(){
        $docteur = $this->getDocteur(123456789, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910, 'www.jeanjeandoc.com');
        $docteur->setNumeroOrdre(123456789);
        $this->assertEquals(123456789, $docteur->getNumeroOrdre());
    }

    public function testGandSNom(){
        $docteur = $this->getDocteur(123456789, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910, 'www.jeanjeandoc.com');
        $docteur->setNom('dupont');
        $this->assertEquals('dupont', $docteur->getNom());
    }

    public function testGandSPrenom(){
        $docteur = $this->getDocteur(123456789, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910, 'www.jeanjeandoc.com');
        $docteur->setPrenom('jeanjean');
        $this->assertEquals('jeanjean', $docteur->getPrenom());
    }

    public function testGandSAdresseTravail(){
        $docteur = $this->getDocteur(123456789, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910, 'www.jeanjeandoc.com');
        $docteur->setAdresseTravail('26 rue du pré');
        $this->assertEquals('26 rue du pré', $docteur->getAdresseTravail());
    }

    public function testGandSCodePostal(){
        $docteur = $this->getDocteur(123456789, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910, 'www.jeanjeandoc.com');
        $docteur->setCodePostal(21850);
        $this->assertEquals(21850, $docteur->getCodePostal());
    }

    public function testGandSVille(){
        $docteur = $this->getDocteur(123456789, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910, 'www.jeanjeandoc.com');
        $docteur->setVille('Saint Apollinaire');
        $this->assertEquals('Saint Apollinaire', $docteur->getVille());
    }

    public function testGandSEmail(){
        $docteur = $this->getDocteur(123456789, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910, 'www.jeanjeandoc.com');
        $docteur->setEmail('jeanjean@dupont.org');
        $this->assertEquals('jeanjean@dupont.org', $docteur->getEmail());
    }

    public function testGandSTelephone(){
        $docteur = $this->getDocteur(123456789, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910, 'www.jeanjeandoc.com');
        $docteur->setTelephone(607080910);
        $this->assertEquals(607080910, $docteur->getTelephone());
    }

    public function testGandSLienSiteInternet(){
        $docteur = $this->getDocteur(123456789, 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org', 607080910, 'www.jeanjeandoc.com');
        $docteur->setLienSiteInternet('www.jeanjeandoc.com');
        $this->assertEquals('www.jeanjeandoc.com', $docteur->getLienSiteInternet());
    }
}