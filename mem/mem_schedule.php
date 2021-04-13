<?php
include("../session_start.php");
include("../try_catch.php");
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


              
                
                <?php
                    date_default_timezone_set('Asia/Tokyo');
                    $year=date("Y");
                    $month=date("n");
                    $date=date("date");
                    $day=date("day");

                    ?>                
            <?php if(isset($_SESSION['mail']) && $_SESSION['type']==3): ?>




                <!-- <div id="col__calender"> -->
                    <?php
                    $errors=array();

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
                        $m=$_POST["month"];

                        $day=date("j");
                        $lastdate=date("t",strtotime("$year-$m-1")); 
                        $firstday=date("w",strtotime("$year-$m-1"));
                        $firstday=(int)$firstday;
                        $thisdate=1-$firstday;
                        $lastdate=(int)$lastdate;


                        echo "<h4>",$year,"年";
                        echo $month,"月</h4>"; ?>
                        


                        <div class="col">    
                            <?php                    
                        echo "<table class='select__calen'><tr><th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th></tr>";

                        while(1):
                            echo "<tr>";
                            for($j=0;$j<7;$j++):
                                if($thisdate<1 || $thisdate>$lastdate):
                                    echo "<td></td>";
                                else:
                                    echo "<td class='sche__input'><form action='schedule_detail.php?$year-$m-$thisdate' method='post'><input type='hidden' name='yy' value='$year'><input type='hidden' name='mm' value='$m'><input type='hidden' name='dd' value='$thisdate'><input type='submit' value='$thisdate'></form></td>";
                                    
                                endif;
                                $thisdate++;
                            endfor;
                            echo "</tr>";
                            if($thisdate>$lastdate):
                                break;
                            endif;
                           



                        endwhile;
                        echo "</table></form>";


///////////////////// 【1】defaultのカレンダー///////////////////// 
                    else:


////// 【1/2】ミーティングのある年月日を取得
                        include("../try_catch.php");
                        $stmt=$pdo->prepare("SELECT * FROM `meeting` WHERE year=$year and month=$month");
                        $stmt->execute();
                        $meeting=array();
                        $start=array();
                        $end=array();
                        $hours=array();
                        while($result=$stmt->fetch(PDO::FETCH_ASSOC)):
                            $yy=$result["year"];
                            $mm=$result["month"];
                            $dd=$result["date"];
                            $t1=$result["time1"];
                            $t2=$result["time2"];
                            $t=$t2-$t1;
                            $meeting[]+=$dd;
                            $start[]+=$t1/100;
                            $end[]+=$t2/100;
                            $hours[]+=$t/100;                            
                        endwhile;
//////【1/2】終了





//////【2/2】カレンダー作成

                        echo "<h4><span><i class='fas fa-arrow-circle-left'></i></span>",$year,"年";
                        echo $month,"月<span><i class='fas fa-arrow-circle-right'></i></span></h4>";

                        echo "<table class='select__calen'><tr><th>日<i class='fas fa-slash'></i>時間</th><th>9:00</th><th>10:00</th><th>11:00</th><th>12:00</th><th>13:00</th><th>14:00</th><th>15:00</th><th>16:00</th><th>17:00</th></tr>";
                        $day=date("j");
                        $lastdate=date("t",strtotime("$year-$month-1")); 
                        $firstday=date("w",strtotime("$year-$month-1"));
                        $firstday=(int)$firstday;
                        $thisdate=1-$firstday;
                        $lastdate=(int)$lastdate;
                        $thdate=1;
                        $cnt=0;
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
                                echo "<td class='from_to ",$year,"-",$month,"-",$thdate,"' colspan='9' style='padding-left:calc((",$start[$cnt]," - 9) * 50px + 10px);'>";
                                echo "<form action='schedule_detail.php?",$year,"-",$month,"-",$thdate,"' method='post' class='sche__on' style='width:calc(",$hours[$cnt]," * 56px);'>";
                                echo "<input type='hidden' name='yy' value='",$year,"'>";
                                echo "<input type='hidden' name='mm' value='",$month,"'>";
                                echo "<input type='hidden' name='dd' value='",$thdate,"'>";
                                echo "<input type='hidden' name='t1' value='",$t1,"'>";
                                echo "<input type='hidden' name='t2' value='",$t2,"'>";
                                echo "<input type='hidden' name='thdate' value='",$thdate,"'>";
                                echo "<input type='submit' value='",$start[$cnt],":00-",$end[$cnt],":00'>";
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
                                // echo "<tr class='time__table'><th></th><th>9:00</th><th>10:00</th><th>11:00</th><th>12:00</th><th>13:00</th><th>14:00</th><th>15:00</th><th>16:00</th><th>17:00</th></tr>";
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





                endif;?>





<div class="col">
<!-- <p class="stamp__intro">スタンプの説明</p> -->
<div class="stamp__inner">
<dl>
    <dt><figure><img src="../images/lesson.png" alt="stamp"></figure></dt>
    <dd>レッスン</dd>
</dl>
</div><!-- stamp__intro end -->
</div><!-- col end                     -->
            </div><!-- row end -->











        

        </section><!--  sec__02 end      -->
        

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
</section>
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