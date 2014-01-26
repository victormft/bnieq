<?php
// Bucket Name
//$bucket="nbtest";
//if (!class_exists('S3'))require_once('S3.php');
			
//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIJLJEQJEWBL33QBA');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');
			
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

//$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);

?>