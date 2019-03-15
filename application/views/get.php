<p>id는 <?=$id?></p>

<ul>
    <?php
    foreach ($boards as $entry){
        ?>

        <li><a href=""><?= $entry -> board_title ?></a></li>
        <?php
    }
    ?>
</ul>