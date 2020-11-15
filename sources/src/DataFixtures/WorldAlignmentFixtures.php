<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\WorldAlignment;

class WorldAlignmentFixtures extends Fixture
{

    protected $data = [
        ['ORDER', 'en', 'Order'],
        ['DESTRUCTION', 'en', 'Destruction'],
        ['DEATH', 'en', 'Death'],
        ['CHAOS', 'en', 'Chaos'],
     ];

    public function load(ObjectManager $manager)
    {

        foreach ($this->data as $data) {
            $object = new WorldAlignment();
            $object->setId($data[0]);
            $object->setTranslatableLocale($data[1]);
            $object->setName($data[2]);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
