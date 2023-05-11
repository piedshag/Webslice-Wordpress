<?php

function getFilesFromQueryString()
{
	$files = $_GET['files'];

	// Make sure at least one filename is present
	if (is_array($files))
	{
		if (count($files) < 1)
		{
			header("HTTP/1.1 500 Filename missing");
			die("Filename missing");
		}
	}
	else
	{
		if ($files == "")
		{
			header("HTTP/1.1 500 Filename missing");
			die("Filename missing");
		}

		$files = [ $files ];
	}

	// Trim empty entries
	foreach ($files as $k => $filename)
	{
		if ($filename == "")
		{
			unset($files[$k]);
		}
	}

	return $files;
}

function getQueryParameter($name)
{
    // Make sure the source filename is present
    if ($_GET[$name] == "")
    {
        header("HTTP/1.1 500 " . $name . " parameter missing or empty");
        die($name . " parameter missing or empty");
    }

    return $_GET[$name];
}

function createFile($filename)
{
	// Create the directory
	@mkdir(dirname($filename), 755, true);

	// Put some random data in the file
	file_put_contents($filename, openssl_random_pseudo_bytes(8192));

	return array(
		"size" => filesize($filename),
		"md5" => md5_file($filename)
	);
}

function deleteFile($filename)
{
	// Put some random data in the file
	$result = unlink($filename);

	return array(
		"removed" => $result,
	);
}

function updateFile($filename)
{
	// Put some random data in the file
	file_put_contents($filename, openssl_random_pseudo_bytes(8192));

	return array(
		"size" => filesize($filename),
		"md5" => md5_file($filename)
	);
}

// converts a unit of size to bytes.
function convert_to_bytes($size, $unit, $precision = 0)
{
	$binary_scale = ['TiB' => 4, 'tB' => 4, 'GiB' => 3, 'gB' => 3, 'MiB' => 2, 'mB' => 2, 'KiB' => 1, 'kB' => 1];
	$decimal_scale = ['TB' => 4, 'GB' => 3, 'MB' => 2, 'KB' => 1, 'B' => 0];

	if (array_key_exists($unit, $binary_scale)) {
		$base = 1024;
		$scale = $binary_scale;
	} else if (array_key_exists($unit, $decimal_scale)) {
		$base = 1000;
		$scale = $decimal_scale;
	} else {
		return false;
	}

	return $size * bcpow($base, $scale[$unit], $precision);
}

// returns an array of system memory info.
function get_mem_info()
{
	$mem_info = [];

	$fh = fopen('/proc/meminfo', 'r');
	if (!$fh) {
		return false;
	}

	while (($buf = fgets($fh, 4096)) !== false) {
		$matches = [];
		if (preg_match('/^([a-zA-Z]+):\W+([0-9]+) ([a-zA-Z]+)$/', $buf, $matches)) {
			list(, $metric, $size, $unit) = $matches;

			if (($bytes = convert_to_bytes($size, $unit, 0)) !== false) {
				$mem_info[$metric] = $bytes;
			}
		}
	}

	fclose($fh);

	return $mem_info;
}

// uploadServerlessLog for further inspection, can be called when something errors unexpectedly.
//  The log is uploaded using sawfs into the volume and will be deleted if the volume is cleaned up.
function uploadServerlessLog()
{
	@copy("/tmp/serverless.log", "/var/www/serverless.log");
}
