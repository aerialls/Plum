<?php

/*
 * This file is part of the Plum package.
 *
 * (c) 2010-2012 Julien Brochet <mewt@madalynn.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$file = __DIR__.'/autoload.php';
if (file_exists($file)) {
    require_once $file;
} else {
    $file .= '.dist';
    if (file_exists($file)) {
        require_once $file;
    }
}
