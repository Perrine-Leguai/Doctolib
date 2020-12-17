<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PatientFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0; $i<=4 ; $i++){
            $client = (new Patient())->setNumeroCarteVitale('292112122113')->setNom('NomFamille $i')->setPrenom('David $i')->setAdresse("20 rue du pré")->setVille('Marseille')->setCoddePostal('13000')->setEmail('jeanjean@gm.com')->setTelephone('0607080910');
            $manager->persist($client);
        }

        $manager->flush();
    }
}
