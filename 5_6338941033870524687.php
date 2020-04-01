<?php

/*

Install php - sudo yum install php
curl -sS https://getcomposer.org/installer | php
cd /var/www/html
sudo mkdir face
cd face
sudo php -d memory_limit=-1 ~/composer.phar require aws/aws-sdk-php

In case if you get memory error - 
	sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
	sudo /sbin/mkswap /var/swap.1
	sudo /sbin/swapon /var/swap.1

sudo wget https://i.pinimg.com/originals/b9/7e/a3/b97ea33b5842c7894b804923c6c05580.jpg
sudo mv b97ea33b5842c7894b804923c6c05580.jpg sample.jpg

*/
error_reporting(0);

require_once(__DIR__ . '/vendor/autoload.php');

use Aws\S3\S3Client;
use Aws\Rekognition\RekognitionClient;


$bucket = 'aws-face-app';
$keyname = 'sample.jpg';

$s3 = S3Client::factory([
	#'profile' 	=> 'default',
	'region' 	=> 'us-east-2',
	'version' 	=> '2006-03-01',
	'signature'	=> 'v4'
]);

try {
    // Upload data.
	$result = $s3->putObject([
		'Bucket' 		=> $bucket,
		'Key'    		=> $keyname,
		'SourceFile'   	=> __DIR__. "/$keyname",
		'ACL'    		=> 'public-read'
	]);

    // Print the URL to the object.
	$imageUrl = $result['ObjectURL'];
	if($imageUrl) {
		echo "Image upload done... Here is the URL: " . $imageUrl;
	}
} catch (Exception $e) {
	echo $e->getMessage() . PHP_EOL;
}