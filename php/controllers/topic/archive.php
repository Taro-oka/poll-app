<?php

namespace controller\topic\archive;

use db\TopicQuery;
use lib\Auth;
use model\UserModel;

function get()
{
    // 学習用：仮に、リンクをどこからも飛ばしていなくても、URLを直接打ち込まれると表示ができてしまう。そのため、リンクの構成上訪問されることがないページでも、こうやって、サーバー上でリジェクトする実装は必要！！
    Auth::requireLogin();

    $user = UserModel::getSession();
    $topics = TopicQuery::fetchByUserId($user);

    \view\topic\archive\index($topics);
}
