<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Task\SSH;


use Herrera\Annotations\Exception\Exception;

class SshConnection
{
	protected $connection = null;

	public function __construct($host, $username, $password = null, $port = 22, $pubkeyfile = null, $privkeyfile = null, $privKeyfilePassphrase = null)
	{
		if (!function_exists('ssh2_connect'))
		{
			throw new \Exception("To use Ssh, you need to install the PHP SSH2 extension.");
		}

		$this->connection = ssh2_connect($host, $port);
		if ($this->connection == false)
		{
			throw new \Exception("Could not establish connection to {$host}:{$port}");
		}

		$auth = null;
		if ($pubkeyfile)
		{
			$auth = ssh2_auth_pubkey_file($this->connection, $username, $pubkeyfile, $privkeyfile, $privKeyfilePassphrase);
		}
		else
		{
			$auth = ssh2_auth_password($this->connection, $username, $password);
		}
		if (!$auth)
			throw new \Exception("Could not authenticate connection!");

	}

	public function getConnection()
	{
		return $this->connection;
	}
}

