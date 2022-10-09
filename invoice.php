<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="dist/js/jquery-3.6.0.js"></script>
    <title>Document</title>
</head>
<?php include_once 'connect_db.php'; ?>

<body>

    <div id="invoice-POS">

        <center id="top">

            <div class="info-logo">
                <h2>Vy Chomrouen</h2>
            </div>
            <!--End Info-->
        </center>
        <!--End InvoiceTop-->

        <div id="mid">
            <div class="info">
                <h2>Contact Info</h2>
            </div>
        </div>
        <!--End Invoice Mid-->

        <div id="bot">

            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item">
                            <h2>Item</h2>
                        </td>
                        <td class="Hours">
                            <h2>Qty</h2>
                        </td>
                        <td class="Rate">
                            <h2>Price</h2>
                        </td>
                        <td class="Rate">
                            <h2>Sub Total</h2>
                        </td>
                    </tr>

                    <?php
                    $select = $conn->query("select sale_id, menu_id, menu_name ,menu_price,sum(quantity) as qty from tb_saleDetail where tb_saleDetail.sale_id=1 group by sale_id ,menu_id ,menu_name,menu_price");
                    $select->execute();
                    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                
                     //   echo $row['menu_name'].$row['quantity']."<br>";

                        // $data[]=$row;   
                        // print_r($data[]);
                        //  echo $row['menu_id'];
                       // $mid=$row['menu_id'];
                //         $selectFromMenu = $conn->query("SELECT count(menuid),name FROM tb_menus WHERE menuid=$mid group by menuid");
                //         $selectFromMenu->execute();

                //         $men = $selectFromMenu->fetch(PDO::FETCH_ASSOC);
                   
                
                        echo '<tr class="service">
                      <td class="tableitem item-name">
  <p class="itemtext">' . $row['menu_name'] . '</p>
  </td>
  <td class="tableitem item-qty">
<p class="itemtext">' . $row['qty']   . '</p>
   </td>
  <td class="tableitem item-price">
     <p class="itemtext">' . $row['menu_price'] . '</p>
  </td> 
  <td class="tableitem item-subtotal">
  <p class="itemtext">' . $row['menu_price'] * $row['qty'] . '</p>
</td>
  </tr>';
                    }
              
                    ?>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>tax</h2>
                        </td>
                        <td class="payment">
                            <h2>$419.25</h2>
                        </td>
                    </tr>

                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate">
                            <h2>Total</h2>
                        </td>
                        <td class="payment">
                            <h2>$3,644.25</h2>
                        </td>
                    </tr>

                </table>
            </div>
            <!--End Table-->

            <div id="legalcopy">
                <p class="legal"><strong>Thank you for your business!</strong>  Payment is expected within 31 days; please process this invoice within that time. There will be a 5% interest charge per month on late invoices.
                </p>
            </div>

        </div>
        <!--End InvoiceBot-->
    </div>
    <!--End Invoice-->
</body>
<script>
    $('.service').each(function() {
  var thisId = $(this).find('.item-name').text();
  var sumVal = parseFloat($(this).find('.item-qty').text());

  var $rowsToGroup = $(this).nextAll('tr').filter(function() {
    return $(this).find('.service').text() === thisId;
  });

  $rowsToGroup.each(function() {
    sumVal += parseFloat($(this).find('.item-qty').text());
    $(this).remove();
  });

  $(this).find('.item-qty').text(sumVal);
});
    // var first_row = '<tr class="service"><td class="item-name">NULL</td></tr>';
    // var rowCount = 0;
    // var rowSum = 0;
    // $.each($('.service'), function(index, curRow) {
    //     if ($(first_row).find('.item-name').text() != $(curRow).find('.item-name')) {
    //         if (rowCount > 1) {
    //             $(first_row).find('item-qty').text(rowSum);
    //             for (i = 0; i < rowCount; i++) {
    //                 $(first_row).next('.service').find('item-qty').remove();
    //             }
    //         }
    //         first_row = $(curRow);
    //         rowSum = 0;
    //         rowCount = 0;
    //     }
    //     rowSum += parseInt($(curRow).find('.item-qty    ').text());
    //     rowCount += 1;
    // })
</script>
<style>
    #invoice-POS {
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        padding: 2mm;
        margin: 0 auto;
        width: 58mm;
        background: #FFF;


    }

    .info-log .h2 {
        text-align: center;
    }

    h1 {
        font-size: 1.5em;
        color: #222;
    }

    h2 {
        font-size: .9em;
    }

    h3 {
        font-size: 1.2em;
        font-weight: 300;
        line-height: 2em;
    }

    p {
        font-size: .7em;
        color: #666;
        line-height: 1.2em;
    }

    #top,
    #mid,
    #bot {
        /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
    }

    #top {
        min-height: 100px;
    }

    #mid {
        min-height: 80px;
    }

    #bot {
        min-height: 50px;
    }

    #top .logo {
        float: left;
        height: 60px;
        width: 60px;
        background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
        background-size: 60px 60px;
    }

    .clientlogo {
        float: left;
        height: 60px;
        width: 60px;
        background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
        background-size: 60px 60px;
        border-radius: 50px;
    }

    .info {
        display: block;
        float: left;

        margin-left: 0;
    }

    .title {
        float: right;
    }

    .title p {
        text-align: right;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 5px 0 5px 15px;
        border: 1px solid #EEE
    }

    .tabletitle {
        padding: 5px;
        font-size: .5em;
        background: #EEE;
    }

    .service {
        border-bottom: 1px solid #EEE;
    }

    .item {
        width: 24mm;
    }

    .itemtext {
        font-size: 12px;
    }

    #legalcopy {
        margin-top: 5mm;
    }
</style>

</html>