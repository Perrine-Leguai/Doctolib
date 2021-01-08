<?php

namespace App\Tests\Entity;

use App\Entity\Patient;
use App\Entity\PriseRdv;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints\RegexValidator;

class PatientTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator=self::$container->get("validator");
    }

    private function getPatient(string $numeroCarteVitale=null,string $nom=null, string $prenom=null, string $adresse=null, string $ville=null, int  $codePostal=null,  string $email=null, string $telephone=null){
        $patient=(new Patient)->setNumeroCarteVitale($numeroCarteVitale)->setNom($nom)->setPrenom($prenom)->setAdresse($adresse)->setVille($ville)->setCodePostal($codePostal)->setEmail($email)->setTelephone($telephone);
        return $patient;
    }
    private function getUser(string $pseudo=null, string $mdp, string $numeroCarteVitale=null,string $nom, string $prenom, string $adresse, string $ville, int  $codePostal=null, string $email, string $telephone=null){
        $user = (new Patient)->setUsername('gentilDoc')->setPassword('1111')->setNumeroCarteVitale('123456789')->setNom('NomFamille')->setPrenom('David')->setAdresse("20 rue du pré")->setVille('Marseille')->setCodePostal('13000')->setEmail('jeanjean@gm.com')->setTelephone('0607080910');
        return $user;
    }
////////////////////////// GETTERS AND SETTERS
    public function testGandSPseudo(){
        $user = $this->getUser('Jeanjean', '1111','192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $user->setUsername('Jeanjean');
        $this->assertEquals('Jeanjean', $user->getUsername());
    }

    public function testGandSMdp(){
        $user = $this->getUser('Jeanjean', '1111','192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $user->setPassword('1111');
        $this->assertEquals('1111', $user->getPassword());
    }
    public function testGandSNumeroCarteVitale(){
        $patient = $this->getPatient('192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $patient->setNumeroCarteVitale('192115915412315');
        $this->assertEquals('192115915412315', $patient->getNumeroCarteVitale());
    }

    public function testGandSNom(){
        $patient = $this->getPatient('192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $patient->setNom('dupont');
        $this->assertEquals('dupont', $patient->getNom());
    }

    public function testGandSPrenom(){
        $patient = $this->getPatient('192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $patient->setPrenom('jeanjean');
        $this->assertEquals('jeanjean', $patient->getPrenom());
    }

    public function testGandSAdresse(){
        $patient = $this->getPatient('192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $patient->setAdresse('26 rue du pré');
        $this->assertEquals('26 rue du pré', $patient->getAdresse());
    }

    public function testGandSCodePostal(){
        $patient = $this->getPatient('192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $patient->setCodePostal(21850);
        $this->assertEquals(21850, $patient->getCodePostal());
    }

    public function testGandSVille(){
        $patient = $this->getPatient('192115915412315', 'dupont', 'jeanjean', '26 rue du pré',  'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $patient->setVille('Saint Apollinaire');
        $this->assertEquals('Saint Apollinaire', $patient->getVille());
    }

    public function testGandSEmail(){
        $patient = $this->getPatient('192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $patient->setEmail('jeanjean@dupont.org');
        $this->assertEquals('jeanjean@dupont.org', $patient->getEmail());
    }

    public function testGandSTelephone(){
        $patient = $this->getPatient('192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $patient->setTelephone('0607080910');
        $this->assertEquals('0607080910', $patient->getTelephone());
    }
///////////////////////////METHODES D'ASSOCIATION

    public function testGetPriseRdv(){
        $patient = $this->getPatient('192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $this->assertCount(0, $patient->getPriseRdvs());
    }

    public function testAddPriseRdv(){
        $patient = $this->getPatient('123456789', 'dupont', 'jeanjean', '26 rue du pré',  'Saint Apollinaire',21850, 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $priseRdv= (new PriseRdv())->setDate(new \DateTime('2020-12-17 14:25:30'));
        $patient->addPriseRdv($priseRdv);
        $this->assertCount(1, $patient->getPriseRdvs());
        $this->assertEquals($patient, $priseRdv->getIdPatient());
    }

    public function testRemovePriseRdv(){
        $patient = $this->getPatient('123456789', 'dupont', 'jeanjean', '26 rue du pré',  'Saint Apollinaire',21850, 'jeanjean@dupont.org','0607080910', 'www.jeanjeandoc.com');
        $priseRdv= (new PriseRdv())->setDate(new \DateTime('2020-12-17 14:25:30'));
        $patient->addPriseRdv($priseRdv);
        $this->assertCount(1, $patient->getPriseRdvs());
        $patient->removePriseRdv($priseRdv);
        $this->assertCount(0, $patient->getPriseRdvs());
    }

////////////////////////// ASSERTS
    public function testNumeroCVRempli(){
        $patient = $this->getPatient('', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Le numéro de Carte Vital est obligatoire.", $errors[0]->getMessage(), "Test echec sur le methode : testNumeroCVRempli");
    }
    public function testNoCVValid(){
        $patient = $this->getPatient('15423698541ml', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Veuillez saisir un numéro entre 13 et 15 chiffres, 2A et 2B acceptés", $errors[0]->getMessage(), "Test echec sur le methode : testNumeroCVRempli");
    
    }

    public function testNomRempli(){
        $patient = $this->getPatient('192115915412315', '', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testNomRempli");
    }

    public function testPrenomRempli(){
        $patient = $this->getPatient('192115915412315', 'Dupont', '', '26 rue du pré','Saint Apollinaire', 21850,  'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testPrenomRempli");
    }

    public function testAdresseRempli(){
        $patient = $this->getPatient('192115915412315', 'Dupont', 'Jeanjean', '', 'Saint Apollinaire', 21850, 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testAdresseRempli");
    }

    public function testVilleRempli(){
        $patient = $this->getPatient('192115915412315', 'Dupont', 'JeanJean', '26 rue du pré', '', 21850, 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testVilleRempli");
    }

    public function testCodePostalRempli(){
        $patient = $this->getPatient('192115915412315', 'Dupont', 'JeanJean', '26 rue du pré', 'Saint Apollinaire', null, 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Champ obligatoire", $errors[0]->getMessage(), "Test echec sur le methode : testCPRempli");
    }

    public function testCPValid(){
        $patient = $this->getPatient('192115915412315', 'dupont', 'jeanjean', '26 rue du pré', 'Saint Apollinaire', 4, 'jeanjean@dupont.org', '0607080910');
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        $this->assertEquals("Veuillez saisir un code postal correct", $errors[0]->getMessage(), "Test echec sur le methode : testNumeroCVRempli");
    
    }
    public function testEmailRempli(){
        $patient = $this->getPatient('192115915412315', 'Dupont', 'JeanJean', '26 rue du pré', 'Saint Apollinaire', 21850, '', '0607080910');
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
    }
}