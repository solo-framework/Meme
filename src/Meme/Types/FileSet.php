<?php
/**
 * Список файлов
 *
 * PHP version 5
 *
 * @package Types
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme\Types;

use Meme\DirectoryScanner;
use Symfony\Component\Finder\Finder;

class FileSet extends Type
{
	/**
	 * @var DirectoryScanner
	 */
	protected $ds;

	/**
	 * Список файлов, подходящих под условия
	 *
	 * @var array
	 */
	protected $files = array();

	protected $baseDir = "";


	/**
	 * When a name path segment is matched against a pattern path segment, the
	 * following special characters can be used:
	 *   '*' matches zero or more characters,
	 *   '?' matches one character.
	 *
	 * Examples:
	 *
	 * "**\*.php" matches all .php files/dirs in a directory tree.
	 *
	 * "test\a??.php" matches all files/dirs which start with an 'a', then two
	 * more characters and then ".php", in a directory called test.
	 *
	 * "**" matches everything in a directory tree.
	 *
	 * "**\test\**\XYZ*" matches all files/dirs that start with "XYZ" and where
	 * there is a parent directory called test (e.g. "abc\test\def\ghi\XYZ123").
	 *
	 * @param string $baseDir Путь к каталогу, в котором будет проходить поиск
	 * @param array $includes
	 * @param array $excludes
	 * @param bool $caseSensitive
	 * @param bool $followSymlinks
	 */
	public function __construct($baseDir, $includes = array(), $excludes = array(), $caseSensitive = true, $followSymlinks = false)
	{
//		if ($baseDir == ".")
//			$baseDir = $baseDir . DIRECTORY_SEPARATOR;

		$this->ds = new DirectoryScanner();
		$this->ds->setBasedir($baseDir);
		$this->ds->SetIncludes((array)$includes);
		$this->ds->SetExcludes((array)$excludes);
		$this->ds->SetCaseSensitive($caseSensitive);
		$this->ds->setExpandSymbolicLinks($followSymlinks);
		$this->baseDir = $this->ds->getBasedir();//$baseDir;
		$this->ds->Scan();
	}

	/**
	 * Возвращает список найденных файлов
	 *
	 * @param bool $pathPrefix Добавлять к имени файла базовый каталог
	 *
	 * @return string[]
	 */
	public function getFiles($pathPrefix = false)
	{
		$files = $this->ds->GetIncludedFiles();
		$dirs = $this->ds->getIncludedDirectories();

		$dirs1 = array_filter($dirs, function($el){
			if ($el !== "" || $el !== ".")
				return $el;
		});

		$files = array_merge($files, $dirs1);

		if (!$pathPrefix)
		{
			return $files;
		}
		else
		{
			$res = array();
			foreach ($files as $file)
			{
//				if (is_dir($file))
//					$res[] = rtrim($this->baseDir, "\/") . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR;
//				else
					$res[] = rtrim($this->baseDir, "\/") . DIRECTORY_SEPARATOR . $file;
			}

			return $res;
		}
	}


	/**
	 * Возвращает базовый каталог нбора файлов
	 *
	 * @return string
	 */
	public function getBaseDir()
	{
		return $this->baseDir;
	}

//	public function __construct($baseDir,
//	                            $paths = array(), $notPaths = array(),
//	                            $names = array(), $notNames = array(),
//								$what = self::FILE_AND_DIRS,
//	                            $followSymlinks = false, $ignoreDotFiles = false)
//	{
//
//			$paths = (array)$paths;
//			$notPaths = (array)$notPaths;
//			$names = (array)$names;
//			$notNames = (array)$notNames;
//
//			$fs = new Finder();
//			$fs->in($baseDir);
//			$fs->ignoreDotFiles($ignoreDotFiles);
//			$fs->ignoreVCS(false);
//
//			if ($followSymlinks)
//				$fs->followLinks();
//
//			if ($what == self::FILES)
//				$fs->files();
//
//			if ($what == self::DIRS)
//				$fs->directories();
//
//
//
//			foreach ($paths as $incl)
//				$fs->path($incl);
//
//			foreach ($notPaths as $excl)
//				$fs->notPath($excl);
//
//			foreach ($names as $incl)
//				$fs->name($incl);
//
//			foreach ($notNames as $excl)
//				$fs->notName($excl);
//
//
//			foreach ($fs as $item)
//				$this->files[] = $item->getPathname();
//
//	}

//	public function __construct($baseDir, $includeDirs, $excludeDirs = array(),
//								$fileNames = array(), $notFileNames = array(),
//								$followSymlinks = false, $ignoreDotFiles = false)
//	{
//
//		try
//		{
////			print_r($excludeDirs);
//			$fileNames = (array)$fileNames;
//			$notFileNames = (array)$notFileNames;
//
////			$includeDirs = array_filter($includeDirs, function($el){
////				return is_dir($el);
////			});
////			$excludeDirs = array_filter($excludeDirs, function($el){
////				return is_dir($el);
////			});
//
//			print_r($includeDirs);
//			print_r($excludeDirs);
//
//			// нечего искать
//			if (count($includeDirs) == 0)
//				return true;
//
//			$fs = new Finder();
//			$fs->ignoreDotFiles($ignoreDotFiles);
//			$fs->ignoreVCS(false);
//
//			if ($followSymlinks)
//				$fs->followLinks();
//
//			//$fs->files();
//			$fs->in($baseDir);
//
////			foreach ($includeDirs as $incl)
////			{
////				$fs->in($incl);
////			}
////
////			foreach ($excludeDirs as $excl)
////			{
////				$fs->exclude($excl);
////			}
//
//			foreach ($fileNames as $file)
//				$fs->name($file);
//
//			foreach ($notFileNames as $file)
//				$fs->notName($file);
//
//
//			foreach ($fs as $item)
//				$this->files[] = $item->getPathname();
//		}
//		catch (\Exception $e)
//		{
//			echo $e->getMessage();
//			return false;
//		}
//
//
//
////
////			->notName(".gitignore")
////			->notName(".test")
////			->notName("*.md")
////
////			->exclude(array("vendor", ".idea"));
//
////		$ri = new \RecursiveDirectoryIterator($this->dir, \RecursiveDirectoryIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS);
////		//new \GlobIterator()
////
////		foreach (new \RecursiveIteratorIterator($ri) as $item)
////		{
////			$this->files[] = $item->getPathname();
////			if ($this->matchPath("Task*.php", $item->getFilename(), false))
////			{
////				print_r($item->getPathname());
////			}
////		}
//			//$this->files[] = $item->getPathname();
//			//print_r( $filename->getPathname() . "\n") ;
//	}
}