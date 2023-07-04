<?php

use Core\App;
use Core\Database;
use Http\Form\LoginForm;
use Core\Authenticator;
use Core\Session;
use Core\ValidationException;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$form = LoginForm::validate([
    'email' => $email,
    'password' => $password
]);

$signedIn = (new Authenticator)->attempt(
    $email, $password
);

if (!$signedIn) {
    $form->error("email", "No matching account found for that email address")
        ->throw();
}

redirect('/');
