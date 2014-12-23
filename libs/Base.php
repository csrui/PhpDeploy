<?php

Class Base {

	/**
	* The name of the file that will be used for logging deployments. Set to
	* FALSE to disable logging.
	*
	* @var string
	*/
	private $_log = 'deployments.log';

	/**
	* The timestamp format used for logging.
	*
	* @link    http://www.php.net/manual/en/function.date.php
	* @var     string
	*/
	private $_date_format = 'Y-m-d H:i:sP';

	  /**
	  * Writes a message to the log file.
	  *
	  * @param  string  $message  The message to write
	  * @param  string  $type     The type of log message (e.g. INFO, DEBUG, ERROR, etc.)
	  */
	  public function log($message, $type = 'INFO')
	  {
		  if ($this->_log)
		  {
			  // Set the name of the log file
			  $filename = $this->_log;

			  if ( ! file_exists($filename))
			  {
				  // Create the log file
				  file_put_contents($filename, '');

				  // Allow anyone to write to log files
				  chmod($filename, 0666);
			  }

			  // Write the message into the log file
			  // Format: time --- type: message
			  file_put_contents($filename, date($this->_date_format).' --- '.$type.': '.$message.PHP_EOL, FILE_APPEND);
		  }
	  }

}