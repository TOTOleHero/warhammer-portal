<?php

namespace App\Helper;

class NationHelper
{
    public static function fixNationCodeName($name)
    {
        switch ($name) {
            case 'CHAOS_DWARF': return 'CHAOS_DWARFS'; break;
            case 'CHAOS_DWARFS_LOA': return 'CHAOS_DWARFS'; break;
            case 'Chaos Dwarf': return 'Chaos Dwarfs'; break;
            case 'Chaos Dwarfs LoA': return 'Chaos Dwarfs'; break;
            case 'OGRE_KINDOMS': return 'OGRE_KINGDOMS'; break;
            case 'Ogre Kindoms': return 'Ogre Kingdoms'; break;
            case 'GREENSKINS': return 'ORCS_&_GOBLINS'; break;
            case 'Greenskins': return 'Orcs & Goblins'; break;
            case 'UNDEAD': return 'UNDEAD_LEGIONS'; break;
            case 'Undead': return 'Undead Legions'; break;
        }

        return $name;
    }
}
