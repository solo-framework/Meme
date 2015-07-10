<?php
/**
 * Копирование набора файлов в указанный каталог
 *
 * $fs = new FileSet("./", array("include/"), array("exclude/"));
 * new Copy($fs, "toDir/");
 *
 * PHP version 5
 *
 * @package Task
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme\Task;

use Meme\Output;
use Meme\Types\FileSet;
use Symfony\Component\Filesystem\Filesystem;

class Copy extends Task
{
	/**
	 * @var
	 */
	protected $files;
	/**
	 * @var
	 */
	protected $destination;
	/**
	 * @var bool
	 */
	protected $overwrite;

	public function __construct($files, $destination, $overwrite = true)
	{
		$this->files = $files;
		$this->destination = $destination;
		$this->overwrite = $overwrite;
	}

	public function run()
	{
		Output::taskHeader("Start Copy task");

		try
		{
			$fs = new Filesystem();
			if ($this->files instanceof FileSet)
				$files = $this->files->getFiles(true);
			else
				$files = (array)$this->files;

			$toDir = trim($this->destination) . DIRECTORY_SEPARATOR;
			foreach ($files as $file)
			{
				// пустые каталоги копировать не получается, просто создаем
				if (is_dir($file))
				{
					$fs->mkdir($toDir . $file);
					continue;
				}

				$res = $toDir . ltrim($file, "\/");
				$fs->copy($file, $res);
			}

			$cnt = count($files);
			Output::info("{$cnt} items were copied into directory '{$toDir}'");
		}
		catch (\Exception $e)
		{
			Output::error($e->getMessage());
		}
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