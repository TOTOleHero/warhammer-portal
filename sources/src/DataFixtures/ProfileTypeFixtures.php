<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ProfileType;

class ProfileTypeFixtures extends Fixture
{

    protected $data = [
        ['profileWFB12', 'en', 'Profile 12 attributes (type WFB old)'],
        ['profileWFB9', 'en', 'Profile 12 attributes (type WFB)'],
        ['profileAOS4', 'en', 'Profile 4 attributes (type AOS)'],

    ];
    public function load(ObjectManager $manager)
    {

        foreach ($this->data as $data) {
            $object = new ProfileType();
            $object->setId($data[0]);
            // $object->setTranslatableLocale($data[1]);
            $object->setName($data[2]);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
