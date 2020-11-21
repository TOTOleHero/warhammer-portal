<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ProfileType;
use App\Entity\ProfileWFB12;
use App\Entity\ProfileWFB9;
use App\Entity\ProfileAOS4;
use App\Entity\ProfileWHQ;

class ProfileTypeFixtures extends Fixture
{

    protected $data = [
        ['profileWFB12','en_US', 'Profile 12 attributes (type WFB old)',ProfileWFB12::class ],
        ['profileWFB9','en_US', 'Profile 12 attributes (type WFB)',ProfileWFB9::class ],
        ['profileAOS4','en_US', 'Profile 4 attributes (type AOS)',ProfileAOS4::class ],
        ['profileWHQ','en_US', 'Profile 15 attributes (type WHQ)',ProfileWHQ::class ],

    ];
    public function load(ObjectManager $manager)
    {

        foreach ($this->data as $data) {
            $object = new ProfileType();
            $object->setId($data[0]);
            $object->setName($data[2]);
            $object->setProfileClassName($data[3]);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
