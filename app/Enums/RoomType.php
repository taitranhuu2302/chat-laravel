<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoomType extends Enum
{
    const PRIVATE_ROOM = 'PRIVATE_ROOM';
    const GROUP_ROOM = 'GROUP_ROOM';
}
