<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Race;
use App\Entity\Nation;
use App\Entity\WorldAlignment;

class NationFixtures extends Fixture 
{

    protected $data = [
        ['HIGH_ELVES','en_US','High elves'],
        ['WOOD_ELVES','en_US','Wood elves'],
        ['DARK_ELVES','en_US','Dark elves'],
    ];

    public function load(ObjectManager $manager)
    {
        
        $worldAlignmentRepository = $manager->getRepository(WorldAlignment::class);


        foreach ($this->data as $data)
        {
            $object = new Nation();
            $object->setId($data[0]);
            $object->setName($data[2]);

            $manager->persist($object);
        }
        $manager->flush();
    }

}
