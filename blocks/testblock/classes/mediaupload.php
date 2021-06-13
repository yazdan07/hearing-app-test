<?php

// this file contains upload function 
// checks if the file exists in server
include("../db/database.php");
require_once(dirname(__FILE__) . '/../../../config.php');
global $IP;

$ajaxdata = $_POST['mediaUpload'];

$FILENAME = $ajaxdata[1];
$IMAGE=$ajaxdata[0];
// an array to check which category the media belongs too
$animal= array("bird","cat","dog","horse","sheep","cow","elephant","bear","giraffe","zebra");
$allowedExts = array("mp3","wav");
$temp = explode(".", $_FILES["audio"]["name"]);
$extension = end($temp);



$test = $_FILES["audio"]["type"]; 


if (
	$_FILES["audio"]["type"] == "audio/wav"||
    $_FILES["audio"]["type"] == "audio/mp3"||
    $_FILES["audio"]["type"] == "audio/mpeg"
	&&
	in_array($extension, $allowedExts)
	)
  	{

		// if the name detected by object detection is present in the animal array
		// then initialize target path to animal database or to others
		if (in_array($FILENAME, $animal)) 
		{ 
			$image_target_dir = "image_dir/";
			$audio_target_dir = "audio_dir/";
			//$audio_target_dir  = __DIR__ . 'audio_dir/';
		} 
		else
		{ 
			$image_target_dir = "other_image_dir/";
			$audio_target_dir = "other_audio_dir/";
		} 
        // Get file path
        
		$img = $IMAGE;
		// decode base64 image
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
        $image_data = base64_decode($img);

		//$extension  = pathinfo( $_FILES["fileUpload"]["name"], PATHINFO_EXTENSION ); // jpg
		$image_extension = "png";
        $image_target_file =$image_target_dir . basename($FILENAME . "." . $image_extension);
		$image_file_upload = "http://localhost:8888/moodle310/blocks/testblock/classes/".$image_target_file;
		
		
		$audio_extension ="mp3";
		$audio_target_file= $audio_target_dir . basename($FILENAME. "." . $audio_extension) ;
		$audio_file_upload = "http://localhost:8888/moodle310/blocks/testblock/classes/".$audio_target_file;

		// file size limit
		if(($_FILES["audio"]["size"])<=51242880)
		{

			$fileName = $_FILES["audio"]["name"]; // The file name
			$fileTmpLoc = $_FILES["audio"]["tmp_name"]; // File in the PHP tmp folder
			$fileType = $_FILES["audio"]["type"]; // The type of file it is
			$fileSize = $_FILES["audio"]["size"]; // File size in bytes
			$fileErrorMsg = $_FILES["audio"]["error"]; // 0 for false... and 1 for true
			
			if (in_array($FILENAME, $animal)) 
			{ 
				$sql = "INSERT INTO mdl_media_animal (animal_image_path,animal_name,animal_audio_path) VALUES ('$image_file_upload','$FILENAME','$audio_file_upload')";
			} else {
				$sql = "INSERT INTO mdl_media_others (others_image_path,others_name,others_audio_path) VALUES ('$image_file_upload','$FILENAME','$audio_file_upload')";
			}

			// if file exists
			if (file_exists($audio_target_file) || file_exists($image_target_file)) {
				echo "alert";
			} else {
				// write image file
				if (file_put_contents($image_target_file, $image_data) ) {
					// ffmpeg to write audio file
					//$output = shell_exec("ffmpeg -i $fileTmpLoc -ab 160k -ac 2 -ar 44100 -vn $audio_target_file");
					//echo $output;
					$test123 = shell_exec("ffmpeg");
					echo $test123;
					echo "sucess";
				
					// $stmt = $conn->prepare($sql);
					$db = mysqli_connect("localhost", "root", "root", "moodle310"); 
					// echo $sql;
					if (!$db) {
						echo "nodb";
						die("Connection failed: " . mysqli_connect_error());
					}
					// echo"sucess";
					if(mysqli_query($db, $sql)){
					// if($stmt->execute()){
						echo $fileTmpLoc;
						echo "sucess";  
						echo $output;
					}
					else {
						// echo "Error: " . $sql . "<br>" . mysqli_error($conn);
						echo "failed";
					}

				}else {
					echo "failed";
				}

				
			
			
			}
    
	 // $test = "ffmpeg -i $outputfile -ab 160k -ac 2 -ar 44100 -vn bub.wav";
		} else
		{
		  echo "File size exceeds 5 MB! Please try again!";
		}
}
else
{
	echo "PHP! Not a video! ";//.$extension." ".$_FILES["uploadimage"]["type"];
	}

// $q = $_REQUEST["q"];
// $file = escapeshellcmd($q);


// $output = shell_exec("ffmpeg -i $file -ab 160k -ac 2 -ar 44100 -vn bub.wav");

	error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    




?>