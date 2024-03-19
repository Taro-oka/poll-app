<?php

namespace view\register;

function index()
{
?>

    <h1 class="sr-only">アカウント登録</h1>
    <div class="mt-5">
        <div class="text-center mb-4">
            <img width="65" src="./images/logo.svg" alt="みんなのアンケート サイトロゴ" />
        </div>
        <div class="login-form bg-white p-4 shadow-sm mx-auto rounded">
            <form class="validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate autocomplete="off">
                <div class="form-group">
                    <label for="id">ユーザーID</label>
                    <input id="id" type="text" name="id" class="form-control validate-target" required tabindex="1" minlength="4" maxlength="10" autofocus />
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="pwd">パスワード</label>
                    <input id="pwd" type="password" name="pwd" class="form-control validate-target" required tabindex="2" minlength="4" pattern="[a-zA-Z0-9]+" />
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="nickname">ニックネーム</label>
                    <input id="nickname" type="text" name="nickname" class="form-control validate-target" required maxlength="10" tabindex="3" />
                    <div class="invalid-feedback"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <a href="<?php echo the_url('login') ?>">ログインへ</a>
                    </div>
                    <div>
                        <input type="submit" class="btn btn-primary shadow-sm" value="登録" />
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php
}
?>