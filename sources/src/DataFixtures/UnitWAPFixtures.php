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
use App\Manager\TagManager;
use App\Repository\EquipmentRepository;
use App\Repository\EquipmentTypeRepository;
use App\Repository\GameSystemRepository;
use App\Repository\RuleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\StorageAttributes;

class UnitWAPFixtures extends Fixture implements DependentFixtureInterface
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
     EquipmentRepository $equipmentRepository, RuleRepository $ruleRepository,EquipmentTypeRepository $equipmentTypeRepository)
    {
        $this->tagManager = $tagManager;
        $this->equipmentRepository = $equipmentRepository;
        $this->ruleRepository = $ruleRepository;
        $this->equipmentTypeRepository = $equipmentTypeRepository;
    }

    protected $data = [
        'High elf warrior / citizen / militia' => [
            'race' => 'ELF',
            'nation' => 'HIGH_ELVES',
            'tags' => [
                'High elf warrior', 'High elf citizen', 'High elf militia',
            ],
            'profiles' => [
                'WFBV3' => [
                    ['Elf', 5, 4, 4, 3, 3, 1, 6, 1, 8, 9, 9, 8],
                ],
                'WFBV4' => [
                    [
                        'High elf spearmen', 5, 4, 4, 3, 3, 1, 6, 1, 8, 'equipments' => ['Spear', 'Sword', 'Shield', 'Light armour'],
                    ],
                    ['High elf warrior', 5, 4, 4, 3, 3, 1, 6, 1, 8, 'equipments' => ['Spear', 'Shield', 'Light armour']],
                    ['Archer', 5, 4, 4, 3, 3, 1, 6, 1, 8, 'equipments' => ['Spear', 'Hand weapon', 'Shield', 'Light armour']],
                    ['Champion', 5, 5, 5, 4, 3, 1, 7, 2, 8],
                ],
                'MHV1' => [
                   ['High elf warrior', 4, 3, 4, 3, 3, 1, 4, 1, 9, 'equipments' => [
                    'Knife',
                    'Mace',
                    'Sword',
                    'Double-handed weapon',
                    'Flail',
                    'Light armour',
                    'Heavy armour',
                    'Shield',
                    'Helmet',
                    'Buckler',
                    'Ithilmar armour',
                   ]],
                   ['High elf archer', 4, 3, 4, 3, 3, 1, 4, 1, 9, 'equipments' => [
                    'Knife',
                    'Mace',
                    'Sword',
                    'Spear',
                    'Bow',
                    'Short bow',
                    'Long bow',
                    'Elf bow',
                    'Light armour',
                    'Shield',
                    'Helmet',
                   ]],
                ],
                'WFBV5' => [
                    [
                        'Elven spearmen', 5, 4, 4, 3, 3, 1, 6, 1, 8, 'equipments' => ['Spear', 'Shield', 'Light armour'], 'rules' => ['Citizen levy'],
                    ],
                    ['Champion', 5, 5, 5, 4, 3, 1, 7, 2, 8, 'equipments' => ['Spear', 'Shield', 'Light armour']],
                    ['Archer', 5, 4, 4, 3, 3, 1, 6, 1, 8],
                ],
                'WFBV6' => [
                    [
                        'Spearmen', 5, 4, 4, 3, 3, 1, 5, 1, 8, 'equipments' => ['Spear', 'Hand weapon', 'Shield', 'Light armour'], 'rules' => ['Fight in three ranks with spears'],
                    ],
                    ['Champion', 5, 4, 4, 3, 3, 1, 5, 2, 8],
                    ['Archer', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                ],
                'WFBV7' => [
                    [
                        'Spearmen', 5, 4, 4, 3, 3, 1, 5, 1, 8, 'equipments' => ['Spear', 'Hand weapon', 'Shield', 'Light armour'], 'rules' => ['Valour of ages', 'Speed of suryan', 'Martial Prowess'],
                    ],
                    ['Sentinel', 5, 4, 4, 3, 3, 1, 5, 2, 8, 'equipments' => ['Spear', 'Hand weapon', 'Shield', 'Light armour']],
                    ['Archer', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                    ['Hawkeyes', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                ],
                'WFBV8' => [
                    ['Spearmen', 5, 4, 4, 3, 3, 1, 5, 1, 8, 'equipments' => ['Spear', 'Shield', 'Light armour']],
                    ['Sentinel', 5, 4, 4, 3, 3, 1, 5, 2, 8, 'equipments' => ['Spear', 'Shield', 'Light armour']],
                    ['Archer', 5, 4, 4, 3, 3, 1, 5, 1, 8],
                    ['Hawkeyes', 5, 4, 5, 3, 3, 1, 5, 1, 8],
                ],
                'T9AV2' => [
                    ['Citizen Spears', 5, 10, 8, 1, 4, 3, 0, 1, 4, 3, 0, 5, 'equipments' => ['Spear', 'Shield', 'Light armour']],
                    ['Citizen Archers', 5, 10, 8, 1, 4, 3, 0, 1, 4, 3, 0, 5, 'equipments' => ['Spear', 'Shield', 'Light armour']],
                ],
                'WHQV1' => [
                    // name + title , battle level, gold,M,WS,BS,S,DiceDamage, T, W,I, A, Luck, WillPower, Skills, Pin
                    ['Ranger elf novice', 1, 0, 4, 4, '5+', 3, 1, 3, '1D6+7', 5, 1, 0, 2, '-', '3+'],
                    ['Ranger elf champion', 2, 2000, 4, 5, '5+', 3, 1, 3, '2D6+8', 6, 1, 0, 3, 1, '3+'],
                ],
                'AOSV1' => [
                    ['Highborn spearmen', 6, 1, 6, '5+', 'equipments' => ['Silverwood Spear', 'Aelven Shield']],
                    ['Highborn archer', 6, 1, 6, '5+'],
                ],
            ],
        ],
    ];

    public function load(ObjectManager $manager)
    {
        $gameSystemRepository = $manager->getRepository(GameSystem::class);
        $nationRepository = $manager->getRepository(Nation::class);
        $raceRepository = $manager->getRepository(Race::class);


        $adapter = new LocalFilesystemAdapter(
            // Determine root directory
            __DIR__.'/warhammer-armies-project'
        );
        $filesystem = new Filesystem($adapter);
        $allFiles = $filesystem->listContents('/')->filter(function (StorageAttributes $attributes) {return $attributes->isFile(); });
        foreach ($allFiles as $item) {
            if($item->isFile() && pathinfo($item->path(),PATHINFO_EXTENSION) == 'cat')
            {
                $nation = null;
                $xmlParser = new \Hobnob\XmlStreamReader\Parser();
                $xmlParser->registerCallback(
                    '/catalogue',
                    function( \Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node ) use (&$nation,$nationRepository,$manager) {
                        
                        $nationCode = str_replace(' ','_',strtoupper($node->attributes()->name));
                        var_dump($nationCode);
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
                    function( \Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node ) use (&$nation,$gameSystemRepository,$manager) {
                        
                        if($node->attributes()->type == 'unit')
                        {
                                                      
                            $profiles = $node->xpath('./selectionentries/selectionentry/profiles/profile');
                            if(count($profiles) == 0)
                            {
                                var_dump('No profile for '.$node->attributes()->name);
                                return;
                            }
                            $profileXml = $profiles[0];
                            if(count($profileXml->xpath('./characteristics/characteristic[@name="M"]')) == 0)
                            {
                                var_dump('No characteristic for '.$node->attributes()->name);
                                return;
                            }
                            $object = new UnitGeneric();
                            $unitName = $node->attributes()->name;
                            $object->setBaseName($unitName);
                      
                            $object->addNation($nation);
                            $gameSystem = 'WFBAPV9';
                            $gameSystem = $gameSystemRepository->find($gameSystem);
                            if (null == $gameSystem) {
                                throw new \Exception('Games system '.$gameSystem.' not found');
                            }
                            $unitGamesSystem = (new UnitGameSystem())
                            ->setGameSystem($gameSystem)
                            ->setName($unitName)
                            ->addTag($this->tagManager->loadOrCreate($unitName));
                            
                            $profile = $this->createProfileByGameSystem($gameSystem, $this->convertToProfileData($profileXml),$manager);

                            $manager->persist($profile);
                            $unitGamesSystem->addProfile($profile);
                            $object->addUnitGameSystem($unitGamesSystem);
                            $manager->persist($unitGamesSystem);

                            $manager->persist($object);
                           
                            //var_dump($node->xpath('//profile'));
                            
                        }
                        
                    }
                );
                $xmlParser->parse($filesystem->readStream($item->path()));
              
            }
            
        }

        $manager->flush();
    }


    protected function convertToProfileData($xmlNode)
    {

        /*
        ->setMovement($profileData[1])
                    ->setWeaponSkill($profileData[2])
                    ->setBallisticSkill($profileData[3])
                    ->setStrength($profileData[4])
                    ->setToughness($profileData[5])
                    ->setWounds($profileData[6])
                    ->setInitiative($profileData[7])
                    ->setAttacks($profileData[8])
                    ->setLeadership($profileData[9]);
        */
        
        // var_dump('convertToProfileData :'.$xmlNode->attributes()->name );

        $profile =  [
            $xmlNode->attributes()->name,
            (string)$xmlNode->xpath('./characteristics/characteristic[@name="M"]')[0],
            (string)$xmlNode->xpath('./characteristics/characteristic[@name="WS"]')[0],
            (string)$xmlNode->xpath('./characteristics/characteristic[@name="BS"]')[0],
            (string)$xmlNode->xpath('./characteristics/characteristic[@name="S"]')[0],
            (string)$xmlNode->xpath('./characteristics/characteristic[@name="T"]')[0],
            (string)$xmlNode->xpath('./characteristics/characteristic[@name="W"]')[0],
            (string)$xmlNode->xpath('./characteristics/characteristic[@name="I"]')[0],
            (string)$xmlNode->xpath('./characteristics/characteristic[@name="A"]')[0],
            (string)$xmlNode->xpath('./characteristics/characteristic[@name="LD"]')[0],
            'equipments' => []                     ,
            'rules' => [],
        ];

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

        return $profile;

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

    protected function createProfileByGameSystem(GameSystem $gameSystem, $profileData,$manager)
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