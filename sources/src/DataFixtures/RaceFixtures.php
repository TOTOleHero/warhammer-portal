<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Race;

class RaceFixtures extends Fixture
{

    protected $data = [
        ['ELVES','en_US','Elves'],
        ['DWARFS','en_US','Dwarfs'],
        ['HUMANS','en_US','Humans'],
    ];

    public function load(ObjectManager $manager)
    {
        
        foreach ($this->data as $data)
        {
            $object = new Race();
            $object->setId($data[0]);
            $object->setName($data[2]);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
