PhpDeploy
=========

Automate website deployment operations using PHP + RSync + GIT

Be sure to include the class autoloader like this:

	require_once 'autoloader.php';

Below are some examples.

Deploy a website using GIT
--------------------------

Using Bitbucket.org integration Hooks, you can create a script that deploys the website when a new commit is made.

	$Deploy = new Deploy(
		'/git/awesomeapp.git/',
		'/var/www/awesomeapp/public_html/',
		[ 'branch' => 'master' ]
	);

	$Deploy->execute(function() use($Deploy) {

		# Now we can do something with the new code

	});

Sync
----

Example on how to setup a sync a source folder to a destination folder ignoring specific file ignore.tmp

	$Sync = new Sync(
		'/storage/wordpress/plugins/',
		'/var/www/awesomeapp/public_html/wp-content/plugins/',
		[ '/index.php' ]
	);

	$Sync->execute();