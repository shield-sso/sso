<?php

declare(strict_types = 1);

namespace ShieldSSO;

use \Silex\Application as SilexApplication;
use Silex\Application\TwigTrait;

class Application extends SilexApplication
{
    use TwigTrait;
}
