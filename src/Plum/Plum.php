<?php

/*
 * This file is part of the Plum package.
 *
 * (c) 2010-2011 Julien Brochet <mewt@madalynn.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plum;

use Plum\Deployer\DeployerInterface;

class Plum
{
    /**
     * @var array
     */
    protected $servers;

    /**
     * @var array
     */
    protected $deployers;

    /**
     * List of options
     * @var array
     */
    protected $options;

    public function __construct()
    {
        $this->servers = array();
        $this->deployers = array();
        $this->options = array();
    }

    /**
     * Registers a deployer
     *
     * @param DeployerInterface $deployer
     *
     * @return \Plum\Plum
     */
    public function registerDeployer(DeployerInterface $deployer)
    {
        if (null !== $deployer) {
            $this->deployers[$deployer->getName()] = $deployer;
        }

        return $this;
    }

    /**
     * Returns deployers
     *
     * @return array
     */
    public function getDeployers()
    {
        return $this->deployers;
    }

    /**
     * Returns a deployer
     *
     * @param string $deployer The deployer name
     *
     * @return \Plum\Deployer\DeployerInterface
     */
    public function getDeployer($deployer)
    {
        if (!isset($this->deployers[$deployer])) {
            throw new \InvalidArgumentException(sprintf('The deployer "%s" is not registered.', $deployer));
        }

        return $this->deployers[$deployer];
    }

    /**
     * Add a server to the list
     *
     * @param string $name
     * @param Server $server
     *
     * @return \Plum\Plum
     */
    public function addServer($name, $server)
    {
        if (null === $server) {
            throw new \InvalidArgumentException('The server can not be null.');
        }

        if (isset($this->servers[$name])) {
            throw new \InvalidArgumentException(sprintf('The server "%s" is already registered.', $name));
        }

        $this->servers[$name] = $server;

        return $this;
    }

    /**
     * Add a list of servers
     *
     * @param array $servers
     *
     * @return \Plum\Plum
     */
    public function setServers(array $servers)
    {
        foreach ($servers as $name => $server) {
            $this->addServer($name, $server);
        }

        return $this;
    }

    /**
     * Remove a server
     *
     * @param string $name
     *
     * @return \Plum\Plum
     */
    public function removeServer($name)
    {
        unset($this->servers[$name]);

        return $this;
    }

    /**
     * Returns a server
     *
     * @param type $server The server name
     *
     * @return \Plum\Server\ServerInterface
     */
    public function getServer($server)
    {
        if (!isset($this->servers[$server])) {
            throw new \InvalidArgumentException(sprintf('The server "%s" is not registered.', $server));
        }

        return $this->servers[$server];
    }

    /**
     * Returns servers
     *
     * @return array
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     * Deploy to the server using the deployer
     *
     * @param string $server
     * @param string $deployer
     * @param array  $options
     */
    public function deploy($server, $deployer, $options = array())
    {
        $server   = $this->getServer($server);
        $deployer = $this->getDeployer($deployer);

        return $deployer->deploy($server, $options);
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Add an option
     *
     * @param string $key
     * @param string $value
     */
    public function addOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * Returns options
     */
    public function getOptions()
    {
        return $this->options;
    }
}