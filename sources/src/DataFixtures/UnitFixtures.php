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

        'High elf warrior / citizen / militia' =>
        [
            'nation' => 'HIGH_ELVES',
            'profiles' => [
                'WFBV3' =>
                [
                    ['Elf', 5, 4, 4, 3, 3, 1, 6, 1, 8, 9, 9, 8],

                ],
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
                ],
                'WHQV1' =>
                [
                    // name + titla , battle level, gold,M,WS,BS,S,DiceDamage, T, W,I, A, Luck, WillPower, Skills, Pin
                    ['Ranger elf novice', 1, 0, 4, 4, '5+', 3, 1, 3, '1D6+7', 5, 1, 0, 2, '-', '3+'],
                    ['Ranger elf champion', 1, 2000, 4, 5, '5+', 3, 1, 3, '2D6+8', 6, 1, 0, 3, 1, '3+'],

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

                if($gameSystem == null)
                {
                    throw new \Exception(sprintf("Games system %s not found for %s unit",$gameSystemCode , $unitName));
                }

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

            case ProfileWFB12::class:
                /** @var ProfileWFB12 $profile  */
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
                    ->setLeadership($profileData[9])
                    ->setIntelligence($profileData[10])
                    ->setCool($profileData[11])
                    ->setWillPower($profileData[12]);

            case ProfileWHQ::class:
                /** @var ProfileWHQ $profile  */
                return $profile
                    ->setName($profileData[0])
                    ->setBattleLevel($profileData[1])
                    ->setGold($profileData[2])
                    ->setMovement($profileData[3])
                    ->setWeaponSkill($profileData[4])
                    ->setBallisticSkill($profileData[5])
                    ->setStrength($profileData[6])
                    ->setDamageDice($profileData[7])
                    ->setToughness($profileData[8])
                    ->setWounds($profileData[9])
                    ->setInitiative($profileData[10])
                    ->setAttacks($profileData[11])
                    ->setLuck($profileData[12])
                    ->setWillPower($profileData[13])
                    ->setSkills($profileData[14])
                    ->setEscapePinning($profileData[15]);
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
