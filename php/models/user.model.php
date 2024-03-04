<?php

namespace model;

class UserModel extends Abstract_model
{
    public string $id;
    public string $pwd;
    public string $nickname;
    public int $del_flg;

    //学習用： アンダースコアをつけているのは、外部から触る値でないことを、明示するため！
    protected static $SESSION_NAME = '_user';
}
