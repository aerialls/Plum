<?php

/*
 * This file is part of the Plum package.
 *
 * (c) 2010-2012 Julien Brochet <mewt@madalynn.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plum\Server;

class Server implements ServerInterface
{
    /**
     * The connection hostname
     *
     * @var string
     */
    protected $host;

    /**
     * The connection port
     *
     * @var string
     */
    protected $port;

    /**
     * The connection username
     *
     * @var string
     */
    protected $user;

    /**
     * The connection directory
     *
     * @var string
     */
    protected $dir;

    /**
     * The connection password
     *
     * @var string
     */
    protected $password;

    /**
     * A list of options
     *
     * @var array
     */
    protected $options;

    public function __construct($host, $user, $dir, $password = null, $port = 22, $options = array())
    {
        if ('/' !== substr($dir, -1)) {
            $dir .= '/';
        }

        $this->host     = $host;
        $this->port     = $port;
        $this->user     = $user;
        $this->dir      = $dir;
        $this->password = $password;
        $this->options  = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * {@inheritDoc}
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * {@inheritDoc}
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     */
    public function getHiddenPassword()
    {
        return str_repeat('*', strlen($this->password));
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions()
    {
        return $this->options;
    }
}