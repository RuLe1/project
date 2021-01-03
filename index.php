<!DOCTYPE html>
<html>
    <head>
        <title>Danh sách sản phẩm</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body{
                font-family: arial;
            }
            .container{
                width: 1200px;
                margin: 0 auto;
            }
            h1{
                text-align: center;
            }
            .product-items{
                border: 1px solid #ccc;
                padding: 30px;
            }
            .product-item{
                float: left;
                width: 23%;
                margin: 1%;
                padding: 10px;
                box-sizing: border-box;
                border: 1px solid #ccc;
                line-height: 26px;
            }
            .product-item label{
                font-weight: bold;
            }
            .product-item p{
                margin: 0;
                line-height: 26px;
                max-height: 52px;
                overflow: hidden;
            }
            .product-price{
                color: red;
                font-weight: bold;
            }
            .product-img{
                padding: 5px;
                border: 1px solid #ccc;
                margin-bottom: 5px;
            }
            .product-item img{
                max-width: 100%;
            }
            .product-item ul{
                margin: 0;
                padding: 0;
                border-right: 1px solid #ccc;
            }
            .product-item ul li{
                float: left;
                width: 33.3333%;
                list-style: none;
                text-align: center;
                border: 1px solid #ccc;
                border-right: 0;
                box-sizing: border-box;
            }
            .clear-both{
                clear: both;
            }
            a{
                text-decoration: none;
            }
            .buy-button{
                text-align: right;
                margin-top: 10px;
            }
            .buy-button a{
                background: #444;
                padding: 5px;
                color: #fff;
            }
            #pagination{
                text-align: right;
                margin-top: 15px;
            }
            .page-item{
                border: 1px solid #ccc;
                padding: 5px 9px;
                color: #000;
            }
            .current-page{
                background: #000;
                color: #FFF;
            }
            #product-search{
                margin: 0 40px;
                padding-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <?php
        $search = isset($_GET['name']) ? $_GET['name'] : "";
        if($search){
            $where = "WHERE `name` LIKE '%". $search. "%'";
        } 

        include './connect_db.php';
        $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:4;
        $current_page = !empty($_GET['page'])?$_GET['page']:1; //Trang hiện tại
        $offset = ($current_page - 1) * $item_per_page;

        if($search){
            $products = mysqli_query($con, "SELECT * FROM `product` WHERE `name` LIKE '%". $search ."%' ORDER BY `id` ASC  LIMIT " . $item_per_page . " OFFSET " . $offset);
            $totalRecords = mysqli_query($con, "SELECT * FROM `product` WHERE `name` LIKE '%". $search."%'");
        }else{
            $products = mysqli_query($con, "SELECT * FROM `product` ORDER BY `id` ASC  LIMIT " . $item_per_page . " OFFSET " . $offset);
            $totalRecords = mysqli_query($con, "SELECT * FROM `product`");
        }
       
        $totalRecords = $totalRecords->num_rows;//số sản phẩm num_rows
        $totalPages = ceil($totalRecords / $item_per_page);//làm tròn tổng số có bao nhiêu trang
        ?>
        <div class="container">
            <h1>Danh sách sản phẩm</h1>
            <form id="product-search" method="GET"> 
                <label>Tìm kiếm sản phẩm</label>
                <input type="text" value="<?=isset($_GET['name']) ? $_GET['name'] : " "?>" name="name"/>
                <input type="submit" value="Tìm kiếm" />
            </form>
            <div class="product-items">
                <?php
                while ($row = mysqli_fetch_array($products)) {
                    ?>
                    <div class="product-item">
                        <div class="product-img">
                        <a href="./detail.php?id=<?=$row['id']?>"><img src="./<?= $row['image'] ?>" title="<?= $row['name'] ?>" /></a>
                        </div>
                        <strong><a href="./detail.php?id=<?=$row['id']?>"><?= $row['name'] ?></a></strong><br/>
                        <label>Giá: </label><span class="product-price"><?= number_format($row['price'], 0, ",", ".") ?> đ</span><br/>
                        <p><?= $row['content'] ?></p>
                        <div class="buy-button">
                            <a href="./cart.php">Mua sản phẩm</a>
                        </div>
                    </div>
                <?php } ?>
                <div class="clear-both"></div>
                <?php
                include './pagination.php';
                ?>
                
            </div>
        </div>
    </body>
</html>