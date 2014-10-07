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

use Symfony\Component\Finder\Finder;

class FileSet extends Type
{
	/**
	 * Список файлов, подходящих под условия
	 *
	 * @var array
	 */
	protected $files = array();

	public function __construct($includeDirs, $excludeDirs = array(),
								$fileNames = array(), $notFileNames = array(),
								$followSymlinks = false, $ignoreDotFiles = false)
	{

		$fs = new Finder();
		$fs->ignoreDotFiles($ignoreDotFiles);
		//$fs->ignoreVCS(false);

		if ($followSymlinks)
			$fs->followLinks();

		//$fs->files();

		foreach ($includeDirs as $incl)
			$fs->in($incl);

		foreach ($excludeDirs as $excl)
			$fs->exclude($excl);

		foreach ($fileNames as $file)
			$fs->name($file);

		foreach ($notFileNames as $file)
			$fs->notName($file);


		foreach ($fs as $item)
			$this->files[] = $item->getPathname();



//
//			->notName(".gitignore")
//			->notName(".test")
//			->notName("*.md")
//
//			->exclude(array("vendor", ".idea"));

//		$ri = new \RecursiveDirectoryIterator($this->dir, \RecursiveDirectoryIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS);
//		//new \GlobIterator()
//
//		foreach (new \RecursiveIteratorIterator($ri) as $item)
//		{
//			$this->files[] = $item->getPathname();
//			if ($this->matchPath("Task*.php", $item->getFilename(), false))
//			{
//				print_r($item->getPathname());
//			}
//		}
			//$this->files[] = $item->getPathname();
			//print_r( $filename->getPathname() . "\n") ;
	}

	public function getFiles()
	{
		return $this->files;
	}

	public function matchPath($pattern, $str, $isCaseSensitive = true) {

		$rePattern = preg_quote($pattern, '/');
		$dirSep = preg_quote(DIRECTORY_SEPARATOR, '/');
		$trailingDirSep = '(('.$dirSep.')?|('.$dirSep.').+)';
		$patternReplacements = array(
			$dirSep.'\*\*'.$dirSep => $dirSep.'.*'.$trailingDirSep,
			$dirSep.'\*\*' => $trailingDirSep,
			'\*\*'.$dirSep => '.*'.$trailingDirSep,
			'\*\*' => '.*',
			'\*' => '[^'.$dirSep.']*',
			'\?' => '[^'.$dirSep.']'
		);
		$rePattern = str_replace(array_keys($patternReplacements), array_values($patternReplacements), $rePattern);
		print_r($rePattern);
		$rePattern = '/^'.$rePattern.'$/'.($isCaseSensitive ? '' : 'i');
		print_r($rePattern . "\n");
		return (bool) preg_match($rePattern, $str);
	}

	public function match($pattern, $str, $isCaseSensitive = true) {

		$rePattern = preg_quote($pattern, '/');
		$rePattern = str_replace(array("\*", "\?"), array('.*', '.'), $rePattern);
		$rePattern = '/^'.$rePattern.'$/'.($isCaseSensitive ? '' : 'i');
		return (bool) preg_match($rePattern, $str);
	}
}