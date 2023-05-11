<?php

// Make sure the source filename is present
if ($_GET['source'] == "")
{
	header("HTTP/1.1 500 Source file missing");
	die("Source filename missing");
}

// Make sure the destination filename is present
if ($_GET['destination'] == "")
{
	header("HTTP/1.1 500 Destination file missing");
	die("Destination filename missing");
}

// Put the source and destination filenames in variables
$sourceFilename = $_GET['source'];
$destinationFilename = $_GET['destination'];

// If the source file doesnt exist, return 404
if (!file_exists($sourceFilename))
{
	// The log is useful if there is a race
	include_once('helper.php');
	uploadServerlessLog();

	header("HTTP/1.1 404 Not Found");
	die("File not found");
}

// If the destination file doesnt exist, return 500
if (file_exists($destinationFilename))
{
	header("HTTP/1.1 500 Destination file already exists");
	die("Destination file already exists");
}

// Get the realpath of the file
$sourceRealFile = realpath($sourceFilename);

// Make sure the file is inside /var/www
if (!(substr($sourceRealFile, 0, strlen("/var/www/")) == "/var/www/"))
{
	header("HTTP/1.1 500 Permission denied");
	die("Permission denied");
}

// Make sure the destination is sane

// Return the contents of the file
if (!copy($sourceRealFile, $destinationFilename))
{
	header("HTTP/1.1 500 Copy error");
	die("Copy error");

}

