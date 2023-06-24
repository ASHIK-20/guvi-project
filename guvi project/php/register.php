<?php
session_start();
ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://127.0.0.1:6379');

$username = $_POST['username'];
$password = $_POST['password'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $errors = array();

  if (empty($username)) {
    $errors[] = "Username is required";
  }

  if (empty($password)) {
    $errors[] = "Password is required";
  } elseif (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long";
  }

 
  if (empty($errors)) {
    echo "Registration successful!";
      header("Location: login.php");
      exit();
  }
}

$servername = "localhost";
$dbname = "root";
$db_username = "test";
$db_password = ""; 

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', $password);
  $stmt->execute();

  echo 'Signup successful , Please login to continue ';
} catch(PDOException $e) {
  echo 'Signup failed. Please try again.';
}
?>
