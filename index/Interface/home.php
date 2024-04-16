<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Technopoliz - We are Glad to Have You Here</title>
    <style>
        @font-face {
            font-family: 'Press Start 2P';
            src: url('press-start-2p.woff2') format('woff2'),
                 url('press-start-2p.woff') format('woff');
            /* Add more font file formats if available (e.g., .ttf, .otf) */
            font-weight: normal;
            font-style: normal;
        }

        body {
    font-family: 'Roboto', sans-serif;
    background-color: #0A2240; /* Dark background */
    color: #c0c0c0; /* Light grey text */
    text-align: center;
    padding: 50px;
    margin: 0;
}

h1 {
    color: #E97451; /* Robotic blue */
}

p {
    margin-bottom: 20px;
    font-size: 18px;
    line-height: 1.6;
    font-family: 'Press Start 2P', sans-serif; /* Applying the Press Start 2P font */
}

.register-login-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.register-tab a, .login-tab a {
    color: #4CBB17; /* Robotic orange */
    text-decoration: none;
    padding: 10px 20px; /* Adjusted padding for better spacing */
    margin: 0 10px;
    border: 1px solid #4CBB17; /* Robotic orange */
    border-radius: 3px;
    transition: background-color 0.3s;
    font-weight: bold;
}

.register-tab a:hover, .login-tab a:hover {
    background-color: #a0522d; /* Darker brown on hover */
}

    </style>
</head>
<body>
    <h1>Welcome to the CNU alumni system!</h1> 
    <p>
        Can you conquer Technopoliz? Technopoliz is an empire with flags that need to be captured!!
        Can you solve the challenges to conquer the empire of Technopoliz, where you shall be the ruler?
        We dare you to try!
    </p>

    <div class="register-login-container">
        <div class="register-tab">
            <p>Don't have an account?</p>
            <a href="register.php">Register</a>
        </div>

        <div class="login-tab">
            <p>Already have an account?</p>
            <a href="login.php">Log In</a>
        </div>
    </div>
</body>

</html>
