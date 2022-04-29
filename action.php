<?php
//index.php

$salutation = '';
$firstname = '';
$lastname = '';
$street = '';
$plz = '';
$phonenumber = '';
$birthday = '';
$email = '';
$userPassword = '';
$userPasswordConfirmed = '';
$city = '';
$state = '';
$userId = random_int(1000000, 9999999);

if (isset($_POST["submit"])) {

  if (!empty($_POST["salutation"])) {
    $salutation = clean_text($_POST["salutation"]);
  }

  if (!empty($_POST["firstname"])) {
    $firstname = clean_text($_POST["firstname"]);
  }

  if (!empty($_POST["lastname"])) {
    $lastname = clean_text($_POST["lastname"]);
  }

  if (!empty($_POST["street"])) {
    $street = clean_text($_POST["street"]);
  }

  if (!empty($_POST["plz"])) {
    $plz = clean_text($_POST["plz"]);
  }

  if (!empty($_POST["phonenumber"])) {
    $phonenumber = clean_text($_POST["phonenumber"]);
  }

  if (!empty($_POST["birthday"])) {
    $birthday = clean_text($_POST["birthday"]);
  }

  if (!empty($_POST["email"])) {
    $email = clean_text($_POST["email"]);
  }

  if (!empty($_POST["password"])) {
    $userPassword = clean_text($_POST["password"]);
    $userPasswordConfirmed = password_hash($userPassword, PASSWORD_DEFAULT);
  }

  if (!empty($_POST["city"])) {
    $city = clean_text($_POST["city"]);
  }

  if (!empty($_POST["state"])) {
    $state = clean_text($_POST["state"]);
  }

  $file_open = fopen("users.csv", "a");
  $no_rows = count(file("users.csv"));

  if ($no_rows > 1) {
    $no_rows = ($no_rows - 1) + 1;
  }

  $form_data = array(
    'sr_no'  => $no_rows,
    'salutation'  => $salutation,
    'firstname'  => $firstname,
    'lastname' => $lastname,
    'street' => $street,
    'plz' => $plz,
    'phonenumber' => $phonenumber,
    'birthday' => $birthday,
    'email' => $email,
    'password' => $userPasswordConfirmed,
    'city' => $city,
    'state' => $state
  );

  fputcsv($file_open, $form_data);

  fclose($file_open);

  $file_name = $_FILES['file']['name'];
  $file_type = $_FILES['file']['type'];
  $file_size = $_FILES['file']['size'];
  $file_tem_loc = $_FILES['file']['tmp_name'];
  $file_store = '/var/www/html/userFiles/' . $file_name;

  if (move_uploaded_file($file_tem_loc, $file_store)) {
    echo "File uploaded successfuly";
    echo "<br>";
  }

  echo "Thanks for registration <br>";
  echo "<a href='main.html'>Back to main website</a>";

  try {

    $servername = 'janginstore.mysql.database.azure.com';
    $username = 'jangin@janginstore';
    $password = 'Jangin95+';
    $db = 'test';

    $connection = new PDO("mysql:host={$servername};dbname={$db}", $username, $password);
    //$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "insert into users values('$userId', '$firstname', '$lastname', '$salutation', '$email', '$birthday', '$userPasswordConfirmed', '$phonenumber', '$street', '$plz', '$city', '$state')";

    $connection->exec($sql);
  } catch (Exception $e) {
    echo ('Fehler: ' . $e->getMessage());
    echo phpinfo();
    exit();
  }

  $connection = null;

  $salutation = '';
  $firstname = '';
  $lastname = '';
  $street = '';
  $plz = '';
  $phonenumber = '';
  $birthday = '';
  $email = '';
  $userPassword = '';
  $userPasswordConfirmed = '';
  $city = '';
  $state = '';
}

function clean_text($string)
{
  $string = trim($string);
  $string = stripslashes($string);
  $string = htmlspecialchars($string);
  return $string;
}
