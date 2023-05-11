<?php

include_once('helper.php');

$files = getFilesFromQueryString();

$response = [];

foreach ($files as $filename)
{
	if (!file_exists($filename))
	{
		header("HTTP/1.1 500 File '" . $filename . "' missing");
		die("File '" . $filename . "' missing");
	}

	$response[$filename] = deleteFile($filename);
}

// Set the content-type header
header("Content-type: application/json");

// Output some json
echo json_encode($response);

