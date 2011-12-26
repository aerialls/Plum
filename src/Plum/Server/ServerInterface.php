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

interface ServerInterface
{
    /**
     * Return the connection port
     */
    public function getPort();

    /**
     * Returns the host
     */
    public function getHost();

    /**
     * Returns the directory
     */
    public function getDir();

    /**
     * Returns the user
     */
    public function getUser();

    /**
     * Returns the password
     */
    public function getPassword();
}