<?php

declare(strict_types=1);

namespace Volgersnet\Monad;

use Volgersnet\Monad\Traits\Accessor;
use Volgersnet\Monad\Traits\Of;

class Chain extends Maybe
{
    use Accessor;

    /** @use Of<Monad> */
    use of;

    public const unit = 'Volgersnet\Monad\Chain::unit';
}
