<?php
 // uploadImage

require_once 'includes/functions.php';

if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'dist/uploads/';

   
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    $filename = time() . '_' . uniqid() . '_' . rand(1000, 9999) . '.' . $extension;

    $uploadFile = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        http_response_code(200);

        $width = $_POST['width'];
        $height = $_POST['height'];

        $imageUrl = baseUrl() . 'uploads/' . $filename;

        $response = array(
            'imgCropped' => resizeImage($imageUrl, $width, $height),
            'imgUrl' => $filename
        );
        echo json_encode($response);
    } else {
        http_response_code(500);
    }
} else {
    http_response_code(500);
}
?>
