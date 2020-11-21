<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\WorldAlignment;
use App\Entity\Unit;
use App\Entity\Nation;
use App\Entity\GameSystem;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


use App\Entity\ProfileWFB12;
use App\Entity\ProfileWFB9;
use App\Entity\ProfileAOS4;
use App\Entity\ProfileWHQ;

class UnitFixtures extends Fixture implements DependentFixtureInterface
{

    protected $data = [
        'High elf warrior citizen' =>
        [
            'nation' => 'HIGH_ELVES',
            'profiles' => [
                'WFBV4' =>
                [
                    ['High elf spearmen', 5, 4, 4, 3, 3, 1, 6, 1, 8],
                    ['High elf warrior', 5, 4, 4, 3, 3, 1, 6, 1, 8],
                    ['Archer', 5, 4, 4, 3, 3, 1, 6, 1, 8],
                    ['Champion', 5, 5, 5, 4, 3, 1, 7, 2, 8]
                ],
                'WFBV5' =>
                [
                    ['Elven spearmen', 5, 4, 4, 3, 3, 1, 6, 1, 8],
                    ['Champion', 5, 5, 5, 4, 3, 1, 7, 2, 8],
                    ['Archer', 5, 4, 4, 3, 3, 1, 6, 1, 8],
                ],
                'WFBV6' =>
                [
                    ['Spearmen', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                    ['Champion', 5, 4, 4, 3, 3, 1, 5, 2, 8],
                    ['Archer', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                ],
                'WFBV7' =>
                [
                    ['Spearmen', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                    ['Sentinel', 5, 4, 4, 3, 3, 1, 5, 2, 8],
                    ['Archer', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                    ['Hawkeyes', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                ],
                'WFBV8' =>
                [
                    ['Spearmen', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                    ['Sentinel', 5, 4, 4, 3, 3, 1, 5, 2, 8],
                    ['Archer', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                    ['Hawkeyes', 5, 4, 5, 3, 3, 1, 5, 1, 8],
                ]
            ]
        ]
    ];

    public function load(ObjectManager $manager)
    {

        $gameSystemRepository = $manager->getRepository(GameSystem::class);
        $nationRepository = $manager->getRepository(Nation::class);

        foreach ($this->data as $unitName => $unitData) {
            $object = new Unit();
            $object->setBaseName($unitName);
            $object->setNation($nationRepository->find($unitData['nation']));
            foreach ($unitData['profiles'] as $gameSystemCode => $profiles) {


                $gameSystem = $gameSystemRepository->find($gameSystemCode);

                foreach ($profiles as $profileData) {

                    $profile = $this->createProfileByGameSystem($gameSystem, $profileData);
                    $manager->persist($profile);
                    $object->addProfile($profile);



                    $manager->persist($object);
                }
            }
        }
        $manager->flush();
    }


    protected function createProfileByGameSystem(GameSystem $gameSystem, $profileData)
    {
        $profile = $gameSystem->newProfile();

        switch (get_class($profile)) {
            case ProfileWFB9::class:
                /** @var ProfileWFB9 $profile  */
                return $profile
                    ->setName($profileData[0])
                    ->setMovement($profileData[1])
                    ->setWeaponSkill($profileData[2])
                    ->setBallisticSkill($profileData[3])
                    ->setStrength($profileData[4])
                    ->setToughness($profileData[5])
                    ->setWounds($profileData[6])
                    ->setInitiative($profileData[7])
                    ->setAttacks($profileData[8])
                    ->setLeadership($profileData[9]);
        }
    }


    public function getDependencies()
    {
        return array(
            GameSystemFixtures::class,
            NationFixtures::class,
        );
    }
}
