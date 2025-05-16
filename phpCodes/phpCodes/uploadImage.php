<?php


$servername = "localhost";
$username = "NaimaZafar";
$password = "naima2922";
$dbname = "project";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);



if(isset($_POST['image']))

	{
		
                 $target_dir = "Images/";
                 $image = $_POST['image'];
                 $imageStore = rand()."_".time().".jpeg";
            	$target_dir = $target_dir."/".$imageStore;

        	file_put_contents($target_dir, base64_decode($image));
			
	 // Write the value of $imageStore to a separate file
    $logFileName = 'image_store_log.txt';
    $logFileContent = "Value of \$imageStore: $imageStore\n";
    file_put_contents($logFileName, $logFileContent, FILE_APPEND);	

	$select= "INSERT into imagedata(image) VALUES ('$imageStore')";
	
        $responce = mysqli_query($conn,$select);
        if($responce)
        {			
			    echo "Image Uploaded";
        }
        else
        {
	        echo "Failed";
       }
       }

mysqli_close($conn);
?>