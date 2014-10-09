<?php
/**
 * Загрузка файла на удаленный хост
 *
 * $ssh = new SshConnection("ubuntu", "dev", "root");
 * new ScpSend($ssh, "storage/files/", "../README.md", 0777);
 *
 * PHP version 5
 *
 * @package Task
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Task\SSH;

use Meme\Console;
use Meme\Task\Task;

class ScpSend extends Task
{
	protected $connection = null;

	public function __construct(SshConnection $ssh, $toDir, $file, $mode = null, $autocreate = true)
	{
		Console::info(">> Start ScpSend task");

		$this->connection = $ssh->getConnection();

		$path = rtrim($toDir, "/") . "/";
		$localEndpoint = $file;

		if (!is_file($localEndpoint))
			throw new \Exception("Could not open local file '{$localEndpoint}'");

		$file = ltrim($file, ".\/");
		$remoteEndpoint = $path . strtr($file, '\\', '/');

		Console::debug("\t Send from '{$localEndpoint}' to '{$remoteEndpoint}'");

		$sftp = null;
		if ($autocreate)
			$sftp = ssh2_sftp($this->connection);

		if ($autocreate)
			ssh2_sftp_mkdir($sftp, dirname($remoteEndpoint), (is_null($mode) ? 0777 : $mode), true);

		if (!is_null($mode))
			$ret = @ssh2_scp_send($this->connection, $localEndpoint, $remoteEndpoint, $mode);
		else
			$ret = @ssh2_scp_send($this->connection, $localEndpoint, $remoteEndpoint);

		if ($ret === false)
			throw new \Exception("Could not create remote file '" . $remoteEndpoint . "'");

	}
}

