<?php

namespace Bigyouth\BigyouthImageResizerBundle;

use Bigyouth\BigyouthImageResizerBundle\Helper\Helper;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BigyouthImageResizerBundle extends Bundle
{
    public function boot()
    {
        // Set some static globals
        Helper::setRootDir($this->container->getParameter("kernel.root_dir"));
    }
}
