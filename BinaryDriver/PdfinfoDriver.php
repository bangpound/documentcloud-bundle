<?php

namespace Bangpound\Bundle\DocumentCloudBundle\BinaryDriver;

use Alchemy\BinaryDriver\AbstractBinary;

class PdfinfoDriver extends AbstractBinary
{
    /**
     * Returns the name of the driver
     *
     * @return string
     */
    public function getName()
    {
        return 'pdfinfo';
    }
}
