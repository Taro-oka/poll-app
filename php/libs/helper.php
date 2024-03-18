<?php
function get_param($key, $default_val, $is_post = true)
{
    // 学習用：GETの時は、URLの？以降と同じものがGET配列に入っている！！
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

// 学習用：HTMLのエスケープ関数。テキストエリアなどに、JavaScriptのスクリプトタグなんかを入れられると、データベースにそのままタグが追加され、それを読み込んだ時にそのJavaScriptが実行されてしまう！！ので、↓を使ってHTMLをエスケープしてやる必要がある。
function escape($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $val) {
            $data[$key] = escape($val);
        }
        return $data;
    } else if (is_object($data)) {
        foreach ($data as $key => $val) {
            $data->$key = escape($val);
        }
        return $data;
    } else {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
