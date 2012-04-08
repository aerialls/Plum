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

interface ServerInterface
{
    /**
     * Return the connection port
     */
    function getPort();

    /**
     * Returns the host
     */
    function getHost();

    /**
     * Returns the directory
     */
    function getDir();

    /**
     * Returns the user
     */
    function getUser();

    /**
     * Returns the password
     */
    function getPassword();

    /**
     * Returns the hidden password
     */
    function getHiddenPassword();

    /**
     * Returns options
     */
    function getOptions();
}