<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="MM GroupWare | HOME";
    include("index_header.php");
    ?>
<body id="index">

    <?php
    include("index_nav.php");
    ?>

    <div class="wrapper__bg">
        <div class="wrapper__bg__left"></div>
        <div class="wrapper__bg__right"></div>
    </div>

    <main>
        <form action="index_login.php" method="post">
            <dl>
                <dt>ログインID</dt>
                <dd><input type="email" name="mail"></dd>
                <dt>パスワード</dt>
                <dd><input type="password" name="pass"></dd>
                <dt><input type="submit" value="ログイン"></dt>
            </dl>
        </form>
        <div class="login__help">
            <p><small>はじめてご利用の方</small></p>
        <p><a href="mem/new_mem.php">会員登録する</a></p>
        <p><small><a href=""><i class="far fa-question-circle"></i>ログインIDを忘れた？</a></small></p>
        <p><small><a href=""><i class="fas fa-question-circle"></i>パスワードを忘れた？</a></small></p>
        <p><small><a href="mem/about.php"><i class="far fa-hand-point-up"></i>当サイトについて</a></small></p>
        </div>   

    </main>
        

    <?php
        include("index_footer.php");
    ?>
    </div><!-- wrapper end -->
<script src="js/jquery.min.js"></script>
<script src="js/pullnav.js"></script>   
</body>
</html>