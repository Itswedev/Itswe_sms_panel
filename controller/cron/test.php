<?php
// session_start();

ini_set('zlib.output_compression', 'Off');

error_reporting(E_ALL);
ini_set("log_errors", TRUE);
// ini_set('error_log', $log_file);

include('/var/www/html/itswe_panel/include/connection.php');
require('/var/www/html/itswe_panel/controller/classes/ssp.class.php');
include('/var/www/html/itswe_panel/include/config.php');

require '/var/www/html/itswe_panel/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dir = '/var/www/html/itswe_panel/controller/upload/';
$test_file = $dir . 'test.txt';

if (is_writable($dir)) {
    echo "The directory is writable.<br>";
    if (file_put_contents($test_file, 'This is a test.') !== false) {
        echo "Test file created successfully.<br>";
        //unlink($test_file); // Clean up the test file
    } else {
        echo "Failed to create test file.<br>";
    }
} else {
    echo "The directory is not writable.<br>";
}

$full_path = "/var/www/html/itswe_panel/controller/upload/Download_2024-05-19_2024-05-19.zip";
$zip = new ZipArchive();

$result_zip = $zip->open($full_path, ZipArchive::CREATE | ZipArchive::OVERWRITE);

if ($result_zip === TRUE) {
    echo 'Zip file created successfully';
    // Add files to the zip here if needed
    $zip->addFile($test_file);
    $zip->close();
} else {
    switch($result_zip) {
        case ZipArchive::ER_EXISTS:
            echo 'File already exists.';
            break;
        case ZipArchive::ER_INCONS:
            echo 'Zip archive inconsistent.';
            break;
        case ZipArchive::ER_MEMORY:
            echo 'Malloc failure.';
            break;
        case ZipArchive::ER_NOENT:
            echo 'No such file.';
            break;
        case ZipArchive::ER_NOZIP:
            echo 'Not a zip archive.';
            break;
        case ZipArchive::ER_OPEN:
            echo 'Can\'t open file.';
            break;
        case ZipArchive::ER_READ:
            echo 'Read error.';
            break;
        case ZipArchive::ER_SEEK:
            echo 'Seek error.';
            break;
        default:
            echo 'An unknown error occurred: ' . $result_zip;
            break;
    }
}

?>
