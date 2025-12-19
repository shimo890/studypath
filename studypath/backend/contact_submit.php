<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $message = $conn->real_escape_string($_POST['message']);
  $stmt = $conn->prepare("INSERT INTO contacts (name,email,message) VALUES (?,?,?)");
  $stmt->bind_param('sss',$name,$email,$message);
  if ($stmt->execute()) {
    echo "<script>alert('Message sent. Thank you');window.location.href='../contact.php';</script>";
  } else {
    echo "Error: " . $conn->error;
  }
}
