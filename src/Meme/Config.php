<?php
/**
 *
 *
 * PHP version 5
 *
 * @created 08.10.2014 23:02
 * @package
 * @author  Andrey Filippov <afi@runtime.pro>
 */

namespace Meme;


use Symfony\Component\Yaml\Yaml;

class Config
{
	protected static $cnf = null;

	public static function init($configFile)
	{
		self::$cnf = Yaml::parse($configFile);
	}

	public static function get($key)
	{
		return self::$cnf[$key];
	}

}