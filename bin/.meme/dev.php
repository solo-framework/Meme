<?php

use Meme\Output;
use Meme\Project;

use Meme\Task\Chmod;
use Meme\Task\Copy;
use Meme\Task\Mkdir;
use Meme\Task\ReplaceInFile;
use Meme\Task\ReplaceInString;
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

$project->setStartTarget("middle");

//
// Write your targets and task below
//
$link = "http://";



//$startTarget = new Target("start", function(){
//
//	Output::info("Hello, world!");
//
//}, "middle");

//$ssh = new SshConnection("runtime.pro", 10022);
//$ssh->authPublicKey("afi", "./run.pub", "./run.priv");


//$startTarget = new Target("start", new \Meme\Custom\Target\MyTarget("/var/log"));

$f =  new Target("test", function(){

	echo "ffffffffffffffffffff";

});

/**
 * Таск бла бла бла
 */
$mT = new Target("middle", function(){

//	$cmd = new \Meme\Task\Command("php ./loop.php > /dev/null 2>&1 &");
//	$cmd = new \Meme\Task\Command("php ./loop.php </dev/null & ");
//	$cmd = new \Meme\Task\Command("php -v");

	//new \Meme\Task\Zip(time() . ".zip", new FileSet("../zip/", array()));

	//new \Meme\Custom\TestTask();



	//new \Meme\Task\CopyFile("./run.priv", "./kiki/rrrrr.ddd");

//	$dir = "../copy";
//	new \Meme\Task\Delete($dir);
//	new \Meme\Task\Delete("lala.zip");
//	new \Meme\Task\Mkdir($dir, 0777);
//
//	$fs = new FileSet("./", array(), array(".meme/", "**/.gitignore"));
//
////	print_r($fs->getFiles(true));
////	print_r($fs->getFiles(false));
//
//	new Copy($fs, $dir);
//
//	$zipName = time();
//	new \Meme\Task\Zip("lala.zip", new FileSet($dir));
//	new \Meme\Task\Zip("{$zipName}.zip", new FileSet(".", array("meme")));


//	$fs = new \Symfony\Component\Filesystem\Filesystem();

//	$cmd = new \Meme\Task\Command("./mongo_migrate", "./44");
//	file_put_contents("local.php", file_get_contents("local.php.dist"));

	//$cmd = new \Meme\Task\Command("git status");
	//print_r($cmd->getResult());

	//new \Meme\Task\Move("../test/", "./ddd/");

//	$fs = new FileSet("../../testcurl/", array("**/*.cs"));
//	new ScpSend($ssh, "session/lflf/", "../README.md", 0777);

	//$cmd = "mkdir -p /test_folder";
	//$cmd = "echo 'kotenok' | sudo -S " . $cmd;

	//new SshCommand($ssh, $cmd, true);
	//new SshCommand($ssh, "uname -a", true);
//	new SshCommand($ssh, "cd / && ls -l", true);

}, "end");

$end = new Target("end", function(){
	Output::info("Hello from end!");

//	$ssh = new SshConnection("46.188.16.48", 10022); // runtime.pro
//	$ssh->authPublicKey("afi", "./run.pub", "./run.priv");
//
//	(new SshCommand($ssh, "cd / && ls -l", true))
//		->run();

//	(new \Meme\Task\Command("ls -l"))
//		->setTimeout(1000)
//		->setVerbose(true)
//		->run();
//
//	(new Mkdir("./lala4"))
//		->setMode(0755)
//		->run();

	$str = "Hello, %username%";
	$res = (new ReplaceInString($str,  ["/%username%/i", "/Hello/"], ["world", "lalala"]))->run();
//	print_r($res);

});

//$project->addTarget($startTarget);
$project->addTarget($mT);
$project->addTarget($end);
$project->addTarget($f);