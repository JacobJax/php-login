<?php
include 'configure/dbh_config.php';

$email = $fullname = $username = $password = $confPassword = '';
$errors = ['fullname'=>'', 'username'=>'', 'email'=>'', 'password'=>'', 'confPassword'=>''];

if(isset($_POST["submit"])){
    
    if(empty($_POST['fullname'])){
        $errors['fullname'] = 'A name is required';
        
    } else {
        $fullname = $_POST['fullname'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $fullname)){
            $errors['fullname'] = 'A name must be letters and spaces only';
        }
    }

    if(empty($_POST['username'])){
        $errors['username'] = 'A username is required';
    } else {
        $username = $_POST['username'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $username)){
            $errors['username'] = 'A username must be letters and spaces only';
        }else{
            $username = $_POST['username'];
            $t_sql = "SELECT * FROM users WHERE username='$username'";

            $result = mysqli_query($conn, $t_sql);
            $detail = mysqli_fetch_assoc($result);
            if($detail){
                $errors['username'] = 'That username is already taken';
            }
        }
    }

    if(empty($_POST['email'])){
        $errors['email'] = 'An email is required';
    } else {
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Email must be a valid email address';
        }else{
            $email = $_POST['email'];
            $t_sql = "SELECT * FROM users WHERE email='$email'";

            $result = mysqli_query($conn, $t_sql);
            $detail = mysqli_fetch_assoc($result);
            if($detail){
                $errors['email'] = 'That email is already taken';
            }
        }
    }

    if(empty($_POST['password'])){
        $errors['password'] = 'A password is required';
    }else{
        $password = $_POST['password'];
        if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $password)){
            $errors['password'] = 'Password must contain 8 or characters, capital letters and special characters';
        }
    }

    if(empty($_POST['confPassword'])){
        $errors['confPassword'] = 'A password is required';
    }else{
        $confPassword = $_POST['confPassword'];
        if($confPassword != $password){
            $errors['confPassword'] = 'The passwords do not match';
        }
    }

    // post to database
    if(!array_filter($errors)){
        $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(fullname, username, email, password) VALUES('$fullname', '$username', '$email', '$hashed_password')";

        if(mysqli_query($conn, $sql)){
            header("Location: login.php");
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<?php include 'templates/header.php' ?>
<div class="sign-form">
    <form action="signup.php" method="post">
        <label for="fullname">Full name:</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($fullname) ?>">
        <div class="red-text"><?php echo $errors['fullname']; ?></div><br>

        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username) ?>">
        <div class="red-text"><?php echo $errors['username']; ?></div><br>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div><br>

        <label for="password">Password:</label>
        <input type="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
        <div class="red-text"><?php echo $errors['password']; ?></div><br>

        <label for="confPassword">Confirm password:</label>
        <input type="password" name="confPassword" value="<?php echo htmlspecialchars($confPassword) ?>">
        <div class="red-text"><?php echo $errors['confPassword']; ?></div>

        <button type="submit" name="submit">Sign up</button>
    </form>
</div> 
</body>
</html>