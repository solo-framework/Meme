<?php

use Meme\Console;
use Meme\Project;

use Meme\Task\Chmod;
use Meme\Task\Copy;
use Meme\Task\Mkdir;
use Meme\Task\Replace;
use Meme\Task\SSH\ScpSend;
use Meme\Task\SSH\Ssh;
use Meme\Task\SSH\SshCommand;
use Meme\Task\SSH\SshConnection;
use Meme\Types;
use Meme\Target;
use Meme\Types\FileSet;

/**
 * @var $project Project
 */

$project->setStartTask("start");

//
// Write your targets and task below
//


$startTarget = new Target("start", function(){

	Console::info("Hello, world!");

}, "middle");

$ssh = new SshConnection("ubuntu", "dev", "root");

/**
 * Таск бла бла бла
 */
$mT = new Target("middle", function() use ($ssh){

	new \Meme\Task\Move("../test/", "./ddd/");

//	$fs = new FileSet("../../testcurl/", array("**/*.cs"));
//	new ScpSend($ssh, "session/lflf/", "../README.md", 0777);

//	new SshCommand($ssh, "ls -l", true);
//	new SshCommand($ssh, "uname -a", true);
//	new SshCommand($ssh, "cd / && ls -l", true);

}, "end");

$end = new Target("end", function(){
	Console::info("Hello from end!");
});

$project->addTarget($startTarget);
$project->addTarget($mT);
$project->addTarget($end);