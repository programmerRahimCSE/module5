<?php
    session_start();
    if(isset($_SESSION['username']))
    {
        $role = $_SESSION['role'];
        if($role == 'admin')
        {
            header("Location: index.php");

        }
        else if($role == "user")
        {
            header("Location: user_index.php");
        }
        else if($role == "manager")
        {
            header("Location: manager_index.php");
        }
    }
    else if(isset($_POST['login']))
    {
        $email = trim($_POST['email']);
        $password = SHA1(MD5($_POST['password']));

        $file = "./data/users.txt";
        $user_data = file_get_contents($file);
        $user_data = json_decode($user_data, true);
        for($i=0;$i<count($user_data);$i++)
        {
            $data = $user_data[$i];
            $role = trim($data[1]);
            $username = trim($data[2]);
            $userEmail = trim($data[3]);
            $userPassword = trim($data[4]);
            if($email == $userEmail && $password == $userPassword)
            {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                setcookie("successMsg", "Login Successful!", time() + 5);
                if($role == 'admin')
                {
                    header("Location: index.php");

                }
                else if($role == "user")
                {
                    header("Location: user_index.php");
                }
                else if($role == "manager")
                {
                    header("Location: manager_index.php");
                }
            }
        }

        $errorMessage = "Wrong Email or Password!";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
                <div class="card">
                    <div class="card-header">
                        Login Form
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                            </div>
                            <div class="form-group">
                                <p class="text-danger"></p><?php echo $errorMessage ?? "";?></p>
                            </div>
                            <button type="submit" class="btn btn-primary" name="login">Login</button> <small class="offset-md-2 offset-sm-2 offset-xs-2"><a href="registration.php">click here</a> for registration</small> 
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
