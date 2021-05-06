<?php



	if (!empty($_FILES['file'])) {



	    $target = "upload/". $_FILES["file"]["name"];

	    move_uploaded_file($_FILES['file']['tmp_name'], $target);

	    echo json_encode(['uploaded' => $target]); 



	} else {



		echo json_encode(['error'=>'No files found for upload.']); 



	}



?>