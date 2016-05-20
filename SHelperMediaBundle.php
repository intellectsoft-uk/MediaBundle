<?php

namespace SHelper\MediaBundle;

use SHelper\MediaBundle\DependencyInjection\SHelperMediaExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SHelperMediaBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SHelperMediaExtension();
    }
}
