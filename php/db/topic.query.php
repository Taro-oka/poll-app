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
        $sql = 'select * from topics where user_id = :id and del_flg != 1 order by id desc';
        $result = $db->select($sql, [
            ':id' => $user->id
        ], DataSource::CLS, TopicModel::class);

        return $result;
    }
    public static function fetchPublishedTopics()
    {
        $db = new DataSource;
        $sql = '
        select t.*, u.nickname from pollapp.topics t 
        inner join pollapp.users u 
        on t.user_id = u.id 
        where t.del_flg != 1 and u.del_flg != 1 and t.published = 1
        order by t.id desc;
        ';
        $result = $db->select($sql, [], DataSource::CLS, TopicModel::class);

        return $result;
    }

    public static function fetchById($topic)
    {
        if (!$topic->isValidId()) {
            return false;
        }
        $db = new DataSource;
        $sql = '
        select t.*, u.nickname from pollapp.topics t 
        inner join pollapp.users u 
        on t.user_id = u.id 
        where t.id = :id and t.del_flg != 1 and u.del_flg != 1 and t.published = 1
        order by t.id desc;
        ';
        $result = $db->selectOne($sql, [
            ':id' => $topic->id
        ], DataSource::CLS, TopicModel::class);

        return $result;
    }

    public static function incrementViewCount($topic)
    {
        if (!$topic->isValidId()) {
            return false;
        }
        $db = new DataSource;
        $sql = 'update topics set views = views + 1 where id = :id;';

        return $db->execute($sql, [
            ':id' => $topic->id
        ]);
    }
}
