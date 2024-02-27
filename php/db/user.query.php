<?php

namespace db;

use db\DataSource;
use model\UserModel;

class UserQuery
{
    public static function fetchById($id)
    {
        $db = new DataSource;
        $sql = 'select * from users where id = :id';
        $result = $db->selectOne($sql, [
            ':id' => $id
        ], DataSource::CLS, UserModel::class);
        // 学習用：Datasource::CLSは、Datasourceクラス内で定数（const）として定義されているものを参照するダブルコロン
        // UserModel::classとは、UserModelクラスを名前空間を含んだ名前を返す！クラスがどの名前空間に属しているか、またはそのクラスへの参照がどこで必要とされているかという情報を明確にするために有用です。

        return $result;
    }
}
