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
use Plum\Exception\SshException;

class SshDeployer implements DeployerInterface
{
    /**
     * The SSH connection
     * @var ressource
     */
    protected $con;

    /**
     * {@inheritDoc}
     */
    public function deploy(ServerInterface $server, array $options = array())
    {
        $commands = isset($options['commands']) ? $options['commands'] : array();
        if (0 === count($commands)) {
            // The SSH deployer is useless if the user has no command
            return;
        }

        if (null === $server->getPassword()) {
            throw new \InvalidArgumentException('No password found for the server.');
        }

        // Dry run?
        $dryRun = isset($options['dry_run']) && $options['dry_run'];

        $this->connect($server);

        if (false === $dryRun) {
            foreach ($commands as $command) {
                // We need to jump to the right directory..
                $command = sprintf('cd %s && %s', $server->getDir(), $command);
                $this->exec($command);
            }
        }

        $this->disconnect();
    }

    /**
     * Open the SSH connection
     *
     * @param Plum\Server\ServerInterface $server
     *
     * @return ressource The ssh2 connection
     */
    protected function connect(ServerInterface $server)
    {
        if (!function_exists('ssh2_connect')) {
            throw new \RuntimeException('The "ssh2_connect" function does not exist.');
        }

        $con = ssh2_connect($server->getHost(), $server->getPort());

        if (false === $con) {
            throw new SshException(sprintf('Cannot connect to server "%s"', $server->getHost()));
        }

        if (false === ssh2_auth_password($con, $server->getUser(), $server->getPassword())) {
            throw new SshException(sprintf('Authorization failed for user "%s"', $server->getUser()));
        }

        $this->con = $con;
    }

    /**
     * Close the SSH connection
     */
    protected function disconnect()
    {
        $this->exec('echo "EXITING" && exit;');
    }

    /**
     * Execute a SSH command
     *
     * @param string $cmd The SSH command
     *
     * @return string The output
     */
    protected function exec($cmd)
    {
        if (false === $stream = ssh2_exec($this->con, $cmd)) {
            throw new SshException(sprintf('"%s" : SSH command failed', $cmd));
        }

        stream_set_blocking($stream, true);

        $data = '';
        while ($buf = fread($stream, 4096)) {
            $data .= $buf;
        }

        fclose($stream);

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ssh';
    }
}