<?php

namespace App\DataFixtures;

use App\Manager\TagManager;
use App\Repository\GameSystemRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Equipment;

class EquipmentFixtures extends Fixture implements DependentFixtureInterface
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
        ['en_US', 'Spear', '', 'gameSystems' => ['WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Sword', '', 'gameSystems' => ['WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Light armour', '', 'gameSystems' => ['WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Shield', '', 'gameSystems' => ['WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Hand weapon', 'Sword, axe or mace', 'gameSystems' => ['WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Longbow', '', 'gameSystems' => ['WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Bow', '', 'gameSystems' => ['WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Silverwood Spear', 'Add 1 to the Attacks characteristic of this unit’s Silverwood Spears while it has 20 or more models.', 'gameSystems' => ['AOSV1', 'AOSV2']],
        ['en_US', 'Aelven Shield', 'Re-roll save rolls of 1 for a unit with Aelven Shields. In the shooting phase, re-roll failed save rolls of 1
        or 2 instead.', 'gameSystems' => ['AOSV1', 'AOSV2']],

        
    ];

    protected function getGameSystem($gameSystem)
    {
        $gameSystems = [];

        if (!array_key_exists($gameSystem, $gameSystems)) {
            $gameSystemObject = $this->gameSystemRepository->find($gameSystem);

            if (null === $gameSystemObject) {
                throw new \Exception(sprintf('%s games system not found'));
            }
            $gameSystems[$gameSystem] = $gameSystemObject;
        }

        return $gameSystems[$gameSystem];
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            foreach ($data['gameSystems'] as $gameSystem) {
                $object = new Equipment();
                $object->setGameSystem($this->getGameSystem($gameSystem));

                $object->setName($data[1]);
                $object->setDescription($data[2]);

                $manager->persist($object);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GameSystemFixtures::class,
        ];
    }
}
