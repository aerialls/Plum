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

class RsyncDeployer implements DeployerInterface
{
    /**
     * {@inheritDoc}
     */
    public function deploy(ServerInterface $server, array $options = array())
    {
        $dryRun = isset($options['dryRun']) ? '--dry-run' : '';

        // Exclude file
        $excludeFile = null;
        if (isset($options['excludeFile'])) {
            $excludeFile = realpath($options['excludeFile']);
            if (false === file_exists($excludeFile)) {
                throw new \InvalidArgumentException('The exclude file does not exist.');
            }
        }

        if (null !== $excludeFile) {
            $exclude = sprintf('--exclude-from \'%s\'', $excludeFile);
        } else {
            $exclude = '';
        }

        $ssh = '';
        if (22 !== $server->getPort()) {
            $ssh = sprintf('-e "ssh -p%d"', $server->getPort());
        }

        $login = sprintf('%s@%s:%s', $server->getUser(), $server->getHost(), $server->getDir());

        $command = sprintf('rsync %s %s %s ./ %s  %s',
                $dryRun,
                isset($options['options']) ? $options['options'] : '',
                $ssh,
                $login,
                $exclude
        );

        exec($command);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'rsync';
    }
}