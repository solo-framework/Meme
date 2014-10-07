<?php

echo "!!!!";

use Meme\Target;

$project = new \Meme\Project("test project", "start");

/**
 *
 * Начало
 *
 */
$startTarget = new Target("start", function(){
	echo "Hello from start!\n";

}, "middle");

/**
 * Таск бла бла бла
 */
$mT = new Target("middle", function(){

	$etask = new \Meme\Task\EchoTask("messsage!!!");
	$etask->run();

	$task = new \Custom\TestTask();
	$task->run();

}, "end");

$end = new Target("end", function(){
	echo "Hello from end!\n";
});


$project->addTarget($startTarget);
$project->addTarget($mT);
$project->addTarget($end);
$project->run("start");

//$task = new \CustomTask\TestTask();