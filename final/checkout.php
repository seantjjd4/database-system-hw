<!-- 使用折扣 -->
<?php
    require_once("dbtools.inc.php");
    if (empty($_POST["couponDiscount"])) {
        $discount = 0;
    } else {
        $CouponID = $_POST["couponDiscount"];
        $link = create_connection();
        $sql = "SELECT *
                FROM `Coupon`
                Where Coupon_ID = $CouponID;";
        $result = execute_sql($link, "DBS_project", $sql);
        $data = mysqli_fetch_array($result);
        mysqli_free_result($result);
    
        $discount = $data["DiscountCount"];
    }
    
?>


<?php
	if (empty($_COOKIE["id"]))
    {	
        setcookie("id", "guest");
        setcookie("NickName", "guest");
        $id = "guest";
        $NickName = "guest";
    }
    else
    {
        $id = $_COOKIE["id"];
        $NickName = $_COOKIE["NickName"];
    }
    $id = $_COOKIE["id"];	
    if (empty($_COOKIE["num_list"]) || empty($_COOKIE["name_list"]) || empty($_COOKIE["price_list"]) || empty($_COOKIE["quantity_list"]))
    {
        setcookie("num_list", "0");
        setcookie("name_list", "0");
        setcookie("price_list", "0");
        setcookie("quantity_list", "0");
        $sum=0;
        $namelen=0;
    }
    else
    {	
        $quantity= $_COOKIE["quantity_list"];
        $num = $_COOKIE["num_list"];
        $name= $_COOKIE["name_list"];
        $price= $_COOKIE["price_list"];	
        if(empty($_COOKIE["num_list"])){
            $namelen=0;
        }
        else{
            $namearray = explode(",",$name);
            $quantityarray=explode(",", $quantity);
            $namelen=count($namearray);
        }
       
        $pricearray = array_map('intval', explode(",",$price));	
        $sum=0;
        for($i=0;$i<$namelen-1;$i++)
        {
            $sum=$sum+$pricearray[$i];
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HOLO商城</title>
    <link rel="shortcut icon" type="image/png" href="./images/logo.png"/>
    <!-- CSS文件載入 -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/color.css">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <!-- js文件載入 -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- header/start -->
    <header class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <a class="navbar-brand" href="index.php">
                <img src="./images/logo.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">首頁</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">HOLOLIVE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">HOLO商城</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="job.php">人物介紹</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://schedule.hololive.tv/">直播時間與連結</a>
                    </li>
                </ul>
                <div class="ml-auto">
                    <?php
                            if ($_COOKIE["id"]=="guest")
                            {
                              echo"<a href='login.html' class='btn btn-outline-info text-info my-2 my-sm-0'>登入</a>";	
                            }
                            else
                            {
                                echo"$NickName 你好 ";
                                echo"<a href='logout.php' class='btn btn-outline-danger text-danger my-2 my-sm-0'>登出</a>";
                            }
                    ?>
                    <a href="cart.php" class="btn btn-outline-info text-info my-2 my-sm-0">購物車</a>
                    <a href="checkout.php" class="btn btn-outline-info text-info my-2 my-sm-0">結帳</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- header/end -->
    <!-- 結帳/start -->
    <section class="page-content">
        <div class="container pt-5 pb-5">
            <div class="row">
                <!-- 結帳訊息/start -->
                <div class="col-12 mb-3">
                    <h2>結帳</h2>
                    <p>Thank you! 感謝你的訂購！</p>
                    <?php
                        if($id=="guest")
                        {
                            echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            您目前尚未登入，請點擊<a href='login.html' class='alert-link'>【連結】</a>進行登入。
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>";
                        }
                    
                    ?>
                </div>
                <!-- 結帳訊息/end -->
                <!-- 帳單資訊/start -->
                <div class="col-12 col-md-6 mb-3">
                    <h2>帳單資訊</h2>
                    <form action="addbill.php" method="post" name="myForm">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="LastName">姓氏
                                    <span class="text-danger">*</span>
                                </label>
                                <input name="surname" type="text" class="form-control" id="LastName" required placeholder="* ex:赤井">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="FirstName">名字
                                    <span class="text-danger">*</span>
                                </label>
                                <input name="name" type="text" class="form-control" id="FirstName" required placeholder="* ex:心">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="tel">連絡電話
                                    <span class="text-danger">*</span>
                                </label>
                                <input name="phone" type="number" class="form-control" id="tel" required placeholder="* ex:0987487587">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="EMail">電子信箱
                                    <span class="text-danger">*</span>
                                </label>
                                <input  name="email" type="email" class="form-control" id="EMail" required placeholder="* 包含@">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Address">地址
                                <span class="text-danger">*</span>
                            </label>
                            <input  name="address" type="text" class="form-control" id="Address" required placeholder="* 填詳細好嗎">
                        </div> 
                        <input type="hidden" name="price" value="<?php if(($sum-$discount+60)<0) echo 0; else echo $sum-$discount+60;?>">
                        <input type="hidden" name="account" value="<?php echo $id?>">
                        <input type="hidden" name="itemlist" value="<?php echo $num?>">
                        <input type="hidden" name="usedCoupon" value="<?php echo $CouponID?>">
                        <button type="submit" class="btn btn-outline-info btn-lg float-right">下單購買</button>
                    </form>
                    
                        
                </div>
                <!-- 帳單資訊/end -->
                <!-- 您的訂單/start -->
                <div class="col-12 col-md-6">
                    <h2>您的訂單</h2>
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td>商品</td>
                                    <td>總計</td>
                                </tr>
                            <?php
                                for($i=0;$i<$namelen;$i++){
                                    $subsum = $pricearray[$i] * $quantityarray[$i];
                                    $sum=$sum + $subsum;
                                    echo" <tr>
                                    <td>$namearray[$i]　ｘ　$quantityarray[$i]</td>
                                    <td>NT$&nbsp;$subsum</td>
                                     </tr>";
                                }
                            ?>
                               
                                <tr>
                                    <td>小計</td>
                                    <td>NT$&nbsp;<?php echo $sum; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>運費</td>
                                    <td>NT$&nbsp60</td>
                                </tr>
                                <tr>
                                    <td>折扣</td>
                                    <td>NT$&nbsp;<?php echo "$discount";?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>總計</td>
                                    <td>NT$&nbsp;<?php if(($sum-$discount+60)<0) echo 0; else echo $sum-$discount+60;?></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                    
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- 您的訂單/end -->
            </div> 
        </div>
    </section>
    <!-- 結帳/end -->
    <!-- 頁腳/start -->
    <footer class="bg-pekoradark">
        <div class="container pt-3 pb-3">
            <div class="row">
                <!-- 選單連結/start -->
                <div class="col-12 col-md-6 mb-3">
                    <ul class="footer-menu">
                        <li><a href="index.php">首頁</a></li>
                        <li><a href="about.php">HOLOLIVE</a></li>
                        <li><a href="shop.php">HOLO商城</a></li>
                        <li><a href="job.php">成員簡介</a></li>
                        <li><a href="https://schedule.hololive.tv/">直播時間</a></li>
                        <li><a href="login.html">登入</a></li>
                        <li><a href="cart.php">購物車</a></li>
                        <li><a href="checkout.php">結帳</a></li>
                    </ul>
                </div>
                <!-- 選單連結/end -->
                <!-- 訂閱/start -->
                <div class="col-12 col-md-6 mb-3">
                    <h6 class="text-white">留下 E-mail，訂閱hololive，可搶先獲得最新的資訊喔！</h6>
                    <form action="addemail.php" method="post" name="myForm">
                        <input name="email" type="email" class="form-control mt-2 mb-2" placeholder="請輸入e-mail">
                        <button type="submit" class="btn btn-primary float-right send-btn">傳送</button>
                    </form>
                </div>
                <!-- 訂閱/end -->
                <!-- 版權所有/start -->
                <div class="col-12 mt-3">
                    <p class="text-white text-center">© Copyright 2021 hololive</p>
                </div>
                <!-- 版權所有/end -->
            </div>
        </div>
    </footer>
    <!-- 頁腳/end -->
</body>
</html>