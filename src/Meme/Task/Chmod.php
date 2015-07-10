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
	 * @var array|FileSet|string
	 */
	protected $target;
	/**
	 * @var int
	 */
	protected $mode;
	/**
	 * @var bool
	 */
	protected $recursive;
	/**
	 * @var int
	 */
	protected $umask;

	/**
	 * @param FileSet|string|array $target Набор файлов\каталогов для установки прав доступа
	 * @param int $mode Восьмеричный режим доступа
	 * @param bool $recursive
	 * @param int $umask Восьмеричная маска режима создания пользовательских файлов
	 */
	public function __construct($target, $mode = 0777, $recursive = false, $umask = 0000)
	{
		$this->target = $target;
		$this->mode = $mode;
		$this->recursive = $recursive;
		$this->umask = $umask;
	}

	public function run()
	{
		Output::taskHeader("Start Chmod task");

		try
		{
			if ($this->target instanceof FileSet)
				$target = $this->target->getFiles(true);
			else
				$target = (array)$this->target;

			$fs = new Filesystem();
			array_map(function ($item) {
				$r = "";
				if ($this->recursive)
					$r = "recursive";

				Output::info("Change file mode on '{$item}' to " . sprintf("%o", $this->mode) . " ({$r})" );
			}, $target);


			$fs->chmod($target, $this->mode, $this->umask, $this->recursive);
		}
		catch (\Exception $e)
		{
			Output::error($e->getMessage());
		}
	}

	/**
	 * @param int $mode
	 *
	 * @return $this
	 */
	public function setMode($mode)
	{
		$this->mode = $mode;
		return $this;
	}

	/**
	 * @param boolean $recursive
	 *
	 * @return $this
	 */
	public function setRecursive($recursive)
	{
		$this->recursive = $recursive;
		return $this;
	}

	/**
	 * @param int $umask
	 *
	 * @return $this
	 */
	public function setUmask($umask)
	{
		$this->umask = $umask;
		return $this;
	}
}