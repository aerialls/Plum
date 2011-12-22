<?php

/*
 * This file is part of the Plum package.
 *
 * (c) 2010-2011 Julien Brochet <mewt@madalynn.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plum\Tests\Server;

use Plum\Server\Server;

class ServerTest extends \PHPUnit_Framework_TestCase
{
    public function testServerArguments()
    {
        $server = new Server('localhost', 'julien', '/home/julien/website');

        $this->assertEquals('localhost', $server->getHost());
        $this->assertEquals('julien', $server->getUser());
        $this->assertEquals('/home/julien/website/', $server->getDir());
        $this->assertEquals(22, $server->getPort());
    }
}
