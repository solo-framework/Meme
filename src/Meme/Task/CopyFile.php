<?php
/**
 * Копирует один файл в другой с возможностью переименования
 *
 * new \Meme\Task\CopyFile("./origin.txt", "./kiki/destination.txt");
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
	/**
	 * Копирует один файл в другой с возможностью переименования
	 *
	 * @param string $file Копируемый файл
	 * @param string $destination Файл назначения
	 * @param bool $overwrite Перезаписывать
	 *
	 * @throws \Exception
	 */
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

