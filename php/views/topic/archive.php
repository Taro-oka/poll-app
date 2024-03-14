<?php

namespace view\topic\archive;

function index($topics)
{
?>

    <h1 class="h2 mb-3">過去の投稿</h1>
    <ul class="container">
        <?php
        foreach ($topics as $topic) {
            \partials\topic_list_item($topic);
        }
        ?>
    </ul>

<?php
}
?>