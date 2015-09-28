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

	/**
	 * @var bool
	 */
	protected $includeBaseDir = true;

	protected $baseDir = null;

	public function __construct($files, $destination, $overwrite = true)
	{
//		print_r($files->getBaseDir());
		$this->files = $files;
		$this->destination = $destination;
		$this->overwrite = $overwrite;
	}

	/**
	 * Можно исключить не копировать базовый каталог, в котором находятся файлы,
	 * для этого нужно указать FALSE
	 *
	 * пример 1:
	 * setIncludeBaseDirectory(true)
	 *
	 * /basedir
	 *   /subdir1
	 *   /subdir2
	 *
	 * будет скопировано как
	 * /destination
	 *   /basedir
	 *     /subdir1
	 *     /subdir1
	 *
	 * пример 2:
	 * setIncludeBaseDirectory(false)
	 *
	 * /basedir
	 *   /subdir1
	 *   /subdir2
	 *
	 * будет скопировано как
	 * /destination
	 *   /subdir1
	 *   /subdir1
	 *
	 * @param bool $val
	 *
	 * @return $this
	 */
	public function setIncludeBaseDirectory($val)
	{
		$this->includeBaseDir = $val;
		return $this;
	}

	public function run()
	{
		Output::taskHeader("Start Copy task");

		try
		{
			$fs = new Filesystem();
			if ($this->files instanceof FileSet)
			{
				$files = $this->files->getFiles(true);
				$this->baseDir =  ltrim($this->files->getBaseDir(), "\/.");
			}
			else
			{
				$files = (array)$this->files;
			}

			$toDir = trim($this->destination) . DIRECTORY_SEPARATOR;
			foreach ($files as $file)
			{
				// удалить ведущие ../
				$dest = preg_replace('~(?:\.\./)+~', '/', $file);

				if (!$this->includeBaseDir && $this->baseDir)
				{
					if (substr($dest, 0, strlen($this->baseDir)) == $this->baseDir)
						$dest = substr($dest, strlen($this->baseDir));
				}

				// пустые каталоги копировать не получается, просто создаем
				if (is_dir($file))
				{
					$dir = $toDir . $dest;
					$fs->mkdir($dir);
					continue;
				}

				$fileDest = $toDir . ltrim($dest, "\/");
				$fs->copy($file, $fileDest);
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