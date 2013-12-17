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
        $process->setEnv([
            'GEM_PATH' => '/Users/bjd/.rvm/gems/ruby-1.9.3-p448@afsc:/Users/bjd/.rvm/gems/ruby-1.9.3-p448@global',
            'GEM_HOME' => '/Users/bjd/.rvm/gems/ruby-1.9.3-p448@afsc',
            'PATH' => '/Users/bjd/.rvm/gems/ruby-1.9.3-p448@afsc/bin:/Users/bjd/.rvm/gems/ruby-1.9.3-p448@global/bin:/Users/bjd/.rvm/rubies/ruby-1.9.3-p448/bin:/Users/bjd/.rvm/bin:/usr/local/pear/bin:/usr/local/share/npm/bin:/Developer/usr/bin:/Users/bjd/.composer/vendor/bin:/Users/bjd/bin:/Users/bjd/bin/sandbox_tools:/usr/local/bin:/usr/local/sbin:/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/bin:/opt/X11/bin:/usr/local/MacGPG2/bin:/Users/bjd/.rvm/bin',
        ]);

        return $this->run($process, $bypassErrors, $listeners);
    }
}
