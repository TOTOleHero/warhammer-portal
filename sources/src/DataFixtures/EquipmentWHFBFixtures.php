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

class EquipmentWHFBFixtures extends Fixture implements DependentFixtureInterface
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
                throw new \Exception(sprintf('%s games system not found',$gameSystem));
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
            if($item->isFile() && pathinfo($item->path(),PATHINFO_EXTENSION) == 'cat')
            {
                $nation = null;
                $version = null;
                $xmlParser = new \Hobnob\XmlStreamReader\Parser();
                $xmlParser->registerCallback(
                    '/catalogue',
                    function( \Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node ) use (&$version, &$nation,$manager) {
                        
                        $nationFullName = $node->attributes()->name;
                        $matches = [];
                        preg_match_all('/(^[^-0-9]*)/',$nationFullName,$matches);
                        $nationName = trim($matches[0][0]);
                        var_dump($nationName);
                        $matches = [];
                        preg_match_all('/\(([0-9]{4})/',$nationFullName,$matches);
                        $year = null;
                        if(isset($matches[1][0]))
                        {
                            $year = trim($matches[1][0]);
                        }
                        //var_dump( $year);
                        $matches = [];
                        if(empty($year))
                        {
                            preg_match_all('/([0-9])ed|([0-9])th/',$nationFullName,$matches);
                            //var_dump( $matches);
                            $version = trim($matches[1][0]);
                            if(empty($version))
                            {
                                $version = trim($matches[2][0]);
                            }
                        }
                        else
                        {
                            switch(true)
                            {
                                case 2000 > $year: $version=5; break;
                                case 2000 <= $year && $year < 2006: $version=6; break;
                                case 2006 <= $year && $year < 2010: $version=7; break;
                                case 2010 <= $year : $version=8; break;
                            }
                        }

                        if(empty($version))
                        {
                            throw new \Exception('No version in : '.$nationFullName);
                        }

                        $nationCode = str_replace(' ','_',strtoupper($nationName));
                        var_dump($nationCode);
                        $nation = $this->nationRepository->find($nationCode);
                        if (null == $nation) {
                            throw new \Exception(sprintf('Nation %s not found', $nationCode));
                        }
                    }
                );
                $xmlParser->parse($filesystem->readStream($item->path()));
                
                $xmlParser = new \Hobnob\XmlStreamReader\Parser();
                $xmlParser->registerCallback(
                    '/catalogue/sharedProfiles/profile',
                    function( \Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node ) use (&$version,&$nation,$manager) {
                        
         
                        if(empty($node->attributes()->name))
                        {
                            var_dump('No name');
                            return;
                        }
                        
                        $gameSystem = 'WFBV'.$version;

                        $object = new Equipment();
                        $object->setGameSystem($this->getGameSystem($gameSystem));
                        $type = 'U';
                        $typeName = $node->attributes()->typename;

                        switch(true)
                        {
                            case $typeName == 'Armour': $type = 'A'; break;
                            case $typeName == 'Weapon': $type = 'W'; break;
                        }
              
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
