<?php

declare(strict_types=1);

namespace Volgersnet\Monad;

use Volgersnet\Monad\Traits\From;
use Volgersnet\Monad\Traits\Then;

class Identity extends Monad
{
    /** @use Then<Monad> */
    use Then;

    /** @use From<Monad> */
    use From;

    public const unit = 'Volgersnet\Monad\Identity::unit';
}
