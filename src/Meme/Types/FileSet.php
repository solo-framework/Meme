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
	 * Список файлов, подходящих под условия
	 *
	 * @var array
	 */
	protected $files = array();


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
		$ds = new DirectoryScanner();
		$ds->SetIncludes($includes);
		$ds->SetExcludes($excludes);
		$ds->SetBasedir($baseDir);
		$ds->SetCaseSensitive($caseSensitive);
		$ds->setExpandSymbolicLinks($followSymlinks);
		$ds->Scan();

		$this->files = $ds->GetIncludedFiles();
	}

	/**
	 * Возвращает список найденных файлов
	 *
	 * @return string[]
	 */
	public function getFiles()
	{
		return $this->files;
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