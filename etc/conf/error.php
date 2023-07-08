<?php

/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2020 ${ORGANIZATION}.
 * @license    MIT
 */

use Windwalker\Core\Application\ApplicationInterface;
use Windwalker\Core\Error\ErrorLogHandler;
use Windwalker\Core\Error\SimpleErrorPageHandler;
use Windwalker\Core\Provider\ErrorHandlingProvider;
use Windwalker\DI\Container;

use function Windwalker\DI\create;
use function Windwalker\ref;

$errorReporting = include __DIR__ . '/error-reporting.php';

return [
    'ini' => [
        'display_errors' => 'on',
        'error_reporting' => (string) WINDWALKER_DEBUG ? E_ALL : $errorReporting,
    ],

    'report_level' => $errorReporting,

    'restore' => false,

    'register_shutdown' => true,

    'template' => 'layout.error.default',

    'log' => true,

    'log_channel' => 'error',

    'providers' => [
        ErrorHandlingProvider::class
    ],

    'handlers' => [
        ApplicationInterface::CLIENT_WEB => [
            'default' => ref('error.factories.handlers.default'),
            'log' => ref('error.factories.handlers.log'),
        ],
        ApplicationInterface::CLIENT_CONSOLE => [
            'default' => ref('error.factories.handlers.console_log'),
        ],
        'cli_web' => [
            'default' => ref('error.factories.handlers.default'),
            'log' => ref('error.factories.handlers.log'),
        ]
    ],

    'factories' => [
        'handlers' => [
            'default' => create(
                SimpleErrorPageHandler::class,
                options: function (Container $container) {
                    return [
                        'debug' => $container->getParam('system.debug'),
                        'layout' => $container->getParam('error.template'),
                    ];
                }
            ),
            'log' => create(
                ErrorLogHandler::class,
                options: function (Container $container) {
                    return [
                        'channel' => 'error',
                        'enabled' => $container->getParam('error.log')
                    ];
                }
            ),
            'console_log' => create(
                ErrorLogHandler::class,
                options: function (Container $container) {
                    return [
                        'channel' => 'console-error',
                        'enabled' => $container->getParam('error.log')
                    ];
                }
            ),
        ]
    ]
];
