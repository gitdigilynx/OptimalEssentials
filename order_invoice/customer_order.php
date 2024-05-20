<?php

require_once("../inc/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // email variable 
    $product_deatil = '';
    $message = '';
    $output_array = [];
    $line_item_xero_array = array(); // isnert item for xero

    // insert data into the order table start
    $customer_id_p = $_POST['customer_id_p'];
    $order_id_post = $_POST['order_id'];
    $recurring = $_POST['recurring'];
    $invoice_id2 = $_POST['invoice_id'];
    $sub_price = $_POST['sub_price'];
    $order_payment_status = $_POST['order_payment_status'];
    $order_shipping_status = $_POST['order_shipping_status'];
    // set timezone
    $created_date_time = date('d-m-Y h:i:s:A');
    $sql = "INSERT INTO customer_order (customer_id, product_sub_total,order_payment_status,order_shipping_status,order_approval_status,order_recurring,order_created_date)
        VALUES ('$customer_id_p','$sub_price','$order_payment_status','$order_shipping_status','pending','$recurring','$created_date_time')";

    if ($conn->query($sql) === TRUE) {

        // set the order id start

        $last_id = $conn->insert_id;
        $order_id = 10000 + $last_id;
        $sql_order_id = "UPDATE customer_order SET order_id='$order_id' WHERE id=$last_id";

        if ($conn->query($sql_order_id) === TRUE) {
            // insert data into the order item  table start

            $product_ids = $_POST['product_id'];
            $variant_id = $_POST['variant_id'];
            $sku_id = $_POST['sku_id'];
            $product_title = $_POST['product_title'];
            $product_img = $_POST['product_img'];
            $quantity = $_POST['quantity'];
            $product_price = $_POST['product_price'];
            $total_price = $_POST['total_price'];
            $count = 1;
            foreach( $product_ids as $count => $code ) {
                $sql_order_items = "INSERT INTO customer_order_item ( order_id, product_id, variant_id,product_sku, product_title,product_src,product_qty,product_price,product_total)
                         VALUES ('$order_id', '$product_ids[$count]', '$variant_id[$count]','$sku_id[$count]','$product_title[$count]','$product_img[$count]','$quantity[$count]','$product_price[$count]','$total_price[$count]')";
                if ($conn->query($sql_order_items) === TRUE) {
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }


                // set xero invoice items start
                array_push($line_item_xero_array, array(
                    "ItemCode" => $sku_id[$count],
                    "Quantity" => $quantity[$count],
                    "UnitAmount" => $product_price[$count]
        
                ));
                // set xero invoice items end

                // set the mail templete for product start
                if ($count == 1) {
                    $product_deatil .= '<tr style="width:100%">
            <td
                style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif;padding-bottom:15px">
                <table
                    style="border-spacing:0;border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td
                                style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif">

                                <img src="' . $product_img[$count] . '"
                                    align="left" width="60"
                                    height="60"
                                    style="margin-right:15px;border-radius:8px;border:1px solid #e5e5e5"
                                    class="CToWUd" data-bit="iit">

                            </td>
                            <td
                                style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif;width:100%">
                                <span
                                    style="font-size:16px;font-weight:600;line-height:1.4;color:#555">' . $product_title[$count] . '&nbsp;×&nbsp;' . $quantity[$count] . '</span><br>
                            </td>
                            <td
                                style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif;white-space:nowrap">

                                <p style="color:#555;line-height:150%;font-size:16px;font-weight:600;margin:0 0 0 15px"
                                    align="right">

                                    $' . $total_price[$count] . '

                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>';
                } else {
                    $product_deatil .= '<tr
        style="width:100%;border-top-width:1px;border-top-color:#e5e5e5;border-top-style:solid">
        <td
            style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif;padding-top:15px">
            <table
                style="border-spacing:0;border-collapse:collapse">
                <tbody>
                    <tr>
                        <td
                            style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif">

                            <img src="' . $product_img[$count] . '"
                                align="left" width="60"
                                height="60"
                                style="margin-right:15px;border-radius:8px;border:1px solid #e5e5e5"
                                class="CToWUd" data-bit="iit">

                        </td>
                        <td
                            style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif;width:100%">




                            <span
                                style="font-size:16px;font-weight:600;line-height:1.4;color:#555">' . $product_title[$count] . '&nbsp;×&nbsp;' . $quantity[$count] . '</span><br>










                        </td>
                        <td
                            style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif;white-space:nowrap">

                            <p style="color:#555;line-height:150%;font-size:16px;font-weight:600;margin:0 0 0 15px"
                                align="right">

                                $' . $total_price[$count] . '

                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>';
                }
                // set the mail templete for product end

                $count++;
            }
            
            // EMPTY CART START
            
            $sql_empty_cart = "DELETE FROM customer_cartproduct_ids WHERE customer_id=$customer_id_p";
            
            // EMPTY CART END
            
            require_once("../send_mail/order_confirmation_hcp_mail.php");

            // insert data into the order item  table end

            // insert data into invoice table start
            // $sql_insert_invoice = "INSERT INTO customer_invoice (customer_id, order_id,invoice_status,sub_total,invoice_created_date)
            //          VALUES ('$customer_id_p', '$order_id','Unpaid','$sub_price','$created_date_time')";

            // if ($conn->query($sql_insert_invoice) === TRUE) {

            //     $last_id_invoice = $conn->insert_id;
            //     $invoice_id = 2000 + $last_id_invoice;
            //     $sql_inoice_id = "UPDATE customer_invoice SET invoice_id='$invoice_id' WHERE id=$last_id_invoice";

            //     if ($conn->query($sql_inoice_id) === TRUE) {
            //     } else {
            //         echo "Error updating invoice id : " . $conn->error;
            //     }

            //     //   delete the customer_id from cart start
            //     $sql_empty_cart = "DELETE FROM customer_cartproduct_ids WHERE customer_id=$customer_id_p";

            //     if ($conn->query($sql_empty_cart) === TRUE) {
            //     } else {
            //         echo "Error deleting record: " . $conn->error;
            //     }
            //     //   delete the customer_id from cart end

            //     // send mail to user
            //     require_once("../send_mail/invoice_mail.php");

            //     $output_array[0] = $order_id;
            //     $output_array[1] = $invoice_id;
            //     echo json_encode($output_array);
            // } else {
            //     echo "Error: " . $sql_insert_invoice . "<br>" . $conn->error;
            // }

            // insert data into invoice table end
        } else {
            echo "Error updating order_id: " . $conn->error;
        }
        // set the order id end





    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // insert data into the order table end


    // include the templete file


    $conn->close();
}
