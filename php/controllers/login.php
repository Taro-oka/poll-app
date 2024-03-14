<?php
// 学習用：PHPでは、名前空間を指定しないと、勝手にグローバルな関数になってしまう！！なお、controller\loginという名前は別になんでも良いっちゃ良い。
namespace controller\login;

use lib\Auth;
use lib\Msg;
use model\UserModel;


function get()
{
    \view\login\index();
}

function post()
{
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    if (Auth::login($id, $pwd)) {
        $user = UserModel::getSession();
        Msg::push(Msg::INFO, "{$user->nickname}さん、ようこそ");
        redirect(GO_HOME);
    } else {
        redirect(GO_REFERER);
    }
}
