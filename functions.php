<?php

function addComment ($note){
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

function vkAuth($code)
{
    $url = "https://oauth.vk.com/access_token?client_id=5338546&client_secret=rLlDNSnJrASHhMIeTNy5&redirect_uri=http://guestbookm.local/index.php&code=$code";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $data = json_decode(curl_exec($ch), true);
    $data = ['email' => $data['email'],'password' =>time()];

    return $data;
}

function register ($note){
    //$note = $_POST['data'];
    $data = fopen("users.json", "a+");
    $r=false;
    while (!feof($data)) {
        $user = fgets($data);
        $user = json_decode($user,true);
        if ($note['email']==$user['email']){
            echo "email already registered"."</br>";
            return false;
/*            $r=true;
            break;*/
        }
    }

    if ($r!=true){
        $note=json_encode($note);
        fwrite($data, $note . PHP_EOL);
        fclose($data);
        return true;
    }
}

?>
