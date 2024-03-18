<?php

namespace controller\topic\edit;

use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use Throwable;

function get()
{
    Auth::requireLogin();

    $topic = TopicModel::getSessionAndFlush();

    if (!empty($topic)) {
        \view\topic\edit\index($topic, true);
        return;
    }

    $topic = new TopicModel;
    // 学習用：ここで、GETメソッド（URLに取る欲しい値が明示してある時は、$_GET配列に同じものが入っている！！！）
    $topic->id = get_param('topic_id', null, false);

    $user = UserModel::getSession();
    Auth::requirePermission($topic->id, $user);

    $fetchedTopic = TopicQuery::fetchById($topic);

    if (!$fetchedTopic) {
        Msg::push(Msg::ERROR, "トピックが見つかりません。");
        redirect('404');
    }

    \view\topic\edit\index($fetchedTopic, true);
}

function post()
{
    Auth::requireLogin();

    $topic = new TopicModel;
    $topic->id = get_param('topic_id', null);
    $topic->title = get_param('title', null);
    $topic->published = get_param('published', null);

    $user = UserModel::getSession();
    Auth::requirePermission($topic->id, $user);

    try {
        $is_success = TopicQuery::update($topic);
    } catch (Throwable $e) {
        Msg::push(Msg::DEBUG, 'メッセージの更新に失敗しました。' . $e->getMessage());
        $is_success = false;
    }

    if ($is_success) {
        Msg::push(Msg::INFO, 'メッセージの更新に成功しました。');
        redirect('topic/archive');
    } else {
        Msg::push(Msg::ERROR, 'メッセージの更新に失敗しました。');
        TopicModel::setSession($topic);
        redirect(GO_REFERER);
    }
}
