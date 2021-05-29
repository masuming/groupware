<!DOCTYPE html>
<html lang="ja">
    <?php
    include("../header.php");
    ?>
<body id="attend">
<?php
    include("../nav.php");

    ?>


<div class="wrapper">
    <main>

        <section id="adm__attend">
            <h2>参加状況入力</h2>

            <div class="row"> 

                <form action="../circle/attend">
                <select name="year" id="year">
                    <option value="y21">2021年</option>
                </select>
                <select name="month" id="month">
                    <option value="m01">1月</option>
                    <option value="m02">2月</option>
                    <option value="m03">3月</option>
                    <option value="m04">4月</option>
                    <option value="m05">5月</option>
                    <option value="m06">6月</option>
                    <option value="m07">7月</option>
                    <option value="m08">8月</option>
                    <option value="m09">9月</option>
                    <option value="m10">10月</option>
                    <option value="m11">11月</option>
                    <option value="m12">12月</option>
                </select>
                <select name="day" id="day">
                    <?php
                    $lastday=date("t");
                    $lastday=(int)$lastday;
                        for($i=1;$i<=$lastday;$i++):
                            echo "<option value='d",$i,"'>",$i,"日</option>";
                        endfor;
                    ?>
                </select>
                <br>
                <input type="submit" value="入力する">
                </form>
                    
        </div>

        <div class="row">

                <h3>参加者のアイコンをクリック</h3>
                <ul>
                    <li></li>
                </ul>

            </section>



        </div>
           
            
    </main>
        
        </div>        
        <?php
    include("../footer.php");
?>
    </div><!-- wrapper end -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/pullnav.js"></script>   
</body>
</html>
</body>
</html>