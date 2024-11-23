<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RAM</title>
<link rel="Web Icon" type="png" href="../Images/logo.jpg">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .product-card {
        display: flex;
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        max-width: 800px;
        margin: 20px auto;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin-top:100px;
        height:500px;
    }
    .product-card img {
        width: 100%;
        max-width: 300px;
        height: auto;
    }
    .product-details {
        padding: 20px;
        flex: 1;
    }
    .product-details h2 {
        margin-top: 0;
    }
    .product-details select, .product-details input[type="number"],.product-details input[type="text"] {
        width: 100%;
        margin-bottom: 10px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .product-details button {
        background-color: #333;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .product-details button:hover {
        opacity: 0.8;
    }
</style>
</head>
<body>

<div class="product-card">
    <img src="../Images/RAM/ram1.jpg" alt="Product Image">
    <div class="product-details">
        <h2 name="head">Random Access Memory (RAM)</h2>
        <p>Ram is a type of computer memory that can be accessed randomly; that is, any byte of memory can be accessed without touching the preceding bytes.</p>
        <p>Capacity: 4GB</p>
        <?php echo"<p>Price :₹".$_SESSION['price']."</p>"?>;
        <form method="post" action="ram1.php">
            <input type="number" placeholder="Quantity" min="1" name="qty" required>
            <input type="text" placeholder="Address" name="address" required><br>
            <label>Payment Mode</label><br><br>
            <div class="pay">
                <input type="radio" value="cash" name="payment">Cash&nbsp;&nbsp;
                <input type="radio" value="gpay" name="payment">Gpay                 
            </div><br>
            <button name="submit">Buy Now</button>
        </form>
    </div>
</div>
<?php
    if(isset($_POST['submit']))
    {
        $name=$_SESSION['user'];
        $pr_name=$_SESSION['name'];
        $qty=$_POST['qty'];
        $payment=$_POST['payment'];
        $address=$_POST['address'];
        $price=$_SESSION['price'];
        $total=$price*$qty;
        $status="shipped";
        $path="/ShopDevelop/Images/RAM/ram1.jpg";

         //Database
         $db_server="localhost";
         $db_user="root";
         $db_pass="";
         $db_name="shop";

         $conn=new mysqli($db_server,$db_user,$db_pass,$db_name);        
         $sql1="SELECT * FROM ram WHERE name ='$pr_name'";
         $result=$conn->query($sql1);
         if($result-> num_rows > 0)
         {
            $row=$result->fetch_assoc();
            $stock =$row['stock'];
            if($qty>$stock)
            {
                echo "<script>window.alert('Product out of stock')
                </script>";
            }
            else
            {
                $sql="INSERT INTO myorder (name,pr_name,image,qty,price,payment,pay_status,del_status,address) VALUES ('$name','$pr_name','$path','$qty','$total','$payment','None','$status','$address')";
                $conn->query($sql);
                $stock=$stock-$qty;
                $sql2="UPDATE ram SET stock = '$stock' WHERE name ='$pr_name'";
                $conn->query($sql2);
                header("Location: Home.html");
            }
         }

    }
?>
</body>
</html>
