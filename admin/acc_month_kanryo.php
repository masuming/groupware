<?php
include("../session_start.php");
?>

<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="GroupWare | 月別経費登録完了";
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

<?php if($_SERVER["REQUEST_METHOD"]==="POST"):
        include("../try_catch.php");
        $ym = $_POST['ym'];
        $times = $_POST['times'];
        $attend = $_POST['attend'];
        $amount = $_POST['amount'];
        $fare = $_POST['fare'];
        $total_per = $_POST['total_per'];
        $flag = $_POST['flag'];
        $num = $_POST['num'];

        $stmt=$pdo->prepare("INSERT INTO `account`(`ym`,`times`,`attend`,`amount`,`fare`,`total_per`,`flag`) VALUES (:ym,:times,:attend,:amount,:fare,:total_per,:flag)");
        $stmt->bindParam(':ym',$ym);
        $stmt->bindParam(':times',$times);
        $stmt->bindParam(':attend',$attend);
        $stmt->bindParam(':amount',$amount);
        $stmt->bindParam(':fare',$fare);
        $stmt->bindParam(':total_per',$total_per);
        $stmt->bindParam(':flag',$flag);
        $stmt->execute();
        $stmt=null;

    $pdo=null;

else:?>
    <h3>月別経費登録結果</h3>
    <h4>入力情報がありません</h4>
    <p class="textcenter error_list"><i class="fas fa-exclamation-triangle"></i>登録画面から入力してください</p>
    <div class="buttons">
        <p class="button"><a href="acc_time_touroku.php">登録画面に行く</a></p>
        <p class="button"><a href="admin.php">管理画面トップ</a></p>
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

            <h3>月別経費登録結果</h3>

                <h4>以下内容で登録いたしました</h4>


                <dl>
                <dt>対象年月</dt>
                <dd>
                <?php
                    echo substr($ym,0,4),"年",substr($ym,4),"月分";
                ?></dd>
                </dl>

                <dl>
                    <dt>レッスン回数</dt>
                    <dd><?php echo $times,"回"; ?></dd>
                </dl>

                <dl>
                <dt>対象者</dt>
                <dd><?php
                $mem=explode(",",$attend);
                foreach($mem as $m):
                if(is_string($m)):
                echo $m,"／";
                endif;
                endforeach;
                echo $num,"人";
                ?>
                </dd>
                </dl>

                <dl>
                <dt>月額負担料</dt>
                <dd><?php echo "{",number_format($amount),"(教室使用料)＋",number_format($fare),"(お足代)}÷",$num,"人(月間参加数)＝",number_format(($amount+$fare)/$num),"円";?></dd>
                </dl>




                <div class="buttons">
                <p class="button"><a href="acc_time_touroku.php">続けて登録</a></p>
                <p class="button"><a href="admin.php">管理ページトップ</a></p>
                </div>

                </section>
                <?php
             include("admin_acc_footer.php");
             ?> 
            </div>


        </section>



        
           
            
    </main>
        
</div>        
<?php
    include("../common/footer.php");
?>
    </div><!-- wrapper end -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/pullnav.js"></script>   
</body>
</html>
