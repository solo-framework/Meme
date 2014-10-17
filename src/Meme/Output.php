<?php
/**
 * Вывод в консоль
 *
 * PHP version 5
 *
 * @package Meme
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Meme;

use Symfony\Component\Console\Output\OutputInterface;

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

	/**
	 * @var OutputInterface
	 */
	protected static $output = null;

	/**
	 * Parses a Text to represent Colors in the Terminal/Output.
	 *
	 * @param string $string
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
		self::$output->writeln("\t<error>{$message}</error>");
	}

	public static function info($message)
	{
		self::$output->writeln("\t<info>{$message}</info>");
	}

	public static function mainHeader($message)
	{
		self::$output->writeln("<mainHeader>{$message}</mainHeader>");
	}

	public static function taskHeader($message)
	{
		self::$output->writeln("   <taskHeader>>> {$message}</taskHeader>");
	}

	public static function targetHeader($message)
	{
		self::$output->writeln("<targetHeader>{$message}</targetHeader>");
	}

	public static function comment($message)
	{
		self::$output->writeln("\t<comment>{$message}</comment>");
	}

	public static function setOutputInterface(OutputInterface $output)
	{
		self::$output = $output;
	}

}

