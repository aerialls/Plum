# Plum

[![Build Status](https://secure.travis-ci.org/aerialls/Plum.png)](http://travis-ci.org/aerialls/Plum)

An object oriented deployer library

## Installation and configuration

Plum does not provide and autoloader but follow the PSR-0 convention.

    $plum = new \Plum\Plum();

    // Add global options for all the servers
    $plum->setOptions(array(
        'dryRun'      => true,
        'excludeFile' => __DIR__.'/exclude.txt'
    ));

    // Register the rsync deployer
    $plum->registerDeployer(new \Plum\Deployer\RsyncDeployer());

    // Add your server
    $plum->addServer('bender', new \Plum\Server\Server('www.mywebsite.com', 'login', '/path/to/my/website'));

    // Let's go!
    $plum->deploy('bender', 'rsync');