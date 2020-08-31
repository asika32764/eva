<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2020 __ORGANIZATION__.
 * @license    __LICENSE__
 */

declare(strict_types=1);

use function Windwalker\ref;

return [
    'default' => 'http',

    'servers' => [
        'http' => ref('di.server.http')
    ]
];
