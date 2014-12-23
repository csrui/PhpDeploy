PhpDeploy
=========

Automate deployment operations using PHP

Be sure to include the class autoloader like the example:

	require_once 'autoloader.php';

Sync
----

Example on how to setup a sync a source folder to a destination folder ignoring specific file ignore.tmp

	$Sync = new Sync(
		'/source_folder/',
		'/destination_folder/',
		[ 'ignore.tmp' ]
	);

	$Sync->execute();