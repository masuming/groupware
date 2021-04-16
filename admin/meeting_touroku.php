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
                
                <p class="textcenter mb20">入力月を選択してください</p>


                
            <?php if(isset($_SESSION['mail']) && $_SESSION['type']==3): ?>
                <form action="meeting_touroku.php" method="post">
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
                        if($j==$month+1):
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
                        echo $m,"月</h4>";

                       
                        echo "<table class='select__calen'><tr><th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th></tr>";

                        while(1):
                            echo "<tr>";
                            for($j=0;$j<7;$j++):
                                if($thisdate<1 || $thisdate>$lastdate):
                                    echo "<td></td>";
                                else:
                                    echo "<td class='sche__input'><form action='meeting_input.php?$year-$m-$thisdate' method='post'><input type='hidden' name='yy' value='$year'><input type='hidden' name='mm' value='$m'><input type='hidden' name='dd' value='$thisdate'><input type='submit' value='$thisdate'></form></td>";
                                    
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

            


                    endif;




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
