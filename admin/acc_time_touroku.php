<?php
include("../session_start.php");
?>
<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="GroupWare | 経費月別登録";
    include("../common/header.php");
    ?>
<body id="adm_acc_time" class="adm">
    <div class="wrapper">
        <div class="wrapper__bg">
            <div class="wrapper__bg__left"></div>
            <div class="wrapper__bg__right"></div>
        </div>
        <?php
        include("../common/nav_ad.php");
        ?>



        <main>

            <section id="account_touroku">
                    

                <h2></h2>

                
                <div class="row"> 

                    <section class="sec__02">
                        <h3>月別経費登録</h3>
                        <div class="col">
                            <?php if(isset($_SESSION['mail'])):
                            if($_SESSION['type']==3):?> 


                            <form action="acc_time_touroku.php" method="post" class="time__select">
                                <?php
                                date_default_timezone_set('Asia/Tokyo');
                                $year=date("Y");
                                $month=date("m");
                                ?>

                                <dl class="ym__select">
                                    <dt>
                                        <select name="year" id="year">

                                            <?php
                                        
                                            if($_POST["year"]):
                                                switch($_POST["year"]):
                                                    case 0:
                                                    $yy=date('Y');
                                                    break;
                                                    default:
                                                    $yy=date('Y', strtotime('+1 year'));
                                                    break;
                                                endswitch;
                                                for($i=0;$i<2;$i++):
                                                    if($i==$_POST["year"]):
                                                    echo "<option value='",$_POST["year"],"' selected>",$yy,"年</option>";
                                                    else:
                                                        echo "<option value='",$i,"' selected>",$yy,"年</option>";
                                                    endif;
                                                endfor;

                                            else: ?>
                                            <option value="0" selected><?php echo date('Y'),"年"; ?></option>
                                            <option value="1"><?php echo date('Y', strtotime('+1 year')),"年"; ?></option>
                                            <?php
                                            endif;?>
                                        </select>    
                                    </dt>

                                    <dt>
                                        <select name="month" id="month">

                                            <?php
                                            if($_POST["month"]):
                                                for($j=1;$j<=12;$j++):
                                                    if($j==$_POST["month"]):
                                                    echo  "<option value='",$_POST["month"],"' selected>",$_POST["month"],"月</option>";
                                                    else:                        
                                                        echo "<option value='",$j,"'>",$j,"月</option>"; 
                                                    endif; 
                                                endfor; 
                                            else:
                                                for($j=1;$j<=12;$j++):
                                                if($j==$month-1):
                                                echo "<option value='",$j,"' selected>",$j,"月</option>";
                                                else:
                                                echo "<option value='",$j,"'>",$j,"月</option>";     
                                                endif;
                                                endfor;
                                                    
                                            endif;?>
                                        </select>    
                                    </dt>

                                    <dd><input type="submit" id="submit" value="選択"></dd>
                                </dl>

                            </form>
                        


                            <?php
                            $errors=array();


        
                            // フォームから年月を選んだときの処理
                            if($_SERVER["REQUEST_METHOD"]==="POST"):

                            $y=$_POST["year"];
                            switch($y) {
                                case 0:
                                $year=date('Y');
                                break;
                                default:
                                $year=date('Y', strtotime('+1 year'));
                                break;
                            }
                            $month=$_POST["month"];



                            // 年月選択前のデフォルトの年月を取得
                            else:
                                date_default_timezone_set('Asia/Tokyo');
                                $year=date("Y",strtotime(date('Y-m-01')."-1 month"));
                                $month=date("n",strtotime(date('Y-m-01')."-1 month"));
                                //$date=date("date");
                            endif;

                            $lastdate=date("t",strtotime("$year-$month-1")); 
                            $firstday=date("w",strtotime("$year-$month-1"));
                            $firstday=(int)$firstday;
                            $thisdate=1-$firstday;
                            $lastdate=(int)$lastdate;


                            $thdate=1;
                            $cnt=0;





                            echo "<h4>",$year,"年";
                            echo $month,"月</h4>";

                

                            include("../try_catch.php");
                            $stmt=$pdo->prepare("SELECT * FROM `meeting` LEFT OUTER JOIN `room` ON meeting.room=room.room WHERE year=$year and month=$month ORDER BY `date`"); 
                            $stmt->execute();
                            $ymd=array();
                            $atteA=array();
                            $atteName=array();
                            $cnt=0;
                            $cnt1=0;
                            $total=0;
                            echo "<div class='attend__now'>";
                                $nameArr=array();?>
                                <dl class="attend__mem"><dt>【会場使用料】</dt><dd>
                                <?php
                                while($result=$stmt->fetch(PDO::FETCH_ASSOC)):
                                    $attend=$result["attend"];
                                    $hours=$result["hours"];
                                    $place=$result["place"];
                                    $room=$result["room"];
                                    $fee=$result["fee"];
                                    $atteName=explode(",",$result["attend"]);
                                    $times=$result["date"]."日";
                                    foreach($atteName as $value):
                                        if(!in_array($value,$atteA) && !is_numeric($value) && $value!=null):
                                            $atteA[]=$value;
                                            $cnt++;
                                        endif;                    
                                    endforeach;
                                    $ymd[]+=array_push($ymd,$times);
                                    $cnt1++;
                                    include("switch_output_place.php");
                                    echo $times,"⇒",$p,"/",$room,"(@",number_format($fee),"×",$hours,"H＝",number_format($fee*$hours),"円)<br>";
                                    $total+=$fee*$hours;

                                endwhile;

                                $stmt=null;
                                $result=null;
                            
                                ?>
                            
                                計<?php echo number_format($total); ?>円</dd></dl>
                                <dl><dt>【お足代】</dt><dd>@500×<?php echo $cnt1; ?>回＝計<?php echo number_format(500*$cnt1); ?>円</dd></dl>
                                <dl><dt>【当月参加者】</dt><dd>
                                    <?php
                                    $att=array();
                                    foreach($atteA as $v):

                                        echo $v,"／";

                                    endforeach;
                                    ?>計<?php echo $cnt ?>人</dd>
                                </dl>

                                <?php
                                $stmt=null;
                                    ?>
                            </div><!-- attend__now end -->



                
                            <?php
                            if($cnt!==0): ?>
                                <p class="textcenter b pt50 mb20">経費月額負担料は<br><?php
                                $subtotal=($total+(500*$cnt1))/$cnt;
                                $subtotal=ceil($subtotal);
                                echo "(",number_format($total),"+",number_format(500*$cnt1),")÷",$cnt,"人＝",number_format($subtotal); ?></p>
                                <div class="total__amount">
                                <p class="textcenter b">おひとり様
                                    <?php
                                    
                                    echo "<span class='big'>",number_format($subtotal); ?>円</span>です</p></div>

                                <?php    
                                $stmt=$pdo->prepare("SELECT `ym` FROM `account` WHERE `ym`=:ym"); 
                                $yymm=$year.$month;
                                $stmt->bindParam(':ym',$yymm);
                                $stmt->execute();
                                $result=$stmt->fetch();
                                if($result):
                                    echo "<p class='textcenter error_list mt20'>※",$year,"年",$month,"月分は登録済です</p>";
                                else: ?>                            
                                
                                
                                <p class="textcenter pb20">上記の内容でよろしければ「登録」ボタンを押して下さい</p>

                        
                                <form action="acc_month_kanryo.php" method="post">
                                    <input type="hidden" name="ym" value="<?php echo $year.$month; ?>">
                                    <input type="hidden" name="times" value="<?php echo $cnt1; ?>">
                                    <?php $attendM=implode(",",$atteA);
                                    ?>
                                    <input type="hidden" name="attend" value="<?php echo $attendM; ?>">
                                    <input type="hidden" name="amount" value="<?php echo $total; ?>">
                                    <input type="hidden" name="fare" value="<?php echo 500*$cnt1; ?>">
                                    <input type="hidden" name="total_per" value="<?php echo ($total+(500*$cnt1))/$cnt; ?>">
                                    <input type="hidden" name="num" value=<?php echo $cnt; ?>>
                                    <input type="hidden" name="flag" value="1">


                                    <input type="submit" value="登録">
                                </form>
                    
                                <?php
                                endif;
                            else:?>
                            <p class="textcenter b mb20 pt50">金額・人数が確定するまでお待ちください</p>

                            <?php endif; ?>
            
                        </div><!--  col end -->

                    <?php
                    endif;
                    ?>
               
                
                    <?php else:
                    include("admin_chk.php");
                    ?>
                    <?php endif; ?>
                        
                    </section>

                    <?php
                    include("admin_sch_footer.php");
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
    <!-- <script src="../js/calender01.js"></script>    -->
</body>
</html>
