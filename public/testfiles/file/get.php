<?php

// Make sure a filename is present
if ($_GET['filename'] == "")
{
	header("HTTP/1.1 404 Not Found");
	die("Filename missing");
}

// Put the filename in a variable
$filename = $_GET['filename'];

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

if (isset($_GET['contents']))
{
	echo file_get_contents($filename);
	return;
}

$is_directory = is_dir($filename);

// Return a checksum of the contents of the file + the file permissions
echo json_encode([
	'directory'   => $is_directory,
	'md5'         => (!$is_directory) ? md5_file($filename) : "",
	'permissions' => fileperms($filename),
]);
