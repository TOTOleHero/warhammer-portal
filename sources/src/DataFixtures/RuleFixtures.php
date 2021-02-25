<?php

namespace App\DataFixtures;

use App\Entity\Rule;
use App\Manager\TagManager;
use App\Repository\GameSystemRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RuleFixtures extends Fixture implements DependentFixtureInterface
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
        ['en_US', 'Citizen levy', 'Spear-armed High Elves can figth with one extra rank compared to other races. Two rank when they move, three rank when they stand.', 'gameSystems' => ['WFBV5']],
        ['en_US', 'Fight in three ranks with spears', 'Spear-armed High Elves can figth with one extra rank compared to other races. Two rank when they move, three rank when they stand.', 'gameSystems' => ['WFBV6']],
        ['en_US', 'Valour of ages', 'High Elves (not including any mounts) may re-roll any psychology tests when fighting Dark Elf army', 'gameSystems' => ['WFBV7', 'WFBV8']],
        ['en_US', 'Speed of suryan', 'All High Elves (not including any mounts) have rule "Always strikes first", ragardless of the weapon there are wielding', 'gameSystems' => ['WFBV7', 'WFBV8']],
        ['en_US', 'Martial Prowess', 'Spear-armed High Elves can figth with one extra rank compared to other races. Two rank when they move, three rank when they stand.', 'gameSystems' => ['WFBV7', 'WFBV8']],
        ['en_US', 'Martial discipline', '', 'gameSystems' => ['T9AV1', 'T9AV2']],
        ['en_US', 'Fight in Extra Rank', '', 'gameSystems' => ['T9AV1', 'T9AV2']],
        ['en_US', 'Lightning Reflexes,', '', 'gameSystems' => ['T9AV1', 'T9AV2']],
        ['en_US', 'Harnessed', '', 'gameSystems' => ['T9AV1', 'T9AV2']],
        ['en_US', 'Spear Phalanx', 'Re-roll hit rolls of 1 for this unit if it did not move in its preceding movement phase.', 'gameSystems' => ['AOSV1', 'AOSV2']],
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
                $object = new Rule();
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
