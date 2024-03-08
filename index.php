<?php

require_once 'config.php';

// Library
require_once SOUECE_BASE . 'libs/helper.php';
require_once SOUECE_BASE . 'libs/auth.php';
// 学習用：↓のように、route関数のありかを指定しても、うまくいかない。なぜなら、route関数は、libという名前空間に属すので、グローバルになっていない！！なので、下で名前空間をuse functionしてやる必要がある。
require_once SOUECE_BASE . 'libs/router.php';

// Model
require_once SOUECE_BASE . 'models/abstract.model.php';
require_once SOUECE_BASE . 'models/user.model.php';

// Message
require_once SOUECE_BASE . 'libs/message.php';

// DB
require_once SOUECE_BASE . 'db/datasource.php';
require_once SOUECE_BASE . 'db/user.query.php';

// 学習用：PHPのuseは、use 名前空間\XXXX と書くと、勝手にXXXXをクラスだと認識する。なので、名前空間内の関数をuseしたい場合は、use function 名前空間\関数名
// というように、関数であることを明示する必要がある！！
use function lib\route;

// 学習用：sessionスタートは、Modelを読みこんだ後にしないといけない！
session_start();

try {
    require_once SOUECE_BASE . 'partials/header.php';

    // 学習用：root pathという意味合いでよく用いられる変数名である。
    $rpath = str_replace(BASE_CONTEXT_PATH, '', CURRENT_URI);

    // 学習用：デフォルトではGETが返ってくる。サイトのリロードなどのリクエストも基本GET
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    route($rpath, $method);

    require_once SOUECE_BASE . 'partials/footer.php';
} catch (Throwable $e) {
    die('<h1>何かがすごくおかしいようです。</h1>');
}
