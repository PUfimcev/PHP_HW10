<?php
require_once './../../header.php';

require_once './../../../kernel/backend/getdata.php';

?>

<div class="container">
    <div class="wrap">
        
        <div class="wrap_articles">
            <h2>Публикации</h2>
            <div class="list_categories">
                <ul><?php $getCategories() ?></ul>
            </div>
            <div class="list_articles">
                <?php 

                if(!isset($_GET['id']) && !isset($_GET['category'])) {
                    echo '<ul>';
                    $getLastPosts();
                    echo '</ul>';
                } elseif(!empty($_GET['id']) && is_numeric($_GET['id'])) {
                    $data['id'] = $_GET['id'] ?? null;
                    $getArticl( $data['id']);
                } elseif(!empty($_GET['category']) && !isset($_GET['page'])){
                    $data['category'] = $_GET['category'] ?? null;
                    
                    echo '<ul>';
                    $getCategory($data['category']);
                    echo '</ul>';
                    echo '<div class="list_pagination"><ul>';
                    $setPagination($data['category']);
                    echo '</ul></div>';
                } elseif(!empty($_GET['category']) && !empty($_GET['page'])){

                    $data['category'] = $_GET['category'] ?? null;
                    $data['page'] = $_GET['page'] ?? null;
                    echo '<ul>';
                    $getCategory($data['category'], $data['page']);
                    echo '</ul>';
                    echo '<div class="list_pagination"><ul>';
                    $setPagination($data['category']);
                    echo '</ul></div>';
                }?>
            </div>
        </div>
    </div>

</div>







<?php require_once './../../footer.php'; ?>