<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php-login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <div class="nav-logo">
            <a href="index.php">P_Login</a>
        </div>
        <div class="nav-links">
            <?php
                session_start();
                if(isset($_SESSION["username"])){
                    echo "<a href='includes/logout.inc.php'>Logout</a>";
                } else {
                    echo "<a href='login.php'>Login</a>";
                    echo "<a href='signup.php'>Sign up</a>";
                }
            ?>    
        </div>
    </nav>