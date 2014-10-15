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

		$zip = new \ZipArchive();
		$res = $zip->open($zipName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

		if ($res === true)
		{
			foreach ($files as $file)
			{
				$fileName = trim($file);
				if (is_dir($file))
				{
					$zip->addEmptyDir(str_replace($fileset->getBaseDir(), "", $fileName));
				}
				else
				{
					$zip->addFile($fileName, str_replace($fileset->getBaseDir(), "", $fileName));//$file);
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
}