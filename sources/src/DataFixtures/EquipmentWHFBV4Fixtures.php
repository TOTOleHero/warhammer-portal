<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Manager\TagManager;
use App\Repository\EquipmentTypeRepository;
use App\Repository\GameSystemRepository;
use App\Repository\NationRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\StorageAttributes;

class EquipmentWHFBV4Fixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var TagManager
     */
    protected $tagManager;

    /**
     * @var GameSystemRepository
     */
    protected $gameSystemRepository;

    /**
     * @var EquipmentTypeRepository
     */
    protected $equipmentTypeRepository;

    /**
     * @var NationRepository
     */
    protected $nationRepository;

    public function __construct(TagManager $tagManager,
     GameSystemRepository $gameSystemRepository,
      EquipmentTypeRepository $equipmentTypeRepository,
      NationRepository $nationRepository)
    {
        $this->tagManager = $tagManager;
        $this->gameSystemRepository = $gameSystemRepository;
        $this->equipmentTypeRepository = $equipmentTypeRepository;
        $this->nationRepository = $nationRepository;
    }

    protected function getGameSystem($gameSystem)
    {
        $gameSystems = [];

        if (!array_key_exists($gameSystem, $gameSystems)) {
            $gameSystemObject = $this->gameSystemRepository->find($gameSystem);

            if (null === $gameSystemObject) {
                throw new \Exception(sprintf('%s games system not found', $gameSystem));
            }
            $gameSystems[$gameSystem] = $gameSystemObject;
        }

        return $gameSystems[$gameSystem];
    }

    public function load(ObjectManager $manager)
    {
        $adapter = new LocalFilesystemAdapter(
            // Determine root directory
            __DIR__.'/whfb'
        );
        $filesystem = new Filesystem($adapter);
        $allFiles = $filesystem->listContents('/')->filter(function (StorageAttributes $attributes) {return $attributes->isFile(); });
        foreach ($allFiles as $item) {
            if ($item->isFile() && 'gst' == pathinfo($item->path(), PATHINFO_EXTENSION)) {
                $xmlParser = new \Hobnob\XmlStreamReader\Parser();
                $xmlParser->registerCallback(
                    '/gameSystem/sharedProfiles/profile',
                    function (\Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node) use (&$version, &$nation, $manager) {
                        if (empty($node->attributes()->name)) {
                            var_dump('No name');

                            return;
                        }
                        $typeName = $node->attributes()->typename;
                        if (!in_array($typeName, ['Ranged Weapon', 'Melee Weapon'])) {
                            var_dump('"'.$typeName.'" is not an equipment');

                            return;
                        }

                        $gameSystem = 'WFBV4';
                        $type = 'U';
                        switch (true) {
                            case 'Melee Weapon' == $typeName: $type = 'W'; break;
                            case 'Ranged Weapon' == $typeName: $type = 'MW'; break;
                        }
                        $object = new Equipment();
                        $object->setGameSystem($this->getGameSystem($gameSystem));
                        $object->setType($this->equipmentTypeRepository->find($type));
                        $object->setName($node->attributes()->name);
                        $object->setDescription($node->attributes()->name);
                        $manager->persist($object);
                    }
                );
                $xmlParser->parse($filesystem->readStream($item->path()));
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GameSystemFixtures::class,
            EquipmentTypeFixtures::class,
        ];
    }
}
