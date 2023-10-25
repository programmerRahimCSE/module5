<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        if($_SESSION['role'] != 'admin')
        {
            header("Location: login.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Project</title>
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

    <div>
        <div class="row justify-content-center">
            <p class="text-danger"><?php echo isset($_COOKIE['errorMsg']) ? $_COOKIE['errorMsg'] : '';?></p>
        </div>
    </div>

    <h2>Users List</h2>
    <table class="table">
        
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $file = "./data/users.txt";
                $user_data = file_get_contents($file);
                $user_data = json_decode($user_data, true);
                $count = 0;
                foreach($user_data as $data)
                {
                    $count++;
                    $sl = trim($data[0]);
                    $username = trim($data[2]);
                    $userEmail = trim($data[3]);
            ?>
            <tr>
                <th scope="row"><?php echo $count;?></th>
                <td><?php echo $username;?></td>
                <td><?php echo $userEmail;?></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
        
    <!-- Add Bootstrap JS and Popper.js if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>