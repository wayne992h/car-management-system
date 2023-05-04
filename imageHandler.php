<?php
//store image to /image folder
$targetDir = "image/";

//Get the list of current images
if (isset($_GET["fetch"]) && $_GET["fetch"] === "existing") {
    $imageDir = "image/";
    $images = glob($imageDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    $fileNames = array();
  
    foreach ($images as $image) {
      $fileNames[] = basename($image);
    }
  
    header('Content-Type: application/json');
    echo json_encode($fileNames);
    exit();
  }

// Udpload the image
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image'])) {
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($fileType, $allowedExtensions)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                echo $fileName;
            } else {
                echo "";
            }
        } else {
            echo "";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['delete'])) {
        $fileName = $_GET['delete'];
        $targetFilePath = $targetDir . $fileName;
        if (file_exists($targetFilePath)) {
            if (unlink($targetFilePath)) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            echo "fail";
        }
    }
}
?>
