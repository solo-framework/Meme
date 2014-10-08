<?php

use Meme\Task\Zip;
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

	$fs = new Types\FileSet(
		"../../testcurl"
		//, array("**/*curl*.exe", "*.cs")

	);


	$res = $fs->getFiles();

	new Zip("../../testcurl" , "testcurl1.zip", $res);
	//print_r($res);

	//$etask = new \Meme\Task\EchoTask("messsage!!!");
	//$etask->run();


//	$fs = new Types\FileSet(
//		"..",
//		array(),// include
//		array("vendor", ".idea", "Command"),// exclude
//		array("*.php"),
//		array("*Task.php", "*.phar")
//	);
//
//	$res = $fs->getFiles();
//	print_r($res);
//	new ZipTask("../yes.zip", $res);

//	$curlDir = "../../testcurl";
//
//	$fs = new Types\FileSet($curlDir, array("build/*.exe"), array(), array(), array());
//	$res = $fs->getFiles();
//	print_r($res);
//
//	new ZipTask("../../testcurl.zip", $res);
//	new \Meme\Task\Delete($curlDir);


	//print_r($res);



	$fs = new \Symfony\Component\Finder\Finder();
	$fs->ignoreDotFiles(false);
	$fs
//		->directories()
		->in("../../testcurl")
//		->path("Exception")
//		->path("Tests")
//		->notPath("Process/Exception")
//		->notPath("vendor/symfony")
//		->name("*ions.yml")
		//->notPath("/")
	;

//		->notName(".gitignore")
//		->notName(".test")
//		->notName("*.md")
//
//		->exclude(array("vendor", ".idea"));

//	foreach ($fs as $item)
//		print_r($item->getPathname() . "\n");


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