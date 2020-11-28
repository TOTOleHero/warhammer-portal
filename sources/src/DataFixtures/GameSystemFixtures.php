<?php

namespace App\DataFixtures;

use App\Entity\GameSystem;
use App\Entity\ProfileType;
use App\Manager\TagManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GameSystemFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var TagManager
     */
    protected $tagManager;

    public function __construct(TagManager $tagManager)
    {
        $this->tagManager = $tagManager;
    }

    protected $data = [
        ['WHQV1', 'en_US', 'Warhammer Quest V1', 'profileWHQ'],
        ['WFBV3', 'en_US', 'Warhammer Fantasy Battle V3', 'profileWFB12'],
        ['WFBV4', 'en_US', 'Warhammer Fantasy Battle V4', 'profileWFB9'],
        ['WFBV5', 'en_US', 'Warhammer Fantasy Battle V5', 'profileWFB9'],
        ['WFBV6', 'en_US', 'Warhammer Fantasy Battle V6', 'profileWFB9'],
        ['WFBV7', 'en_US', 'Warhammer Fantasy Battle V7', 'profileWFB9'],
        ['WFBV8', 'en_US', 'Warhammer Fantasy Battle V8', 'profileWFB9'],
        ['AOSV1', 'en_US', 'Age Of Sigmar V1', 'profileAOS4'],
        ['AOSV2', 'en_US', 'Age Of Sigmar V2', 'profileAOS4'],
        ['T9AV2', 'en_US', 'The 9th Age V2', 'profileT9A12'],
        ['T9AV1', 'en_US', 'The 9th Age V1', 'profileT9A12'],
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
            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProfileTypeFixtures::class,
        ];
    }
}
