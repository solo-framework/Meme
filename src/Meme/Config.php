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

	public static function init($envName, $configFile, $additionalConfigFile)
	{
		$yaml = Yaml::parse(file_get_contents($configFile));

		if ($additionalConfigFile)
		{
			$add = Yaml::parse($additionalConfigFile);

			self::recursiveMerge($yaml, $add);
		}

		self::$yaml = $yaml;
		if (array_key_exists($envName, $yaml))
			self::$cnf = $yaml[$envName];
		else
			throw new \RuntimeException("Environment '{$envName}' not found in configuration");

	}

	private static function recursiveMerge(&$a, $b)
	{ //$a will be result. $a will be edited. It's to avoid a lot of copying in recursion
		if (is_array($b) || is_object($b))
		{
			foreach ($b as $child => $value)
			{
				if (is_array($a))
				{
					if (isset($a[$child]))
						self::recursiveMerge($a[$child], $value);
					else
						$a[$child] = $value;
				}
				elseif (is_object($a))
				{
					if (isset($a->{$child}))
						self::recursiveMerge($a->{$child}, $value);
					else
						$a->{$child} = $value;
				}
			}
		} else
			$a = $b;
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