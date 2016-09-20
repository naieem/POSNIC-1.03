<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>POSNIC - Add Stock Category</title>

    <!-- Stylesheets -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="js/date_pic/date_input.css">
    <link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
    <script src="js/date_pic/jquery.date_input.js"></script>
    <script src="lib/auto/js/jquery.autocomplete.js "></script>

    <script type="text/javascript">
        $(function () {

            $("#supplier").autocomplete("customer1.php", {
                width: 160,
                autoFill: true,
                selectFirst: true
            });
            $("#item").autocomplete("stock.php", {
                width: 160,
                autoFill: true,
                mustMatch: true,
                selectFirst: true
            });
            $("#item").blur(function () {
                document.getElementById('total').value = document.getElementById('sell').value * document.getElementById('quty').value
            });
            $("#item").blur(function () {


                $.post('check_item_details.php', {stock_name1: $(this).val()},
                    function (data) {

                        $("#sell").val(data.sell);
                        $("#stock").val(data.stock);
                        $('#guid').val(data.guid);
                        if (data.sell != undefined)
                            $("#0").focus();


                    }, 'json');


            });
            $("#supplier").blur(function () {


                $.post('check_customer_details.php', {stock_name1: $(this).val()},
                    function (data) {

                        $("#address").val(data.address);
                        $("#contact1").val(data.contact1);

                        if (data.address != undefined)
                            $("#0").focus();

                    }, 'json');


            });
            $('#test1').jdPicker();
            $('#test2').jdPicker();


            var hauteur = 0;
            $('.code').each(function () {
                if ($(this).height() > hauteur) hauteur = $(this).height();
            });

            $('.code').each(function () {
                $(this).height(hauteur);
            });
        });

    </script>
    <script>
        /*$.validator.setDefaults({
         submitHandler: function() { alert("submitted!"); }
         });*/
        $(document).ready(function () {
            document.getElementById('bill_no').focus();
            // validate signup form on keyup and submit
            $("#form1").validate({
                rules: {
                    bill_no: {
                        required: true,
                        minlength: 3,
                        maxlength: 200
                    },
                    stockid: {
                        required: true
                    },
                    grand_total: {
                        required: true
                    },
                    supplier: {
                        required: true,
                    },
                    payment: {
                        required: true,
                    }
                },
                messages: {
                    supplier: {
                        required: "Please Enter Supplier"
                    },
                    stockid: {
                        required: "Please Enter Stock ID"
                    },
                    payment: {
                        required: "Please Enter Payment"
                    },
                    grand_total: {
                        required: "Add Stock Items"
                    },
                    bill_no: {
                        required: "Please Enter Bill Number",
                        minlength: "Bill Number must consist of at least 3 characters"
                    }
                }
            });

        });
        function numbersonly(e) {
            var unicode = e.charCode ? e.charCode : e.keyCode
            if (unicode != 8 && unicode != 46 && unicode != 37 && unicode != 27 && unicode != 38 && unicode != 39 && unicode != 40 && unicode != 9) { //if the key isn't the backspace key (which we should allow)
                if (unicode < 48 || unicode > 57)
                    return false
            }
        }


    </script>
    <script type="text/javascript">
        function remove_row(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
        function add_values() {
            if (unique_check()) {

                if (document.getElementById('edit_guid').value == "") {
                    if (document.getElementById('item').value != "" && document.getElementById('quty').value != "" && document.getElementById('total').value != "") {

                        if (document.getElementById('quty').value != 0) {
                            code = document.getElementById('item').value;

                            quty = document.getElementById('quty').value;
                            sell = document.getElementById('sell').value;
                            disc = document.getElementById('stock').value;
                            total = document.getElementById('total').value;
                            item = document.getElementById('guid').value;
                            main_total = document.getElementById('posnic_total').value;

                            $('<tr id=' + item + '><td><input type=hidden value=' + item + ' id=' + item + 'id ><input type=text name="stock_name[]"  id=' + item + 'st style="width: 150px" class="round  my_with" ></td><td><input type=text name=quty[] readonly="readonly" value=' + quty + ' id=' + item + 'q class="round  my_with" style="text-align:right;" ></td><td><input type=text name=sell[] readonly="readonly" value=' + sell + ' id=' + item + 's class="round  my_with" style="text-align:right;"  ></td><td><input type=text name=stock[] readonly="readonly" value=' + disc + ' id=' + item + 'p class="round  my_with" style="text-align:right;" ></td><td><input type=text name=jibi[] readonly="readonly" value=' + total + ' id=' + item + 'to class="round  my_with" style="width: 120px;margin-left:20px;text-align:right;" ><input type=hidden name=total[] id=' + item + 'my_tot value=' + main_total + '> </td><td><input type=button value="" id=' + item + ' style="width:30px;border:none;height:30px;background:url(images/edit_new.png)" class="round" onclick="edit_stock_details(this.id)"  ></td><td><input type=button value="" id=' + item + ' style="width:30px;border:none;height:30px;background:url(images/close_new.png)" class="round" onclick=reduce_balance("' + item + '");$(this).closest("tr").remove(); ></td></tr>').fadeIn("slow").appendTo('#item_copy_final');
                            document.getElementById('quty').value = "";
                            document.getElementById('sell').value = "";
                            document.getElementById('stock').value = "";
                            document.getElementById('total').value = "";
                            document.getElementById('item').value = "";
                            document.getElementById('guid').value = "";
                            if (document.getElementById('grand_total').value == "") {
                                document.getElementById('grand_total').value = main_total;
                            } else {
                                document.getElementById('grand_total').value = parseFloat(document.getElementById('grand_total').value) + parseFloat(main_total);
                            }
                            document.getElementById('main_grand_total').value = parseFloat(document.getElementById('grand_total').value);
                            document.getElementById(item + 'st').value = code;
                            document.getElementById(item + 'to').value = total;
                        } else {
                            alert('No Stock Available For This Item');
                        }
                    } else {
                        alert('Please Select An Item');
                    }
                } else {
                    id = document.getElementById('edit_guid').value;
                    document.getElementById(id + 'st').value = document.getElementById('item').value;
                    document.getElementById(id + 'q').value = document.getElementById('quty').value;
                    document.getElementById(id + 's').value = document.getElementById('sell').value;
                    document.getElementById(id + 'p').value = document.getElementById('stock').value;
                    document.getElementById('grand_total').value = parseFloat(document.getElementById('grand_total').value) + parseFloat(document.getElementById('posnic_total').value) - parseFloat(document.getElementById(id + 'my_tot').value);
                    document.getElementById('main_grand_total').value = parseFloat(document.getElementById('grand_total').value);
                    document.getElementById(id + 'to').value = document.getElementById('total').value;
                    document.getElementById(id + 'id').value = id;

                    document.getElementById(id + 'my_tot').value = document.getElementById('posnic_total').value
                    document.getElementById('quty').value = "";
                    document.getElementById('sell').value = "";
                    document.getElementById('stock').value = "";
                    document.getElementById('total').value = "";
                    document.getElementById('item').value = "";
                    document.getElementById('guid').value = "";
                    document.getElementById('edit_guid').value = "";
                }
            }
            discount_amount();
        }
        function total_amount() {
            balance_amount();

            document.getElementById('total').value = document.getElementById('sell').value * document.getElementById('quty').value
            document.getElementById('posnic_total').value = document.getElementById('total').value;
            //  document.getElementById('total').value = '$ ' + parseFloat(document.getElementById('total').value).toFixed(2);
            if (document.getElementById('item').value === "") {
                document.getElementById('item').focus();
            }
        }
        function edit_stock_details(id) {
            document.getElementById('item').value = document.getElementById(id + 'st').value;
            document.getElementById('quty').value = document.getElementById(id + 'q').value;
            document.getElementById('sell').value = document.getElementById(id + 's').value;
            document.getElementById('stock').value = document.getElementById(id + 'p').value;
            document.getElementById('total').value = document.getElementById(id + 'to').value;

            document.getElementById('guid').value = id;
            document.getElementById('edit_guid').value = id;

        }
        function unique_check() {
            if (!document.getElementById(document.getElementById('guid').value) || document.getElementById('edit_guid').value == document.getElementById('guid').value) {
                return true;

            } else {

                alert("This Item is already added In This Purchase");
                document.getElementById('item').focus();
                document.getElementById('quty').value = "";
                document.getElementById('sell').value = "";
                document.getElementById('stock').value = "";
                document.getElementById('total').value = "";
                document.getElementById('item').value = "";
                document.getElementById('guid').value = "";
                document.getElementById('edit_guid').value = "";
                return false;
            }
        }
        function quantity_chnage(e) {
            var unicode = e.charCode ? e.charCode : e.keyCode
            if (unicode != 13 && unicode != 9) {
            }
            else {
                add_values();

                document.getElementById("item").focus();

            }
            if (unicode != 27) {
            }
            else {

                document.getElementById("item").focus();
            }
        }
        function formatCurrency(fieldObj) {
            if (isNaN(fieldObj.value)) {
                return false;
            }
            fieldObj.value = '$ ' + parseFloat(fieldObj.value).toFixed(2);
            return true;
        }
        function balance_amount() {
            if (document.getElementById('payable_amount').value != "" && document.getElementById('payment').value != "") {
                data = parseFloat(document.getElementById('payable_amount').value);
                document.getElementById('balance').value = data - parseFloat(document.getElementById('payment').value);
                if (parseFloat(document.getElementById('payable_amount').value) >= parseFloat(document.getElementById('payment').value)) {

                } else {
                    if (document.getElementById('payable_amount').value != "") {
                        document.getElementById('balance').value = '000.00';
                        document.getElementById('payment').value = parseFloat(document.getElementById('payable_amount').value);
                    } else {
                        document.getElementById('balance').value = '000.00';
                        document.getElementById('payment').value = "";
                    }
                }
            } else {
                document.getElementById('balance').value = "";
            }


        }
        function stock_size() {
            if (parseFloat(document.getElementById('quty').value) > parseFloat(document.getElementById('stock').value)) {
                document.getElementById('quty').value = parseFloat(document.getElementById('stock').value);

                console.log();
            }
        }
        function discount_amount() {

            if (document.getElementById('grand_total').value != "") {
                document.getElementById('disacount_amount').value = parseFloat(document.getElementById('grand_total').value) * (parseFloat(document.getElementById('discount').value)) / 100;

            }
            if (document.getElementById('discount').value == "") {
                document.getElementById('disacount_amount').value = "";
            }
            discont = parseFloat(document.getElementById('disacount_amount').value);
            if (document.getElementById('disacount_amount').value == "") {
                discont = 0;
            }
            document.getElementById('payable_amount').value = parseFloat(document.getElementById('grand_total').value) - discont;
            if (parseFloat(document.getElementById('payment').value) > parseFloat(document.getElementById('payable_amount').value)) {
                document.getElementById('payment').value = parseFloat(document.getElementById('payable_amount').value);

            }
            balance_amount();
        }
        function discount_as_amount() {
            if (parseFloat(document.getElementById('disacount_amount').value) > parseFloat(document.getElementById('grand_total').value))
                document.getElementById('disacount_amount').value = "";

            if (document.getElementById('grand_total').value != "") {
                if (parseFloat(document.getElementById('disacount_amount').value) < parseFloat(document.getElementById('grand_total').value)) {
                    discont = parseFloat(document.getElementById('disacount_amount').value);

                    document.getElementById('payable_amount').value = parseFloat(document.getElementById('grand_total').value) - discont;
                    if (parseFloat(document.getElementById('payment').value) > parseFloat(document.getElementById('payable_amount').value)) {
                        document.getElementById('payment').value = parseFloat(document.getElementById('payable_amount').value);

                    }
                } else {
                    // document.getElementById('disacount_amount').value=parseFloat(document.getElementById('grand_total').value)-1;
                }
            }
        }
        
        function add_tax() {
            var grand_tot = parseFloat(document.getElementById('grand_total').value);
            if (parseFloat(document.getElementById('tax').value) > parseFloat(document.getElementById('grand_total').value))
                document.getElementById('tax').value = "";
            var result = isNaN(parseFloat(document.getElementById('tax').value));
            if(result == true)
            {
                document.getElementById('payable_amount').value = grand_tot;
            }
            if (document.getElementById('grand_total').value != "") {
                if (parseFloat(document.getElementById('tax').value) < parseFloat(document.getElementById('grand_total').value)) {
                    tax = parseFloat(document.getElementById('tax').value);
                    document.getElementById('payable_amount').value = parseFloat(document.getElementById('grand_total').value) + tax;
                    if (parseFloat(document.getElementById('payment').value) > parseFloat(document.getElementById('payable_amount').value)) {
                        document.getElementById('payment').value = parseFloat(document.getElementById('payable_amount').value);
                    }
                }
            } 
            balance_amount();
         }
        
        function reduce_balance(id) {
            var minus = parseFloat(document.getElementById(id + "my_tot").value);
            document.getElementById('grand_total').value = parseFloat(document.getElementById('grand_total').value) - minus;
            document.getElementById('main_grand_total').value = parseFloat(document.getElementById('grand_total').value);
            discount_amount();
            //console.log(id);
        }
        function discount_type() {
            if (document.getElementById('round').checked) {
                document.getElementById("discount").readOnly = true;
                document.getElementById("disacount_amount").readOnly = false;
                if (parseFloat(document.getElementById('grand_total')) != "") {
                    document.getElementById('disacount_amount').value = "";
                    document.getElementById('discount').value = "";
                    discount_amount();
                }
            } else {
                document.getElementById("discount").readOnly = false;
                document.getElementById("disacount_amount").readOnly = true;
            }
        }
    </script>

</head>
<body>

<!-- TOP BAR -->
<?php include_once("tpl/top_bar.php"); ?>
<!-- end top-bar -->


<!-- HEADER -->
<div id="header-with-tabs">

    <div class="page-full-width cf">

        <ul id="tabs" class="fl">
            <li><a href="dashboard.php" class="dashboard-tab">Dashboard</a></li>
            <li><a href="view_sales.php" class="active-tab  sales-tab">Sales</a></li>
            <li><a href="view_customers.php" class=" customers-tab">Customers</a></li>
            <li><a href="view_purchase.php" class="purchase-tab">Purchase</a></li>
            <li><a href="view_supplier.php" class=" supplier-tab">Supplier</a></li>
            <li><a href="view_product.php" class="stock-tab">Stocks / Products</a></li>
            <li><a href="view_payments.php" class="payment-tab">Payments / Outstandings</a></li>
            <li><a href="view_report.php" class="report-tab">Reports</a></li>
        </ul>
        <!-- end tabs -->

        <!-- Change this image to your own company's logo -->
        <!-- The logo will automatically be resized to 30px height. -->
        <a href="#" id="company-branding-small" class="fr"><img src="<?php if (isset($_SESSION['logo'])) {
                echo "upload/" . $_SESSION['logo'];
            } else {
                echo "upload/posnic.png";
            } ?>" alt="Point of Sale"/></a>

    </div>
    <!-- end full-width -->

