<?php

/**
 * Handles GIT post hook deployments
 *
 * @src http://brandonsummers.name/blog/2012/02/10/using-bitbucket-for-automated-deployments/
 **/
class Deploy extends Base {

	/**
	* The name of the branch to pull from.
	*
	* @var string
	*/
	private $_branch = 'master';

	/**
	* The name of the remote to pull from.
	*
	* @var string
	*/
	private $_remote = 'origin';

	/**
	* The directory where your website and git repository are located, can be
	* a relative or absolute path
	*
	* @var string
	*/
	private $_directory;

	private $_repo_directory;


	/**
	* Sets up defaults.
	*
	* @param  string  $directory  Directory where your website is located
	* @param  array   $data       Information about the deployment
	*/
	public function __construct($repo_directory, $directory, $options = array())
	{

		$this->_repo_directory = realpath($repo_directory).DIRECTORY_SEPARATOR;

		// Determine the directory path
		$this->_directory = realpath($directory).DIRECTORY_SEPARATOR;

		$available_options = array('log', 'date_format', 'branch', 'remote');

		foreach ($options as $option => $value)
		{
				if (in_array($option, $available_options))
				{
						$this->{'_'.$option} = $value;
				}
		}

	}

	private function buildCommand($command) {

		$full_cmd = sprintf('git --work-tree=%s --git-dir=%s %s', $this->_directory, $this->_repo_directory, $command);
		return $full_cmd;

	}

	public function getRef() {

		return shell_exec($this->buildCommand('rev-parse --short HEAD'));

	}


	/**
	* Executes the necessary commands to deploy the website.
	*/
	public function execute($post_execute = null)
	{

		try
		{

			$this->log('Attempting deployment...');

			$this->log('Before deployment: ' . $this->getRef());

			$output = shell_exec($this->buildCommand(sprintf('pull %s %s', $this->_remote, $this->_branch)));
			$this->log($output);

			$output = shell_exec($this->buildCommand('checkout -f'));
			$this->log($output);

			$this->log('After deployment: ' . $this->getRef());

			// Secure the .git directory
			// exec('chmod -R og-rx .git');
			// $this->log('Securing .git directory... ');

			# Post execute

			if (is_callable($post_execute)) {

				$this->log('Running post execute command');
				call_user_func($post_execute);

			}

			$this->log('Finished');


		}
		catch (Exception $e)
		{
			$this->log($e, 'ERROR');
		}

	}

}