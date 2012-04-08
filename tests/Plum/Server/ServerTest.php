<?php

/*
 * This file is part of the Plum package.
 *
 * (c) 2010-2012 Julien Brochet <mewt@madalynn.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plum\Tests\Server;

use Plum\Server\Server;

class ServerTest extends \PHPUnit_Framework_TestCase
{
    public function testServerArg()
    {
        $server = new Server('localhost', 'julien', '/var/www/', 's3cret', 1234, array('dry_run' => true));

        $this->assertEquals('localhost', $server->getHost());
        $this->assertEquals('julien', $server->getUser());
        $this->assertEquals('/var/www/', $server->getDir());
        $this->assertEquals('s3cret', $server->getPassword());
        $this->assertEquals(1234, $server->getPort());
        $this->assertEquals(array('dry_run' => true), $server->getOptions());
    }

    public function testServerDefaultArg()
    {
        $server = new Server('localhost', 'julien', '/home/julien/website');

        $this->assertNull($server->getPassword());
        $this->assertEquals(22, $server->getPort());
        $this->assertEquals(array(), $server->getOptions());
    }

    public function testServerPath()
    {
        $s1 = new Server('localhost', 'julien', '/home/julien/website');
        $s2 = new Server('localhost', 'julien', '/home/julien/website/');

        $this->assertEquals('/home/julien/website/', $s1->getDir());
        $this->assertEquals('/home/julien/website/', $s2->getDir());
    }
}
