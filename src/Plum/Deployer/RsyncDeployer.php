<?php

/*
 * This file is part of the Plum package.
 *
 * (c) 2010-2012 Julien Brochet <mewt@madalynn.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plum\Deployer;

use Plum\Server\ServerInterface;

class RsyncDeployer extends AbstractDeployer
{
    /**
     * {@inheritDoc}
     */
    public function doDeploy(ServerInterface $server, array $options, $dryRun)
    {
        $rsyncOptions = isset($options['rsync_options']) ? $options['rsync_options'] : '-azC --force --delete --progress';

        // Exclude file
        $excludeFile = null;
        if (isset($options['rsync_exclude'])) {
            $excludeFile = $options['rsync_exclude'];
            if (false === file_exists($excludeFile)) {
                throw new \InvalidArgumentException(sprintf('The exclude file "%s" does not exist.', $excludeFile));
            }

            $excludeFile = realpath($excludeFile);
        }

        $exclude = '';
        if (null !== $excludeFile) {
            $exclude = sprintf('--exclude-from \'%s\'', $excludeFile);
        }

        $ssh = '';
        if (22 !== $server->getPort()) {
            $ssh = sprintf('-e "ssh -p%d"', $server->getPort());
        }

        $login = sprintf('%s@%s:%s', $server->getUser(), $server->getHost(), $server->getDir());

        $command = sprintf('rsync %s %s %s ./ %s  %s',
                $dryRun,
                $rsyncOptions,
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