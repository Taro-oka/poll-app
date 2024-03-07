<?php

namespace model;

use Error;

//学習用メモ： abstractと、先頭につけることで、継承しないと使えないようになる！！
abstract class Abstract_model
{
    protected static $SESSION_NAME = null;
    public static function setSession($val)
    {
        // 学習用：このように、エラーを出すことで、継承先で、強制的に、この値を変更させるよにする！（ユーザーのためというより、開発者向けの実装）
        if (empty(static::$SESSION_NAME)) {
            throw new Error('$SESSION_NAMEを設定して下さい');
        }
        $_SESSION[static::$SESSION_NAME] = $val;
    }

    public static function getSession()
    {
        return $_SESSION[static::$SESSION_NAME] ?? null;
    }

    public static function clearSession()
    {
        static::setSession(null);
    }

    public static function getSessionAndFlush()
    {
        try {
            return static::getSession();
        } finally {
            static::clearSession();
        }
    }
}
