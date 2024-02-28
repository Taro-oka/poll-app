<?php
// 学習用：PHPでは、名前空間を指定しないと、勝手にグローバルな関数になってしまう！！なお、controller\loginという名前は別になんでも良いっちゃ良い。
namespace controller\login;

use lib\Auth;

function get()
{
    require_once SOUECE_BASE . 'views/login.php';
}

function post()
{
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    if (Auth::login($id, $pwd)) {
        echo '認証成功';
    } else {
        echo '認証失敗';
    }
}
