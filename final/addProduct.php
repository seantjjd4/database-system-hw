<?php
  include_once("function.php");
  @$Product_name = $_POST["Product_name"];
  @$Product_description = $_POST["Product_description"];
  @$Price = $_POST["Price"];
  @$Stock = $_POST["Stock"];
  @$Product_detail = $_POST["Product_detail"];
  @$Product_standerd = $_POST["Product_standerd"];
  @$Image_path = $_POST["Image_path"];

  date_default_timezone_set("Asia/Taipei");
  $link = create_connection();
  $sql =
    "INSERT INTO Product(Product_name, Product_description, Price, Stock, Publish_date, Product_detail, Product_standerd)
    Value($Product_name, $Product_description, $Price, $Stock, ".date("Y-m-d").", $Product_detail, $Product_standerd)";
  $result = execute_sql($link, "DBS_project", $sql);
  //關閉資料連接	
  mysqli_close($link);
  echo json_encode(array(
    'result' => $result,
    'Product_name' => $Product_name,
    'Product_description' => $Product_description,
    'Price' => $Price,
    'Stock' => $Stock,
    'Product_detail' => $Product_detail,
    'Product_standerd' => $Product_standerd
  ));
?>