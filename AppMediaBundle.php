<?php

namespace SHelper\MediaBundle;

use SHelper\MediaBundle\DependencyInjection\AppMediaExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppMediaBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new AppMediaExtension();
    }
}
