<?php
include("../config/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form se data lena
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    // Password ko secure (hash) karna
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check karna ki email pehle se toh nahi hai
    $check_email = mysqli_query($conn, "SELECT email FROM users WHERE email='$email'");
    
    if (mysqli_num_rows($check_email) > 0) {
        echo "<script>alert('Email already registered'); window.location='signup.html';</script>";
    } else {
        $query = "INSERT INTO users (first_name, last_name, username, email, password, role) 
                  VALUES ('$first_name', '$last_name', '$username', '$email', '$password', '$role')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration Successful!'); window.location='login.html';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
