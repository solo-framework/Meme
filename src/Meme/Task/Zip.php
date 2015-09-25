<?php
/**
 * Создание архива файлов
 *
 * new \Meme\Task\Zip("result.zip", new FileSet($dir));
 *
 * PHP version 5
 *
 * @created 07.10.2014 21:29
 * @package
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme\Task;


use Meme\Output;
use Meme\Types\FileSet;
use Symfony\Component\Filesystem\Filesystem;
use ZipArchive;

class Zip extends Task
{
	/**
	 * @var string
	 */
	private $zipName;
	/**
	 * @var FileSet
	 */
	private $fileset;

	/**
	 * Создание архива файлов
	 *
	 * @param string $zipName Имя файла результирующего архива
	 * @param \Meme\Types\FileSet $fileset Набор файлов
	 */
	public function __construct($zipName, FileSet $fileset)
	{
		$this->zipName = $zipName;
		$this->fileset = $fileset;
	}

	protected function normalizeSlashes($string)
	{
		return str_replace("\\", "/", $string);
	}

	/**
	 * Выполнение действия
	 *
	 * @return mixed
	 */
	public function run()
	{
		Output::taskHeader("Start Zip task");
		$files = $this->fileset->getFiles(true);
		$baseDir = $this->normalizeSlashes(rtrim($this->fileset->getBaseDir(), '\/') . "/");

		$zip = new \ZipArchive();
		$res = $zip->open($this->zipName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
		if ($res === true)
		{
			foreach ($files as $file)
			{
				$fileName = trim($file);
				$fname = $this->normalizeSlashes($fileName);
				$fname = str_replace($baseDir, "", $fname);

				if (is_dir($file))
				{
					$fname = "./" . ltrim($fname, '\/');
					$zip->addEmptyDir($fname);
				}
				else
				{
					$zip->addFile($fileName, $fname);
				}
			}

			Output::comment("Creating zip file {$this->zipName}");
		}
		else
		{
			$report = error_get_last();
			$message = "";
			if ($report)
				$message = $report["message"];
			Output::error("ZIP error: {$message}");
		}

		$zip->close();
	}
}