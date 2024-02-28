    <h1>ログインページです</h1>
    <!-- <img src="<?php echo BASE_IMAGE_PATH ?>logo.svg" alt=""> -->
    <form action="<?php echo CURRENT_URI; ?>" method="POST">
        <div>
            id: <input type="text" name="id">
        </div>
        <div>
            pw: <input type="password" name="pwd">
        </div>
        <div>
            <input type="submit" value="ログイン">
        </div>
    </form>