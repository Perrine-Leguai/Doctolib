<?php

namespace App\Tests\Entity;

use App\Entity\Docteur;
use App\Entity\PriseRdv;
use App\Entity\Specialite;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DocteurTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator=self::$container->get("validator");
    }

    private function getDocteur(string $numeroOrdre=null,string $nom, string $prenom, string $adresseTravail, int  $codePostal=null, string $ville, string $email, string $telephone=null, string $lienSiteInternet=null){
        $docteur=(new Docteur)->setNumeroOrdre($numeroOrdre)->setNom($nom)->setPrenom($prenom)->setAdresseTravail($adresseTravail)->setCodePostal($codePostal)->setVille($ville)->setEmail($email)->setTelephone($telephone)->setLienSiteInternet($lienSiteInternet);
        return $docteur;
    }

///////////////////////// GETTERS AND SETTERS
    public function testGandSNumeroOrdre(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $docteur->setNumeroOrdre('123456789');
        $this->assertEquals('123456789', $docteur->getNumeroOrdre());
    }

    public function testGandSNom(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $docteur->setNom('dupont');
        $this->assertEquals('dupont', $docteur->getNom());
    }

    public function testGandSPrenom(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $docteur->setPrenom('jeanjean');
        $this->assertEquals('jeanjean', $docteur->getPrenom());
    }

    public function testGandSAdresseTravail(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $docteur->setAdresseTravail('26 rue du pré');
        $this->assertEquals('26 rue du pré', $docteur->getAdresseTravail());
    }

    public function testGandSCodePostal(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $docteur->setCodePostal(21850);
        $this->assertEquals(21850, $docteur->getCodePostal());
    }

    public function testGandSVille(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $docteur->setVille('Saint Apollinaire');
        $this->assertEquals('Saint Apollinaire', $docteur->getVille());
    }

    public function testGandSEmail(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $docteur->setEmail('jeanjean@dupont.org');
        $this->assertEquals('jeanjean@dupont.org', $docteur->getEmail());
    }

    public function testGandSTelephone(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $docteur->setTelephone(607080910);
        $this->assertEquals(607080910, $docteur->getTelephone());
    }

    public function testGandSLienSiteInternet(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $docteur->setLienSiteInternet('www.jeanjeandoc.com');
        $this->assertEquals('www.jeanjeandoc.com', $docteur->getLienSiteInternet());
    }

///////////////////////// ASSERTS
    public function testNumeroOrdreRempli(){
        $docteur = $this->getDocteur(null, 'dupont', 'jeanjean', '26 rue du pré',21850,'Saint Apollinaire', 'jeanjean@dupont.org', '0607080910', 'www.jeanjeandoc.com');
        $errors = $this->validator->validate($docteur);
        $this->assertCount(1, $errors);
        $this->assertEquals("numero d'ordre des médecins obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testNoOrdreRempli");
    }
    
    public function testNumeroOrdreValid(){
        $docteur = $this->getDocteur('15', 'dupont', 'jeanjean', '26 rue du pré',21850,'Saint Apollinaire', 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($docteur);
        $this->assertCount(1, $errors);
        $this->assertEquals("Le numéro d'ordre est constitué de 9 chiffres", $errors[0]->getMessage(), "Test echec sur le methode : testNumeroCVDocRempli");
    }

    public function testNomDocRempli(){
        $docteur = $this->getDocteur('123456789', '', 'jeanjean', '26 rue du pré',21850,'Saint Apollinaire', 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($docteur);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testNomDocRempli");

    }

    public function testPrenomDocRempli(){
        $docteur = $this->getDocteur('123456789', 'Dupont', '', '26 rue du pré', 21850,'Saint Apollinaire',   'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($docteur);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testPrenomDocRempli");
    }

    public function testAdresseDocRempli(){
        $docteur = $this->getDocteur('123456789', 'Dupont', 'Jeanjean', '',21850,'Saint Apollinaire', 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($docteur);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testAdresseDocRempli");
    }

    public function testVilleDocRempli(){
        $docteur = $this->getDocteur('123456789', 'Dupont', 'JeanJean', '26 rue du pré', 21850,'',  'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($docteur);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testVilleDocRempli");
    }

    public function testCodePostalDocRempli(){
        $docteur = $this->getDocteur('123456789', 'Dupont', 'JeanJean', '26 rue du pré', null, 'Saint Apollinaire', 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($docteur);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testCPDocRempli");
    }

    public function testCPValid(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré',4,'Saint Apollinaire',  'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($docteur);
        $this->assertCount(1, $errors);
        $this->assertEquals("Veuillez saisir un code postal correct", $errors[0]->getMessage(), "Test echec sur le methode : testNumeroCVDocRempli");

    }
    public function testEmailDocRempli(){
        $docteur = $this->getDocteur('123456789', 'Dupont', 'JeanJean', '26 rue du pré',21850,'Saint Apollinaire', '', '0607080910');
        $errors = $this->validator->validate($docteur);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testCPDocRempli");
    }

    public function testEmailValid(){
        $docteur = $this->getDocteur('123456789', 'Dupont', 'JeanJean', '26 rue du pré',21850,'Saint Apollinaire', 'jjjj.frite', '0607080910');
        $errors = $this->validator->validate($docteur);
        $this->assertCount(1, $errors);
        $this->assertEquals("Adresse email erronée", $errors[0]->getMessage(), "Test echec sur le methode : testCPDocRempli");
    }


///////////////////////////TEST DE METHODES D ASSOCIATION
    public function testGetSpecialite(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $this->assertCount(0, $docteur->getSpecialites());
    }

    public function testAddSpecialite(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $specialite= (new Specialite())->setNom('podologie');
        $docteur->addSpecialite($specialite);
        $this->assertCount(1, $docteur->getSpecialites());
        // $this->assertEquals($docteur, $specialite->getLibelle());
    }

    public function testRemoveSpecialite(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $specialite= (new Specialite())->setNom('cardiologie');
        $docteur->addSpecialite($specialite);
        $this->assertCount(1, $docteur->getSpecialites());
        $docteur->removeSpecialite($specialite);
        $this->assertCount(0, $docteur->getSpecialites());
    }

    public function testGetPriseRdv(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $this->assertCount(0, $docteur->getPriseRdvs());
    }

    public function testAddPriseRdv(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $priseRdv= (new PriseRdv())->setDate(new \DateTime('2020-12-17 14:25:30'));
        $docteur->addPriseRdv($priseRdv);
        $this->assertCount(1, $docteur->getPriseRdvs());
        $this->assertEquals($docteur, $priseRdv->getidDocteur());
    }

    public function testRemovePriseRdv(){
        $docteur = $this->getDocteur('123456789', 'dupont', 'jeanjean', '26 rue du pré', 21850, 'Saint Apollinaire', 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $priseRdv= (new PriseRdv())->setDate(new \DateTime('2020-12-17 14:25:30'));
        $docteur->addPriseRdv($priseRdv);
        $this->assertCount(1, $docteur->getPriseRdvs());
        $docteur->removePriseRdv($priseRdv);
        $this->assertCount(0, $docteur->getPriseRdvs());
    }
    
}