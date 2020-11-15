<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\GameSystem;
use App\Entity\ProfileType;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class GameSystemFixtures extends Fixture implements DependentFixtureInterface
{

    protected $data = [
        ['WFBV3', 'en', 'Warhammer Fantasy Battle V3','profileWFB12'],
        ['WFBV4', 'en', 'Warhammer Fantasy Battle V4','profileWFB9'],
        ['WFBV5', 'en', 'Warhammer Fantasy Battle V5','profileWFB9'],
        ['WFBV6', 'en', 'Warhammer Fantasy Battle V6','profileWFB9'],
        ['WFBV7', 'en', 'Warhammer Fantasy Battle V7','profileWFB9'],
        ['WFBV8', 'en', 'Warhammer Fantasy Battle V8','profileWFB9'],
        ['AOSV1', 'en', 'Age Of Sigmar V1','profileAOS4'],
        ['AOSV2', 'en', 'Age Of Sigmar V2','profileAOS4'],
     ];

    public function load(ObjectManager $manager)
    {

        $profileTypeRepository = $manager->getRepository(ProfileType::class);

        foreach ($this->data as $data) {
            $object = new GameSystem();
            $object->setId($data[0]);
            $object->setTranslatableLocale($data[1]);
            $object->setName($data[2]);
            $object->setProfileType($profileTypeRepository->find($data[3]));
            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProfileTypeFixtures::class,
        );
    }
}
