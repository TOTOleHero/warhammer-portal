<?php

namespace App\DataFixtures;

use App\Entity\Nation;
use App\Entity\WorldAlignment;
use App\Manager\TagManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\StorageAttributes;

class NationWHFBFixture extends Fixture
{
    /**
     * @var TagManager
     */
    protected $tagManager;

    public function __construct(TagManager $tagManager)
    {
        $this->tagManager = $tagManager;
    }

    public function load(ObjectManager $manager)
    {
        $worldAlignmentRepository = $manager->getRepository(WorldAlignment::class);
        $nationRepository = $manager->getRepository(Nation::class);

        $adapter = new LocalFilesystemAdapter(
            // Determine root directory
            __DIR__.'/whfb'
        );
        $filesystem = new Filesystem($adapter);
        $allFiles = $filesystem->listContents('/')->filter(function (StorageAttributes $attributes) {return $attributes->isFile(); });
        foreach ($allFiles as $item) {
            if($item->isFile() && pathinfo($item->path(),PATHINFO_EXTENSION) == 'cat')
            {
                $xmlParser = new \Hobnob\XmlStreamReader\Parser();
                $xmlParser->registerCallback(
                    '/catalogue',
                    function( \Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node ) use ($nationRepository,$manager) {
                        

                        $nationName = $node->attributes()->name;
                        $matches = [];
                        preg_match_all('/(^[^-0-9(]*)/',$nationName,$matches);

                        $nationName = trim($matches[0][0]);

                        $nationCode = str_replace(' ','_',strtoupper($nationName));
                        $nation = $nationRepository->find($nationCode);
                        if($nation == null)
                        {
                            var_dump($nationCode.' create');
                            $object = new Nation();
                            $object->setName($nationName);
                            $object->setId($nationCode);
                            $object->addTag($this->tagManager->loadOrCreate($object->getName()));
                            $manager->persist($object);
                        }
                        else
                        {
                            var_dump($nationCode.' exist');
                        }
                    }
                );
                $xmlParser->parse($filesystem->readStream($item->path()));
              
            }

        }

        
        $manager->flush();
    }
}
