<?php

// Make sure a directory name is present
if ($_GET['directory'] == "")
{
	header("HTTP/1.1 404 Not Found");
	die("Directory missing");
}

// Put the directory name in a variable
$directory = $_GET['directory'];

// If the directory exists, return 404
if (file_exists($directory))
{
	header("HTTP/1.1 500 Directory already exists");
	die("Directory already exists");
}

if (!mkdir($directory))
{
	header("HTTP/1.1 500 Unable to create directory");
	die("Unable to create directory");
}

$is_directory = is_dir($directory);

// Return a checksum of the contents of the file + the file permissions
echo json_encode([
	'directory'   => $is_directory,
	'permissions' => fileperms($directory),
]);
