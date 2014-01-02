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

    public function command($command, $bypassErrors = false, $listeners = null)
    {
        if (!is_array($command)) {
            $command = array($command);
        }

        $process = $this->factory->create($command);

        return $this->run($process, $bypassErrors, $listeners);
    }
}
