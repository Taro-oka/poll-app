<?php

namespace model;

class CommentModel extends Abstract_model
{

    public int $id;
    public int $topic_id;
    public int $agree;
    public string $body;
    public string $user_id;
    public string $nickname;
    public int $del_flg;

    protected static $SESSION_NAME = '_comment';
}
