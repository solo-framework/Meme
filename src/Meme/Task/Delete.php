<?php
/**
 * Удаление набора файлов
 *
 * $dir = "./dir";
 * new \Meme\Task\Delete($dir);
 *
 * или
 * new \Meme\Task\Delete(array("./dir", "./dir2"));
 *
 * или
 * $fs = new FileSet("./", array("include/"), array("exclude/"));
 * new \Meme\Task\Delete($fs);
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme\Task;

use Meme\Output;
use Meme\Types\FileSet;
use Symfony\Component\Filesystem\Filesystem;

class Delete extends Task
{
	/**
	 * @var array|FileSet|string
	 */
	protected $target;
	/**
	 * @var bool
	 */
	protected $deleteEmptyDirs;
	/**
	 * @var bool
	 */
	protected $verbose;

	/**
	 * Удаление набора файлов
	 *
	 * @param string|array|FileSet $target Набор файлов для удаления
	 * @param bool $deleteEmptyDirs Удалять пустые каталоги
	 * @param bool $verbose Отображать процесс выполнения
	 */
	public function __construct($target, $deleteEmptyDirs = true, $verbose = true)
	{
		$this->target = $target;
		$this->deleteEmptyDirs = $deleteEmptyDirs;
		$this->verbose = $verbose;
	}

	public function run()
	{
		Output::taskHeader("Start Delete task");

		if ($this->target instanceof FileSet)
		{
			$target = $this->target->getFiles(true);
		}
		else
		{
			$target = (array)$this->target;
		}

		$fs = new Filesystem();
		$fs->remove($target);

		if ($this->verbose)
		{
			foreach ($target as $file)
				Output::info("Deleted {$file}");
		}

		$cnt = count($target);
		Output::info("{$cnt} file(s) were deleted");
	}

	/**
	 * @param boolean $deleteEmptyDirs
	 *
	 * @return $this
	 */
	public function setDeleteEmptyDirs($deleteEmptyDirs)
	{
		$this->deleteEmptyDirs = $deleteEmptyDirs;
		return $this;
	}

	/**
	 * @param boolean $verbose
	 *
	 * @return $this
	 */
	public function setVerbose($verbose)
	{
		$this->verbose = $verbose;
		return $this;
	}
}

