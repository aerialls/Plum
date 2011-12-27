<?php

/*
 * This file is part of the Plum package.
 *
 * (c) 2010-2011 Julien Brochet <mewt@madalynn.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plum\Deployer;

use Plum\Server\ServerInterface;

abstract class AbstractDeployer implements DeployerInterface
{
    /**
     * Dry run mode
     * @var boolean
     */
    protected $dryRun;

    /**
     * {@inheritDoc}
     */
    public function deploy(ServerInterface $server, array $options = array())
    {
        // Dry run?
        $this->dryRun = false;
        if (isset($options['dry_run']) && $options['dry_run']) {
            $this->dryRun = true;
        }
    }
}