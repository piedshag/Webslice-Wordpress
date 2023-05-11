<?php

include_once('helper.php');

$files = getFilesFromQueryString();

$response = [];

foreach ($files as $filename)
{
	if (file_exists($filename))
	{
		header("HTTP/1.1 500 File '" . $filename . "' already exists");
		die("File '" . $filename . "' already exists");
	}


	$response[$filename] = createFile($filename);
}

// Set the content-type header
header("Content-type: application/json");

// Output some json
echo json_encode($response);
