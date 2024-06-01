<?php

namespace App\Manager;

use App\Entity\GameSystem;
use App\Entity\Nation;
use App\Entity\UnitGeneric;
use Doctrine\ORM\EntityManagerInterface;

class UnitGenericManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByNationId($nationsId)
    {
        return $this->entityManager->createQueryBuilder()
        ->select('u')
        ->from(UnitGeneric::class, 'u')
        ->join('u.nations', 'n')
        ->where('n.id = :nationId')
        ->setParameter(':nationId', $nationsId)
        ->getQuery()
        ->execute();
    }

    public function countAll()
    {
        return $this->entityManager->createQueryBuilder()
        ->select('count(o.id)')
        ->from(UnitGeneric::class, 'o')
        ->getQuery()
        ->getSingleScalarResult();
    }

    public function findByBaseNameAndNation($baseName, $nationId)
    {
        if ($nationId instanceof Nation) {
            $nationId = $nationId->getId();
        }

        return $this->entityManager->createQueryBuilder()
        ->select('u')
        ->from(UnitGeneric::class, 'u')
        ->join('u.nations', 'n')
        ->where('n.id = :nationId')
        ->andWhere('u.baseName = :baseName')
        ->setParameter(':nationId', $nationId)
        ->setParameter(':baseName', $baseName)
        ->getQuery()
        ->execute();
    }

    public function findByNationAndGameSystem($nationId, $gameSystemId)
    {
        if ($nationId instanceof Nation) {
            $nationId = $nationId->getId();
        }
        if (null == $gameSystemId) {
            return $this->entityManager->getRepository(UnitGeneric::class)->findByNation($nationId);
        }
        if ($gameSystemId instanceof GameSystem) {
            $gameSystemId = $gameSystemId->getId();
        }

        return $this->entityManager->createQueryBuilder()
        ->select('u')
        ->from(UnitGeneric::class, 'u')
        ->join('u.nations', 'n')
        ->join('u.unitGameSystems', 'ugs')
        ->join('ugs.gameSystem', 'gs')
        ->where('n.id = :nationId')
        ->andWhere('gs.id = :gameSystemId')
        ->setParameter(':nationId', $nationId)
        ->setParameter(':gameSystemId', $gameSystemId)
        ->getQuery()
        ->execute();
    }
}
