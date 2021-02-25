<?php

namespace App\DataFixtures;

use App\Entity\GameSystem;
use App\Entity\Nation;
use App\Entity\ProfileAOS4;
use App\Entity\ProfileT9A12;
use App\Entity\ProfileWFB12;
use App\Entity\ProfileWFB9;
use App\Entity\ProfileWHQ;
use App\Entity\Race;
use App\Entity\UnitGameSystem;
use App\Entity\UnitGeneric;
use App\Manager\TagManager;
use App\Repository\EquipmentRepository;
use App\Repository\RuleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use League\Csv\Reader;

class WHQUnitFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var TagManager
     */
    protected $tagManager;

    /**
     * @var EquipmentRepository
     */
    protected $equipmentRepository;
    /**
     * @var EquipmentRepository
     */
    protected $ruleRepository;

    public function __construct(TagManager $tagManager,
     EquipmentRepository $equipmentRepository, RuleRepository $ruleRepository)
    {
        $this->tagManager = $tagManager;
        $this->equipmentRepository = $equipmentRepository;
        $this->ruleRepository = $ruleRepository;
    }

    public function load(ObjectManager $manager)
    {
        $gameSystemRepository = $manager->getRepository(GameSystem::class);
        $nationRepository = $manager->getRepository(Nation::class);
        $raceRepository = $manager->getRepository(Race::class);

        $csv = Reader::createFromPath(__DIR__.'/whq.csv', 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader();
        $data = $csv->getRecords();

        foreach ($data as $unitData) {
            $unitName = $unitData['Monster Name'];

            $object = new UnitGeneric();
            $object->setBaseName($unitName);

            if (array_key_exists('tags', $unitData)) {
                foreach ($unitData['tags'] as $tag) {
                    $object->addTag($this->tagManager->loadOrCreate($tag));
                }
            }
            $nation = $nationRepository->find($unitData['Type']);
            if($nation == null)
            {
                var_dump($unitData['Type']);die;
            }
            $object->addNation($nation);
            
                        
            $object->setRace($raceRepository->find($unitData['Race']));
            $gameSystemCode = 'WHQV1';
            $profileData = [[
                $unitData['Monster Name']
                /*
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
                */
                ,
                $unitData['Level'],
                $unitData['Gold (Each)'], 
                $unitData['Move'],
                $unitData['WS'],
                $unitData['BS'],
                $unitData['Strength'],
                $unitData['Damage'],
                $unitData['T'],
                $unitData['Wounds'],
                $unitData['Initiative'],
                $unitData['Attacks'],
                $unitData['Monster Name'],
                $unitData['Monster Name'],
                $unitData['Monster Name'],
                '' /*$unitData[''] */,
                '' /*$unitData[''] */,
                '' /*$unitData[''] */,
                ]];
            
            $gameSystem = $gameSystemRepository->find($gameSystemCode);

            if (null == $gameSystem) {
                throw new \Exception(sprintf('Games system %s not found for %s unit', $gameSystemCode, $unitName));
            }

            $unitGamesSystem = (new UnitGameSystem())
                ->setGameSystem($gameSystem)
                ->setName($unitName)
                ->addTag($this->tagManager->loadOrCreate($unitName));

            foreach ($profileData as $oneProfileData) {
                $profile = $this->createProfileByGameSystem($gameSystem, $oneProfileData);

                $manager->persist($profile);
                $unitGamesSystem->addProfile($profile);
                $object->addUnitGameSystem($unitGamesSystem);
                $manager->persist($unitGamesSystem);

                $manager->persist($object);
            }
            
        }
        $manager->flush();
    }

    protected function createProfileByGameSystem(GameSystem $gameSystem, $profileData)
    {
        $profile = $gameSystem->newProfile()
            ->addTag($this->tagManager->loadOrCreate($profileData[0]))
            ->setName($profileData[0]);

        if (array_key_exists('equipments', $profileData)) {
            foreach ($profileData['equipments'] as $equipmentName) {
                $equipment = $this->equipmentRepository->findOneBy(['name' => $equipmentName, 'gameSystem' => $gameSystem]);
                if (null === $equipment) {
                    throw new \Exception(sprintf('%s equipment not found', $equipmentName));
                }

                $profile->addEquipment($equipment);
            }
        }

        if (array_key_exists('rules', $profileData)) {
            foreach ($profileData['rules'] as $ruleName) {
                $rule = $this->ruleRepository->findOneBy(['name' => $ruleName, 'gameSystem' => $gameSystem]);
                if (null === $rule) {
                    throw new \Exception(sprintf('%s rule not found', $ruleName));
                }

                $profile->addRule($rule);
            }
        }

        switch (get_class($profile)) {
            case ProfileWFB9::class:
                /* @var ProfileWFB9 $profile  */
                return $profile

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
                /* @var ProfileWFB12 $profile  */
                return $profile

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

            case ProfileT9A12::class:
                /* @var ProfileT9A12 $profile  */
                return $profile

                    ->setGlobalAdvanceRate($profileData[1])
                    ->setGlobalMarch($profileData[2])
                    ->setGlobalDiscipline($profileData[3])
                    ->setDefensiveHealthPoints($profileData[4])
                    ->setDefensiveSkill($profileData[5])
                    ->setDefensiveResilience($profileData[6])
                    ->setDefensiveArmour($profileData[7])
                    ->setOffensiveAgility($profileData[8])
                    ->setOffensiveAttack($profileData[9])
                    ->setOffensiveSkill($profileData[10])
                    ->setOffensiveStrength($profileData[11])
                    ->setOffensiveArmourPenetration($profileData[12]);

            case ProfileWHQ::class:
                /* @var ProfileWHQ $profile  */
                return $profile

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

            case ProfileAOS4::class:
                /* @var ProfileAOS4 $profile  */
                return $profile

                    ->setMovement($profileData[1])
                    ->setWounds($profileData[2])
                    ->setBravery($profileData[3])
                    ->setSave($profileData[4]);

            default:
                throw new \Exception(sprintf('type %s not found ', get_class($profile)));
        }
    }

    public function getDependencies()
    {
        return [
            GameSystemFixtures::class,
            NationFixtures::class,
            RaceFixtures::class,
            EquipmentFixtures::class,
            RuleFixtures::class,
        ];
    }
}
