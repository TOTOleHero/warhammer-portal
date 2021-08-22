<?php

namespace App\DataFixtures;

use App\Entity\EquipmentType;
use App\Manager\TagManager;
use App\Repository\GameSystemRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipmentTypeFixtures extends Fixture
{
    /**
     * @var TagManager
     */
    protected $tagManager;

    /**
     * @var GameSystemRepository
     */
    protected $gameSystemRepository;

    public function __construct(TagManager $tagManager, GameSystemRepository $gameSystemRepository)
    {
        $this->tagManager = $tagManager;
        $this->gameSystemRepository = $gameSystemRepository;
    }

    protected $data = [
        ['en_US', 'Hand-to-hand combat weapons', '', 'HHW'],
        ['en_US', 'Missile Weapons', '', 'MW'],
        ['en_US', 'Armour', '', 'A'],
        ['en_US', 'Unknown', '', 'U'],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $object = new EquipmentType();
            $object->setName($data[1]);
            //$object->setDescription($data[2]);
            $object->setId($data[3]);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
