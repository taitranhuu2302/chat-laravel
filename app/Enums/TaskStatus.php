<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TaskStatus extends Enum
{
    const PENDING =   "PENDING";
    const COMPLETED =   "COMPLETED";
    const CANCELLED = "CANCELLED";
    const IN_COMPLETE = "IN_COMPLETE";
}
