<?php
class Invoice
{
    // public $sale_id;
    // public $conn;
    // // function __construct($sale_id,$conn)
    // // {
    // //     $this->sale_id=$sale_id;
    // //     $this->conn=$conn;
    // // }
    function showInvoice($sale_id, $conn)
    {

        $select = $conn->prepare("SELECT * from tb_saleDetail where sale_id=$sale_id");

        $select->execute();
        echo '<button class="btn btn-info" id="show-menu">Show menu</button><br>';
        echo '<div class="table-responsive-md"style="overflow-y:scroll;height:400px;border:1px solid">
        
        <table class="table table-stripped" id="oderDetail">
        <tr>
        <thead>
        <th>Menu</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
        <th>Status</th>
        </tr>
        </thead>';
        $showBtnPayment = true;
        while ($row = $select->fetch(PDO::FETCH_OBJ)) {
            echo '
        <tboday>
        <tr><td>' . $row->menu_name . '</td>
        
        <td>' . $row->quantity . '</td>
        <td>' . $row->menu_price . '</td>
        <td>' . $row->menu_price * $row->quantity . '</td>
        <td>';
            if ($row->status == "noComfirm") {
                $showBtnPayment = false;
                echo '<a class="btn btn-danger btn-delete-item" data-id="' . $row->id . '"><i class="fa fa-trash-alt"></i></a>';
            } else {
                echo '<i class="fas fa-check-circle"></i>';
            }
            echo '</td>
        </tr>';
        }
        $totalprice = $conn->prepare("select * from tb_sales where id=$sale_id");
        $totalprice->execute();
        $toprice = $totalprice->fetch(PDO::FETCH_OBJ);
        echo '</tbody>
           </table>
         
           </div> 
        <hr>
        <h3 id="price">Total Price: ' . $toprice->total_price . '</h3>';
        if ($showBtnPayment) {
            echo '<button class="btn btn-block btn-Success btn-success btn-payment" data-id="' . $sale_id . '" data-toggle="modal" data-target="#model" data-totalAmount="'.$toprice->total_price.'" >Payment</button>
   ';
        } else {
            echo '<button class="btn btn-block btn-warning btn-comfirm-order" data-id="' . $sale_id . '">Comfirm Order</button>
            ';
        }
    }
}
