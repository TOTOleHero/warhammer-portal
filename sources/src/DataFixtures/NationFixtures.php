<?php

namespace App\DataFixtures;

use App\Entity\Nation;
use App\Entity\WorldAlignment;
use App\Manager\TagManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationFixtures extends Fixture
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
        ['HIGH_ELVES', 'en_US', 'High elves'
    
        ,'externalLinks' =>[
            [
                'category' => 'communityDescription'
                ,'href' => 'https://bibliotheque-imperiale.com/index.php/Cat%C3%A9gorie:Hauts_Elfes'
                ,'locale' => 'fr_FR'
            ],
            [
                'category' => 'communityDescription'
                ,'href' => 'https://warhammeronline.fandom.com/fr/wiki/Hauts_Elfes'
                ,'locale' => 'fr_FR'
            ],
            [
                'category' => 'communityDescription'
                ,'href' => 'https://warhammerfantasy.fandom.com/wiki/High_Elves'
                ,'locale' => 'en_US'
            ],
            [
                'category' => 'communityDescription'
                ,'href' => 'https://whfb.lexicanum.com/wiki/High_Elves'
                ,'locale' => 'en_US'
            ],
            [
                'category' => 'communityDescription'
                ,'href' => 'https://totalwarwarhammer.gamepedia.com/High_Elves'
                ,'locale' => 'en_US'
            ],
            [
                'category' => 'communityDescription'
                ,'href' => 'https://1d4chan.org/wiki/High_Elves_(Warhammer_Fantasy)'
                ,'locale' => 'en_US'
            ],
            [
                'category' => 'communityRule'
                ,'href' => 'http://warhammerarmiesproject.blogspot.com/search/label/Cathay'
                ,'locale' => 'en_US'
            ],
            [
                'category' => 'communityDescription'
                ,'href' => 'https://www.the-ninth-age.com/community/lexicon/index.php?lexicon/29-highborn-elves-he/'
                ,'locale' => 'en_US'
            ],
            [
                'category' => 'communityForum'
                ,'href' => 'https://www.the-ninth-age.com/community/index.php?board/7-highborn-elves-he/'
                ,'locale' => 'en_US'
            ],
            
            
        ]
    
    ],
        ['WOOD_ELVES', 'en_US', 'Wood elves'],
        ['DARK_ELVES', 'en_US', 'Dark elves'],
        ['BRETONNIA',        'en_US', 'Bretonnia'],
        ['EMPIRE',                                  'en_US',                                  'Empire'],
        ['DWARFS',                                  'en_US',                                  'Dwarfs'],
        ['CHAOS DWARFS',                                  'en_US',                                  'Chaos Dwarfs'],
        ['LIZARDMEN',                                  'en_US',                                  'Lizardmen'],
        ['GREENSKINS',                                  'en_US',                                  'Greenskins'],
        ['BEASTMEN',                                  'en_US',                                  'Beastmen'],
        ['DAEMONS',                                  'en_US',                                  'Daemons'],
        ['WARRIORS_OF_CHAOS',                                  'en_US',                                  'Warriors of Chaos'],
        ['SKAVEN',                                  'en_US',                                  'Skaven'],
        ['VAMPIRE_COUNTS',                                  'en_US',                                  'Vampire Counts'],
        ['TOMB_KINGS',                                  'en_US',                                  'Tomb Kings'],
        ['OGRE_KINGDOMS',                                  'en_US',                                  'Ogre Kingdoms'],
        ['MARIENBURG',                                  'en_US',                                  'Marienburg'],
        ['TILEA',                                  'en_US',                                  'Tilea'],
        ['ESTALIA',                                  'en_US',                                  'Estalia'],
        ['NORSCA',                                  'en_US',                                  'Norsca'],
        ['KISLEV',                                  'en_US',                                  'Kislev'],
        ['ARABY',                                  'en_US',                                  'Araby'],
        ['CATHAY',                                  'en_US',                                  'Cathay'
        ,'externalLinks' =>[
            [
                'category' => 'communityDescription'
                ,'href' => 'http://bibliotheque-imperiale.com/index.php/Cat%C3%A9gorie:Cathay'
                ,'locale' => 'fr_FR'
            ],
            [
                'category' => 'communityHistory'
                ,'href' => 'http://bibliotheque-imperiale.com/index.php/Histoire_de_Cathay'
                ,'locale' => 'fr_FR'
            ],
            [
                'category' => 'communityHistory'
                ,'href' => 'http://bibliotheque-imperiale.com/index.php/Histoire_de_Cathay'
                ,'locale' => 'fr_FR'
            ],[
                'category' => 'communityRule'
                ,'href' => 'http://warhammerarmiesproject.blogspot.com/search/label/Cathay'
                ,'locale' => 'en_US'
            ]
            
        ]
    ],
        ['NIPPON',                                  'en_US',                                  'Nippon'
    
        ,'externalLinks' =>[
            [
                'category' => 'communityDescription'
                ,'href' => 'http://bibliotheque-imperiale.com/index.php/Cat%C3%A9gorie:Nippon'
                ,'locale' => 'fr_FR'
            ],
            [
                'category' => 'communityHistory'
                ,'href' => 'http://bibliotheque-imperiale.com/index.php/Histoire_de_Nippon'
                ,'locale' => 'fr_FR'
            ]

        ]
        
    ],
        ['ALBION',                                  'en_US',                                  'Albion'],
        ['IND',                                  'en_US',                                  'Ind'],
        ['VAMPIRE_COAST',                                  'en_US',                                  'Vampire Coast'],


    ];

    public function load(ObjectManager $manager)
    {
        $worldAlignmentRepository = $manager->getRepository(WorldAlignment::class);

        foreach ($this->data as $data) {
            $object = new Nation();
            $object->setId($data[0]);
            $object->setName($data[2]);
            $object->addTag($this->tagManager->loadOrCreate($data[2]));
            $manager->persist($object);
        }
        $manager->flush();
    }
}
