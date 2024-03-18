<?php

namespace controller\topic\detail;

use db\CommentQuery;
use db\DataSource;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\CommentModel;
use model\TopicModel;
use model\UserModel;
use Throwable;

function get()
{

    $topic = new TopicModel;
    // 学習用：ここで、GETメソッド（URLに取る欲しい値が明示してある時は、$_GET配列に同じものが入っている！！！）
    $topic->id = get_param('topic_id', null, false);

    // 学習用：閲覧された時にカウントを増やす実装は、getメソッドが呼ばれた時の呼べば良い！！！！
    TopicQuery::incrementViewCount($topic);

    $fetchedTopic = TopicQuery::fetchById($topic);
    $comments = CommentQuery::fetchByTopicId($topic);

    if (empty($fetchedTopic) || !$fetchedTopic->published) {
        Msg::push(Msg::ERROR, "トピックが見つかりません。");
        redirect('404');
    }


    \view\topic\detail\index($fetchedTopic, $comments);
}

function post()
{
    Auth::requireLogin();

    $comment = new CommentModel;
    $comment->topic_id = get_param('topic_id', null);
    $comment->body = get_param('body', null);
    $comment->agree = get_param('agree', null);

    $user = UserModel::getSession();
    $comment->user_id = $user->id;

    try {
        $db = new DataSource;

        // 学習用：今回は、コメントの追加、トピックに対する賛成反対、という２つのテーブルに対して処理を行う。
        // したがって、データベースを扱う際には、transactionを行って、エラー時には、更新しようとした時より前の状態に初期化するためのセーフティーネットを用意しておかなければならない！！！

        $db->begin();

        $is_success = TopicQuery::incrementLikesOrDislikes($comment);
        if ($is_success && !empty($comment->body)) {
            $is_success = CommentQuery::insert($comment);
        }
    } catch (Throwable $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
        $is_success = false;
    } finally {
        if ($is_success) {
            $db->commit();
            Msg::push(Msg::INFO, 'コメントの登録に成功しました。');
        } else {
            Msg::push(Msg::ERROR, 'コメントの登録に失敗しました。');
            $db->rollback();
        }
    }

    redirect('topic/detail?topic_id=' . $comment->topic_id);
}
