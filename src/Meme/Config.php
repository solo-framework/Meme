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

	protected static $yaml = null;

	public static function init($configFile, $envName)
	{
		$yaml = Yaml::parse($configFile);
		self::$yaml = $yaml;
		if (array_key_exists($envName, $yaml))
			self::$cnf = $yaml[$envName];
		else
			throw new \RuntimeException("Environment '{$envName}' not found in configuration");

	}

	public static function get($key)
	{
		return self::$cnf[$key];
	}

	public static function read($configFile)
	{
		self::$yaml = Yaml::parse($configFile);
		return self::$yaml;
	}

}