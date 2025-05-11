<?php
    // Data for frontend
    define("SITE_URL", "http://127.0.0.1/php/hotel-booking/");
    define("TEAM_IMAGE_PATH", SITE_URL."assets/team/");
    define("CAROUSEL_IMAGE_PATH", SITE_URL."assets/carousel/");
    define("FACILITY_IMAGE_PATH", SITE_URL."assets/facilities/");
    define("ROOM_IMAGE_PATH", SITE_URL."assets/rooms/");
    define("USERS_IMAGE_PATH", SITE_URL."assets/users/");

    // Upload process data for backend
    define("TEAM_FOLDER", "team/");
    define("ROOM_FOLDER", "rooms/");
    define("USER_FOLDER", "users/");
    define("ABOUT_FOLDER", "about/");
    define("CAROUSEL_FOLDER", "carousel/");
    define("FACILITY_FOLDER", "facilities/");
    define("UPLOAD_IMAGE_PATH", $_SERVER["DOCUMENT_ROOT"]."/php/hotel-booking/assets/");

    // SendGrid API key
    define("SENDGRID_ORGANISATION", "Your organisation name");
    define("SENDGRID_EMAIL_ADDRESS", "Your sendgrid email address");
    define("SENDGRID_API_KEY", "Your API key");

    function alert($type, $message) {
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";

        echo<<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <p class="m-0">$message</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <script>
                setTimeout(() => {
                    let alertBox = document.querySelector(".alert");
                    
                    if (alertBox) {
                        alertBox.remove();
                    }
                }, 3000);
            </script>
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

    function uploadSVGImage($image, $folder) {
        $valid_mime = ["image/svg+xml"];
        $image_mime = $image["type"];

        if (!in_array($image_mime, $valid_mime)) {
            return "invalid-image";    // invalid image mime or format
        } else if (($image["size"] / (1024 * 1024)) > 1) {
            return "invalid-size";    // invalid image size (greater than 1MB)
        } else {
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
            $random_name = "SVG_".random_int(111111, 999999).".$extension";
            $image_path = UPLOAD_IMAGE_PATH.$folder.$random_name;
            
            if (move_uploaded_file($image["tmp_name"], $image_path)) {
                return $random_name;
            } else {
                return "upload-failed";
            }
        }
    }

    function uploadUserImage($image) {
        $valid_mime = ["image/jpg", "image/png", "image/jpeg", "image/webp"];
        $image_mime = $image["type"];

        if (!in_array($image_mime, $valid_mime)) {
            return "invalid-image";    // invalid image mime or format
        } else {
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
            $random_name = "IMAGE_".random_int(111111, 999999).".jpeg";
            $image_path = UPLOAD_IMAGE_PATH.USER_FOLDER.$random_name;

            if ($extension == "png" || $extension == "PNG") {
                $img = imagecreatefrompng($image["tmp_name"]);
            } else if ($extension == "webp" || $extension == "WEBP") {
                $img = imagecreatefromwebp($image["tmp_name"]);
            } else {
                $img = imagecreatefromjpeg($image["tmp_name"]);
            }

            if (imagejpeg($img, $image_path, 75)) {
                return $random_name;
            } else {
                return "upload-failed";
            }
        }
    }
?>