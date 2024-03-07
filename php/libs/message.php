<?php

namespace lib;

use model\Abstract_model;

class Msg extends Abstract_model
{
    protected static $SESSION_NAME = '_msg';
    public const ERROR = 'error';
    public const INFO = 'info';
    public const DEBUG = 'debug';
    public static function push($type, $msg)
    {
        if (!is_array(static::getSession())) {
            static::init();
        }

        $msgs = static::getSession();
        // 学習用：PHPでは、配列の末尾に要素を入れる時、↓の様に書く！ 配列[]とするだけで、配列[count(配列)]と同じ意味になる！
        $msgs[$type][] = $msg;
        static::setSession($msgs);
    }

    public static function flush()
    {
        $msgs_with_type = static::getSessionAndFlush() ?? [];

        foreach ($msgs_with_type as $type => $msgs) {
            if ($type === static::DEBUG && !DEBUG) {
                continue;
            }

            foreach ($msgs as $msg) {
                echo "<div>{$type}:{$msg}</div>";
            }
        }
    }

    private static function init()
    {
        static::setSession([
            static::ERROR => [],
            static::INFO => [],
            static::DEBUG => []
        ]);
    }
}
