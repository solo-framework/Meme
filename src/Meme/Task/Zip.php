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
	 * Создание архива файлов
	 *
	 * @param string $zipName Имя файла результирующего архива
	 * @param \Meme\Types\FileSet $fileset Набор файлов
	 */
	public function __construct($zipName, FileSet $fileset)
	{
		Output::taskHeader("Start Zip task");
		$files = $fileset->getFiles(true);
		$baseDir = $this->normalizeSlashes(rtrim($fileset->getBaseDir(), '\/') . "/");

		$zip = new \ZipArchive();
		$res = $zip->open($zipName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
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

			Output::comment("Created zip file {$zipName}");
		}
		else
		{
			Output::error("ZIP error");
		}

		$zip->close();
	}

	protected function normalizeSlashes($string)
	{
		return str_replace("\\", "/", $string);
	}
}