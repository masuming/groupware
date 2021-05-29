<?php
include("../session_start.php");
include("../try_catch.php");
?>

<!DOCTYPE html>
<html lang="ja">
    <?php
    $title="GroupWare | 費目登録確認";    
    include("../common/header.php");    
    ?>
    <body id="adm_item" class="adm">
        <div class="wrapper">
            <div class="wrapper__bg">
                <div class="wrapper__bg__left"></div>
                <div class="wrapper__bg__right"></div>
            </div>  
            <?php
            include("../common/nav_ad.php");
            ?>

            <main>

                <section id="adm__item">
                    <h2></h2>


                    <div class="row"> 
                        <section class="sec__02">
                        <?php
                        if(isset($_SESSION['mail'])) :
                            if($_SESSION['type']==3):?>
                            <?php
                            $errors=array();

                            $type=null;
                            $type=$_POST["type"];

                            $item=null;
                            $itemmatch="/^[ぁ-んァ-ヶー々一-龠０-９a-zA-Z0-9-\/:-@\[-`\{-\~]+$/";
                                if(!preg_match($itemmatch,$_POST["item"])):
                                    $errors["item"]="費目名を正しく入力してください(全角かな、半角英数)";
                                else:
                                    if(strlen($_POST["item"])>50):
                                        $errors["item"]="費目名が長すぎます(20文字以内)";
                                    else:
                                    $stmt=$pdo->prepare("SELECT * FROM `items` WHERE `item`=:item");
                                    $stmt->bindParam(':item',$_POST["item"]);
                                    $stmt->execute();
                                    $result=$stmt->fetch();
                                        if($result):
                                            $errors["item"]="この費目名は既に登録済みです";
                                        else:
                                        $item=$_POST["item"];
                                        endif;
                                    $stmt=null;
                                    endif;
                                endif;

                                $unit=null;
                                $unit=$_POST["unit"];

                                $value=null;
                                $valuematch="/^([0-9]{1,})$/";
                                if(!preg_match($valuematch,$_POST["value"])):
                                    $errors["value"]="数字は半角で１桁以上入れて下さい";
                                else:
                                $value=$_POST["value"];
                                endif;

                                $calc=null;
                                $calc=$_POST["calc"];
                                ?>
        
                            <?php
                            if(count($errors)):?>            
                            <h3>！登録内容に誤りがあります</h3>                
                            <p class="mb20"><i class="fas fa-check-square"></i>以下のエラー内容をご確認ください。</p>                
                            <ul class="error_list">
                                <?php
                                foreach($errors as $error):?>
                                <li>
                                <i class="fas fa-exclamation-triangle"></i><?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8")?>
                                </li>
                            <?php endforeach; ?>
                            </ul>

                            <p class="next"><a href="javascript:history.back();"><i class="fas fa-arrow-right"></i>登録画面に戻る</a></p>

                            <?php else: ?>                
                            <h3>費目登録内容の確認</h3>

                            <h4>以下でよろしければ「登録」、修正の場合は「戻る」を押して下さい</h4>

                            <form action="accitem_touroku_kanryo.php" method="post">

                                <dl>
                                <dt>項目名</dt>
                                <?php include("switch_output_itemtype.php"); ?>
                                <dd><?php echo $t;?>
                                <input type="hidden" name="type" value="<?php echo $type ?>"></dd>
                                </dl>
                                
                                <dl>
                                <dt>費目名</dt>
                                <dd><?php echo $item;?>
                                <input type="hidden" name="item" value="<?php echo $item ?>"></dd>
                                </dl>

                                <dl>
                                <dt>単価／単位</dt>
                                <?php include("switch_output_itemunit.php"); ?>
                                <dd><?php echo number_format($value),"円／",$u;?>
                                <input type="hidden" name="unit" value="<?php echo $unit ?>">
                                <input type="hidden" name="value" value="<?php echo $value ?>"></dd>
                                </dl>

                                <dl>
                                <dt>個人負担率</dt>
                                <?php include("switch_output_itemcalc.php"); ?>
                                <dd><?php echo $c;?>
                                <input type="hidden" name="calc" value="<?php echo $calc ?>"></dd>
                                </dl>

                                <div class="buttons">
                                <input type="button" value="戻る" onclick='history.go(-1)'>
                                <input type="submit" value="登録する">
                                </div>
                            </form>

                        
                            
                        </section>     

                        <?php endif;?>
                        <?php
                        include("admin_acc_footer.php"); ?>
                        <?php else:
                        @include("admin_chk.php");
                        endif;?>
                    <?php else:
                    @include("session_chk.php");
                    ?>
                    <?php endif; ?>
                
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