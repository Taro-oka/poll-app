<?php

namespace lib;

use Throwable;

function route($rpath, $method)
{

    try {

        if ($rpath === '') {
            $rpath = 'home';
        }

        $targetFile = SOUECE_BASE . "controllers/{$rpath}.php";
        if (!file_exists($targetFile)) {
            require_once SOUECE_BASE . 'views/404.php';
            return;
        }

        require_once $targetFile;

        // 学習用：getかpostかによって、namespaceと組み合わせて呼び出す関数を切り分けている！（ダブルクオーテーションの関係上、バックスラッシュはエスケープのために2個書いている）
        $rpath = str_replace('/', '\\', $rpath);
        $fn = "\\controller\\{$rpath}\\{$method}";

        $fn();
    } catch (Throwable $E) {
        Msg::push(Msg::DEBUG, $E->getMessage());
        Msg::push(Msg::ERROR, '何かがおかしいようです。。');
        require_once SOUECE_BASE . 'views/404.php';
    }
}