</div>
<!-- end header -->


<!-- MAIN CONTENT -->
<div id="content">

    <div class="page-full-width cf">

        <div class="side-menu fl">

            <h3>Sales Management</h3>
            <ul>
                <li><a href="add_sales.php">Add Sales</a></li>
                <li><a href="view_sales.php">View Sales</a></li>
            </ul>

        </div>
        <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">Add Sales</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                </div>
                <!-- end content-module-heading -->

                <div class="content-module-main cf">


                    <?php
                    //Gump is libarary for Validatoin
                    if (isset($_GET['msg'])) {
                        echo $_GET['msg'];
                    }

                    if (isset($_POST['payment'])) {
                        $_POST = $gump->sanitize($_POST);

                        $gump->validation_rules(array(
                            'payment' => 'required|max_len,100|min_len,1'


                        ));

                        $gump->filter_rules(array(
                            'payment' => 'trim|sanitize_string|mysqli_escape'


                        ));

                        $validated_data = $gump->run($_POST);
                        $stock_name = "";
                        $stockid = "";
                        $payment = "";
                        $bill_no = "";


                        if ($validated_data === false) {
                            echo $gump->get_readable_errors(true);
                        } else {
                            $username = $_SESSION['username'];

                            $stockid = mysqli_real_escape_string($db->connection, $_POST['stockid']);
                            $bill_no = mysqli_real_escape_string($db->connection, $_POST['bill_no']);
                            $customer = mysqli_real_escape_string($db->connection, $_POST['supplier']);
                            $address = mysqli_real_escape_string($db->connection, $_POST['address']);
                            $contact = mysqli_real_escape_string($db->connection, $_POST['contact']);
                            $count = $db->countOf("customer_details", "customer_name='$customer'");
                            if (($count == 0)&&(isset($_POST['supplier']))) {
                                $db->query("insert into customer_details(customer_name,customer_address,customer_contact1) values('$customer','$address','$contact')");
                            }else{
                                $customer = 'anonymous';
                                $db->query("insert into customer_details(customer_name,customer_address,customer_contact1) values('$customer','$address','$contact')");
                            }
                            $stock_name = $_POST['stock_name'];
                            $quty = $_POST['quty'];
                            $date = mysqli_real_escape_string($db->connection, $_POST['date']);
                            $sell = $_POST['sell'];
                            $total = $_POST['total'];
                            $payable = $_POST['subtotal'];
                            $description = mysqli_real_escape_string($db->connection, $_POST['description']);
                            $due = mysqli_real_escape_string($db->connection, $_POST['duedate']);
                            $payment = mysqli_real_escape_string($db->connection, $_POST['payment']);
                            $discount = mysqli_real_escape_string($db->connection, $_POST['discount']);
                            if ($discount == "") {
                                $discount = 00;
                            }
                            $dis_amount = mysqli_real_escape_string($db->connection, $_POST['dis_amount']);
                            if ($dis_amount == "") {
                                $dis_amount = 00;
                            }
                            $subtotal = mysqli_real_escape_string($db->connection, $_POST['payable']);
                            $balance = mysqli_real_escape_string($db->connection, $_POST['balance']);
                            $mode = mysqli_real_escape_string($db->connection, $_POST['mode']);
                            $tax = mysqli_real_escape_string($db->connection, $_POST['tax']);
                            if ($tax == "") {
                                $tax = 00;
                            }
                            $tax_dis = mysqli_real_escape_string($db->connection, $_POST['tax_dis']);
                            $temp_balance = $db->queryUniqueValue("SELECT balance FROM customer_details WHERE customer_name='$customer'");
                            $temp_balance = (int)$temp_balance + (int)$balance;
                            $db->execute("UPDATE customer_details SET balance=$temp_balance WHERE customer_name='$customer'");
                            $selected_date = $_POST['due'];
                            $selected_date = strtotime($selected_date);
                            $mysqldate = date('Y-m-d H:i:s', $selected_date);
                            $due = $mysqldate;
                            $max = $db->maxOfAll("id", "stock_entries");
                            $max = $max + 1;
                            $autoid = "SID" . $max . "";
                            for ($i = 0; $i < count($stock_name); $i++) {
                                $name1 = $stock_name[$i];
                                $quantity = $_POST['quty'][$i];
                                $rate = $_POST['sell'][$i];
                                $total = $_POST['total'][$i];


                                $selected_date = $_POST['date'];
                                $selected_date = strtotime($selected_date);
                                $mysqldate = date('Y-m-d H:i:s', $selected_date);
                                $username = $_SESSION['username'];

                                $count = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name1'");

                                if ($count >= 1) {


                                    $db->query("insert into stock_sales (tax,tax_dis,discount,dis_amount,grand_total,transactionid,stock_name,selling_price,quantity,amount,date,username,customer_id,subtotal,payment,balance,due,mode,description,count1,billnumber)
                            values('$tax','$tax_dis','$discount','$dis_amount','$payable','$autoid','$name1','$rate','$quantity','$total','$mysqldate','$username','$customer','$subtotal','$payment','$balance','$due','$mode','$description',$i+1,'$bill_no')");

                                    $amount = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name1'");
                                    $amount1 = $amount - $quantity;

                                    $db->query("insert into stock_entries (stock_id,stock_name,quantity,opening_stock,closing_stock,date,username,type,salesid,total,selling_price,count1,billnumber) values('$autoid','$name1','$quantity','$amount','$amount1','$mysqldate','$username','sales','$autoid','$total','$rate',$i+1,'$bill_no')");
                                    //echo "<br><font color=green size=+1 >New Sales Added ! Transaction ID [ $autoid ]</font>" ;


                                    $amount = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name1'");
                                    $amount1 = $amount - $quantity;
                                    $db->execute("UPDATE stock_avail SET quantity='$amount1' WHERE name='$name1'");

                                } else {
                                    echo "<br><font color=green size=+1 >There is no enough stock deliver for $name1! Please add stock !</font>";
                                }


                            }
                            $msg = "<br><font color=green size=6px >Sales Added successfully Ref: [" . $_POST['stockid'] . "] !</font>";
                            echo "<script>window.location = 'add_sales.php?msg=$msg';</script>";


                            echo "<script>window.open('add_sales_print.php?sid=$autoid','myNewWinsr','width=620,height=800,toolbar=0,menubar=no,status=no,resizable=yes,location=no,directories=no');</script>";
                            //echo "<script>window.open('add_sales_print.php?sid=$autoid','myNewWinsr','width=620,height=800,toolbar=0,menubar=no,status=no,resizable=yes,location=no,directories=no');</script>";
                            //$msg="<br><font color=green size=6px >Parchase order Added successfully Ref: [". $_POST['stockid']."] !</font>" ;
                            //header("location:  add_purchase.php?msg=$msg");
                        }

                    }

                    ?>

                    <form name="form1" method="post" id="form1" action="">
                        <input type="hidden" id="posnic_total">

                        <p><strong>Add Sales/Product </strong> - Add New ( Control +2)</p>
                        <table class="form" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <?php
                                $max = $db->maxOfAll("id", "stock_entries");
                                $max = $max + 1;
                                $autoid = "SID" . $max . "";
                                ?>
                                <td>Bill no:</td>
                                <td><input name="stockid" type="text" id="stockid" readonly="readonly" maxlength="200"
                                           class="round default-width-input" style="width:130px "
                                           value="<?php echo $autoid ?>"/></td>

                                <td>Date:</td>
                                <td><input name="date" id="test1" placeholder="" value="<?php echo date('d-m-Y'); ?>"
                                           type="text" id="name" maxlength="200" class="round default-width-input"/>
                                </td>
                                
                                

                            </tr>
                            <tr>
                                <td>Customer:</td>
                                <td><input name="supplier" placeholder="ENTER CUSTOMER" type="text" id="supplier"
                                           maxlength="200" class="round default-width-input" style="width:130px "/></td>

                                <td>Address:</td>
                                <td><input name="address" placeholder="ENTER ADDRESS" type="text" id="address"
                                           maxlength="200" class="round default-width-input"/></td>

                                <td>contact:</td>
                                <td><input name="contact" placeholder="ENTER CONTACT" type="text" id="contact1"
                                           maxlength="200" class="round default-width-input"
                                           onkeypress="return numbersonly(event)" style="width:120px "/></td>

                            </tr>
                        </table>
                        <input type="hidden" id="guid">
                        <input type="hidden" id="edit_guid">
                        <table class="form">
                            <tr>
                                <td>Item:</td>
                                <td>Quantity:</td>

                                <td>Price:</td>
                                <td>Available Stock:</td>
                                <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</td>
                                <td> &nbsp;</td>
                            </tr>
                            <tr>
<script type="text/javascript">
function ff()
{
 var focusval1=document.getElementById("item").value;
 document.getElementById("aa").innerHTML=focusval1;
 }
 </script>
                                <td><input name="" type="text" id="item" maxlength="200"autofocus="autofocus" id="xax"
                                           class="round default-width-input " style="width: 150px"/></td>

                                <td><input name="" type="text" id="quty" maxlength="200"
                                           class="round default-width-input my_with"
                                           onKeyPress="quantity_chnage(event);return numbersonly(event)"
                                           onkeyup="total_amount();unique_check();stock_size();"/></td>


                                <td><input name="" type="text" id="sell" readonly="readonly" maxlength="200"
                                           class="round default-width-input my_with"/></td>


                                <td><input name="" type="text" id="stock" readonly="readonly" maxlength="200"
                                           class="round  my_with"/></td>


                                <td><input name="" type="text" id="total" maxlength="200"
                                           class="round default-width-input " style="width:120px;  margin-left: 20px"/>
                                </td>
                                <td><input type="button" onclick="add_values()" onkeyup=" balance_amount();"
                                           id="add_new_code"
                                           style="margin-left:30px; width:30px;height:30px;border:none;background:url(images/add_new.png)"
                                           class="round"></td>

                            </tr>
                        </table>
                        <div style="overflow:auto ;max-height:300px;  ">
                            <table class="form" id="item_copy_final">

                            </table>
                        </div>


                        <table class="form">
                            <tr>
                                <td> &nbsp;</td>
                                <td> &nbsp;</td>
                                <td><input type="checkbox" id="round" onclick="discount_type()">Discount As Amount</td>
                            </tr>
                            <tr>
                                <td> &nbsp;</td>
                                <td>Discount %<input type="text" maxlength="3" class="round"
                                                     onkeyup=" discount_amount(); "
                                                     onkeypress="return numbersonly(event);" name="discount"
                                                     id="discount">
                                </td>

                                <td>Discount Amount:<input type="text" readonly="readonly"
                                                           onkeypress="return numbersonly(event);"
                                                           onkeyup=" discount_as_amount(); " class="round"
                                                           id="disacount_amount" name="dis_amount">
                                </td>
                                <td> &nbsp;</td>

                                <td> &nbsp;</td>
                                <td> &nbsp;</td>
                                <td>Grand Total:<input type="hidden" readonly="readonly" id="grand_total"
                                                       name="subtotal">
                                    <input type="text" id="main_grand_total" readonly="readonly"
                                           class="round default-width-input" style="text-align:right;width: 120px">
                                </td>
                                <td> &nbsp;</td>
                                <td>Description</td>
                                <td><textarea name="description"></textarea></td>
                            </tr>
                            <tr>
                                <td> &nbsp;</td>
                                <td>Payment:<input type="text" class="round" onkeyup=" balance_amount(); "
                                                   onkeypress="return numbersonly(event);" name="payment" id="payment">
                                </td>

                                <td>Balance:<input type="text" class="round" readonly="readonly" id="balance"
                                                   name="balance">
                                </td>
                                <td> &nbsp;</td>

                                <td> &nbsp;</td>
                                <td> &nbsp;</td>
                                <td>Payable Amount:<input type="hidden" readonly="readonly" id="grand_total">
                                    <input type="text" id="payable_amount" readonly="readonly" name="payable"
                                           class="round default-width-input" style="text-align:right;width: 120px">
                                </td>
                                <td> &nbsp;</td>
                                <td> &nbsp;</td>
                                <td> &nbsp;</td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td>Mode &nbsp;</td>
                                <td>
                                    <select name="mode">
                                        <option value="cash">Cash</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="other">Other</option>
                                    </select>
                                </td>
                                <td>
                                    Due Date:<input type="text" name="duedate" id="test2"
                                                    value="<?php echo date('d-m-Y'); ?>" class="round">
                                </td>
                                <td> Tax:<input type="text" id="tax" name="tax" onkeypress="return numbersonly(event);" onkeyup="add_tax();"></td>
                                <td>Tax Description:<input type="text" name="tax_dis"></td>


                                <td> &nbsp;</td>
                                <td> &nbsp;</td>
                            </tr>
                        </table>
                        <table class="form">
                            <tr>
                                <td>
                                    <input class="button round blue image-right ic-add text-upper" type="submit"
                                           name="Submit" value="Add">
                                </td>
                                <td> (Control + S)
                                    <input class="button round red   text-upper" type="reset" name="Reset"
                                           value="Reset"></td>
                                <td> &nbsp;</td>
                                <td> &nbsp;</td>
                            </tr>
                        </table>
                    </form>


                </div>
                <!-- end content-module-main -->


            </div>
            <!-- end content-module -->


        </div>
    </div>
    <!-- end full-width -->

</div>
<!-- end content -->


<!-- FOOTER -->
<div id="footer">
    <p>Any Queries email to <a href="mailto:sridhar.posnic@gmail.com?subject=Stock%20Management%20System">sridhar.posnic@gmail.com</a>.
    </p>

</div>
<!-- end footer -->

</body>
</html>