<?php

namespace lib;

use db\UserQuery;
use model\UserModel;

class Auth
{
    public static function login($id, $pwd)
    {
        $is_success = false;

        $user =  UserQuery::fetchById($id);

        if (!empty($user) && $user->del_flg !== 1) {
            if (password_verify($pwd, $user->pwd)) {
                $is_success = true;
                UserModel::setSession($user);
            } else {
                echo 'パスワードが一致しません';
            }
        } else {
            echo 'ユーザーが見つかりません';
        }

        return $is_success;
    }

    public static function register($user)
    {
        $is_success = false;

        $user_exists = UserQuery::fetchById($user->id);

        if (!empty($user_exists)) {
            echo 'ユーザーがすでに存在します';
            return false;
        }

        $is_success = UserQuery::insert($user);

        if ($is_success) {
            UserModel::setSession($user);
        }

        return $is_success;
    }

    public static function isLogin()
    {
        $user = UserModel::getSession();

        return isset($user);
    }
}
