<?php

namespace App\DataFixtures;

use App\Entity\GameLine;
use App\Manager\TagManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameLineFixtures extends Fixture
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
        ['WARHAMMER_FANTASY_BATTLE', 'en_US', 'Warhammer Fantasy Battle',  'Games Workshop'],
        ['WARHAMMER_AGE_OF_SIGMAR', 'en_US', 'Warhammer Age Of Sigmar V1', 'Games Workshop'],
        ['THE_NINTH_AGE', 'en_US', 'The 9th Age', 'The 9th Age Community'],
        ['KING_OF_WAR', 'en_US', 'King OF War', 'Mantic Games'],
        ['WARHAMMER_ARMIES_PROJECT', 'en_US', 'Warhammer Armies Project',  'Mathias Eliasson'],
        ['RUNEWARS_MINIATURES_GAME', 'en_US', 'Runewars miniatures game',  'Fantasy Flight Games'],
        ['FROSTGRAVE', 'en_US', 'Frostgrave',  'Osprey Games'],
        ['SAGA', 'en_US', 'Saga',  'Studio Tomahawk'],
        ['AGE_OF_FANTASY', 'en_US', 'Age of fantasy',  'onepagerules'],
        ['CHRONOPIA', 'en_US', 'Chronopia',  'Target Games'],
        ['WARMACHINE', 'en_US', 'Warchine',  'Privateer Press'],
        ['CONFRONTATION', 'en_US', 'Confrontation',  'Rackham'],
     ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $object = new GameLine();
            $object->setId($data[0]);
            $object->setName($data[2]);
            $object->addTag($this->tagManager->loadOrCreate($data[2]));
            $object->setPublisher($data[3]);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
