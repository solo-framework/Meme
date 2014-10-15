<?php
/**
 * Копирует один файл в другой с возможностью переименования
 *
 * PHP version 5
 *
 * @package Task
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Task;

use Meme\Output;
use Symfony\Component\Filesystem\Filesystem;

class CopyFile extends Task
{
	public function __construct($file, $destination, $overwrite = true)
	{
		Output::taskHeader("Start CopyFile task");

		if (!is_file($file))
			throw new \Exception("File {$file} doesn't esist");

		$fs = new Filesystem();
		$fs->copy($file, $destination, $overwrite);
		Output::info("Copied {$file} to {$destination}");
	}
}

