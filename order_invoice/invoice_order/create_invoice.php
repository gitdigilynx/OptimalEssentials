<?php

require_once("../../inc/db_connect.php");

$order_id = $_GET['order_id'];

$invoice_xero_invoice_res = '';
$output_array = [];

$hcp_details =[];
$line_item_xero_array = array(); // isnert item for xero

$sql_check_invoice = "SELECT id,invoice_id,customer_id FROM customer_invoice where order_id=$order_id";
$result_check_invoice = $conn->query($sql_check_invoice);

if ($result_check_invoice->num_rows > 0) {
  // output data of each row
  $value_check_invoice = $result_check_invoice->fetch_assoc();
    $output_array[0] = 'exsits';
    $output_array[1] = $value_check_invoice['customer_id'];
    $output_array[2] = $value_check_invoice['invoice_id'];
    echo json_encode($output_array);
} else {
 
            
            
            $sql_address_get = "
            SELECT 
            customersorder.product_sub_total,
            customersorder.customer_id,
            customers.email,
            customeraddress.customer_fname,
            customeraddress.customer_lname,
            customeraddress.customer_address1,
            customeraddress.customer_address2,
            customeraddress.customer_city,
            customeraddress.customer_zip,
            customeraddress.customer_counrty,
            Customers_hcp.first_name as hcp_fname,
            Customers_hcp.last_name as hcp_lname,
            Customers_hcp.email as hcp_email,
            hcp_address.customer_address1 as hcp_address1,
            hcp_address.customer_address2 as hcp_address2,
            hcp_address.customer_city as hcp_city,
            hcp_address.customer_zip as hcp_zip,
            hcp_address.customer_state_code as hcp_customer_state_code,
            hcp_address.customer_phone as hcp_customer_phone,
            hcp_address.customer_counrty as hcp_country
            
            FROM 
            
            customer_order as customersorder
            
            LEFT JOIN cutomer_address AS customeraddress
            ON customersorder.customer_id = customeraddress.customer_id
            
            LEFT JOIN Customers AS customers
            ON customersorder.customer_id = customers.customer_id
            
            
            LEFT JOIN Customers AS Customers_hcp
            ON customers.hcp_id = Customers_hcp.customer_id
            
            LEFT JOIN cutomer_address AS hcp_address
            ON customers.hcp_id = hcp_address.customer_id
            
            WHERE customersorder.order_id=$order_id";
            
            $result_address_get = $conn->query($sql_address_get);
            
            if ($result_address_get->num_rows > 0) {
                
                $value_address_get = $result_address_get->fetch_assoc();
                
                // subtotal
                $sub_price = $value_address_get['product_sub_total'];
                
                // customer id
                $customer_id_p = $value_address_get['customer_id'];
                
                // customer address
                $customer_fname = $value_address_get['customer_fname'];
                $customer_lname = $value_address_get['customer_lname'];
                $customer_name = $customer_fname . ' ' . $customer_lname;
                $customer_address1 = $value_address_get['customer_address1'];
                $customer_address2 = $value_address_get['customer_address2'];
                $customer_city = $value_address_get['customer_city'];
                $customer_zip = $value_address_get['customer_zip'];
                $customer_counrty = $value_address_get['customer_counrty'];
                // HCP address
                
                $hcp_fname = $value_address_get['hcp_fname'];
                $hcp_details['first_name']= $hcp_fname;
                
                $hcp_lname = $value_address_get['hcp_lname'];
                $hcp_details['hcp_lname']= $hcp_lname;
                
                $hcp_name = $hcp_fname . ' ' . $hcp_lname;
                $hcp_customer_phone = $value_address_get['hcp_customer_phone'];
                $hcp_details['hcp_customer_phone']= $hcp_customer_phone;
                
                $hcp_address1 = $value_address_get['hcp_address1'];
                $hcp_details['hcp_address1']= $hcp_address1;
                
                $hcp_address2 = $value_address_get['hcp_address2'];
                $hcp_details['hcp_address2']= $hcp_address2;
                
                $hcp_city = $value_address_get['hcp_city'];
                $hcp_details['hcp_city']= $hcp_city;
                
                $hcp_zip = $value_address_get['hcp_zip'];
                $hcp_details['hcp_zip']= $hcp_zip;
                
                $hcp_counrty = $value_address_get['hcp_country'];
                $hcp_details['hcp_country']= $hcp_counrty;
                
                $hcp_customer_state_code = $value_address_get['hcp_customer_state_code'];
                $hcp_details['region']= $hcp_customer_state_code;
                
                $staff_id_check = $value_address_get['staff_id'];
                // customer email
                $to = $value_address_get['email'];
                $hcp_email = $value_address_get['hcp_email'];
                $hcp_details['hcp_email']= $hcp_email;
                
                
                // customer email
                $to = $value_address_get['email'];
                
            } else {
                echo 'eror' . $conn->error;;
            }
            
            
            // get order item start
            $sql_selet_item = "SELECT * FROM customer_order_item WHERE order_id=$order_id";
            $result_selet_item = $conn->query($sql_selet_item);
            
            if($result_selet_item->num_rows > 0)
            {
                $count = 1;
                while($value_selet_item = $result_selet_item->fetch_assoc())
                {
                    $product_img = $value_selet_item['product_src'];
                    $product_sku = $value_selet_item['product_sku'];
                    $product_title = $value_selet_item['product_title'];
                    $product_qty = $value_selet_item['product_qty'];
                    $product_price = $value_selet_item['product_price'];
                    $product_total = $value_selet_item['product_total'];
                    
                    // set xero invoice items start
                array_push($line_item_xero_array, array(
                    "ItemCode" => $product_sku,
                    "Quantity" => $product_qty,
                    "UnitAmount" => $product_price
        
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
            
                                            <img src="' . $product_img . '"
                                                align="left" width="60"
                                                height="60"
                                                style="margin-right:15px;border-radius:8px;border:1px solid #e5e5e5"
                                                class="CToWUd" data-bit="iit">
            
                                        </td>
                                        <td
                                            style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif;width:100%">
                                            <span
                                                style="font-size:16px;font-weight:600;line-height:1.4;color:#555">' . $product_title . '&nbsp;×&nbsp;' . $product_qty . '</span><br>
                                        </td>
                                        <td
                                            style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif;white-space:nowrap">
            
                                            <p style="color:#555;line-height:150%;font-size:16px;font-weight:600;margin:0 0 0 15px"
                                                align="right">
            
                                                $' . $product_total . '
            
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
            
                                        <img src="' . $product_img. '"
                                            align="left" width="60"
                                            height="60"
                                            style="margin-right:15px;border-radius:8px;border:1px solid #e5e5e5"
                                            class="CToWUd" data-bit="iit">
            
                                    </td>
                                    <td
                                        style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif;width:100%">
            
            
            
            
                                        <span
                                            style="font-size:16px;font-weight:600;line-height:1.4;color:#555">' .$product_title . '&nbsp;×&nbsp;' . $product_qty . '</span><br>
            
            
            
            
            
            
            
            
            
            
                                    </td>
                                    <td
                                        style="font-family:-apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,&quot;Roboto&quot;,&quot;Oxygen&quot;,&quot;Ubuntu&quot;,&quot;Cantarell&quot;,&quot;Fira Sans&quot;,&quot;Droid Sans&quot;,&quot;Helvetica Neue&quot;,sans-serif;white-space:nowrap">
            
                                        <p style="color:#555;line-height:150%;font-size:16px;font-weight:600;margin:0 0 0 15px"
                                            align="right">
            
                                            $' . $product_total . '
            
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
            }else{
                echo     'error';die();
            }
            // get order item end
            
            // current date
            $created_date_time = date('d-m-Y h:i:s:A');
            
             $sql_insert_invoice = "INSERT INTO customer_invoice (customer_id, order_id,invoice_status,sub_total,invoice_created_date)
                                 VALUES ('$customer_id_p', '$order_id','Unpaid','$sub_price','$created_date_time')";
            
                        if ($conn->query($sql_insert_invoice) === TRUE) {
            
                            $last_id_invoice = $conn->insert_id;
                            $invoice_id = 2000 + $last_id_invoice;
                            $sql_inoice_id = "UPDATE customer_invoice SET invoice_id='$invoice_id' WHERE id=$last_id_invoice";
            
                            if ($conn->query($sql_inoice_id) === TRUE) {
                            } else {
                                echo "Error updating invoice id record: " . $conn->error;
                            }
            
                            //   delete the customer_id from cart start
                            // $sql_empty_cart = "DELETE FROM customer_cartproduct_ids WHERE customer_id=$customer_id_p";
            
                            // if ($conn->query($sql_empty_cart) === TRUE) {
                            // } else {
                            //     echo "Error deleting record: " . $conn->error;
                            // }
                            //   delete the customer_id from cart end
            
                            // send mail to user
                            
                            
                            
                            // include('../../send_mail/invoice_mail.php');
                            
                            // call xero for creating invoice start
                            require_once('../../xero/create_customer_and_invoice_xero.php');
                            // call xero for creating invoice end
            
                            $output_array[0] = $order_id;
                            $output_array[1] = $invoice_id;
                            $output_array[2] = $customer_id_p;
                            echo json_encode($output_array);
                        } else {
                            echo "Error: " . $sql_insert_invoice . "<br>" . $conn->error;
                        }
}
?>