<?php

// валидация и запись данных в файл

// (email (поставил type = 'email') и textarea (поставил атрибут required) валидируются в браузере)
session_start();

if (isset($_SESSION['auth'])){var_dump($_SESSION);}

if (isset($_POST['data']) && ctype_alpha($_POST['data']['name']) && 
isset($_SESSION['auth'])) {
echo 'add note';
    $note = $_POST['data'];
    $note['date'] = date("m.d.Y");
    $data = fopen("guestbook.json", "a");
    $note=json_encode($note);
    fwrite($data, $note.PHP_EOL);
    fclose($data);
}

function display()
{
    $data = fopen("guestbook.json", "r");
    $perPage=2;
    if (!isset($_GET['page'])) {
        $linesToDispay = [1,$perPage];
    }else{
        $page = $_GET['page']*$perPage;
        $linesToDispay = [$page,$page+1];
    }
    $lineCount = 0;

    while (!feof($data)) {
        $lineCount++;
        $line = fgets($data);
        $note = json_decode($line,true);
        if ($lineCount >= $linesToDispay[0] && $lineCount <= $linesToDispay[1]) {
        ?>
        <div class="post-block">
            <b><?php echo $note['name'] ?></b> <i><?php echo $note['email'] ?></i> <i
                style="text-decoration: underline;"><?php echo $note['date'] ?></i>
            <p>
                <?php echo $note['text'] ?>
            </p>
        </div>
        <?php
        }elseif($lineCount>$linesToDispay[1]){break;}
    }
    fclose($data);
}

function postCount(){
    $count=0;
    $data = fopen("guestbook.json","r");
    while (!feof($data)){
        fgets($data);
        $count++;
    }
    $count--;
    return $count;
}

function pagination(){
    $perPage=2;
    $pageCount = floor(postCount()/$perPage);
    for ($i = 1; $i<=$pageCount;$i++){
        echo "<li><a href=\"index.php?page=$i\">$i</a></li>";
    }
}


if (isset($_GET['code'])){

    $code = $_GET['code'];
    $url = "https://oauth.vk.com/access_token?client_id=5338546&client_secret=rLlDNSnJrASHhMIeTNy5&redirect_uri=http://guestbookm.local/index.php&code=$code";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $data = json_decode(curl_exec($ch), true);

    $userId = $data['user_id'];
    $token = $data['access_token'];
    //$email=$data['email'];
    var_dump($data);

    /*        //$url = "https://api.vk.com/method/users.get?user_id=$userId&v=5.44&access_token=$token";
            //var_dump($url);
            $url = "https://api.vk.com/method/friends.get?user_id=$userId&fields=nickname,bdate";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $data1 = json_decode(curl_exec($ch), true);

            var_dump($data1);die;*/
    //var_dump($data);die;
}else{
    echo "vk not set";
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
