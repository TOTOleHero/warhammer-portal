<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Race;
use App\Entity\Nation;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class NationFixtures extends Fixture implements DependentFixtureInterface
{

    protected $data = [
        ['HIGH_ELVES','en','High elves','ELVES'],
        ['WOOD_ELVES','en','Wood elves','ELVES'],
        ['DARK_ELVES','en','Dark elves','ELVES'],
    ];

    public function load(ObjectManager $manager)
    {
        
        $raceRepository = $manager->getRepository(Race::class);


        foreach ($this->data as $data)
        {
            $object = new Nation();
            $object->setId($data[0]);
            $object->setTranslatableLocale($data[1]);
            $object->setName($data[2]);
            $object->setRace($raceRepository->find($data[3]));
            $manager->persist($object);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return array(
            RaceFixtures::class,
        );
    }
}
