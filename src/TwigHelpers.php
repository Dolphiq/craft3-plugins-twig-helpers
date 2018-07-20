<?php

/**
 * Craft Twig helpers
 *
 * @author    dolphiq
 * @copyright Copyright (c) 2017 dolphiq
 * @link      https://dolphiq.nl/
 */

namespace dolphiq\twighelpers;

use dolphiq\twighelpers\twigextensions\LaravelMixTwigExtension;

use Craft;
use craft\base\Plugin;


class TwigHelpers extends \craft\base\Plugin
{
    /**
     * @var TwigHelpers
     */
    public static $plugin;

    public function init()
    {
        parent::init();

        self::$plugin = $this;

        Craft::$app->view->registerTwigExtension(new LaravelMixTwigExtension());

        Craft::info('LaravelMix plugin loaded', __METHOD__);
    }
}
