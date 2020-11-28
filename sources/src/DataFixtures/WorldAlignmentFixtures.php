<?php

namespace App\DataFixtures;

use App\Entity\WorldAlignment;
use App\Manager\TagManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WorldAlignmentFixtures extends Fixture
{
    /**
     * @var TagManager
     */
    protected $tagManager;

    public function __construct(TagManager $tagManager)
    {
        $this->tagManager = $tagManager;
    }

    protected $data = [
        ['ORDER', 'en_US', 'Order'],
        ['DESTRUCTION', 'en_US', 'Destruction'],
        ['DEATH', 'en_US', 'Death'],
        ['CHAOS', 'en_US', 'Chaos'],
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
