<header>
    <p class="header__subtitle"><small>サークル・メンバーの情報共有ツール | MM GROUPWARE |</small></p>   
    <div class="header__inner">
        <h1><a href="../index.php"><img src="../images/header__logo.svg" alt=""></a></h1>
        <nav id="gnav">
            <ul>
                <li><a href="../mem/index.php" title="home"></a></li>
                <li><a href="../mem/mem_post_list.php" title="posts"></a></li>
                <li><a href="../mem/mem_schedule.php" title="schedule"></a></li>
                <li><a href="../mem/mem_add_list.php" title="address"></a></li>
                <li><a href="../mem/mem_acc.php" title="accout"></a></li>
                <li><a href="../mem/mypage.php" title="mypage"></a></li>
                <?php
                if(isset($_SESSION["mail"]) && $_SESSION["type"]===3):?>
                <li><a href="admin.php" title="admin"></a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="login__box">
            <div id="login">
                <figure class="avatar__icon">
                    <?php
                    if(isset($_SESSION['avatar'])):?> 
                    <img src="<?php echo $_SESSION['avatar']; ?>" alt="">

                    <?php else: ?>
                    <img src="../images/avatar_noimg.png" alt="">
                    <?php endif; ?>
                </figure>

                <p class="pullnav__btn"><i class="fas fa-chevron-down"></i></p>            
            </div><!-- login end -->
            <?php
            if(isset($_SESSION['mail'])):
            echo "<p class='login__mail'>",$_SESSION["mail"],"</p>";
            
            endif;?>
            <nav id="pullNav">
                <p class="pullNav__username">
                <?php
                if(isset($_SESSION['name'])):            
                echo $_SESSION['name']," 様"; 
                else:
                echo "ゲスト様"; 
                endif; ?>
                </p>
                <ul>
                    <li><a href="admin_log.php">管理画面トップ</a></li>
                        <li><a href="member.php">メンバー登録</a></li>
                        <li><a href="member_list.php">メンバー一覧</a></li>                    
                        <li><a href="admin_logout.php">ログアウト</a></li>
                </ul>
                <i class="fas fa-times textcenter close"></i>
            </nav>
        </div><!-- login__box end -->

        <nav id="gnavi">
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="calendar.php">SCHEDULE</a></li>
                <li><a href="">ACCOUNT</a></li>
                <li><a href="">MEMBERS</a></li>
                <li><a href="">INFO</a></li>
            </ul>
        </nav>
    </div>
</header>