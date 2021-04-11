<?php
include("try_catch.php");
?>
<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="MM GroupWare | LOGIN";
    include("index_header.php");
    ?>
<body id="index" class="index_login">

    <?php
    include("index_nav.php");
    ?>

<div class="wrapper__bg">
        <div class="wrapper__bg__left"></div>
        <div class="wrapper__bg__right"></div>
    </div>
        <main>
            <div class="row">
            <section>
<?php
        if($_SERVER["REQUEST_METHOD"]==="POST"):
            $stmt=$pdo->prepare("SELECT * FROM `member` WHERE `mail`=:mail");
            $stmt->bindParam(":mail",$_POST["mail"]);
            $stmt->execute();
            $result=$stmt->fetch();
            if($result):
                if(password_verify($_POST["pass"],$result["pass"])):
                session_start();
                session_regenerate_id(true);
				$_SESSION['mail']=$_POST["mail"];
				$_SESSION['pass']=$_POST["pass"];
                $_SESSION['name']=$result["name"];
                $_SESSION['pinyin']=$result["pinyin"];
				$_SESSION['type']=$result["type"];
                $_SESSION['service']=$result["service"];
                $_SESSION['avatar']=$result["avatar"];
                header("Location: http://".$_SERVER['HTTP_HOST']."/groupware/mem/index.php");
                else:
                    $errors="パスワードが違います";
                endif;
            else:
                $errors="ユーザーが存在しません";
            endif;
            $stmt=null;

            if(isset($errors)):
                echo "<h2>ログイン情報</h2>";
                echo "<h3 class='err'>※ログインに失敗しました</h3>";
                echo "<p class='textcenter error_list'><i class='fas fa-exclamation-triangle'></i>",$errors," </p>";?>
                <div class="buttons">
                        <p class="button"><a href="index.php">ログイン画面に戻る</a></p>

                </div><!-- buttons end         -->

            <?php endif; 

        else:
            die("ログイン画面からログインしてください");
        endif;
        $pdo=null;

        ?>
<!-- <form action="index_login.php" method="post">
    <dl>
        <dt>ログインID</dt>
        <dd><input type="email" name="mail"></dd>
        <dt>パスワード</dt>
        <dd><input type="pass" name="pass"></dd>
        <dt><input type="submit" vale="ログイン"></dt>
    </dl>
</form> -->

                   
        </section>
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