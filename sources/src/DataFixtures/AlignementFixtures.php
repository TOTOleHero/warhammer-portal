<?php

namespace App\DataFixtures;

use App\Entity\Alignment;
use App\Manager\TagManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AlignementFixtures extends Fixture
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
        ['LAWFUL_GOOD', 'en_US', 'Lawful Good'],
        ['NEUTRAL_GOOD', 'en_US', 'Neutral Good'],
        ['CHAOTIC_GOOD', 'en_US', 'Chaotic Good'],
        ['LAWFUL_NEUTRAL', 'en_US', 'Lawful Neutral'],
        ['TRUE_NEUTRAL', 'en_US', 'True Neutral'],
        ['CHAOTIC_NEUTRAL', 'en_US', 'Chaotic Neutral'],
        ['LAWFUL_EVIL', 'en_US', 'Lawful Evil'],
        ['NEUTRAL_EVIL', 'en_US', 'Neutral Evil'],
        ['CHAOTIC_EVIL', 'en_US', 'Chaotic Evil'],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $object = new Alignment();
            $object->setId($data[0]);

            $object->setName($data[2]);

            $object->addTag($this->tagManager->loadOrCreate($data[2]));
            $manager->persist($object);
        }
        $manager->flush();
    }
}
