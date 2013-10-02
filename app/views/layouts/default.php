<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>DietCake <?php eh($title) ?></title>

        <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/bootstrap/css/style.css" rel="stylesheet">
        <style>
            body {
                padding-top: 60px;
            }
        </style>
    </head>

    <body>

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="<?php eh(url('thread/index'))?>">DietCake Board</a>
                    
                    <div class="login"> 
                        <?php if(isset($_SESSION['username'])): ?>
                            <span>Welcome back, <b><?php echo $_SESSION['username'] ?></b>!</span>
                            <a href="<?php eh(url('user/logout')) ?>" class="btn btn-primary">Log Out</a>
                        <?php else: ?>
                            <form method="post" action="<?php eh(url('user/login')) ?>">
                                <input type="text" name="username" placeholder="Username">
                                <input type="password" name="password" placeholder="Password">
                                <input class="btn btn-primary" type="submit" value="Log In">
                                <a href="<?php eh(url('user/register')) ?>" class="btn btn-primary">Register</a>
                            </form>
                        <?php endif ?>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="container">
            <?php echo $_content_ ?>
        </div>

        <script>
        console.log(<?php eh(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
        </script>

    </body>
</html>
