<?php

namespace view\home;

function index($topics)
{
    // 学習用：array_shiftを使うと、一番目を取り出し、且つ、引数に渡す配列から先頭を削除してくれる！！！！JavaScriptのshiftと同じである。
    $topic = escape($topics);
    $topic = array_shift($topics);
    \partials\topic_header_item($topic, true);
?>

    <h1 class="h2 mb-3">過去の投稿</h1>
    <ul class="container">
        <?php
        foreach ($topics as $topic) {
            $url = get_url('topic/detail?topic_id=' . $topic->id);
            \partials\topic_list_item($topic, $url, false);
        }
        ?>
    </ul>

<?php
}
?>