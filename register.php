<?php
require_once 'functions.php';
session_start();
if (isset($_POST['data'])) {

    if (register($_POST['data'])){
        $_SESSION['auth'] = true;
        $_SESSION['email'] = $_POST['data']['email'];
        header("location: index.php");
    };

}

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Guestbook</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
          integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
</head>
<body>

<div class="container">

    <?php require_once 'navbar.php' ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            Registration
        </div>
        <div class="panel-body">
            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" name="data[email]"/>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="data[password]"/>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="form"/>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

