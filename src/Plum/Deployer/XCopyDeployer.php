<?php

/*
 * This file is part of the Plum package.
 *
 * (c) 2015 Alan Candido <contact@acandido.info>
 * Based work by Julien Brochet <mewt@madalynn.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Plum\Deployer;

use Plum\Server\ServerInterface;
use Plum\Deployer\AbstractDeployer;

class XCopyDeployer extends AbstractDeployer {

	/**
	 *
	 * {@inheritDoc}
	 *
	 */
	public function doDeploy(ServerInterface $server, array $options, $dryRun) {
		if ((PHP_OS != "WIN32") && (PHP_OS != "WINNT") && (PHP_OS != "Windows")) {
			throw new \Exception ( "This deployer running only Windows OS. This OS is " . PHP_OS );
		}

		$xcopyOptions = isset ( $options ['xcopy_options'] ) ? $options ['xcopy_options'] : '/D /E /F /K /Y /I';

		// Exclude file
		$excludeFile = null;

		if (isset ( $options ['xcopy_exclude'] )) {
			$excludeOption = $options ['xcopy_exclude'];
		} else {
			$excludeOption = $options ['rsync_exclude'];
		}

		if (isset ( $excludeOption )) {
			$excludeFile = $excludeOption;
			if (false === file_exists ( $excludeFile )) {
				throw new \InvalidArgumentException ( sprintf ( 'The exclude file "%s" does not exist.', $excludeFile ) );
			}

			$excludeFile = realpath ( $excludeFile );
		}

		$exclude = '';
		if (null !== $excludeFile) {
			$exclude = sprintf ( '/EXCLUDE:%s', $excludeFile );
		}

		$target = trim ( $server->getDir () );
		$target = substr ( $server->getDir (), 0, strlen ( $server->getDir () ) - 1 );

		$command = sprintf ( 'xcopy %s %s %s %s', ".", $target, $xcopyOptions, $exclude );

		print_r ( $command );
		print "\n";

		$result = system ( $command );

		print ($result) ;
		print "\n";

		$commands = isset ( $options ['commands'] ) ? $options ['commands'] : array ();
		$this->execCommands ( $server, $commands );
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 */
	public function getName() {
		return 'xcopy';
	}
	private function execCommands($server, $commands) {
		if (0 === count ( $commands )) {
			return;
		}

		$target = $server->getDir ();
		$bat = "";

		foreach ( $commands as $command ) {
			$command = str_replace ( "%target%", $target, $command );
			print "\n > $command";
			$bat .= "$command\n";
		}

		file_put_contents ( "_deploy.bat", $bat );
		system ( "_deploy.bat" );

	}
}