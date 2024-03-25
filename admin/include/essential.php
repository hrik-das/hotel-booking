<?php
    // Frontend Purpose Data
    define("SITE_URL", "http://127.0.0.1/PHP/Hotel Booking/");
    define("ABOUT_IMG_PATH", SITE_URL."images/about/");
    define("CAROUSEL_IMG_PATH", SITE_URL."images/carousel/");
    define("FEATURES_IMG_PATH", SITE_URL."images/facilities/");
    define("ROOM_IMG_PATH", SITE_URL."images/rooms/");
    define("USER_IMG_PATH", SITE_URL."images/users/");

    // Backend Upload Process
    define("UPLOAD_IMAGE_PATH", $_SERVER["DOCUMENT_ROOT"]."/PHP/Hotel Booking/images/");
    define("ABOUT_FOLDER", "about/");
    define("CAROUSEL_FOLDER", "carousel/");
    define("FEATURES_FOLDER", "facilities/");
    define("ROOM_FOLDER", "rooms/");
    define("USER_FOLDER", "users/");

    function alert($type, $message){
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo<<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3">$message</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
            </div>
        alert;
    }

    function redirect($url){
        echo "<script> window.location.href = '$url'; </script>";
        exit();
    }

    function adminLogin(){
        session_start();
        if(!(isset($_SESSION["adminLogin"]) && $_SESSION["adminLogin"] == true)){
            header("Location: index.php");
            exit();
        }
    }

    function uploadImage($image, $folder){
        $validateMime = ["image/jpeg", "image/png", "image/webp", "image/jpg"];
        $imageMime = $image["type"];
        if(!in_array($imageMime, $validateMime)){
            return "invalidImage";    // Invalid Image Format
        }else if(($image["size"] / (1024 * 1024)) > 2){
            return "invalidSize";
        }else{
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
            $rname = "IMG_".random_int(11111, 99999).".$extension";
            $imgPath = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image["tmp_name"], $imgPath)){
                return $rname;
            }else{
                return "uploadFailed";
            }
        }
    }

    function deleteImage($image, $folder){
        if(unlink(UPLOAD_IMAGE_PATH.$folder."/".$image)){
            return true;
        }else{
            return false;
        }
    }
?>