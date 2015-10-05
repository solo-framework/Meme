<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme;

class Params
{
	protected static $options = [];

	public static function set($options)
	{
		self::$options = $options;
	}

	public static function get($key)
	{
		if (isset(self::$options->$key))
		{
			return self::$options->$key;
		}
		else
		{
			throw new \Exception("Not defined param: {$key}");
		}
	}
}

