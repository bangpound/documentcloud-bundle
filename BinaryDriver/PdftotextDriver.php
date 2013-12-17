<?php

namespace Bangpound\Bundle\DocumentCloudBundle\BinaryDriver;

use Alchemy\BinaryDriver\AbstractBinary;

/**
 * Class PdftotextDriver
 * @package Bangpound\Bundle\DocumentCloudBundle\BinaryDriver
 */
class PdftotextDriver extends AbstractBinary
{
    /**
     * Returns the name of the driver
     *
     * @return string
     */
    public function getName()
    {
        return 'pdftotext';
    }
}
