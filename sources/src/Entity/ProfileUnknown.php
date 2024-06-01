<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      allOf={
 *          @Model(type=Profile::class)
 *      }
 * )
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class ProfileUnknown extends Profile
{
    public function getProfileType(): ?string
    {
        return self::PROFILE_TYPE_UNKNOWN;
    }
}
