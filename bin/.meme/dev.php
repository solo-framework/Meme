<?php

use Meme\Console;
use Meme\Project;

use Meme\Task\Chmod;
use Meme\Task\Copy;
use Meme\Task\Mkdir;
use Meme\Task\Replace;
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

}, "middle"/*, add dependencies here*/);


/**
 * Таск бла бла бла
 */
$mT = new Target("middle", function(){

	$files = array("./lala/tee", "./ddd");
	new Mkdir($files, 0755);

}, "end");

$end = new Target("end", function(){
	Console::info("Hello from end!");
});

$project->addTarget($startTarget);
$project->addTarget($mT);
$project->addTarget($end);