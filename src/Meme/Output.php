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

class Output
{
	/**
	 * List of Colors and they Output representation.
	 * @var array
	 */
	private static $foregroundColors = array(
			'black' => '0;30',
			'dark_gray' => '1;30',
			'blue' => '0;34',
			'light_blue' => '1;34',
			'green' => '0;32',
			'light_green' => '1;32',
			'cyan' => '0;36',
			'light_cyan' => '1;36',
			'red' => '0;31',
			'light_red' => '1;31',
			'purple' => '0;35',
			'light_purple' => '1;35',
			'brown' => '0;33',
			'yellow' => '1;33',
			'light_gray' => '0;37',
			'white' => '1;37'

	);

	protected static $output = null;

	/**
	 * Parses a Text to represent Colors in the Terminal/Output.
	 *
	 * @param string $string
	 * @param Config $config
	 *
	 * @return string
	 */
	public static function color($string)
	{
		foreach (self::$foregroundColors as $key => $code)
		{
			$replaceFrom = array(
					'<' . $key . '>',
					'</' . $key . '>'
			);

			$replaceTo = array(
					"\033[" . $code . 'm',
					"\033[0m"
			);

			$string = str_replace($replaceFrom, $replaceTo, $string);
		}

		return $string;
	}

	public static function error($message)
	{
		self::$output->writeln("<error>{$message}</error>");
	}

	public static function info($message)
	{
		self::$output->writeln("<info>{$message}</info>");
	}

	public static function warning($message)
	{
		self::$output->writeln("<warning>{$message}</warning>");
	}

	public static function comment($message)
	{
		self::$output->writeln("<comment>{$message}</comment>");
	}

	public static function setOutputInterface($output)
	{
		self::$output = $output;
	}

}

