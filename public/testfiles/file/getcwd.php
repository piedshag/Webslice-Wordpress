<?php

// Make sure a directory name is present
if ($_GET['directory'] == "")
{
	header("HTTP/1.1 404 Not Found");
	die("Directory missing");
}

// Put the directory name in a variable
$directory = $_GET['directory'];

// If the directory doesn't exist or the the directory is not a directory, return 404
if (!file_exists($directory) && !is_dir($directory))
{
	header("HTTP/1.1 500 Directory doesn't exist");
	die("Directory doesn't exist");
}

if (!chdir($directory))
{
	header("HTTP/1.1 500 Unable to change directory");
	die("Unable to change directory");
}

$result = getcwd();

if ($result === false)
{
	header("HTTP/1.1 500 Unable to remove directory");
	die("Unable to remove directory");
}

if ($result != $directory)
{
	header("HTTP/1.1 500 Directory mismatch");
	die("Directory mismatch");
}

echo "{}";
