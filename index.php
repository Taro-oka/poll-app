<?php

require_once 'config.php';

require_once SOUECE_BASE . 'partials/header.php';

// 学習用：root pathという意味合いでよく用いられる変数名である。
$rpath = str_replace(BASE_CONTEXT_PATH, '', $_SERVER['REQUEST_URI']);

// 学習用：デフォルトではGETが返ってくる。サイトのリロードなどのリクエストも基本GET
$method = strtolower($_SERVER['REQUEST_METHOD']);


route($rpath, $method);
function route($rpath, $method)
{
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
    $fn = "\\controller\\{$rpath}\\{$method}";

    $fn();
}

require_once SOUECE_BASE . 'partials/footer.php';
