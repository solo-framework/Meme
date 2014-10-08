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


use ZipArchive;

class Zip extends Task
{
	/**
	 * @param string $fileName Имя файла архива
	 * @param array $files Список путей файлов для записи в архив
	 */
	public function __construct($baseDir, $fileName, $files)
	{
		echo ">> Start Zip task\n";
		$files = (array)$files;

		$zip = new \ZipArchive();
		$res = $zip->open($fileName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

		if ($res === true)
		{
			foreach ($files as $file)
			{
				$fileName = $baseDir . "/" . trim($file);
				if (is_dir($file))
					$zip->addEmptyDir($file);
				else
					$zip->addFile($fileName, $file);
			}
		}
		else
		{
			echo "ZIP error\n";
		}

		$zip->close();
	}

	public function run()
	{
		// TODO: Implement run() method.
	}
}