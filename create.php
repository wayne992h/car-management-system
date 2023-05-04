<?php
// Include carDAO file
require_once('./dao/carDAO.php');

 
// Define variables and initialize with empty values
$brand = $model = $year = "";
$brand_err = $model_err = $year_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate brand
    $input_brand = trim($_POST["brand"]);
    if(empty($input_brand)){
        $brand_err = "Please enter a brand.";
    } elseif(!filter_var($input_brand, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $brand_err = "Please enter a valid brand.";
    } else{
        $brand = $input_brand;
    }
    
    // Validate model
    $input_model = trim($_POST["model"]);
    if(empty($input_model)){
        $model_err = "Please enter an model.";     
    } else{
        $model = $input_model;
    }
    
    
    // Validate year
    $input_year = trim($_POST["year"]);
    if(empty($input_year)){
        $year_err = "Please enter the year.";     
    } elseif(!ctype_digit($input_year)){
        $year_err = "Please enter a positive integer value.";
    } else{
        $year = $input_year;
    }
    
    $picture = "";
    $uploadOk = 1;
    if ($_FILES["picture"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "image/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file was uploaded successfully and move it to the target directory
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            $picture = $target_file;
        } else {
            echo "Error uploading the image.";
            $uploadOk = 0;
        }
    }

    // Check input errors before inserting in database
    if(empty($brand_err) && empty($model_err) && empty($year_err) && $uploadOk){
        $carDAO = new carDAO();    
        $car = new Car(0, $brand, $model, $year, $_POST["date_of_purchase"], $picture);
        $addResult = $carDAO->addCar($car);        
        header( "refresh:2; url=index.php" ); 
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';   
        // Close connection
        $carDAO->getMysqli()->close();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="validate.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add car record to the database.</p>
					
					<!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="create.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" name="brand" id="brand" class="form-control <?php echo (!empty($brand_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $brand; ?>">
                        <span class="invalid-feedback"><?php echo $brand_err;?></span>
                         <span id="brand-error" class="error-text"></span>
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <textarea name="model" id="model" class="form-control <?php echo (!empty($model_err)) ? 'is-invalid' : ''; ?>"><?php echo $model; ?></textarea>
                        <span class="invalid-feedback"><?php echo $model_err;?></span>
                        <span id="model-error" class="error-text"></span>
                    </div>
                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="year" id="year" class="form-control <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year; ?>">
                        <span class="invalid-feedback"><?php echo $year_err;?></span>
                        <span id="year-error" class="error-text"></span>
                    </div>
                    <div class="form-group">
                        <label for="date_of_purchase">Date of Purchase</label>
                        <input type="date" name="date_of_purchase" class="form-control" id="date_of_purchase" required>
                    </div>
                    <div class="form-group">
                        <label for="picture">Picture</label>
                        <input type="file" name="picture" class="form-control" id="picture" accept="image/*">
                    </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
        <?include 'footer.php';?>
    </div>
</body>
</html>