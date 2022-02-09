<!DOCTYPE = html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <link href="css/style.css" media="all" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <!-- Sign Up form -->
        <div class='container'>
            <form method='POST' action='inc/signup.inc.php'>
                <h1 class='title'>Sign Up</h1>

                <div class='form-group'>
                    <label>Enter a new Username:</label>
                    <input type='text' name='userid' class='form-control' placeholder='Username'><br>
                </div>

                <div class='form-group'>
                    <label>Enter your full name:</label>
                    <input type='text' name='fullname' class='form-control' placeholder='Full Name'><br>
                </div>

                <div class='form-group'>
                    <label>Select your password:</label>
                    <input type='password' name='pwd' class='form-control' placeholder='Password'><br>
                </div>   

                <div class='form-group'>
                    <label>Confirm your password:</label>
                    <input type='password' name='pwdConfirm' class='form-control' placeholder='Confirm Password'><br>
                </div>

                <!-- Password verification for professors -->
                <div class='form-group'>
                    <label>Professor Sign Up:</label>
                    <input type='password' name='profPwd' class='form-control' placeholder='Enter the professor Password'><br>
                </div>

                <button type='submit' class='btn' name='signupSubmit'>Sign Up</button>
            </form>
        </div>

    <?php

        // Error control
        if(isset($_GET["error"])) {
            if($_GET["error"] == "emptyinput") {
                    echo "<p>Please fill in all fields.</p>";
            }

            if($_GET["error"] == "useduid") {
                echo "<p>This user ID is in use. Please choose another one.</p>";
            }

            if($_GET["error"] == "passwordcnfrm") {
                echo "<p>Your password doesn't match. Please try again.</p>";
            }

            if($_GET["error"] == "profcnfrm") {
                echo "<p>Your professor confirmation password doesn't match. Please try again.</p>";
            }
        }
    ?>

    </body>