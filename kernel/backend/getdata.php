<?php 

require_once 'connection.php';

$getCategories = function() use ($mysqli)
{
    $result = $mysqli->query('SELECT * FROM categories');

    if($result->num_rows) {
        while ($row = mysqli_fetch_assoc($result)){
            switch($row['id']){
                case '1':
                    $name = 'politics';
                break;
                case '2':
                    $name = 'economics';
                break;
                case '3':
                    $name = 'auto';
                break;
                case '4':
                    $name = 'tech';
                break;
                case '5':
                    $name = 'realestate';
                break;
            }
            echo "<li><a class=\"category category_{$row['id']}\" href=\"/PHP_HW10/views/components/articles/?category=$name\" a>$row[name]</a></li>";
        }
    } else {
        echo "No categories";
    }
};

$getLastPosts = function() use ($mysqli)
{
    $result = $mysqli->query('SELECT id, title, date FROM posts ORDER BY date DESC LIMIT 6');

    if($result->num_rows) {
        while ($row = mysqli_fetch_assoc($result)){
            $date = date("d.m.Y h:m:s", strtotime($row['date']));
            echo "<li><a class=\"article article_{$row['id']}\" href=\"/PHP_HW10/views/components/articles/?id=$row[id]\">$row[title]...</a><span class=\"data_article\">$date</span></li>";
    }
    }
};

$getArticl = function($data) use ($mysqli)
{
    if(!$data) return;
    $result = $mysqli->query('SELECT title, content, date, authors.name AS author, categories.name AS category FROM posts JOIN authors ON posts.author_id = authors.id JOIN categories ON posts.category_id = categories.id WHERE posts.id ='.$data);

    if($result->num_rows) {
        while ($row = mysqli_fetch_assoc($result)){
            $date = date("d.m.Y h:m:s", strtotime($row['date']));
            echo "<div class=\"post\"><p class=\"post_category\">$row[category]</p><p class=\"post_title\">$row[title]</p><p class=\"post_content\">$row[content]</p><p class=\"post_auther\">$row[author]</p><span class=\"data_article\">$date</span></a></div>";
    }
    }
};

$getCategory = function($data1, $data2 = null) use ($mysqli)
{
    if(!isset($data1)) return;

    if(!isset($mult)) $mult = 0;
    $mult = $data2*5 - 5;
    if($mult < 0) $mult = 0;

    switch($data1){
        case 'politics':
            $name = 'Политика';
        break;
        case 'economics':
            $name = 'Экономика';
        break;
        case 'auto':
            $name = 'Авто';
        break;
        case 'tech':
            $name = 'ИТ-сектор';
        break;
        case 'realestate':
            $name = 'Недвижимость';
        break;
    }

    $result = $mysqli->query('SELECT posts.id AS id, title, date, categories.name AS category FROM posts JOIN categories ON posts.category_id = categories.id WHERE  categories.name = \''.$name.'\' ORDER BY date DESC LIMIT 5 OFFSET '.$mult.'');

    if($result->num_rows) {

        echo "$name";

        while ($row = mysqli_fetch_assoc($result)){
            $date = date("d.m.Y h:m:s", strtotime($row['date']));

            echo "<li><a class=\"article article_{$row['id']}\" href=\"/PHP_HW10/views/components/articles/?id=$row[id]\">$row[title]...</a><span class=\"data_article\">$date</span></li>";

    }
    }
};

$setPagination = function($data) use ($mysqli)
{
    switch($data){
        case 'politics':
            $name = 'Политика';
        break;
        case 'economics':
            $name = 'Экономика';
        break;
        case 'auto':
            $name = 'Авто';
        break;
        case 'tech':
            $name = 'ИТ-сектор';
        break;
        case 'realestate':
            $name = 'Недвижимость';
        break;
    }

    $result = $mysqli->query('SELECT COUNT(posts.id) AS count  FROM posts JOIN categories ON posts.category_id = categories.id WHERE  categories.name = \''.$name.'\'');

    if($result->num_rows) {
        $row = mysqli_fetch_assoc($result);
        $amounts = ceil($row['count']/5);
        
        if($amounts > 1){
            $nums = '';
            $i = 1;
            while($i <=  $amounts){
                $nums .= "<li><a href=\"/PHP_HW10/views/components/articles/?page=$i&category=$data\">$i</a></li>";
                $i++;
            }

            echo "$nums";
        }
    }
};




