<?php

$uploads_dir = '/var/www/public/uploads';

@mkdir($uploads_dir, 0755);

$response = [];

foreach ($_FILES as $fileName => $file)
{
	if ($file['error'] == UPLOAD_ERR_OK)
	{
		$file_upload_location = $uploads_dir . "/" . $file['name'];

		if (!move_uploaded_file($file['tmp_name'], $file_upload_location))
		{
			header("HTTP/1.1 500 Permission denied");
			die("Permission denied");
		}

		$response[$file['name']] = [
			"md5" => md5_file($file_upload_location),
			"size" => filesize($file_upload_location),
		];
	}
	else
	{
		header("HTTP/1.1 500 Upload error");
		die("Upload error");
	}
}

echo json_encode($response);
