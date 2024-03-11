<?php
function get_param($key, $default_val, $is_post = true)
{
    $array = $is_post ? $_POST : $_GET;
    return $array[$key] ?? $default_val;
}

function redirect($path)
{
    if ($path === GO_HOME) {
        $path = get_url('');
    } else if ($path === GO_REFERER) {
        $path = $_SERVER['HTTP_REFERER'];
    } else {
        $path = get_url($path);
    }

    header("Location: {$path}");
    // 学習用：returnはその関数内で処理をスキップするが、dieを呼ぶと、それ以降のコードの流れが完全にストップする（つまり、実質throw new Errorしたのを同じ結果になる！！！）
    die();
}

function the_url($path)
{
    echo get_url($path);
}
function get_url($path)
{
    return BASE_CONTEXT_PATH . trim($path, '/');
}

function is_alnum($val)
{
    return preg_match("/^[0-9a-zA-Z]+$/", $val);
}
