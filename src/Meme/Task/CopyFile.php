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
	 * @var string
	 */
	protected $file;
	/**
	 * @var string
	 */
	protected $destination;
	/**
	 * @var bool
	 */
	protected $overwrite;

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
		$this->file = $file;
		$this->destination = $destination;
		$this->overwrite = $overwrite;
	}

	public function run()
	{
		Output::taskHeader("Start CopyFile task");

		if (!is_file($this->file))
			throw new \Exception("File {$this->file} doesn't exist");

		$fs = new Filesystem();
		$fs->copy($this->file, $this->destination, $this->overwrite);
		Output::info("Copied {$this->file} to {$this->destination}");
	}

	/**
	 * @param boolean $overwrite
	 *
	 * @return $this
	 */
	public function setOverwrite($overwrite)
	{
		$this->overwrite = $overwrite;
		return $this;
	}
}

