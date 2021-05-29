<?php
	session_start();
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-1000);
	}
	session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="GroupWare | Logout";
    include("../common/header.php");
    ?>
    <body id="admin">
    <?php
    include("../common/nav_ad.php");
    ?>

        <div class="wrapper">
            <main>
                <section>
                <h3 class="h3_logout">ログアウトしました</h3>
                <p class="textcenter"><i class="fas fa-arrow-circle-left"></i><a href="../index.php">トップページへ</a></p>
                </section>
            </main>
        <?php
        include("../common/footer.php");
        ?>
        </div><!-- wrapper end -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/pullnav.js"></script>    
    </body>
</html>