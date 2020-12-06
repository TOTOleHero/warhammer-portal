<?php

namespace App\DataFixtures;

use App\Manager\TagManager;
use App\Repository\GameSystemRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Equipment;
use App\Repository\EquipmentTypeRepository;

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

    /**
     * @var EquipmentTypeRepository
     */
    protected $equipmentTypeRepository;

    public function __construct(TagManager $tagManager, GameSystemRepository $gameSystemRepository,EquipmentTypeRepository $equipmentTypeRepository)
    {
        $this->tagManager = $tagManager;
        $this->gameSystemRepository = $gameSystemRepository;
        $this->equipmentTypeRepository = $equipmentTypeRepository;
    }

    protected $data = [
        ['en_US', 'Spear', '', 'type'=>'HHW','gameSystems' => ['MHV1','WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Sword', '','type'=>'HHW', 'gameSystems' => ['MHV1','WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Light armour', '','type'=>'A', 'gameSystems' => ['MHV1','WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Shield', '','type'=>'A', 'gameSystems' => ['MHV1','WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Hand weapon','type'=>'HHW', 'Sword, axe or mace', 'gameSystems' => ['WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Long bow', '','type'=>'MW', 'gameSystems' => ['MHV1','WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Bow', '','type'=>'MW', 'gameSystems' => ['MHV1','WFBV4', 'WFBV5', 'WFBV6', 'WFBV7', 'WFBV8', 'T9AV1', 'T9AV2']],
        ['en_US', 'Silverwood Spear', 'Add 1 to the Attacks characteristic of this unit’s Silverwood Spears while it has 20 or more models.',
        'type'=>'HHW', 'gameSystems' => ['AOSV1', 'AOSV2']],
        ['en_US', 'Aelven Shield', 'Re-roll save rolls of 1 for a unit with Aelven Shields. In the shooting phase, re-roll failed save rolls of 1
        or 2 instead.', 'type'=>'A','gameSystems' => ['AOSV1', 'AOSV2']],

        ['en_US', 'Knife', '','type'=>'HHW', 'gameSystems' => ['MHV1']],
        ['en_US', 'Mace', '', 'type'=>'HHW','gameSystems' => ['MHV1']],
        ['en_US', 'Double-handed weapon', '','type'=>'HHW', 'gameSystems' => ['MHV1']],
        ['en_US', 'Flail', '', 'type'=>'HHW','gameSystems' => ['MHV1']],
        ['en_US', 'Elven Greatsword', 'Sword master only','type'=>'HHW', 'gameSystems' => ['MHV1']],
        ['en_US', 'Heavy armour', '', 'type'=>'A','gameSystems' => ['MHV1']],
        ['en_US', 'Helmet', '','type'=>'A', 'gameSystems' => ['MHV1']],
        ['en_US', 'Buckler', '', 'type'=>'A','gameSystems' => ['MHV1']],
        ['en_US', 'Ithilmar armour', '', 'type'=>'A','gameSystems' => ['MHV1']],
        ['en_US', 'Short bow', '', 'type'=>'MW','gameSystems' => ['MHV1']],
        ['en_US', 'Elf bow', '', 'type'=>'MW','gameSystems' => ['MHV1']],
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
                $object->setType($this->equipmentTypeRepository->find($data['type']));
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
            EquipmentTypeFixtures::class,
        ];
    }
}
