<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    __LICENSE__
 */

declare(strict_types=1);

namespace App\Module\Front;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Unicorn\Script\UnicornScript;
use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Asset\AssetService;
use Windwalker\Core\Html\HtmlFrame;
use Windwalker\Core\Language\LangService;
use Windwalker\Core\Middleware\AbstractLifecycleMiddleware;

/**
 * The FrontMiddleware class.
 */
class FrontMiddleware extends AbstractLifecycleMiddleware
{
    public function __construct(
        protected AppContext $app,
        protected AssetService $asset,
        protected HtmlFrame $htmlFrame,
        protected UnicornScript $unicornScript,
    ) {
    }

    /**
     * prepareExecute
     *
     * @param  ServerRequestInterface  $request
     *
     * @return  mixed
     */
    protected function preprocess(ServerRequestInterface $request): void
    {
        $this->unicornScript->init('js/front/main.js');

        $this->asset->js('https://kit.fontawesome.com/59f5955d51.js');
        $this->asset->js('vendor/bootstrap/dist/js/bootstrap.bundle.js');

        $this->asset->css('css/front/app.css');

        $this->htmlFrame->setSiteName('Windwalker');
    }

    /**
     * postExecute
     *
     * @param  ResponseInterface  $response
     *
     * @return  mixed
     */
    protected function postProcess(ResponseInterface $response): void
    {
    }
}
