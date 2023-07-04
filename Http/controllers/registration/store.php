<?php

use \Core\Validator;
use \Core\App;
use \Core\Database;

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];
// validate the form data
if (!Validator::email($email)) {
    $errors['email'] = "Please provide a valid email address.";
}

if (!Validator::string($password, 7, 255)) {
    $errors['password'] = "Password must be a string between 7 and 255 characters long";
}

if (!empty($errors)) {
    view('registration/create.view.php', [
        'errors' => $errors
    ]);
}

$db = App::resolve(Database::class);
// check if the account already exists
$user = $db->query("select * from users where email = :email", [
    'email' => $email
])->find();

if ($user) {
    header("location: /");
    exit();
} else {
    $db->query("insert into users(email, password) values(:email, :password)", [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT)
    ]);

    // mark that the user has logged in
    login($user);

    header('location: /');
    exit();
}