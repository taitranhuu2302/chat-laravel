<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FriendStatus extends Enum
{
    const FRIEND = 'FRIEND';
    const BLOCKED = 'BLOCKED';
}
