<?php

namespace App\DataFixtures;

use App\Entity\GameLine;
use App\Entity\GameSystem;
use App\Entity\ProfileType;
use App\Manager\TagManager;
use App\Repository\WorldRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GameSystemFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var TagManager
     */
    protected $tagManager;

    /**
     * @var
     */
    protected $worldRepository;

    public function __construct(TagManager $tagManager, WorldRepository $worldRepository)
    {
        $this->tagManager = $tagManager;
        $this->worldRepository = $worldRepository;
    }

    protected $data = [
        ['WHQV1', 'en_US', 'Warhammer Quest V1', 'profileWHQ', 'Games Workshop', 'warhammer-old-world', 'WARHAMMER_FANTASY_BATTLE'],
        ['WFBV3', 'en_US', 'Warhammer Fantasy Battle V3', 'profileWFB12', 'Games Workshop', 'warhammer-old-world', 'WARHAMMER_FANTASY_BATTLE'],
        ['WFBV4', 'en_US', 'Warhammer Fantasy Battle V4', 'profileWFB9', 'Games Workshop', 'warhammer-old-world', 'WARHAMMER_FANTASY_BATTLE'],
        ['WFBV5', 'en_US', 'Warhammer Fantasy Battle V5', 'profileWFB9', 'Games Workshop', 'warhammer-old-world', 'WARHAMMER_FANTASY_BATTLE'],
        ['WFBV6', 'en_US', 'Warhammer Fantasy Battle V6', 'profileWFB9', 'Games Workshop', 'warhammer-old-world', 'WARHAMMER_FANTASY_BATTLE'],
        ['WFBV7', 'en_US', 'Warhammer Fantasy Battle V7', 'profileWFB9', 'Games Workshop', 'warhammer-old-world', 'WARHAMMER_FANTASY_BATTLE'],
        ['WFBV8', 'en_US', 'Warhammer Fantasy Battle V8', 'profileWFB9', 'Games Workshop', 'warhammer-old-world', 'WARHAMMER_FANTASY_BATTLE'],
        ['AOSV1', 'en_US', 'Age Of Sigmar V1', 'profileAOS4', 'Games Workshop', 'mortal-realms', 'WARHAMMER_AGE_OF_SIGMAR'],
        ['AOSV2', 'en_US', 'Age Of Sigmar V2', 'profileAOS4', 'Games Workshop', 'mortal-realms', 'WARHAMMER_AGE_OF_SIGMAR'],
        ['T9AV2', 'en_US', 'The 9th Age V2', 'profileT9A12', 'Games Workshop', 'earth', 'THE_NINTH_AGE'],
        ['T9AV1', 'en_US', 'The 9th Age V1', 'profileT9A12', 'Games Workshop', 'earth', 'THE_NINTH_AGE'],
        ['KOW1', 'en_US', 'King of war V1', 'profileKOW', 'Mantic', 'mantica', 'KING_OF_WAR'],
        ['KOW2', 'en_US', 'King of war V2', 'profileKOW', 'Mantic', 'mantica', 'KING_OF_WAR'],
        ['KOW3', 'en_US', 'King of war V3', 'profileKOW', 'Mantic', 'mantica', 'KING_OF_WAR'],
        ['MHV1', 'en_US', 'Mordheim V1', 'profileWFB9', 'Games Workshop', 'warhammer-old-world', 'WARHAMMER_FANTASY_BATTLE'],
        ['WFBAPV9', 'en_US', 'Warhammer Armies Project V9', 'profileWFB9', 'Mathias Eliasson', 'warhammer-old-world', 'WARHAMMER_ARMIES_PROJECT', 'externalLinks' => [
            [
                'category' => 'communityRules',
                'href' => 'http://warhammerarmiesproject.blogspot.com/search/label/9th%20Edition',
                'locale' => 'en_US',
            ],
        ]],
        ['WFBAPV8', 'en_US', 'Warhammer Armies Project V8', 'profileWFB9', 'Mathias Eliasson', 'warhammer-old-world', 'WARHAMMER_ARMIES_PROJECT', 'externalLinks' => [
            [],
        ]],
     ];

    public function load(ObjectManager $manager)
    {
        $profileTypeRepository = $manager->getRepository(ProfileType::class);
        $gameLineRepository = $manager->getRepository(GameLine::class);

        foreach ($this->data as $data) {
            
            $object = new GameSystem();
            $object->setId($data[0]);
            $object->setName($data[2]);
            $object->addTag($this->tagManager->loadOrCreate($data[2]));
            if (empty($data[3])) {
                $data[3] = 'profileUnknown';
            }
            $object->setProfileType($profileTypeRepository->find($data[3]));
            $object->setWorld($this->worldRepository->find($data[5]));
            $object->setPublisher($data[4]);
            $object->setGameLine($gameLineRepository->find($data[6]));

            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GameLineFixtures::class,
            ProfileTypeFixtures::class,
            WorldFixtures::class,
        ];
    }
}
