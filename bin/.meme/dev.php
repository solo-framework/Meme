<?php

use Meme\Task\ZipTask;
use Meme\Types;
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


	$fs = new Types\FileSet(
		array(".meme", ".."),// include
		array("vendor", ".idea"),// exclude
		array("*"),
		array("*.phar")
	);
	$res = $fs->getFiles();
	//print_r($res);

	new ZipTask("../yes.zip", $res);

//	$fs = new \Symfony\Component\Finder\Finder();
//	$fs->ignoreDotFiles(false);
//	$fs->files()
//		->in(".meme")
//		->in("..")
//
//		->notName(".gitignore")
//		->notName(".test")
//		->notName("*.md")
//
//		->exclude(array("vendor", ".idea"));
//
//
//	var_dump($fs->getIterator());
//
//	foreach ($fs as $item)
//		print_r($item->getRealpath() . "\n");

//	$fs = new Types\FileSet(".", "vendor,var/cache,var/compile",
//		array("vendor", "var/cache", "var/compile")
//	);



	//print_r($fs->getFiles());

	//$task = new \Custom\TestTask();
	//$task->run();


}, "end");

$end = new Target("end", function(){
	echo "Hello from end!\n";
});


$project->addTarget($startTarget);
$project->addTarget($mT);
$project->addTarget($end);
$project->run("start");

//$task = new \CustomTask\TestTask();