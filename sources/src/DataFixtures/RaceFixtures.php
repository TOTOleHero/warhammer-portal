<?php

namespace App\DataFixtures;

use App\Entity\ExternalLink;
use App\Entity\Race;
use App\Manager\ExternalLinkCategoryManager;
use App\Manager\TagManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaceFixtures extends Fixture
{
    /**
     * @var TagManager
     */
    protected $tagManager;

    /**
     * @var ExternalLinkCategoryManager
     */
    protected $externalLinkCategoryManager;

    public function __construct(TagManager $tagManager,ExternalLinkCategoryManager $externalLinkCategoryManager)
    {
        $this->tagManager = $tagManager;
        $this->externalLinkCategoryManager = $externalLinkCategoryManager;
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
        ['ELEMENTAL', 'en_US', 'Elemental'],
        ['HALFING', 'en_US', 'Halfing'],
        ['BEAST_HUMANOID', 'en_US', 'Beast-humanoid'],
        ['LIZARD', 'en_US', 'Lizard'
                ,'externalLinks'=>
                [
                    [
                        'category' => 'forum'
                        ,'href'=>'https://www.lustria-online.com/',
                        'locale' => 'en_US'
                    ]
                ]
        ],
        ['ORC', 'en_US', 'Orc'],
        ['GOBLIN', 'en_US', 'Goblin'],
        ['MONSTER', 'en_US', 'Monster'],
        ['GIANT', 'en_US', 'Giant'],
        ['TROLL', 'en_US', 'Troll'],
        ['SKAVEN', 'en_US', 'Skaven'],
        ['UNDEAD', 'en_US', 'Undead'],
        ['DAEMON', 'en_US', 'Daemon'],
        ['ANIMATED_THING', 'en_US', 'Animated thing'],
        ['FIMIR', 'en_US', 'Fimir'],
        ['NATURAL_SPIRIT', 'en_US', 'NAtural spirit'],

    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $object = new Race();
            $object->setId($data[0]);
            $object->setName($data[2]);
            $object->addTag($this->tagManager->loadOrCreate($data[2]));

            if(array_key_exists('externalLinks',$data))
            {
                foreach($data['externalLinks'] as $externalLinkData)
                {
                    $externalLink = new ExternalLink();
                    $externalLink->setHref($externalLinkData['href']);
                    $externalLink->setCategory($this->externalLinkCategoryManager->loadOrCreate($externalLinkData['category']));
                    $object->addExternalLink($externalLink);
                }
            }

            $manager->persist($object);
        }
        $manager->flush();
    }
}

