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
        ['HIGH_ELVES', 'en_US', 'High elves'],
        ['WOOD_ELVES', 'en_US', 'Wood elves'],
        ['DARK_ELVES', 'en_US', 'Dark elves'],
        ['BRETONNIA',        'en_US', 'Bretonnia',],
        ['EMPIRE',                                  'en_US',                                  'Empire',],
        ['DWARFS',                                  'en_US',                                  'Dwarfs',],
        ['CHAOS DWARFS',                                  'en_US',                                  'Chaos Dwarfs',],
        ['LIZARDMEN',                                  'en_US',                                  'Lizardmen',],
        ['GREENSKINS',                                  'en_US',                                  'Greenskins',],
        ['BEASTMEN',                                  'en_US',                                  'Beastmen',],
        ['DAEMONS',                                  'en_US',                                  'Daemons',],
        ['WARRIORS_OF_CHAOS',                                  'en_US',                                  'Warriors of Chaos',],
        ['SKAVEN',                                  'en_US',                                  'Skaven',],
        ['VAMPIRE_COUNTS',                                  'en_US',                                  'Vampire Counts',],
        ['TOMB_KINGS',                                  'en_US',                                  'Tomb Kings',],
        ['OGRE_KINGDOMS',                                  'en_US',                                  'Ogre Kingdoms',],
        ['MARIENBURG',                                  'en_US',                                  'Marienburg',],
        ['TILEA',                                  'en_US',                                  'Tilea',],
        ['ESTALIA',                                  'en_US',                                  'Estalia',],
        ['NORSCA',                                  'en_US',                                  'Norsca',],
        ['KISLEV',                                  'en_US',                                  'Kislev',],
        ['ARABY',                                  'en_US',                                  'Araby',],
        ['CATHAY',                                  'en_US',                                  'Cathay',],
        ['NIPPON',                                  'en_US',                                  'Nippon',],
        ['ALBION',                                  'en_US',                                  'Albion',],
        ['IND',                                  'en_US',                                  'Ind',],
        ['VAMPIRE_COAST',                                  'en_US',                                  'Vampire Coast',],


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
