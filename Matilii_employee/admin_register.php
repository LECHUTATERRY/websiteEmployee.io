<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'config.php';  // Database connection

    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        echo "Username or password cannot be empty.";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL
        $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            echo "Registration successful! <a href='admin_login.php'>Login here</a>";
        } else {
            echo "Error: " . $stmt->error;
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
    <title>Registration Form</title>
    <style>
        /* Basic reset */
        body, h1, form, input, button {
            margin: 0;
            padding: 0;
            box-sizing: border-box; /* Include padding and borders in the element's total width and height */
        }

        body {
            font-family: 'Arial', sans-serif; /* Using a common, web-safe font */
            background-color: #f4f4f9; /* Light grey background for a neutral look */
            display: flex;
            align-items: center; /* Aligns children (form container) vertically */
            justify-content: center; /* Aligns children (form container) horizontally */
            height: 100vh; /* Full viewport height */
            text-align: center; /* Aligns all text inside the body to center */
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Maximum width of the form */
        }

        h1 {
            color: #333;
            margin-bottom: 20px; /* Space below the header */
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"], input[type="password"], input[type="email"], button {
            padding: 10px;
            margin-bottom: 15px; /* Space between inputs */
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center; /* Ensures text in inputs and button is centered */
        }

        button {
            background-color: #5c67f2; /* A pleasant blue */
            color: white;
            font-size: 16px; /* Slightly larger font size for better readability */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        button:hover {
            background-color: #4a54e1; /* A darker shade of blue for hover effect */
        }

        @media (max-width: 600px) {
            .form-container {
                width: 90%; /* Smaller width on smaller screens */
                padding: 20px; /* Less padding on smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Register</h1>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
            <p>Already have an account? <a href="admin_login.php">Login here</a>.</p>
            
        </form>
    </div>
</body>
</html>
