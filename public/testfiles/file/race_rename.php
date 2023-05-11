<?php
/**
 * race_rename.php
 *
 * Attempt to trigger the race condition in rename() by performing
 * the same set of IO operations as grav's templating engine.
 */

include_once('helper.php');

define('SOURCE_DIR', '/var/www/public/source');
define('TARGET_DIR', '/var/www/public/target');

// getRandomString will return a random string of length n
function getRandomString($n) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$str = '';

	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$str .= $characters[$index];
	}

	return $str;
}

// Create the source and target directories
if (!file_exists(SOURCE_DIR)) {
	mkdir(SOURCE_DIR, 0755, true);
}

if (!file_exists(TARGET_DIR)) {
	mkdir(TARGET_DIR, 0755, true);
}

// Iterate 50 times, this can be overridden by passing the URL parameter ?n=
$n = 50;
if (isset($_GET['n'])) {
	$n = $_GET['n'];
}

$response = [];
for ($i=0; $i<$n; $i++) {
	// This function uses mkstemp() go generate a temporary file, it uses the
	// fifo queue to upload an empty file, the php version seems to do this
	// twice as the close() syscall also triggers the rename.
	//
	// There's a todo to fix this behaviour so that the create doesn't upload.
	$path = tempnam(SOURCE_DIR, "temp_");
	if (!$path) {
		header("HTTP/1.1 500 Couldn't create temp file in " . SOURCE_DIR);
		die("Couldn't create temp file in " . SOURCE_DIR);
	}

	// chmod the file, this uses the fifo queue to update the files metadata
	$success = chmod($path, 0644);
	if (!$success) {
		header("HTTP/1.1 500 Couldn't chmod(644) temp file " . $path);
		die("Couldn't chmod(644) temp file " . $path);
	}

	// put some data in the file, this uses the fifo queue to
	// upload the file to s3 and update the file info table
	$bytes_n = rand(100, 75000);
	$data = getRandomString($bytes_n);
	$success = file_put_contents($path, $data);
	if (!$success) {
		header("HTTP/1.1 500 Couldn't write " + $bytes_n + " to temp file " . $path);
		die("Couldn't write " + $bytes_n + " to temp file " . $path);
	}

	// chmod the file, this uses the fifo queue to update the files metadata
	$success = chmod($path, 0444);
	if (!$success) {
		header("HTTP/1.1 500 Couldn't chmod(444) temp file " . $path);
		die("Couldn't chmod(444) temp file " . $path);
	}

	// move the file into another location, this uses the fifo queue to upload a file
	$target_path = TARGET_DIR . DIRECTORY_SEPARATOR . basename($path);
	$success = rename($path, $target_path);
	if (!$success) {
		header("HTTP/1.1 500 Couldn't rename " . $path . " to " . $target_path);
		die("Couldn't rename " . $path . " to " . $target_path);
	}

	// This data is used to compare what makes it to the proxy, before and after a snapshot
	$response[$target_path] = [
		'size' => $bytes_n,
		'md5'  => md5($data),
	];
}

uploadServerlessLog();

// Set the content-type header
header("Content-type: application/json");

// Output some json
echo json_encode($response);
