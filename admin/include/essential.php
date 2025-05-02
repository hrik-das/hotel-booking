<?php
    // Data for frontend
    define("SITE_URL", "http://127.0.0.1/php/hotel-booking/");
    define("TEAM_IMAGE_PATH", SITE_URL."assets/team/");

    // Upload process data for backend
    define("TEAM_FOLDER", "team/");
    define("ABOUT_FOLDER", "about/");
    define("UPLOAD_IMAGE_PATH", $_SERVER["DOCUMENT_ROOT"]."/php/hotel-booking/assets/");

    function alert($type, $message) {
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";

        echo<<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <p class="m-0">$message</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
    }

    function redirect($url) {
        echo "<script> window.location.href = '$url'; </script>";
        exit();
    }

    function adminLogin() {
        session_start();      
        if (!(isset($_SESSION["adminLogin"]) && $_SESSION["adminLogin"] == true)) {
            header("Location: index.php");
            exit();
        }
    }

    function uploadImage($image, $folder) {
        $valid_mime = ["image/jpg", "image/png", "image/jpeg", "image/webp"];
        $image_mime = $image["type"];

        if (!in_array($image_mime, $valid_mime)) {
            return "invalid-image";    // invalid image mime or format
        } else if (($image["size"] / (1024 * 1024)) > 2) {
            return "invalid-size";    // invalid image size (greater than 2MB)
        } else {
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
            $random_name = "IMAGE_".random_int(111111, 999999).".$extension";
            $image_path = UPLOAD_IMAGE_PATH.$folder.$random_name;
            
            if (move_uploaded_file($image["tmp_name"], $image_path)) {
                return $random_name;
            } else {
                return "upload-failed";
            }
        }
    }

    function deleteImage($image, $folder) {
        if (unlink(UPLOAD_IMAGE_PATH.$folder.$image)) {
            return true;
        } else {
            return false;
        }
    }
?>