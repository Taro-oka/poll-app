<?php

namespace controller\topic\create;

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

    if (empty($topic)) {
        $topic = new TopicModel();
        $topic->id = -1;
        $topic->title = '';
        $topic->published = 1;
    }


    \view\topic\edit\index($topic, false);
}

function post()
{
    // 学習用：ログインを要求する実装は、しつこく書く！こうしないと、何かしらのツールからPOSTメソッドを呼ばれた時に不正に入られることがある！
    Auth::requireLogin();

    $topic = new TopicModel;
    $topic->id = get_param('topic_id', null);
    $topic->title = get_param('title', null);
    $topic->published = get_param('published', null);

    $user = UserModel::getSession();

    try {
        $is_success = TopicQuery::insert($topic, $user);
    } catch (Throwable $e) {
        Msg::push(Msg::DEBUG, 'メッセージの更新に失敗しました。' . $e->getMessage());
        $is_success = false;
    }

    if ($is_success) {
        Msg::push(Msg::INFO, 'メッセージの登録に成功しました。');
        redirect('topic/archive');
    } else {
        Msg::push(Msg::ERROR, 'メッセージの登録に失敗しました。');
        // 入力した値がおかしい時に、その値をセッションに保持しておく
        TopicModel::setSession($topic);
        // リダイレクト時は、自動的にGETメソッドになる！！
        redirect(GO_REFERER);
    }
}
