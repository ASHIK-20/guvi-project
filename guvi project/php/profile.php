<?php
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$mongoDB = $mongoClient->selectDatabase("test");
$collection = $mongoDB->selectCollection("profiles");
$errors = array();

  if (empty($name)) {
    $errors[] = "Name is required";
  }

  if (empty($email)) {
    $errors[] = "Email is required";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
  }

  if (empty($age)) {
    $errors[] = "Age is required";
  } elseif (!is_numeric($age)) {
    $errors[] = "Age must be a numeric value";
  }

  if (empty($dob)) {
    $errors[] = "Date of birth is required";
  } elseif (!strtotime($dob)) {
    $errors[] = "Invalid date of birth";
  }

  if (empty($contact)) {
    $errors[] = "Contact is required";
  }

  if (empty($errors)) {
    echo "Profile update successful!";
      header("Location: profile.php");
      exit();
  }

$redis = new Redis();
$redis->connect('localhost', 6379);

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION["username"];
$profile = $collection->findOne(["username" => $username]);

if (!$profile) {
    echo "Profile not found!";
    exit();
}
echo "Username: " . $profile["username"] . "<br>";
echo "Age: " . $profile["age"] . "<br>";
echo "DOB: " . $profile["dob"] . "<br>";
echo "Contact: " . $profile["contact"] . "<br>";
$mongoClient->close();

$sessionId = session_id();
$redis->set($sessionId, $username);
$redis->expire($sessionId, 3600); 
?>
 