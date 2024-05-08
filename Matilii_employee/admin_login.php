<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'config.php';  // Database connection

    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        echo "Username or password cannot be empty.";
    } else {
        // Prepare SQL
        $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                header("Location: admin_dashboard.php"); // Redirect to a dashboard
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "Username not found.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;  /* Light grey background for a neutral look */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full viewport height */
            text-align: center;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px;  /* Suitable width for the form */
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            margin: 10px 0; /* Space between inputs */
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            margin-top: 20px; /* Space above the button */
            background-color: #5c67f2; /* A pleasant blue */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4a54e1; /* Darker blue for hover effect */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="admin_register.php">Register here</a>.</p>
             
        </form>
    </div>
</body>
</html>
