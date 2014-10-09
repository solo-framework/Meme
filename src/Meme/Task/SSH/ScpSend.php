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

use Meme\Console;
use Meme\Task\Task;
use Meme\Types\FileSet;

class ScpSend extends Task
{
	protected $connection = null;

	public function __construct($files, SshConnection $ssh, $toDir, $mode, $autocreate = true)
	{
		Console::info(">> Start ScpSend task");
		clearstatcache();

		$this->connection = $ssh->getConnection();

		if ($files instanceof FileSet)
			$files =  $files->getFiles(true);
		else
			$files = (array)$files;

		foreach ($files as $file)
		{
			Console::info($file);
			continue;

			$path = rtrim($toDir, "/") . "/";
			$localEndpoint = $file;

			$file = ltrim($file, ".\/");
			$remoteEndpoint = $path . strtr($file, '\\', '/');

			Console::debug("\t Send from '{$localEndpoint}' to '{$remoteEndpoint}'");

			// prepare sftp resource
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




//		$fs = new Filesystem();
//		$fs->remove($target);
	}


	protected function copyFile($local, $remote)
	{


	}
}

