<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Alignment;

class AlignementFixtures extends Fixture
{

    protected $data = [
        ['LAWFUL_GOOD', 'en', 'Lawful Good'],
        ['NEUTRAL_GOOD', 'en', 'Neutral Good'],
        ['CHAOTIC_GOOD', 'en', 'Chaotic Good'],
        ['LAWFUL_NEUTRAL', 'en', 'Lawful Neutral'],
        ['TRUE_NEUTRAL', 'en', 'True Neutral'],
        ['CHAOTIC_NEUTRAL', 'en', 'Chaotic Neutral'],
        ['LAWFUL_EVIL', 'en', 'Lawful Evil'],
        ['NEUTRAL_EVIL', 'en', 'Neutral Evil'],
        ['CHAOTIC_EVIL', 'en', 'Chaotic Evil'],
    ];

    public function load(ObjectManager $manager)
    {

        foreach ($this->data as $data) {
            $object = new Alignment();
            $object->setId($data[0]);
            $object->setTranslatableLocale($data[1]);
            $object->setName($data[2]);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
