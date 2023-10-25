<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        header("Location: login.php");
    }

    if($_SESSION['role'] != 'admin')
    {
        setcookie("errorMsg", "You are not authorized to access this page!", time() + 5);
        header("Location: login.php");
    }
    
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        
        $file = "./data/users.txt";
        $user_data = file_get_contents($file);
        $user_data = json_decode($user_data, true);
        
        if(isset($user_data[$id]))
        {
            $role = $user_data[$id][1];
            $username = $user_data[$id][2];
            $email = $user_data[$id][3];
        }
        else
        {
            setcookie("errorMsg", "No record Found!", time() + 5);
            header("Location: roles.php");
        }
    }
    
    if(isset($_POST['update']))
    {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $file = "./data/users.txt";
        $user_data = file_get_contents($file);
        $user_data = json_decode($user_data, true);

        if(isset($user_data[$id]))
        {
            $user_data[$id][2] = $username;
            $user_data[$id][3] = $email;
            $user_data[$id][1] = $role;
            $user_data = json_encode($user_data);
            file_put_contents($file, $user_data);
            setcookie("successMsg", "Successfully uodated!", time() + 5);
            header("Location: roles.php");
        }
        else
        {
            setcookie("errorMsg", "No record Found!", time() + 5);
            header("Location: roles.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">WELCOME <?php echo strtoupper($_SESSION['role']); ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php
                    if($_SESSION['role'] == 'admin'){
                ?>
                <li class="nav-item active">
                    <a class="nav-link" href="roles.php">Role Management <span class="sr-only">(current)</span></a>
                </li>
                <?php
                    }
                ?>
            </ul>
            
            <form class="form-inline my-2 my-lg-0">
            <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
            <a href="logout.php" class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</a>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Update User
                    </div>
                    <div class="card-body">
                        <form action="" method="post" onsubmit="return confirm('Are you sure?')">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?? '';?>" placeholder="Enter your username">
                                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?? '';?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?? '';?>" placeholder="Enter your email">
                            </div>
                            <div class="form-group">
                                <label for="password">Role</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="user" <?php echo $role == 'user' ? 'selected' : '';?>>user</option>
                                    <option value="manager" <?php echo $role == 'manager' ? 'selected' : '';?>>manager</option>
                                    <option value="admin" <?php echo $role == 'admin' ? 'selected' : '';?>>admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="update">Update</button> 
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
