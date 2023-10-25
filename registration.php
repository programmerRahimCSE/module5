<?php
    session_start();
    if(isset($_SESSION['username']))
    {
        header("Location: login.php");
    }
    else if(isset($_POST['register']))
    {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = SHA1(MD5($_POST['password']));

        if(strlen($username) == 0 && strlen($email) == 0)
        {
            setcookie("errorMsg", "All fields are required!", time() + 5);
            header("Location: roles.php");
            return;
        }
        else if(strlen($username) == 0)
        {
            setcookie("errorMsg", "Username field is required!", time() + 5);
            header("Location: roles.php");
            return;
        }
        else if(strlen($email) == 0)
        {
            setcookie("errorMsg", "Email field is required!", time() + 5);
            header("Location: roles.php");
            return;
        }

        $role = "user";
        $file = "./data/users.txt";
        $previous_data = file_get_contents($file);
        $previous_data = json_decode($previous_data, true);

        foreach($previous_data as $data)
        {
            $previousEmail = trim($data[3]);
            if($previousEmail == $email){
                setcookie("errorMsg", "Email already exists! Please try with another", time() + 5);
                header("Location: registration.php");
                return;
            }
        }

        $sl = count($previous_data);
        $previous_data[] = array($sl,$role, $username, $email, $password);
        $new_data = json_encode($previous_data);
        file_put_contents($file, $new_data,LOCK_EX);
        setcookie("successMsg", "Registration Successful! Please Login", time() + 5);
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <p class="text-center text-success">
                    <?php echo isset($_COOKIE['successMsg']) ? $_COOKIE['successMsg'] : '';?>
                </p>
                <p class="text-center text-danger">
                    <?php echo isset($_COOKIE['errorMsg']) ? $_COOKIE['errorMsg'] : '';?>
                </p>
                <div class="card">
                    <div class="card-header">
                        Registration Form
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="register">Register</button> <small class="offset-md-2 offset-sm-2 offset-xs-2">already have registered, <a href="login.php">click here to login</a></small> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
