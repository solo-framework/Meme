<?php
/**
 *
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
	 * @param $baseDir
	 * @param string $fileName Имя файла архива
	 * @param array $files Список путей файлов для записи в архив
	 */
	public function __construct(/* $baseDir, */ $fileName, FileSet $fileset)
	{
		Output::info(">> Start Zip task");

//		$fs = new Filesystem();
//		if ($files instanceof FileSet)
			$files = $fileset->getFiles(true);
//		else
//			$files = (array)$files;

		//$files = (array)$files;

		$zip = new \ZipArchive();
		$res = $zip->open($fileName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

		if ($res === true)
		{
			foreach ($files as $file)
			{
				//$fileName = $baseDir . "/" . trim($file);
				// TODO не копировать в архив базовый каталог
				// TODO: возможно в конструктор передавать не файл, а FileSet?
				// TODO: чтобы можно было определить базовый каталог
				//$fileName = $baseDir . "/" . trim($file);
				$fileName = trim($file);
				if (is_dir($file))
				{
					$zip->addEmptyDir($file);
					print_r("dir: {$file}\n");
				}

				else
				{
					$zip->addFile($fileName, str_replace($fileset->getBaseDir(), "", $fileName));//$file);
				}
//				print_r(str_replace($fileset->getBaseDir(), "", $fileName) . "\n");
//				print_r($fileName . "\n");
//				print_r($fileName . "\n");
			}
		}
		else
		{
			Output::error("ZIP error");
		}

		$zip->close();
	}
}