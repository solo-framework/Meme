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

	public function __construct($host, $port = 22)
	{
		if (!function_exists('ssh2_connect'))
			throw new \Exception("To use Ssh, you need to install the PHP SSH2 extension.");

		$this->connection = ssh2_connect($host, $port);
		if ($this->connection == false)
			throw new \Exception("Could not establish connection to {$host}:{$port}");

//		$auth = null;
//		if ($pubkeyfile)
//		{
//			$auth = ssh2_auth_pubkey_file($this->connection, $username, $pubkeyfile, $privkeyfile, $privKeyfilePassphrase);
//		}
//		else
//		{
//			$auth = ssh2_auth_password($this->connection, $username, $password);
//		}
//		if (!$auth)
//			throw new \Exception("Could not authenticate connection!");

	}

	/**
	 * Аутентификация с паролем
	 *
	 * @param $userName
	 * @param $password
	 *
	 * @throws \Exception
	 */
	public function authPassword($userName, $password)
	{
		$auth = ssh2_auth_password($this->connection, $userName, $password);
		if (!$auth)
			throw new \Exception("Could not authenticate connection with password!");
	}

	/**
	 * Аутентификация по ключам
	 *
	 * @param $userName
	 * @param $pubkeyfile
	 * @param $privkeyfile
	 * @param null $privKeyfilePassphrase
	 *
	 * @throws \Exception
	 */
	public function authPublicKey($userName, $pubkeyfile, $privkeyfile, $privKeyfilePassphrase = null)
	{
		$auth = ssh2_auth_pubkey_file($this->connection, $userName, $pubkeyfile, $privkeyfile, $privKeyfilePassphrase);
		if (!$auth)
			throw new \Exception("Could not authenticate connection with key!");
	}

	/**
	 * Authenticate over SSH using the ssh agent
	 *
	 * @param $userName
	 *
	 * @throws \Exception
	 */
	public function authAgent($userName)
	{
		$auth = ssh2_auth_agent($this->connection, $userName);
		if (!$auth)
			throw new \Exception("Could not authenticate connection with key!");
	}

	public function getConnection()
	{
		return $this->connection;
	}
}

