<?php

namespace App\DataFixtures;

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
        ['WHQV1', 'en_US', 'Warhammer Quest V1', 'profileWHQ', 'Games Workshop', 'warhammer-old-world'],
        ['WFBV3', 'en_US', 'Warhammer Fantasy Battle V3', 'profileWFB12', 'Games Workshop', 'warhammer-old-world'],
        ['WFBV4', 'en_US', 'Warhammer Fantasy Battle V4', 'profileWFB9', 'Games Workshop', 'warhammer-old-world'],
        ['WFBV5', 'en_US', 'Warhammer Fantasy Battle V5', 'profileWFB9', 'Games Workshop', 'warhammer-old-world'],
        ['WFBV6', 'en_US', 'Warhammer Fantasy Battle V6', 'profileWFB9', 'Games Workshop', 'warhammer-old-world'],
        ['WFBV7', 'en_US', 'Warhammer Fantasy Battle V7', 'profileWFB9', 'Games Workshop', 'warhammer-old-world'],
        ['WFBV8', 'en_US', 'Warhammer Fantasy Battle V8', 'profileWFB9', 'Games Workshop', 'warhammer-old-world'],
        ['AOSV1', 'en_US', 'Age Of Sigmar V1', 'profileAOS4', 'Games Workshop', 'mortal-realms'],
        ['AOSV2', 'en_US', 'Age Of Sigmar V2', 'profileAOS4', 'Games Workshop', 'mortal-realms'],
        ['T9AV2', 'en_US', 'The 9th Age V2', 'profileT9A12', 'Games Workshop', 'earth'],
        ['T9AV1', 'en_US', 'The 9th Age V1', 'profileT9A12', 'Games Workshop', 'earth'],
//        ['KOW1', 'en_US', 'King of war V1', '', 'Mantic', 'mantica'],
//        ['KOW2', 'en_US', 'King of war V2', '', 'Mantic', 'mantica'],
//        ['KOW3', 'en_US', 'King of war V3', '', 'Mantic', 'mantica'],
        ['MHV1', 'en_US', 'Mordheim V1', 'profileWFB9', 'Games Workshop', 'warhammer-old-world'],
        ['WFBAPV9', 'en_US', 'Warhammer Armies Project V9', 'profileWFB9', 'Mathias Eliasson', 'warhammer-old-world', 'externalLinks' => [
            [
                'category' => 'communityRules',
                'href' => 'http://warhammerarmiesproject.blogspot.com/search/label/9th%20Edition',
                'locale' => 'en_US',
            ],
        ]],
        ['WFBAPV8', 'en_US', 'Warhammer Armies Project V8', 'profileWFB9', 'Mathias Eliasson', 'warhammer-old-world', 'externalLinks' => [
            [],
        ]],
     ];

    public function load(ObjectManager $manager)
    {
        $profileTypeRepository = $manager->getRepository(ProfileType::class);

        foreach ($this->data as $data) {
            $object = new GameSystem();
            $object->setId($data[0]);
            $object->setName($data[2]);
            $object->addTag($this->tagManager->loadOrCreate($data[2]));
            $object->setProfileType($profileTypeRepository->find($data[3]));
            $object->setWorld($this->worldRepository->find($data[5]));
            $object->setPublisher($data[4]);
            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProfileTypeFixtures::class,
            WorldFixtures::class,
        ];
    }
}
