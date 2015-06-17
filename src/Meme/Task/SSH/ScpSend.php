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

use Meme\Output;
use Meme\Task\Task;

class ScpSend extends Task
{
	protected $connection = null;
	/**
	 * @var SshConnection
	 */
	protected $ssh;
	/**
	 * @var
	 */
	protected $toDir;
	/**
	 * @var
	 */
	protected $file;
	/**
	 * @var null
	 */
	protected $mode;
	/**
	 * @var bool
	 */
	protected $autocreate = true;

	/**
	 * @param SshConnection $ssh
	 * @param $toDir
	 * @param $file
	 * @param null $mode
	 */
	public function __construct(SshConnection $ssh, $toDir, $file, $mode = null, $autocreate = true)
	{
		$this->ssh = $ssh;
		$this->toDir = $toDir;
		$this->file = $file;
		$this->mode = $mode;
		$this->autocreate = $autocreate;
	}

	/**
	 * Выполнение действия
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function run()
	{
		Output::info(">> Start ScpSend task");

		$this->connection = $this->ssh->getConnection();

		$path = rtrim($this->toDir, "/") . "/";
		$localEndpoint = $this->file;

		if (!is_file($localEndpoint))
			throw new \Exception("Could not open local file '{$localEndpoint}'");

		$file = ltrim($this->file, ".\/");
		$remoteEndpoint = $path . strtr($file, '\\', '/');

		Output::comment("\t Send from '{$localEndpoint}' to '{$remoteEndpoint}'");

		$sftp = null;
		if ($this->autocreate)
			$sftp = ssh2_sftp($this->connection);

		if ($this->autocreate)
			ssh2_sftp_mkdir($sftp, dirname($remoteEndpoint), (is_null($this->mode) ? 0777 : $this->mode), true);

		if (!is_null($this->mode))
			$ret = @ssh2_scp_send($this->connection, $localEndpoint, $remoteEndpoint, $this->mode);
		else
			$ret = @ssh2_scp_send($this->connection, $localEndpoint, $remoteEndpoint);

		if ($ret === false)
			throw new \Exception("Could not create remote file '" . $remoteEndpoint . "'");

	}

}

