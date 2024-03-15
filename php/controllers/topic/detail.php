<?php

namespace controller\topic\detail;

use db\CommentQuery;
use db\TopicQuery;
use lib\Msg;
use model\TopicModel;

function get()
{

    $topic = new TopicModel;
    // 学習用：ここで、GETメソッド（URLに取る欲しい値が明示してある時は、$_GET配列に同じものが入っている！！！）
    $topic->id = get_param('topic_id', null, false);

    $fetchedTopic = TopicQuery::fetchById($topic);
    $comments = CommentQuery::fetchByTopicId($topic);

    if (!$fetchedTopic) {
        Msg::push(Msg::ERROR, "トピックが見つかりません。");
        redirect('404');
    }


    \view\topic\detail\index($fetchedTopic, $comments);
}
