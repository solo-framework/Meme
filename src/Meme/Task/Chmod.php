<?php
/**
 * Задача изменения прав доступа к файлам и каталогам
 *
 * PHP version 5
 *
 * Пример:
 * $fs = new FileSet("./", array("includeDir/"), array("excludeDir/"));
 * new Chmod($fs, 0777);
 *
 * Или
 * new Chmod(array("dir1", "dir2"), 0777);
 *
 * Или
 * new Chmod("dir1", 0777);
 *
 * @created 08.10.2014 22:12
 * @package
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme\Task;


use Meme\Output;
use Meme\Types\FileSet;
use Symfony\Component\Filesystem\Filesystem;

class Chmod extends Task
{
	/**
	 * @param FileSet|string|array $target Набор файлов\каталогов для установки прав доступа
	 * @param int $mode Восьмеричный режим доступа
	 * @param bool $recursive
	 * @param int $umask Восьмеричная маска режима создания пользовательских файлов
	 */
	public function __construct($target, $mode, $recursive = false, $umask = 0000)
	{
		Output::taskHeader("Start Chmod task");

		try
		{
			if ($target instanceof FileSet)
				$target = $target->getFiles(true);
			else
				$target = (array)$target;

			$fs = new Filesystem();
			array_map(function ($item) use($mode, $recursive){
				$r = "";
				if ($recursive)
					$r = "recursive";

				Output::info("Change file mode on '{$item}' to " . vsprintf("%o", $mode) . " ({$r})" );
			}, $target);


			$fs->chmod($target, $mode, $umask, $recursive);
		}
		catch (\Exception $e)
		{
			Output::error($e->getMessage());
		}
	}
}