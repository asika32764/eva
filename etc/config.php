<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2020 ${ORGANIZATION}.
 * @license    __LICENSE__
 */

declare(strict_types=1);

use Windwalker\Utilities\Arr;

return Arr::mergeRecursive(
    [
        'server' => include __DIR__ . '/conf/server.php',
        'di' => include __DIR__ . '/di.php',
    ]
);
