<?php

namespace App\DataFixtures;

use App\Entity\Race;
use App\Manager\TagManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaceFixtures extends Fixture
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
        ['ELVES', 'en_US', 'Elves'],
        ['DWARFS', 'en_US', 'Dwarfs'],
        ['HUMANS', 'en_US', 'Humans'],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $object = new Race();
            $object->setId($data[0]);
            $object->setName($data[2]);
            $object->addTag($this->tagManager->loadOrCreate($data[2]));
            $manager->persist($object);
        }
        $manager->flush();
    }
}
