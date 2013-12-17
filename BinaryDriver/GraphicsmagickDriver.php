<?php

namespace Bangpound\Bundle\DocumentCloudBundle\BinaryDriver;

use Alchemy\BinaryDriver\AbstractBinary;

/**
 * Class GraphicsmagickDriver
 * @package Bangpound\Bundle\DocumentCloudBundle\BinaryDriver
 */
class GraphicsmagickDriver extends AbstractBinary
{

    /**
     * Returns the name of the driver
     *
     * @return string
     */
    public function getName()
    {
        return 'graphicsmagick';
    }
}
