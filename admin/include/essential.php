<?php
    // Frontend Purpose Data
    define("SITE_URL", "http://127.0.0.1/PHP/hotel-booking/");
    define("ABOUT_IMG_PATH", SITE_URL."images/about/");
    define("CAROUSEL_IMG_PATH", SITE_URL."images/carousel/");
    define("FACILITIES_IMG_PATH", SITE_URL."images/facilities/");
    define("ROOM_IMG_PATH", SITE_URL."images/rooms/");
    define("USER_IMG_PATH", SITE_URL."images/users/");

    // Backend Upload Process
    define("UPLOAD_IMAGE_PATH", $_SERVER["DOCUMENT_ROOT"]."/PHP/hotel-booking/images/");
    define("ABOUT_FOLDER", "about/");
    define("CAROUSEL_FOLDER", "carousel/");
    define("FACILITIES_FOLDER", "facilities/");
    define("ROOM_FOLDER", "rooms/");
    define("USER_FOLDER", "users/");

    // SENDGRID API KEY
    define("SENDGRID_API_KEY", "Your Sendgrid Mail API Key.");
    define("SENDGRID_NAME", "Godlike Restaurant");
    define("SENDGRID_EMAIL", "hrikdas012@gmail.com");

    /**
     * Displays a Bootstrap-styled alert message.
     *
     * @param string $type The type of alert ('success' or 'error').
     * @param string $message The message to be displayed.
     */
    function alert($type, $message) {
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo<<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3">$message</strong>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    let alertElement = document.querySelector('.custom-alert');
                    if (alertElement) {
                        let bsAlert = new bootstrap.Alert(alertElement);
                        bsAlert.close();
                    }
                }, 3000);
            </script>
        alert;
    }

    /**
     * Redirects to a specified URL.
     *
     * @param string $url The URL to redirect to.
    **/
    function redirect($url) {
        echo "<script> window.location.href = '$url'; </script>";
        exit();
    }

    /**
     * Checks if the admin is logged in, if not redirects to login page.
     */
    function adminLogin() {
        session_start();
        if (!(isset($_SESSION["adminLogin"]) && $_SESSION["adminLogin"] == true)) {
            header("Location: index.php");
            exit();
        }
    }

    /**
     * Uploads an image to the specified folder.
     *
     * @param array $image The image file information from the $_FILES superglobal.
     * @param string $folder The folder where the image will be saved.
     * @return string The result of the upload process ('invalidImage', 'invalidSize', 'uploadFailed', or the image name).
     */
    function uploadImage($image, $folder) {
        $validateMime = ["image/jpeg", "image/png", "image/webp", "image/jpg"];
        $imageMime = $image["type"];
        if (!in_array($imageMime, $validateMime)) {
            return "invalidImage";    // Invalid Image Format
        } else if (($image["size"] / (1024 * 1024)) > 2) {
            return "invalidSize";
        } else {
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
            $rname = "IMG_".random_int(11111, 99999).".$extension";
            $imgPath = UPLOAD_IMAGE_PATH.$folder.$rname;
            if (move_uploaded_file($image["tmp_name"], $imgPath)) {
                return $rname;
            } else {
                return "uploadFailed";
            }
        }
    }

    /**
     * Deletes an image from the specified folder.
     *
     * @param string $image The name of the image to be deleted.
     * @param string $folder The folder from which to delete the image.
     * @return bool True on success, false on failure.
     */
    function deleteImage($image, $folder) {
        if (unlink(UPLOAD_IMAGE_PATH.$folder."/".$image)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Uploads an SVG image to the specified folder.
     *
     * @param array $image The SVG file information from the $_FILES superglobal.
     * @param string $folder The folder where the SVG will be saved.
     * @return string The result of the upload process ('invalidImage', 'invalidSize', 'uploadFailed', or the SVG name).
     */
    function uploadSVG($image, $folder) {
        $validateMime = ["image/svg+xml"];
        $imageMime = $image["type"];
        if (!in_array($imageMime, $validateMime)) {
            return "invalidImage";    // Invalid Image
        } else if (($image["size"] / (1024 * 1024)) > 1) {
            return "invalidSize";
        } else {
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
            $rname = "IMG_".random_int(11111, 99999).".$extension";
            $imagePath = UPLOAD_IMAGE_PATH.$folder.$rname;
            if (move_uploaded_file($image["tmp_name"], $imagePath)) {
                return $rname;
            } else {
                return "uploadFailed";
            }
        }
    }

    /**
     * Uploads a user's image, converting it to JPEG format.
     *
     * @param array $image The image file information from the $_FILES superglobal.
     * @return string The result of the upload process ('invalidImage', 'uploadFailed', or the image name).
     */
    function uploadUserImage($image){
        $validateMime = ["image/jpeg", "image/png", "image/webp", "image/jpg"];
        $imageMime = $image["type"];
        if (!in_array($imageMime, $validateMime)) {
            return "invalidImage";    // Invalid Image
        } else {
            $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
            $rname = "IMG_".random_int(11111, 99999).".jpeg";
            $imgPath = UPLOAD_IMAGE_PATH.USER_FOLDER.$rname;
            if ($extension == "png" || $extension == "PNG") {
                $img = imagecreatefrompng($image["tmp_name"]);
            } else if ($extension == "webp" || $extension == "WEBP") {
                $img = imagecreatefromwebp($image["tmp_name"]);
            } else {
                $img = imagecreatefromjpeg($image["tmp_name"]);
            }
            if (imagejpeg($img, $imgPath, 75)) {
                return $rname;
            } else {
                return "uploadFailed";
            }
        }
    }
?>