<?php

/**
 * Iterate over all the files in a directory and generate md5sums for each file
 * @param $path
 *
 * @return array
 */
function getDirContents($path)
{
	$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

	$files = array();
	foreach ($rii as $file)
	{
		if ($file->isDir())
		{
			continue;
		}

		$fullPath = $file->getPathname();
		$filename = str_replace($path, "", $fullPath);

		if ($filename == "..") {
			continue;
		}


		$files[$filename] = md5_file($fullPath);
	}

	ksort($files);
	
	return $files;
}

// Set the content-type header
header("Content-type: application/json");

// Return the encoded list of md5sums
echo json_encode([
	'files' => getDirContents("/var/www/")
]);
