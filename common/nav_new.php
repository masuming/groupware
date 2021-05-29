<header>
    <p class="header__subtitle"><small>サークル・メンバーの情報共有ツール | MM GROUPWARE |</small></p>
    <div class="header__inner">
        <h1><a href="../index.php"><img src="../images/header__logo.svg" alt=""></a></h1>

        <div class="login__box">
            <div id="login">
                <figure class="avatar__icon">
                    <img src="../images/avatar_noimg.png" alt="">
                </figure>


                <p class="pullnav__btn"><i class="fas fa-chevron-down"></i></p>
            </div><!-- login end -->

            <?php
            if(isset($_SESSION['mail'])):
            echo "<p class='login__mail'>",$_SESSION["mail"],"</p>";
            else:
                echo "<p class='login__mail'>ゲスト様</p>";
            
            endif;?>                
            <nav id="pullNav">
                <p class="pullNav__username">
                <?php
                if(isset($_SESSION['mail'])):                
                echo $_SESSION['name'],"様";
                else:
                echo "ゲスト様"; 
                endif; ?>
                </p>
                <ul>
                </ul>                    
            </nav>
        </div><!-- login__box end -->
        <nav id="gnavi">
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="">SCHEDULE</a></li>
                <li><a href="">ACCOUNT</a></li>
                <li><a href="">MEMBERS</a></li>
                <li><a href="">INFO</a></li>
            </ul>
        </nav>
    </div>
</header>