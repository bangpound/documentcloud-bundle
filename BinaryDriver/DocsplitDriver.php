<?php

namespace Bangpound\Bundle\DocumentCloudBundle\BinaryDriver;

use Alchemy\BinaryDriver\AbstractBinary;

/**
 * Class DocsplitDriver
 * @package Bangpound\Bundle\DocumentCloudBundle\BinaryDriver
 */
class DocsplitDriver extends AbstractBinary
{
    /**
     * Returns the name of the driver
     *
     * @return string
     */
    public function getName()
    {
        return 'docsplit';
    }
}
