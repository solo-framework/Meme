<?php

use Meme\Console;
use Meme\Project;

use Meme\Types;
use Meme\Target;

/**
 * @var $project Project
 */

$project->setStartTask("start");

//
// Write your targets and task below
//


$startTarget = new Target("start", function(){

	Console::info("Hello, world!");

} /*, add dependencies here*/);


/**
 * Таск бла бла бла
 */
$mT = new Target("middle", function(){

	$fs = new Types\FileSet(
		"../test/",
		array("**/*.phar", "**/*.zip", "*.json")
	);

	$res = $fs->getFiles(true);

//	new \Meme\Task\Delete($fs);
	print_r($res);

	//echo "\033[31mred\033[37m\r\n";

}, "end");

$end = new Target("end", function(){
	Console::info("Hello from end!");
});

$project->addTarget($startTarget);
$project->addTarget($mT);
$project->addTarget($end);