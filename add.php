<?php
require_once 'User.php';

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
    $name = $_POST[ 'name' ];
    $email = $_POST[ 'email' ];
    $contact = $_POST[ 'contact' ];
    $photo = null;

    // Check if a file is uploaded
    if ( isset( $_FILES[ 'photo' ] ) && $_FILES[ 'photo' ][ 'error' ] === UPLOAD_ERR_OK ) {
        // Extract file details
        $tmpName = $_FILES[ 'photo' ][ 'tmp_name' ];
        $fileName = basename( $_FILES[ 'photo' ][ 'name' ] );
        $uploadDir = 'uploads/';

        // Ensure the uploads directory exists
        if ( !is_dir( $uploadDir ) ) {
            mkdir( $uploadDir, 0755, true );
        }

        // Sanitize file name and move file
        $photo = time() . '_' . preg_replace( '/[^a-zA-Z0-9_\.-]/', '_', $fileName );
        // Unique file name
        $uploadPath = $uploadDir . $photo;

        if ( move_uploaded_file( $tmpName, $uploadPath ) ) {
            echo 'File uploaded successfully!';
        } else {
            echo 'Failed to upload file.';
            $photo = null;
            // Reset photo if upload fails
        }
    } else {
        echo 'No file uploaded or an error occurred.';
    }

    // Save data to the database
    $user = new User();
    $user->createUser( [
        'name' => $name,
        'email' => $email,
        'photo' => $photo,
        'contact' => $contact
    ] );

    header( 'Location: index.php' );
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add User</title>
</head>
<body>
<h1>Add User</h1>
<form method = 'POST' enctype = 'multipart/form-data'>
<label>Name:</label>
<input type = 'text' name = 'name' required><br>
<label>Email:</label>
<input type = 'email' name = 'email' required><br>
<label>Contact:</label>
<input type = 'text' name = 'contact' required><br>
<label>Photo:</label>
<input type = 'file' name = 'photo'><br>
<button type = 'submit'>Submit</button>
</form>
</body>
</html>
