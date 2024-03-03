<?php

namespace lib;

use db\UserQuery;

class Auth
{
    public static function login($id, $pwd)
    {
        $is_success = false;

        $user =  UserQuery::fetchById($id);

        if (!empty($user) && $user->del_flg !== 1) {
            if (password_verify($pwd, $user->pwd)) {
                $is_success = true;
                $_SESSION['user'] = $user;
            } else {
                echo 'パスワードが一致しません';
            }
        } else {
            echo 'ユーザーが見つかりません';
        }

        return $is_success;
    }

    public static function register($id, $pwd, $nickname)
    {
        $is_success = false;

        $user_exists = UserQuery::fetchById($id);

        if (!empty($user_exists)) {
            echo 'ユーザーがすでに存在します';
            return false;
        }

        $is_success = UserQuery::insert($id, $pwd, $nickname);

        return $is_success;
    }
}
