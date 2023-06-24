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
    echo "Login successful!";
      header("Location: profile.php");
      exit();
  }
}

$servername = "localhost";
$dbname = "test";
$db_username = "root";
$db_password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_username, $db_password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
  $stmt->bindParam(':username', $username);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['password'] == $password) {
      echo 'Login successful!';
    } else {
      header('HTTP/1.1 401 Unauthorized');
      echo 'Login failed. Invalid username or password.';
    }
  } else {
    header('HTTP/1.1 401 Unauthorized');
    echo 'Login failed. Invalid username or password.';
  }
} catch(PDOException $e) {
  header('HTTP/1.1 401 Unauthorized');
  echo 'Login failed. Please try again.';
}
?>
