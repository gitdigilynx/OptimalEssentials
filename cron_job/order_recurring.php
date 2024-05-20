<?php 
require_once("../inc/db_connect.php");



        
        // set timezone
        $current_date = date('d-m-Y');
        $sql = "SELECT * FROM customer_order";
        $result = $conn->query($sql);

if($result->num_rows > 0)
{
    while( $value = $result->fetch_assoc()){
        // get data from datbase
        $order_created_date = $value['order_created_date'];
        $order_recurring = $value['order_recurring'];
        // insert data into the order table start
                        $customer_id_p = $value['customer_id'];
                        $order_id_old = $value['order_id'];
                        $recurring = $value['order_recurring'];
                        $sub_price = $value['product_sub_total'];
                        
        
        // get the date only
        $date = explode(" ",$order_created_date);
        $exact_date = $date[0];
        
        // make the varchardate into date formate
        $exact_datenew = strtotime($exact_date);
        $date_week_add = strtotime('+'.$order_recurring.' week', $exact_datenew); // add week to date
        $date_after_week_add = date('d-m-Y', $date_week_add); 
        
        // To send email before 7 days/ 1 week to customer start
        $exact_datenew1 = strtotime($date_after_week_add);
        $date_week_minus = strtotime('-1 week', $exact_datenew1); // minius 1 week to date
        $date_after_week_minus = date('d-m-Y', $date_week_minus); 
        
         if($current_date == $date_after_week_minus)
        {
         include '../send_mail/unscribe_email.php';
        }
        else{
            // include '../send_mail/unscribe_email.php';
            // do nothing hre
        }
        
       
        // To send email before 7 days/ 1 week to customer start
        // check the date with current date
        if($recurring != 0){
            if($current_date == $date_after_week_add)
        {
                    //random order_id and invoice_id
                    $order_id = rand(8999,9999);
                    $invoice_id = rand(8999,9999);
            $current_date_time = $current_date.' '.$date[1];
                    
                        $sql = "INSERT INTO customer_order (customer_id, product_sub_total,order_payment_status,order_shipping_status,order_recurring,order_created_date)
                            VALUES ('$customer_id_p',  '$sub_price','Unpaid','Unshipped','$recurring','$current_date_time')";
                            
                            if ($conn->query($sql) === TRUE) {
                                $order_id_last = $conn->insert_id;
                                $order_id = '100'.$order_id_last;
                                
                                
                                $sql_updateOrder = "UPDATE customer_order SET order_id='$order_id' WHERE id=$order_id_last";

                                if ($conn->query($sql_updateOrder) === TRUE) {
                                    echo 'success order_id update';
                                }else{
                                    echo 'failed orderid update';
                                }
                                
                                // get all the product of old orders start 
                                $sql_old_data = "SELECT * FROM customer_order_item WHERE order_id=$order_id_old";
                                $result_old_data = $conn->query($sql_old_data);
                                if($result_old_data->num_rows > 0)
                                {
                                    while($value_old_data = $result_old_data->fetch_assoc())
                                    {
                                        $product_ids = $value_old_data['product_id'];
                                        $product_title = $value_old_data['product_title'];
                                        $product_img = $value_old_data['product_src'];
                                        $quantity = $value_old_data['product_qty'];
                                        $product_price = $value_old_data['product_price'];
                                        $total_price = $value_old_data['product_total'];
                                        // insert data into the order item  table start
                    
                                        $sql_order_items = "INSERT INTO customer_order_item ( order_id, product_id,product_title,product_src,product_qty,product_price,product_total)
                                             VALUES ('$order_id', '$product_ids','$product_title','$product_img','$quantity','$product_price','$total_price')";
                                         if ($conn->query($sql_order_items) === TRUE) {
                                            
                                            } else {
                                              echo "Error: " . $sql . "<br>" . $conn->error;
                                            }
                    
                                        // insert data into the order item  table end
                                        
                                        
                                    }
                                }else {
                                    echo "Error: " . $sql_old_data . "<br>" . $conn->error;
                                }
                                // get all the product of old orders end 
                                
                             
                                            
                               
                                
                                  // insert data into invoice table start
                                 $sql_insert_invoice = "INSERT INTO customer_invoice ( customer_id, order_id,invoice_status,sub_total,invoice_created_date)
                                         VALUES ('$customer_id_p', '$order_id','Unpaid','$sub_price','$current_date_time')";
                                
                                if ($conn->query($sql_insert_invoice) === TRUE) {
                                    $invoice_id_last = $conn->insert_id;
                                    $invoice_id = '20'.$invoice_id_last;
                                     $sql_updateinvoice = "UPDATE customer_invoice SET invoice_id='$invoice_id' WHERE id=$invoice_id_last";

                                if ($conn->query($sql_updateinvoice) === TRUE) {}
                                } else {
                              echo "Error: " . $sql_insert_invoice . "<br>" . $conn->error;
                            }
                            
                                // insert data into invoice table end
                                   
                            } else {
                              echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                    // insert data into the order table end
                    
                    
                    
                    

        }
        }
        
       
        
        
        
    }
   
}

?>

 <!--$date2 = date_parse_from_format('d-M-Y:h:i:s:A', $order_created_date);-->
 <!--       echo $date2['year'].'<br>';-->
 <!--       echo $date2['month'].'<br>';-->
 <!--       echo $date2['day'].'<br>';-->