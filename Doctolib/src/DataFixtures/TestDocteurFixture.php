<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Docteur;
use App\Entity\Patient;
use App\Entity\PriseRdv;
use App\Entity\Specialite;
use App\Repository\DocteurRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TestDocteurFixture extends Fixture
{
    public function __construct(DocteurRepository $repo, UserPasswordEncoderInterface $passwordEncoder){
        $this->repository = $repo;
        $this->passwordEncoder = $passwordEncoder;
    
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for($i=1; $i<=5 ; $i++){
            $docteur = (new Docteur())->setUsername($faker->shuffle('gentilDoc'))->setPassword($this->passwordEncoder->encodePassword($i.$i.$i.$i))->setNumeroOrdre('12345678'.$i)->setNom($faker->lastName)->setPrenom($faker->firstName)->setAdresseTravail($faker->streetAddress)->setCodePostal($faker->postcode)->setVille($faker->city)->setEmail($faker->email)->setTelephone($faker->phoneNumber);
            $patient = (new Patient())->setUsername($faker->shuffle('gentilPatient'))->setPassword($this->passwordEncoder->encodePassword($i.$i.$i.$i))->setNumeroCarteVitale('29211212211'.$i)->setNom($faker->lastName)->setPrenom($faker->firstName)->setAdresse($faker->streetAddress)->setVille($faker->city)->setCodePostal($faker->postcode)->setEmail($faker->email)->setTelephone($faker->phoneNumber);

            $manager->persist($docteur);
            $manager->persist($patient);
            $randomSpecialite=['oncologie','cardiologie','pneumologie','pédiatrie','neurochirurgie','gynécologie'];
            for($j=1; $j<=3; $j++){
                $priseRdv = (new PriseRdv())->setIdDocteur($docteur)->setIdPatient($patient)->setDate(new \DateTime($faker->dateTime->format('Y-m-d')));
                $specialite = (new Specialite())->setNom($faker->randomElement($randomSpecialite))->addDocteur($docteur);

                $manager->persist($priseRdv);
                $manager->persist($specialite);
            }
        }
        

        $manager->flush();
    }
}
