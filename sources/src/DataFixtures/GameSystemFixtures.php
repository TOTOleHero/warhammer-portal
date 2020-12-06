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
        ['WHQV1', 'en_US', 'Warhammer Quest V1', 'profileWHQ', 'Games Workshop'],
        ['WFBV3', 'en_US', 'Warhammer Fantasy Battle V3', 'profileWFB12', 'Games Workshop'],
        ['WFBV4', 'en_US', 'Warhammer Fantasy Battle V4', 'profileWFB9', 'Games Workshop'],
        ['WFBV5', 'en_US', 'Warhammer Fantasy Battle V5', 'profileWFB9', 'Games Workshop'],
        ['WFBV6', 'en_US', 'Warhammer Fantasy Battle V6', 'profileWFB9', 'Games Workshop'],
        ['WFBV7', 'en_US', 'Warhammer Fantasy Battle V7', 'profileWFB9', 'Games Workshop'],
        ['WFBV8', 'en_US', 'Warhammer Fantasy Battle V8', 'profileWFB9', 'Games Workshop'],
        ['AOSV1', 'en_US', 'Age Of Sigmar V1', 'profileAOS4', 'Games Workshop'],
        ['AOSV2', 'en_US', 'Age Of Sigmar V2', 'profileAOS4', 'Games Workshop'],
        ['T9AV2', 'en_US', 'The 9th Age V2', 'profileT9A12', 'Games Workshop'],
        ['T9AV1', 'en_US', 'The 9th Age V1', 'profileT9A12', 'Games Workshop'],
        ['MHV1', 'en_US', 'Mordheim V1', 'profileWFB9', 'Games Workshop'],
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
            $object->setPublisher($data[4]);
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
