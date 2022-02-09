<?php
    include 'inc/dbh.inc.php';
    include 'inc/login.inc.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Log In</title>
        <link href="css/style.css" media="all" rel="stylesheet" type="text/css"/>
        
    </head>

    <body>

        <?php
            // Login Form
            echo "<div class='container'>
                <form method='POST' action='".getLogin($conn)."'>
                    <h1 class='title'>Log in</h1>

                    <div class='form-group'>
                        <label>Enter your Username:</label>
                        <input type='text' class='form-control' name='userid' placeholder='Username'><br>
                    </div>

                    <div class='form-group'>
                        <label>And your Password:</label>
                        <input type='password' class='form-control' name='pwd' placeholder='Password'><br>
                    </div>

                    <button type='submit' class='btn' name='loginSubmit'>Log In</button><br>

                    <a href='signup.php'>Don't have an account? Sign Up</a>
                </form>
            </div>";

            // Error control if credentials don't match
            if(isset($_GET["error"])) {
                if($_GET["error"] == "loginfailed") {
                    echo "<p>Your username or password doesn't match. Please try again.</p>";
                }
            }
        ?>
    
    </body>

</html>