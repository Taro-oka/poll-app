<?php

namespace controller\topic\archive;

use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\UserModel;

function get()
{
    // 学習用：仮に、リンクをどこからも飛ばしていなくても、URLを直接打ち込まれると表示ができてしまう。そのため、リンクの構成上訪問されることがないページでも、こうやって、サーバー上でリジェクトする実装は必要！！
    Auth::requireLogin();

    $user = UserModel::getSession();
    $topics = TopicQuery::fetchByUserId($user);

    if ($topics === false) {
        Msg::push(Msg::ERROR, "ログインしてください。");
        redirect('login');
    }

    if (count($topics) > 0) {
        \view\topic\archive\index($topics);
    } else {
        echo '<div class="alert alert-primary">トピックを投稿してみよう！</div>';
    }
}
