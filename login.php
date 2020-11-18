<?php 
    include 'configure/dbh_config.php';
    $emailOrPassword = $password = '';
    $errors = ['emailOrUsername'=>'', 'password'=>'', 'account'=>''];

    if(isset($_POST['submit'])){

        if(empty($_POST['emailOrUsername']) OR empty($_POST['password'])){
            $errors['emailOrUsername'] = 'Please enter Email or Username';
            $errors['password'] = 'Please enter Password';            
        } else {
            $emailOrPassword = $_POST['emailOrUsername'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE email = '$emailOrPassword' OR username = '$emailOrPassword'";
            $result = mysqli_query($conn, $sql);
            $detail = mysqli_fetch_assoc($result);

            if($detail){
                $u_password = $detail['password'];
                if(password_verify($password, $u_password)){
                    session_start();
                    $_SESSION["id"] = $detail['id'];
                    $_SESSION["username"] = $detail['username'];
    
                    header("Location: index.php");
                } else {
                    $errors['password'] = 'Incorrect password';
                }
            }else{
                $errors['account'] = 'That account does not exist';
            }

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'templates/header.php' ?>
<div class="sign-form">
    <form action="login.php" method="post">
        <div class="red-text"><?php echo $errors['account']; ?></div><br>

        <label for="emailOrUsername">Email or Username:</label>
        <input type="text" name="emailOrUsername" value="<?php echo htmlspecialchars($emailOrPassword) ?>">
        <div class="red-text"><?php echo $errors['emailOrUsername']; ?></div><br>

        <label for="password">Password:</label>
        <input type="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
        <div class="red-text"><?php echo $errors['password']; ?></div>

        <button type="submit" name="submit">Log in</button>
    </form>
</div>
    
</body>
</html>