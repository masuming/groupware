<?php
include("../session_start.php");
?>

<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="GroupWare | スケジュール";
    include("../common/header.php");
    ?>
<body id="mem_schedule" class="mem">
<div class="wrapper">
    <div class="wrapper__bg">
        <div class="wrapper__bg__left"></div>
        <div class="wrapper__bg__right"></div>
    </div>  
    <?php
    include("../common/nav_mem.php");
    ?>

    <main>

        <section>

        <h2></h2>

        <div class="row">

            <?php
                if(isset($_SESSION['mail'])) :
                    ?>        
            <section class="sec__02">
            

            <h3>スケジュール</h3>


                            
             
            <?php if(isset($_SESSION['mail'])): ?>

                <form action="mem_schedule.php" method="post" class="time__select">
                <?php
                    date_default_timezone_set('Asia/Tokyo');
                    $year=date("Y");
                    $month=date("m");

                    ?>

                    <dl>
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
                        
                endif;



                //カレンダー作成に必要な値の取得
                    $lastdate=date("t",strtotime("$year-$month-1")); 
                    $firstday=date("w",strtotime("$year-$month-1"));
                    $firstday=(int)$firstday;
                    $thisdate=1-$firstday;
                    $lastdate=(int)$lastdate;
                    $thdate=1;
                    $cnt=0;
                    ?>

                    <?php



     ///// 該当月のミーティングがある日にち・時間帯を取得

                        include("../try_catch.php");
                        $stmt=$pdo->prepare("SELECT * FROM `meeting` WHERE year=$year and month=$month");
                        $stmt->execute();                        
                        $meeting=array();
                        $start=array();
                        $startmin=array();
                        $end=array();
                        $endmin=array();
                        $hours=array();
                        $starthr=array();
                        $endhr=array();
                        $tt1=array();
                        $tt2=array();
                        while($result=$stmt->fetch(PDO::FETCH_ASSOC)):
                            $yy=$result["year"];
                            $mm=$result["month"];
                            $dd=$result["date"];
                            $meeting[]+=$dd;
                            $t1=$result["time1"];
                            $t2=$result["time2"];
                            $tt1[]=$t1;
                            $tt2[]=$t2;                            
                            $startmin[]+=substr($t1,-2);
                            $endmin[]+=substr($t2,-2); 
                            if((substr($t1,-2))==30):
                                $t1+=20;
                            endif;
                            if((substr($t2,-2))==30):
                                $t2+=20;                           
                            endif;
                            $t=round(($t2-$t1)/100,2);

                            $hours[]+=$t;
                            $starthr[]+=round(($t1/100),1);
                            $endhr[]+=round(($t2/100),1);
                        endwhile;
//////





//////カレンダー作成
                        echo "<h4>",$year,"年",$month,"月</h4>";
                        echo "<table class='select__calen' style='background-image: url(../images/calen_bg.png),url(../images/m",$month,".png);'><tr><th>日<i class='fas fa-slash'></i>時間</th><th>9:00</th><th>10:00</th><th>11:00</th><th>12:00</th><th>13:00</th><th>14:00</th><th>15:00</th><th>16:00</th><th>17:00</th></tr>";
                        //$day=date("j");

                        while(1):
                            echo "<tr>";
                            include("../admin/switch_week.php");
                            if(in_array($thdate,$meeting)):
                                
                                if($firstday==6):
                                    echo "<th style='color:rgb(16,118,165);' >",$thdate,"日",$week,"</th>";
                                elseif($firstday==0):
                                    echo "<th style='color:rgb(197,62,96);' >",$thdate,"日",$week,"</th>";
                                else:
                                echo "<th>",$thdate,"日",$week,"</th>";
                                endif;   
                                echo "<td class='from_to ",$year,"-",$month,"-",$thdate,"' colspan='9' style='padding-left:calc(((50px * (",$starthr[$cnt]," - 9)) + 22px));'>";
                                echo "<form action='schedule_detail.php?",$year,"-",$month,"-",$thdate,"' method='post' class='sche__on' style='width:calc(",$hours[$cnt]," * 50px);'>";
                                echo "<input type='hidden' name='yy' value='",$year,"'>";
                                echo "<input type='hidden' name='mm' value='",$month,"'>";
                                echo "<input type='hidden' name='dd' value='",$thdate,"'>";
                                echo "<input type='hidden' name='t1' value='",$t1,"'>";
                                echo "<input type='hidden' name='t2' value='",$t2,"'>";
                                echo "<input type='hidden' name='hh' value='",$t,"'>";                             
                                echo "<input type='submit' value='",substr($tt1[$cnt],0,strlen($tt1[$cnt])-2),":",substr($tt1[$cnt],-2,2),"-",substr($tt2[$cnt],0,strlen($tt2[$cnt])-2),":",substr($tt2[$cnt],-2,2),"'>";
                                echo "</form></td></tr>"; 
                                $cnt++;

                            else:
                                if($firstday==6):
                                    echo "<th style='color:rgb(16,118,165);' >",$thdate,"日",$week,"</th><td colspan='9'></td></tr>";
                                elseif($firstday==0):
                                    echo "<th style='color:rgb(197,62,96);' >",$thdate,"日",$week,"</th><td colspan='9'></td></tr>";

                                else:
                                    echo "<th>",$thdate,"日",$week,"</th><td colspan='9'></td></tr>";
                                endif;
                                
                            endif;

                            if($firstday==6):
                                $firstday=0;
                            else:
                                $firstday++;
                            endif;
                                $thdate++;

                    
                            if($thdate>$lastdate):
                            break;
                            endif;
                        
                        endwhile;
                    echo "</table></form>";
                    
                    $timestamp=null;
                    $year=null;
                    $month=null;?>


            <div class="col">
                <p class="stamp__intro">スタンプの説明</p>
                <div class="stamp__inner">
                <dl>
                    <dt><figure><img src="../images/lesson_stamp.png" alt="stamp"></figure></dt>
                    <dd>レッスン</dd>
                </dl>
                </div><!-- stamp__intro end -->
            </div><!-- col end                     -->
        </div><!-- row end -->

        


                

                    <?php else:
                    include("login_chk.php");
                    ?>
                    <?php endif;        
                    //include("admin_mem_footer.php"); 
                    ?>
                        <?php else:
                        include("admin_chk.php");
                        ?>
                        <?php endif; ?>
                </section><!--  sec__02 end      -->
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