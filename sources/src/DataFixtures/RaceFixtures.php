<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Race;

class RaceFixtures extends Fixture
{

    protected $data = [
        ['ELVES','en','Elves'],
        ['DWARFS','en','Dwarfs'],
        ['HUMANS','en','Humans'],
    ];

    public function load(ObjectManager $manager)
    {
        
        foreach ($this->data as $data)
        {
            $object = new Race();
            $object->setId($data[0]);
            $object->setTranslatableLocale($data[1]);
            $object->setName($data[2]);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
