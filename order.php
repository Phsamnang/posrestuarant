<?php
include "connect_db.php";
session_start();
if ($_SESSION['username'] == null && $_SESSION['userid'] == null) {
    header("Location:index.php");
}
include_once "header.php";
?>
<div class="modal fade" id="model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="totalAmount"></h3>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">រៀល</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" id="recieveAmount">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
                <h4 class="changeAmount"></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-save-payment" disabled>Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 col-md-6 col-xl-6">
                    <h1 class="m-0">កម្មង</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-sm-5 col-xl-5">
                    <div class="row" id="table_detail">
                        <select name="" id="table-detail" class="form-control col-md-3" onblur="current_id=this.value;" onclick="current_id=0;">
                            <option value="0">Table</option>
                            <?php
                            $select = $conn->prepare("select * from tb_table");
                            $select->execute();
                            while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                            ?>
                                <option value="<?php echo $row->id; ?>" class="table-click"><?php echo $row->name; ?></option>


                            <?php
                            }
                            ?>
                        </select>

                    </div>
                    <!-- <button class="btn btn-info" id="show-table">Show Table</button> -->

                    <div id="selected-table"></div>
                    <div id="orderdetail"></div>
                </div>
                <div class="col-7" id="listmenu">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <?php
                            $cate = $conn->prepare("select * from tb_category");
                            $cate->execute();
                            while ($row = $cate->fetch(PDO::FETCH_OBJ)) {
                                echo '<a class="nav-link nav-item" data-toggle="tab" data-id="' . $row->cateid . '">' . $row->category . '</a>';
                            }
                            ?>
                        </div>
                    </nav>
                    <div class="row mt" id="itemlist"></div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
</div>
<script>
    var current_id = 0;
    // $(document).ready(function() {
    //     $("#table_detail").hide();
    // });
    $("#listmenu").hide();
    // $("#show-table").click(function() {
    //     if ($("#table_detail").is(":hidden")) {
    //         $("#table_detail").slideDown('fast');
    //         $("#show-table").html("Hide Table").removeClass("btn-info").addClass("btn-danger");
    //     } else {
    //         $("#table_detail").slideUp('fast');
    //         $("#show-table").html("Show Table").removeClass("btn-danger").addClass("btn-info");
    //     }


    // });
    $("#orderdetail").on('click', "#show-menu", function() {
        $("#listmenu").fadeIn('fast');
    });
    $(".nav-link").click(function() {
        var id = $(this).data("id");
        $.ajax({
            type: "post",
            url: "getmenu.php",
            data: {
                mid: id
            },
            success: function(data) {
                $("#itemlist").hide();
                $("#itemlist").html(data);
                $("#itemlist").fadeIn('fast');
            }
        });

    });
</script>
<script>
    // $("#table-detail").on("click",".table-click",function(){
    //     var TABLE_ID=$(this).data("id");
    //     alert(TABLE_ID);
    // })
    var QTY = "";
    var TABLE_ID = "";
    var TABLE_NAME = "";
    var SALE_ID = "";
    $("#listmenu").on("change", ".qty", function() {
        QTY = $(this).val();

    })
    $("select").change(function() {
        $("#listmenu").hide();
        TABLE_ID = $("#table-detail").find(':selected').val();
        // TABLE_ID = $(this).find(':selected').data('id');
        TABLE_NAME = $(this).find(':selected').text();
        if (TABLE_ID == 0) {
            $("#selected-table").html("<br><h3>TABLE :" + "Select table" + "</h3><hr>").hide();
        } else {
            $("#selected-table").html("<br><h3>TABLE :" + TABLE_NAME + "</h3><hr>").show();
            console.log(TABLE_ID);
            $.ajax({
                type: "get",
                // data: {
                //     table_id: TABLE_ID,
                // },
                url: "getSaleDetail.php?" + "table_id=" + TABLE_ID,
                success: function(data) {
                    $("#orderdetail").html(data);
                    //$("#startOrder").hide();
                }

            })

        }


        // alert(TABLE_ID);

    });
    $("#listmenu").on("click", ".btn-menu", function() {
        if (TABLE_ID == "") {
            alert("Please choose the table you want to order");
        } else {
            if (QTY == 0) {
                alert("Please Input Quantity");
            } else {
                var menu_id = $(this).data("id");
                //  console.log(QTY);

                $.ajax({
                    type: "post",
                    data: {
                        menuid: menu_id,
                        tableid: TABLE_ID,
                        tablename: TABLE_NAME,
                        quantity: QTY
                    },
                    url: "orderfood.php",
                    success: function(data) {
                        $("#orderdetail").html(data);

                        $(".qty").val(" ");
                        QTY = "";
                    }
                })
            }


        }

    });
    $("#orderdetail").on("click", ".btn-delete-item", function() {
        var item_id = $(this).data("id");
        var tdh = $(this);
        $.ajax({
            type: "Post",
            data: {
                id: item_id
            },
            url: "deleteOrderItem.php",
            success: function(data) {
                tdh.parents('tr').hide();
                //$("#price").fadeIn();
                $("#orderdetail").html(data);
            }
        });
    });
    $("#orderdetail").on("click", ".btn-comfirm-order", function() {
        var id = $(this).data("id");
        $.ajax({
            type: "POST",
            data: {
                id: id
            },
            url: "confirmOrder.php",
            success: function(data) {
                $("#orderdetail").html(data);
            }
        })
    });
    $("#orderdetail").on('click', '.btn-payment', function() {
        var totalPrice = $(this).attr("data-totalAmount");
        $(".totalAmount").html("Total Amount: " + totalPrice);
        SALE_ID = $(this).data("id");
    });
    $("#recieveAmount").keyup(function() {
        var totalPrice = $('.btn-payment').attr("data-totalAmount");
        var recieve = $(this).val();
        var changeAmount = recieve - totalPrice;
        $(".changeAmount").html("Change Amount:" + changeAmount + "រៀល");

        if (changeAmount >= 0) {
            $(".btn-save-payment").prop('disabled', false);
        } else {
            $(".btn-save-payment").prop('disabled', true);
        }

    });

    $(".btn-save-payment").click(function() {

        var recieve = $("#recieveAmount").val();
        $.ajax({
            type: "post",
            data: {
                sale_id: SALE_ID,
                recieve: recieve,
            },
            url: "savePayment.php",
            success: function(data) {
                window.location.href = "order.php";
            }
        })
    })
    $("#orderdetail").on('click', '.startOrder', function() {
        $("#listmenu").show();
        $.ajax({
            type: "POST",
            data: {
                tab_id: TABLE_ID,
                tab_name: TABLE_NAME
            },
            url: "startorder.php",
            success: function(data) {
                $("#orderdetail").html(data);



            }
        })


    });
</script>
<?php
include_once "footer.php";

?>