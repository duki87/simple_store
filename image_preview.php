<?php

//Get image
  if(isset($_FILES["image_file"]["name"]) && $_FILES["image_file"]["name"] != '') {
    $name = $_FILES["image_file"]["name"];
    $explode = explode(".", $name);
    $extension = end($explode);
    $newName = rand(10,10000) . "." . $extension;
    $location = "images/" . $newName;
    move_uploaded_file($_FILES['image_file']['tmp_name'], $location);
    echo '
    <div class="image-content">
    <img src="'.$location.'" class="form-control img-responsive" id="product_image" alt="" width="100%" height="auto">
    <button type="button" name="location" data-location="'.$location.'" class="btn btn-danger " id="remove_button" name="button">x</button>
    </div>';
  }

//Delete image
if(!empty($_POST['location'])) {
  if(unlink($_POST['location'])) {
    echo 'Image deleted!';
  }
}
?>
