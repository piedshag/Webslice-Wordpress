<?php

// Make sure a filename is present
if ($_GET['filename'] == "")
{
	header("HTTP/1.1 404 Not Found");
	die("Filename missing");
}

// Make sure a filename is present
if ($_GET['permissions'] == "")
{
	header("HTTP/1.1 404 Not Found");
	die("Permissions missing");
}

// Put the filename in a variable
$filename = $_GET['filename'];
$permissions = $_GET['permissions'];

// If the file doesnt exist, return 404
if (!file_exists($filename))
{
	header("HTTP/1.1 404 Not Found");
	die("File not found");
}

// Get the realpath of the file
$real_file = realpath($filename);

// Make sure the file is inside /var/www
if (!(substr($real_file, 0, strlen("/var/www/")) == "/var/www/")) {
	header("HTTP/1.1 500 Permission denied");
	die("Permission denied");
}

if (!chmod($real_file, $permissions)) {
	header("HTTP/1.1 500 Error changing ownership");
	die("Error changing ownership");
}

// Return a checksum of the contents of the file + the file permissions
echo json_encode([
	'md5'         => md5_file($filename),
	'permissions' => fileperms($filename),
]);
