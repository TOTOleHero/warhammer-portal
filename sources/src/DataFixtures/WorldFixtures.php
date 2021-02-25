<?php

namespace App\DataFixtures;

use App\Entity\World;
use App\Manager\TagManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WorldFixtures extends Fixture
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
        ['en_US', 'warhammer-old-world', 'Warhammer Old World'],
        ['en_US', 'mortal-realms', 'Mortal Realms'],
        ['en_US', 'earth', 'Earth'],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $object = new World();
            $object->setId($data[1]);
            $object->setName($data[2]);
            //$object->setDescription($data[2]);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
