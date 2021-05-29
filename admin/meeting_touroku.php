<?php
include("../session_start.php");
?>
<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="GroupWare | 会議登録";
    include("../common/header.php");
    ?>
<body id="adm_meeting" class="adm">
<div class="wrapper">
<div class="wrapper__bg">
        <div class="wrapper__bg__left"></div>
        <div class="wrapper__bg__right"></div>
    </div>
<?php
    include("../common/nav_ad.php");
    ?>



    <main>

        <section id="lesson_touroku">
                

            <h2></h2>

            
            <div class="row"> 

            <section class="sec__02">
<h3>レッスンの登録</h3>

            <div class="col">       
                
                


                
            <?php if(isset($_SESSION['mail']) && $_SESSION['type']==3): ?>
                <p class="textcenter mb20">入力月を選択してください</p>
                <form action="meeting_touroku.php" method="post">
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
                                    echo "<option value='",$i,"' selected>",$yy,"年</option>";
                                    elseif($i<$_POST["year"]):
                                        echo "<option value='",$i,"'>",$yy-$_POST["year"],"年</option>";
                                    else:
                                        echo "<option value='",$i,"'>",$_POST["year"]-$yy,"年</option>";
                                    endif;
                            endfor;

                        else: ?>
                        <option value="0" selected><?php echo date('Y'),"年"; ?></option>
                        <option value="1"><?php echo date('Y', strtotime('+1 year')),"年"; ?></option>
                        <?php

                     endif;
                        ?>
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
                        if($j==$month):
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
                </div><!-- col end -->

            <div id="col__calender">
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
                        $year=date("Y");
                        $month=date("n");
                        //$date=date("date");
                    endif;

                        $day=date("j");
                        $lastdate=date("t",strtotime("$year-$month-1")); 
                        $firstday=date("w",strtotime("$year-$month-1"));
                        $firstday=(int)$firstday;
                        $thisdate=1-$firstday;
                        $lastdate=(int)$lastdate;
                        $day=date("day");
                        



                        echo "<h4>",$year,"年";
                        echo $month,"月</h4>";

                       
                        echo "<table class='select__calen'><tr><th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th></tr>";

                        include("../try_catch.php");
                        $stmt=$pdo->prepare("SELECT * FROM `meeting` WHERE year=$year and month=$month");
                        $stmt->execute();
                        $ymd=array();
                        while($result=$stmt->fetch(PDO::FETCH_ASSOC)):
                            $yY=$result["year"];
                            $mM=$result["month"];
                            $dD=$result["date"];
                            $ymd[]+=$yY.$mM.$dD;
                        endwhile;
                        


                        while(1):
                            echo "<tr>";
                            
                            for($j=0;$j<7;$j++):
                                $thisymd=$year.$month.$thisdate;
                                if($thisdate<1 || $thisdate>$lastdate):
                                    echo "<td></td>";
                                elseif(in_array($thisymd,$ymd)):
                                        echo "<td class='sche__input have'><form action='meeting_input.php?$year-$month-$thisdate' method='post'><input type='hidden' name='yy' value='$year'><input type='hidden' name='mm' value='$month'><input type='hidden' name='dd' value='$thisdate'><input type='submit' value='$thisdate'></form></td>";

                                else:
                                    echo "<td class='sche__input'><form action='meeting_input.php?$year-$month-$thisdate' method='post'><input type='hidden' name='yy' value='$year'><input type='hidden' name='mm' value='$month'><input type='hidden' name='dd' value='$thisdate'><input type='submit' value='$thisdate'></form></td>";
                                    
                                endif;
                                $thisdate++;
                            endfor;
                            echo "</tr>";
                            if($thisdate>$lastdate):
                                break;
                            endif;
                           



                        endwhile;
                        echo "</table></form>";
                        echo "<p class='textcenter'>カレンダーの日付をクリックして入力画面に進んでください</p>";

            


                    




                    ?>
            </div>


               
                
                <?php else:
                include("admin_chk.php");
                ?>
                <?php endif; ?>
                
                
                


                    
                </section>
            <?php
             include("admin_sch_footer.php");
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
    <!-- <script src="../js/calender01.js"></script>    -->
</body>
</html>
