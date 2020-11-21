<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\WorldAlignment;

class WorldAlignmentFixtures extends Fixture
{

    protected $data = [
        ['ORDER','en_US', 'Order'],
        ['DESTRUCTION','en_US', 'Destruction'],
        ['DEATH','en_US', 'Death'],
        ['CHAOS','en_US', 'Chaos'],
     ];

    public function load(ObjectManager $manager)
    {

        foreach ($this->data as $data) {
            $object = new WorldAlignment();
            $object->setId($data[0]);

            $object->setName($data[2]);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
