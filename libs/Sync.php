<?php

Class Sync extends Base {

	private $_exceptions = [];

	private $_source = null;

	private $_destination = null;

	public function __construct($source, $destination, $exceptions = array()) {

		$this->_source = $source;
		$this->_destination = $destination;
		$this->_exceptions = $exceptions;

	}

	private function isReadable($folder) {

		return is_readable($folder);

	}

	public function execute($post_execute = null) {

		# Verify folders

		if (!$this->isReadable($this->_source)) {

			$this->log(sprintf('Source not readable: ' . $this->_source));
			return false;

		}

		if (!$this->isReadable($this->_destination)) {

			$this->log(sprintf('Destination not readable: ' . $this->_destination));
			return false;

		}

		# Prepare exclusions

		$exclude_param = '';

		foreach ($this->_exceptions as $item) {

			$exclude_param .= sprintf('--exclude %s ', $item);

		}

		# Run command

		$execute_cmd = sprintf('rsync -avz %s %s %s', $exclude_param, $this->_source, $this->_destination);
		$this->log('Attempting: ' . $execute_cmd);

		exec($execute_cmd, $output);

		# Post execute

		if (is_callable($post_execute)) {

			$this->log('Running post execute command');
			call_user_func($post_execute);

		}

		$this->log('Finished');

	}

}