<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Entity\GameSystem;
use App\Entity\Nation;
use App\Entity\ProfileAOS4;
use App\Entity\ProfileT9A12;
use App\Entity\ProfileWFB12;
use App\Entity\ProfileWFB9;
use App\Entity\ProfileWHQ;
use App\Entity\Race;
use App\Entity\Rule;
use App\Entity\UnitGameSystem;
use App\Entity\UnitGeneric;
use App\Helper\NationHelper;
use App\Manager\TagManager;
use App\Manager\UnitGenericManager;
use App\Repository\EquipmentRepository;
use App\Repository\EquipmentTypeRepository;
use App\Repository\RuleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\StorageAttributes;

class UnitT9AFixtures extends Fixture implements DependentFixtureInterface
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

    /**
     * @var UnitGenericManager
     */
    protected $unitGenericManager;

    public function __construct(TagManager $tagManager,
     EquipmentRepository $equipmentRepository,
      RuleRepository $ruleRepository,
      EquipmentTypeRepository $equipmentTypeRepository,
      UnitGenericManager $unitGenericManager
      ) {
        $this->tagManager = $tagManager;
        $this->equipmentRepository = $equipmentRepository;
        $this->ruleRepository = $ruleRepository;
        $this->equipmentTypeRepository = $equipmentTypeRepository;
        $this->unitGenericManager = $unitGenericManager;
    }

    public function load(ObjectManager $manager)
    {
        $gameSystemRepository = $manager->getRepository(GameSystem::class);
        $nationRepository = $manager->getRepository(Nation::class);
        $raceRepository = $manager->getRepository(Race::class);

        $adapter = new LocalFilesystemAdapter(
            // Determine root directory
            __DIR__.'/The-9th-Age'
        );
        $filesystem = new Filesystem($adapter);
        $allFiles = $filesystem->listContents('/')->filter(function (StorageAttributes $attributes) {return $attributes->isFile(); });
        foreach ($allFiles as $item) {
            if ($item->isFile() && 'cat' == pathinfo($item->path(), PATHINFO_EXTENSION)) {
                $nation = null;
                $xmlParser = new \Hobnob\XmlStreamReader\Parser();
                $xmlParser->registerCallback(
                    '/catalogue',
                    function (\Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node) use (&$nation, $nationRepository) {
                        $nationName = $node->attributes()->name;
                        //var_dump($nationName);
                        $matches = [];
                        preg_match_all('/(^[^-0-9(]*)/', $nationName, $matches);
                        $nationName = trim($matches[0][0]);
                        $nationCode = str_replace(' ', '_', strtoupper($nationName));
                        $nationCode = NationHelper::fixNationCodeName($nationCode);
                        $nationName = NationHelper::fixNationCodeName($nationName);
                        $nation = $nationRepository->find($nationCode);
                        if (null == $nation) {
                            throw new \Exception(sprintf('Nation %s not found', $nationCode));
                        }
                    }
                );
                $xmlParser->parse($filesystem->readStream($item->path()));

                $xmlParser = new \Hobnob\XmlStreamReader\Parser();
                $xmlParser->registerCallback(
                    '/catalogue/selectionEntries/selectionEntry',
                    function (\Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node) use (&$nation, $gameSystemRepository, $manager) {
                        if ('unit' == $node->attributes()->type) {
                            if (
                                0 == count($node->xpath('./selectionentries/selectionentry/profiles/profile/characteristics/characteristic[ @name="Adv" or @name="Mar" or @name="Dis"  or @name="HP" or @name="Def" or @name="Res" or @name="Arm"  or  @name="Att" or @name="Off" or @name="Str" or @name="AP" or @name="Agi" ]'))
                                && 0 == count($node->xpath('./profiles/profile/characteristics/characteristic[ @name="Adv" or @name="Mar" or @name="Dis"  or @name="HP" or @name="Def" or @name="Res" or @name="Arm"  or  @name="Att" or @name="Off" or @name="Str" or @name="AP" or @name="Agi" ]'))) {
                                var_dump('No characteristic for '.$node->attributes()->name);

                                return;
                            }
                            $nodeToProcesses = [$node];
                            $expandedNodes = $node->xpath('./selectionentrygroups/selectionentrygroup[not(contains(@name,"quipment"))]/selectionentries/selectionentry');
                            if (count($expandedNodes) > 0) {
                                // var_dump('Expanded unit');
                                $nodeToProcesses = $expandedNodes;
                            }

                            foreach ($nodeToProcesses as $nodeToProcess) {
                                $profileArray = $this->convertToProfileData($nodeToProcess, $node);

                                $unitName = $nodeToProcess->attributes()->name;
                                //var_dump('OK for '.$unitName);
                                if (!$profileArray['isCompleted']) {
                                    var_dump('Profile invalide for '.$unitName.'. Skip');
                                    continue;
                                }

                                $object = $this->unitGenericManager->findByBaseNameAndNation($unitName, $nation);
                                if (0 == count($object)) {
                                    $object = new UnitGeneric();
                                    $object->setBaseName($unitName);
                                } elseif (count($object) > 1) {
                                    throw new \Exception('Mot than one for '.$unitName);
                                } else {
                                    $object = $object[0];
                                }
                                $object->addNation($nation);
                                // === Game system
                                $gameSystem = 'T9AV2';
                                $gameSystem = $gameSystemRepository->find($gameSystem);
                                if (null == $gameSystem) {
                                    throw new \Exception('Games system '.$gameSystem.' not found');
                                }

                                $profile = $this->createProfileByGameSystem($gameSystem, $profileArray, $manager);
                                $unitGamesSystem = (new UnitGameSystem())
                                ->setGameSystem($gameSystem)
                                ->setName($profile->getName())
                                ->addTag($this->tagManager->loadOrCreate($profile->getName()));

                                $manager->persist($profile);

                                $unitGamesSystem->addProfile($profile);

                                $object->addUnitGameSystem($unitGamesSystem);
                                $manager->persist($unitGamesSystem);
                                $manager->persist($object);
                                $manager->flush();

                                //var_dump($node->xpath('//profile'));
                            }
                        }
                    }
                );
                $xmlParser->parse($filesystem->readStream($item->path()));
            }
        }

        $manager->flush();
    }

    protected function convertToProfileData($xmlNode, $initialNode)
    {
        /*
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

        */

        // var_dump('convertToProfileData :'.$xmlNode->attributes()->name );

        $profile = [
            $this->getGoodName($initialNode, $xmlNode, $xmlNode->attributes()->name),
            $this->getGoodData($initialNode, $xmlNode, 'Adv'),
            $this->getGoodData($initialNode, $xmlNode, 'Mar'),
            $this->getGoodData($initialNode, $xmlNode, 'Dis'),
            $this->getGoodData($initialNode, $xmlNode, 'HP'),
            $this->getGoodData($initialNode, $xmlNode, 'Def'),
            $this->getGoodData($initialNode, $xmlNode, 'Res'),
            $this->getGoodData($initialNode, $xmlNode, 'Arm'),
            $this->getGoodData($initialNode, $xmlNode, 'Att'),
            $this->getGoodData($initialNode, $xmlNode, 'Off'),
            $this->getGoodData($initialNode, $xmlNode, 'Str'),
            $this->getGoodData($initialNode, $xmlNode, 'AP'),
            $this->getGoodData($initialNode, $xmlNode, 'Agi'),
            'equipments' => [],
            'rules' => [],
        ];
        $profile['isCompleted'] = count(array_keys($profile, '')) < 2;

        /*
                $zeroEquipment = $xmlNode->xpath('./../../selectionentries/selectionentry/costs/cost[@value="0.0"]/../..');

                foreach($zeroEquipment as $equipment)
                {

                    $infolinks = $equipment->xpath('./infolinks/infolink');
                    foreach($infolinks as $infolink)
                    {
                        if($infolink->attributes()->type=="rule")
                        {
                            $profile['rules'][]=$infolink->attributes()->name;
                        }
                        if($infolink->attributes()->type=="profile")
                        {
                            $profile['equipments'][]=$infolink->attributes()->name;
                        }

                    }
                }
        */
        return $profile;
    }

    protected function getGoodName($initialNode, $xmlNode, $defaultName)
    {
        if (count($initialNode->xpath('./profiles/profile[@name]')) > 0) {
            $name = (string) $initialNode->xpath('./profiles/profile[@name]')[0]->attributes()->name;
        } elseif (count($initialNode->xpath('./selectionentries/selectionentry/profiles/profile[@name]')) > 0) {
            $name = (string) $initialNode->xpath('./selectionentries/selectionentry/profiles/profile[@name]')[0]->attributes()->name;
        } elseif (count($initialNode->xpath('./selectionentries/selectionentry/profiles/profile[@name]')) > 0) {
            $name = (string) $initialNode->xpath('./selectionentries/selectionentry/profiles/profile[@name]')[0]->attributes()->name;
        } elseif (count($xmlNode->xpath('./profiles/profile[@name]')) > 0) {
            $name = (string) $xmlNode->xpath('./profiles/profile[@name]')[0];
        } else {
            $name = $defaultName;
        }

        return str_replace(['Global', 'Size', 'Defensive', 'Offensive'], '', $name);
    }

    protected function getGoodData($initialNode, $xmlNode, $name)
    {
        if (count($initialNode->xpath('./profiles/profile/characteristics/characteristic[@name="'.$name.'"]')) > 0) {
            return (string) $initialNode->xpath('./profiles/profile/characteristics/characteristic[@name="'.$name.'"]')[0];
        }
        if (count($initialNode->xpath('./selectionentries/selectionentry/profiles/profile/characteristics/characteristic[@name="'.$name.'"]')) > 0) {
            return (string) $initialNode->xpath('./selectionentries/selectionentry/profiles/profile/characteristics/characteristic[@name="'.$name.'"]')[0];
        }
        if (count($xmlNode->xpath('./profiles/profile/characteristics/characteristic[@name="'.$name.'"]')) > 0) {
            return (string) $xmlNode->xpath('./profiles/profile/characteristics/characteristic[@name="'.$name.'"]')[0];
        }
        //throw new \Exception('Data not found for '.$name);
        return '';
    }

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

    protected function createProfileByGameSystem(GameSystem $gameSystem, $profileData, $manager)
    {
        $profile = $gameSystem->newProfile()
            ->addTag($this->tagManager->loadOrCreate($profileData[0]))
            ->setName($profileData[0]);

        if (array_key_exists('equipments', $profileData)) {
            foreach ($profileData['equipments'] as $equipmentName) {
                $equipment = $this->equipmentRepository->findOneBy(['name' => $equipmentName, 'gameSystem' => $gameSystem]);
                if (null === $equipment) {
                    $equipment = new Equipment();
                    $equipment->setGameSystem($gameSystem);
                    $equipment->setType($this->equipmentTypeRepository->find('U'));
                    $equipment->setName($equipmentName);
                    $equipment->setDescription($equipmentName);

                    $manager->persist($equipment);
                    $manager->flush();

                    // throw new \Exception(sprintf('%s equipment not found', $equipmentName));
                }

                $profile->addEquipment($equipment);
            }
        }

        if (array_key_exists('rules', $profileData)) {
            foreach ($profileData['rules'] as $ruleName) {
                $rule = $this->ruleRepository->findOneBy(['name' => $ruleName, 'gameSystem' => $gameSystem]);
                if (null === $rule) {
                    $rule = new Rule();
                    $rule->setGameSystem($gameSystem);

                    $rule->setName($ruleName);
                    $rule->setDescription($ruleName);

                    $manager->persist($rule);
                    $manager->flush();

                    //throw new \Exception(sprintf('%s rule not found', $ruleName));
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
