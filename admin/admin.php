<?php
include("../session_start.php");
?>
<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="GroupWare | 管理画面トップ";
    include("../common/header.php");
    ?>
    <body id="adm" class="adm">
        <div class="wrapper">
            <div class="wrapper__bg">
                <div class="wrapper__bg__left"></div>
                <div class="wrapper__bg__right"></div>
            </div>     
            <?php
            include("../common/nav_ad.php");
            ?>

            <main>
                <section>
            
                <?php
                if(isset($_SESSION['mail'])):
                    if($_SESSION['type']===3): ?>
                        

                    <h2></h2>
                    <div class="row">
                        <div class="col">
                        <h3>会員情報</h3>    
                            <nav id="admin__mem" class="btn_double">
                            <ul>
                                <li><a href="member.php">メンバー登録</a></li>
                                <li><a href="member_list.php">メンバー一覧</a></li>
                                <li><a href="">登録情報変更</a></li>
                                <li><a href="">退会処理</a></li>
                            </ul>
                            </nav>
                        </div> 

                        <div class="col">      
                        <h3>レッスン情報</h3>
                        <nav id="admin__lesson" class="btn_double">
                            <ul>
                                <li><a href="meeting_touroku.php">授業登録</a></li>
                                <li><a href="meeting_attend.php">出席登録</a></li>
                                <li><a href="meeting_henkou.php">授業変更</a></li>
                                <li><a href="">授業削除</a></li>
                            </ul>
                            </nav>
                        </div>

                        <div class="col">      
                        <h3>活動室情報</h3>
                        <nav id="admin__lesson" class="btn_double">
                            <ul>
                                <li><a href="room_touroku.php">活動室登録</a></li>
                                <li><a href="">活動室一覧</a></li>
                                <li><a href="">活動室情報変更</a></li>
                                <li><a href="">活動室情報削除</a></li>
                            </ul>
                            </nav>
                        </div>

                        <div class="col">
                        <h3>会計情報</h3>
                        <nav id="admin__fee" class="btn_double">
                            <ul>
                                <li><a href="acc_item_touroku.php">費目登録</a></li>
                                <li><a href="acc_time_touroku.php">月別経費登録</a></li>
                                <li><a href="">経費一覧（月別）</a></li>
                                <li><a href="acc_mem_touroku.php">経費一覧（人別）</a></li>
                            </ul>
                        </nav>
                        </div>

                        <?php
                        else:
                        @include("admin_chk.php");
                        endif;?>
                    <?php
                    else:
                    @include("session_chk.php");

                    endif; // if(count($errors)): end
                    ?>
   


                    </div><!-- row end -->

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