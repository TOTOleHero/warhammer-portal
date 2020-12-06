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
        ['ELVE', 'en_US', 'Elve',
    
        'externalLinks'=>
        [
            [
                'category' => 'communityDescription'
                ,'href'=>'https://warhammerfantasy.fandom.com/wiki/Elves',
                'locale' => 'en_US'
            ]
        ]
    ],
        ['DWARF', 'en_US', 'Dwarf'],
        ['HUMAN', 'en_US', 'Human'],

        ['HALFING', 'en_US', 'Halging'],
        ['OLD_ONE', 'en_US', 'Old one'],
        ['ORC', 'en_US', 'Orc'],
        ['GOBLIN', 'en_US', 'Goblin'],
        ['MONSTER', 'en_US', 'Monster'],
        ['GIANT', 'en_US', 'Giant'],
        ['TROLL', 'en_US', 'Troll'],
        ['SKAVEN', 'en_US', 'Skaven'],
        ['UNDEAD', 'en_US', 'Undead'],
        ['DAEMON', 'en_US', 'Daemon'],

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
