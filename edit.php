<?php
require_once 'User.php';

$user = new User();
$userData = $user->getUserById( $_GET[ 'id' ] );

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
    $name = $_POST[ 'name' ];
    $email = $_POST[ 'email' ];
    $contact = $_POST[ 'contact' ];
    $photo = $_FILES[ 'photo' ][ 'name' ] ? $_FILES[ 'photo' ][ 'name' ] : $userData[ 'photo' ];

    if ( $_FILES[ 'photo' ][ 'name' ] ) {
        move_uploaded_file( $_FILES[ 'photo' ][ 'tmp_name' ], "uploads/$photo" );
    }

    $user->updateUser( $_GET[ 'id' ], [
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
<title>Edit User</title>
</head>
<body>
<h1>Edit User</h1>
<form method = 'POST' enctype = 'multipart/form-data'>
<label>Name:</label>
<input type = 'text' name = 'name' value = "<?= $userData['name'] ?>" required><br>
<label>Email:</label>
<input type = 'email' name = 'email' value = "<?= $userData['email'] ?>" required><br>
<label>Contact:</label>
<input type = 'text' name = 'contact' value = "<?= $userData['contact'] ?>" required><br>
<label>Photo:</label>
<input type = 'file' name = 'photo'><br>
<button type = 'submit'>Update</button>
</form>
</body>
</html>
