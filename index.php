<?php
require_once 'functions.php';

session_start();

if (isset($_GET['code'])) {

    $data = vkAuth($_GET['code']);

    if (register($data)) {
        echo "user registered and user logged in via Vk";
        $_SESSION['auth'] = true;
        $_SESSION['email'] = $data['email'];
    } else {
        echo "user logged in via Vk";
        $_SESSION['auth'] = true;
        $_SESSION['email'] = $data['email'];
    }
}

if (isset($_POST['data']) && ctype_alpha($_POST['data']['name']) &&
    isset($_SESSION['auth'])) {

        addComment($_POST['data']);

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
            GuestBook
        </div>
        <div class="panel-body">
            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" name="data[email]"/>
                </div>
                <div class="form-group">
                    <label>Имя</label>
                    <input type="text" class="form-control" name="data[name]"/>
                </div>
                <div class="form-group">
                    <label>Текст</label>
                    <textarea class="form-control" name="data[text]" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="form"/>
                </div>
            </form>

            <hr/>

            <?php if (file_exists("guestbook.json") && isset($_SESSION['auth']) && $_SESSION['auth']==true) {
                display();
            } else {echo "для отображения записей необходимо залогиниться";}?>

            <nav>
                <ul class="pagination">
<!--                    <li>
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>-->
                    <?php pagination(); ?>
<!--                   <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>-->
                </ul>
            </nav>

        </div>
    </div>
</div>

</body>
</html>
