<?php

namespace App\DataFixtures;

use App\Entity\Nation;
use App\Entity\WorldAlignment;
use App\Helper\NationHelper;
use App\Manager\NationManager;
use App\Manager\TagManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\StorageAttributes;

class NationWHFBFixture extends Fixture
{
    /**
     * @var TagManager
     */
    protected $tagManager;

    /**
     * @var NationManager
     */
    protected $nationManager;

    public function __construct(TagManager $tagManager, NationManager $nationManager)
    {
        $this->tagManager = $tagManager;
        $this->nationManager = $nationManager;
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
            if ($item->isFile() && 'cat' == pathinfo($item->path(), PATHINFO_EXTENSION)) {
                $xmlParser = new \Hobnob\XmlStreamReader\Parser();
                $xmlParser->registerCallback(
                    '/catalogue',
                    function (\Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node) {
                        $nationName = $node->attributes()->name;
                        $matches = [];
                        preg_match_all('/(^[^-0-9(]*)/', $nationName, $matches);

                        $nationName = trim($matches[0][0]);
                        $nationCode = str_replace(' ', '_', strtoupper($nationName));
                        $nationCode = NationHelper::fixNationCodeName($nationCode);
                        $nationName = NationHelper::fixNationCodeName($nationName);
                        $this->nationManager->loadOrCreate($nationCode, $nationName);
                    }
                );
                $xmlParser->parse($filesystem->readStream($item->path()));
            }
        }

        $manager->flush();
    }
}
