<?php

namespace db;

use db\DataSource;
use model\TopicModel;

class TopicQuery
{
    public static function fetchByUserId($user)
    {
        if (!$user->isValidId()) {
            return false;
        }

        $db = new DataSource;
        $sql = 'select * from topics where user_id = :id and del_flg != 1';
        $result = $db->select($sql, [
            ':id' => $user->id
        ], DataSource::CLS, TopicModel::class);

        return $result;
    }

    // public static function insert($user)
    // {
    //     $db = new DataSource;
    //     $sql = "INSERT INTO users (id, pwd, nickname) VALUES (:id, :pwd, :nickname)";

    //     // ここでハッシュ化を行う！！デフォルトではbcrypt。
    //     $pwd = password_hash($user->pwd, PASSWORD_DEFAULT);

    //     return $db->execute($sql, [
    //         ':id' => $user->id,
    //         ':pwd' => $pwd,
    //         ':nickname' => $user->nickname
    //     ]);
    // }
}
