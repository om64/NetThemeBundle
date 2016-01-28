<?php

namespace Claroline\NetThemeBundle;

use Claroline\CoreBundle\Library\PluginBundle;
use Claroline\KernelBundle\Bundle\ConfigurationBuilder;

/**
 * Bundle class.
 */
class ClarolineNetThemeBundle extends PluginBundle
{
    public function getConfiguration($environment)
    {
        $config = new ConfigurationBuilder();

        return $config->addRoutingResource(__DIR__ . '/Resources/config/routing.yml', null, 'claroline_net');
    }

    public function hasMigrations()
    {
        return false;
    }
}
