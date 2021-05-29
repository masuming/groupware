<?php
include("../session_start.php");

?>
<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="GroupWare | 費目登録";
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

        <section id="item_touroku">
     

            <h2></h2>

            <div class="row"> 
                <section class="sec__02">

                <?php
                if(isset($_SESSION['mail'])) :
                    if($_SESSION['type']==3):?>
                <h3>経費費目の登録</h3>
                <div class='col'>
                <?php
                include("../try_catch.php");
                $stmt=$pdo->prepare("SELECT * FROM `items` LEFT OUTER JOIN `room` ON items.type=room.place UNION SELECT * FROM `items` RIGHT OUTER JOIN `room` ON items.type=room.place");
                $stmt->execute();
                echo "<h4>現在の登録状況</h4>";   
                echo "<table><tr><th>費目</th><th>単位</th><th>単価</th><th>負担率</th></tr>";     
                while($result=$stmt->fetch(PDO::FETCH_ASSOC)):
                    $type=$result["type"];
                    $item=$result["item"];
                    $unit=$result["unit"];
                    $value=$result["value"];
                    $calc=$result["calc"];
                    $place=$result["place"];
                    $room=$result["room"];
                    $fee=$result["fee"];

                    switch($calc):
                        case 0:
                            $c="全額";
                            break;
                            case 1:
                            $c="／参加人数";
                            break;
                            default:
                            $c="";
                            break;
                    endswitch;
                        echo "<tr>";
                        if($place==1 || $place==2):
                            include("switch_output_place.php");

                            echo "<td>部屋使用料<br>",$p,"／",$room,"</td>";
                            echo "<td>時間</td>";
                            echo "<td>",number_format($fee),"</td>";
                            echo "<td>／参加人数</td>";
                            echo "</tr>";                            
                            else:
                            include("switch_output_itemunit.php");
                            include("switch_output_itemcalc.php");                                
                            echo "<td>",$item,"</td>";
                            echo "<td>",$u,"</td>";
                            echo "<td>",number_format($value),"</td>";
                            echo "<td>",$c,"</td>";
                            echo "</tr>";
                            endif;

                endwhile;
                echo "</table>";
                $pdo=null;?>

        </div> <!-- col end -->

        <div class="col">


                <!-- <p class="textcenter mb50">以下の情報を入力して「登録内容の確認」ボタンをおしてください</p>  -->
                
                <form action="accitem_confirm.php" method="post">
                <div class="form__box">
                    <h4>費目登録</h4>

                    <dl>
                    <dt>項目：</dt>
                    <dd>
                    <select name="type">
                        <option value="0">一般</option>
                    </select>
                    </dd>
            </dl>
            <dl>
                    <dt>費目名：</dt>
                    <dd>
                    <input type="text" name="item" size="20"> 
                    </dd>
                    </dl>
            <dl>                    
                    <dt>単位：</dt>
                    <dd>
                    <select name="unit">
                        <option value="0">回</option>
                        <option value="1">時間</option>
                        <option value="2">個</option>
                    </select>
                    </dd>
                    </dl>
            <dl>
                    <dt>単価（円）：</dt>
                    <dd>
                    <input type="text" name="value" size="15"> 
                    </dd>
                    </dl>
            <dl>
                    <dt>個人負担率：</dt>
                    <dd>
                    <select name="calc" id="">
                        <option value="0">全額</option>
                        <option value="1">／参加人数</option>
                    </select>
                    </dd>
                    </dl>
                    <input type="submit" value="確認">

            <p class="mt50">※お部屋の使用料は<a href="room_touroku.php">『活動室登録』ページ</a>から登録してください</p>                    
                </div>    

                
            </form>

                



                <?php
                $pdo=null; ?>

                </div><!-- col end                 -->
        </section>
                <?php else:
                    @include("admin_chk.php");
                    endif;?>
                <?php else:
                @include("session_chk.php");
                ?>


            

                <?php endif;        
                include("admin_acc_footer.php"); ?>         
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
