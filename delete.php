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
        $role = $_SESSION['role'];
        if($role != 'admin')
        {
            setcookie("errorMsg", "You are not authorized to access this page!", time() + 5);
            header("Location: login.php");
        }
        else
        {
            $id = $_GET['id'];

            $file = "./data/users.txt";
            $user_data = file_get_contents($file);
            $user_data = json_decode($user_data, true);

            if(isset($user_data[$id]))
            {
                $role = $user_data[$id][1];
                if($role == 'admin')
                {
                    setcookie("errorMsg", "admin user cannot be deleted!", time() + 5);
                    header("Location: roles.php");
                }
                else
                {
                    unset($user_data[$id]);
                    $user_data = json_encode($user_data);
                    file_put_contents($file, $user_data);
                    setcookie("successMsg", "successfully deleted!", time() + 5);
                    header("Location: roles.php");
                }
            }
            else
            {
                setcookie("errorMsg", "No record Found!", time() + 5);
                header("Location: roles.php");
            }

            
        }
    }
?>