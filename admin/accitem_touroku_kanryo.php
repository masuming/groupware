<?php
include("../session_start.php");
?>

<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="GroupWare | 費目登録完了";
    include("../common/header.php");
    ?>
    <body id="adm_item" class="adm">
        <div class="wrapper">    
            <?php
            include("../common/nav_ad.php");

            ?>
            <div class="wrapper__bg">
                <div class="wrapper__bg__left"></div>
                <div class="wrapper__bg__right"></div>
            </div>

            <main>

                <section id="adm__mem">
                    <h2></h2>
                    <div class="row">
                        <section class="sec__02">

                        <?php
                        if($_SERVER["REQUEST_METHOD"]==="POST"):
                            include("../try_catch.php");
                            $type = $_POST['type'];
                            $item = $_POST['item'];
                            $unit = $_POST['unit'];
                            $value = $_POST['value'];
                            $calc = $_POST['calc'];

                            $stmt=$pdo->prepare("INSERT INTO `items`(`type`,`item`,`unit`,`value`,`calc`) VALUES (:type,:item,:unit,:value,:calc)");
                            $stmt->bindParam(':type',$type);
                            $stmt->bindParam(':item',$item);
                            $stmt->bindParam(':unit',$unit);
                            $stmt->bindParam(':value',$value);
                            $stmt->bindParam(':calc',$calc);
                            $stmt->execute();
                            $stmt=null;

                            $pdo=null;

                        else:?>
                            <h3>費目情報登録結果</h3>
                            <h4>経費費目の入力情報がありません</h4>
                            <p class="textcenter error_list"><i class="fas fa-exclamation-triangle"></i>登録画面から入力してください</p>
                            <div class="buttons">
                                <p class="button"><a href="acc_item_touroku.php">登録画面に行く</a></p>
                                <p class="button"><a href="admin.php">管理画面トップ</a></p>
                            </div>
                        </section>
                    </div> 
                </section>       
            
            </main>
                
            <?php
            include("../footer.php");
            ?>
            </div><!-- wrapper end -->
            <script src="../js/jquery.min.js"></script>
            <script src="../js/pullnav.js"></script> 
            <?php die();
            endif;
            ?>

                            <h3>経費費目登録結果</h3>
                            <h4>以下内容で登録いたしました</h4>

                            <dl>
                            <dt>項目</dt>
                            <dd>
                            <?php                    
                                @include("switch_output_itemtype.php");
                                echo "$t";
                            ?></dd>
                            </dl>

                            <dl>
                            <dt>費目名</dt>
                            <dd><?php echo $item;?></dd>
                            </dl>

                            <dl>
                            <dt>単価／単位</dt>
                            <?php include("switch_output_itemunit.php"); ?>
                            <dd><?php echo number_format($value),"円／",$u;?></dd>
                            </dl>

                            <dl>
                            <dt>個人負担率</dt>
                            <?php include("switch_output_itemcalc.php"); ?>
                            <dd><?php echo $c;?></dd>
                            </dl>



                            <div class="buttons">
                            <p class="button"><a href="acc_item_touroku.php">続けて登録</a></p>
                            <p class="button"><a href="admin.php">管理ページトップ</a></p>
                            </div>

                        </section>
                    <?php
                    include("admin_acc_footer.php");
                    ?> 
                    </div>


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
