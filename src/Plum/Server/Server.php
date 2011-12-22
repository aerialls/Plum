<?php

/*
 * This file is part of the Plum package.
 *
 * (c) 2010-2011 Julien Brochet <mewt@madalynn.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plum\Server;

class Server implements ServerInterface
{
    protected $host;
    protected $port;
    protected $user;
    protected $dir;

    public function __construct($host, $user, $dir, $port = 22)
    {
        if ('/' !== substr($dir, -1)) {
            $dir .= '/';
        }

        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->dir  = $dir;
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
}