<?php


// Note why i put same code in every if statement because when i use it once it will not provide accurate result .. so i use then in each condition o work it properly


require_once("../inc/db_connect.php");

$email_type = 9;
$sql_email_template = "SELECT * FROM email_emplate where type = $email_type";

$result_email_template = $conn->query($sql_email_template);

if ($result_email_template->num_rows > 0) {
    while ($value_email_template = $result_email_template->fetch_assoc()) {
        $from = $value_email_template['email_from'];
        $subject = $value_email_template['subject'];
        $email_content = $value_email_template['content'];
    }
}
$remove_variable = preg_replace('/{{[\s\S]+?}}/', '{{}}', $email_content);;

$dataa =  (explode("{{}}", $remove_variable));


$sql = "SELECT
sender_detail.first_name as sender_first_name,
sender_detail.tags as sender_tag,
reciver_detail.first_name as reciver_first_name,
reciver_detail.tags as reciver_tag,
reciver_detail.email as reciver_mail,
chats.msg_for,
chats.message,
chats.HCPClient_email,
chats.HCP_email,
chats.HCPStaff_email,
chats.Nutritionists_email,
chats.id as chat_id

FROM 
chats as chats

LEFT JOIN Customers as sender_detail
ON  chats.customer_id = sender_detail.customer_id

LEFT JOIN Customers as reciver_detail
ON  chats.msg_for_id = reciver_detail.customer_id";

$result = $conn->query($sql);

function Send_mai_from_file($to,$subject,$message,$mail_response_msg){
    $to=$to;
    $subject=$subject;
    $message=$message;
    $mail_response_msg=$mail_response_msg;
    include('../send_mail/smtp_server/index.php');
}

if ($result->num_rows > 0) {
    $count = 0;
    $output = '';
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        
        $chat_id = $row['chat_id'];
        $check_msg_for = $row['msg_for'];
        $sender_first_name = $row['sender_first_name'];
        $sender_tag = $row['sender_tag'];
        $reciver_first_name = $row['reciver_first_name'];
        $reciver_tag = $row['reciver_tag'];
        $to = $row['reciver_mail'];
        $message = $row['message'];

        if ($check_msg_for === 'Admin') {
        } else if ($check_msg_for === 'Home Care Provider Client') {

            $check_HCPClient = $row['HCPClient_email'];
            if ($check_HCPClient == 0) {
                $message_send = $dataa[0] . $reciver_first_name . $dataa[1] .$sender_first_name.','. $sender_tag . $dataa[2] . $reciver_first_name . $dataa[3] . $message . $dataa[4];
                

                $msg_output = 'Your mail has been sent successfully.';
                Send_mai_from_file($to,$subject,$message_send,$msg_output);
                    
                    $sql_update_chat = "UPDATE chats SET HCPClient_email='1' WHERE id=$chat_id";

                    if ($conn->query($sql_update_chat) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
            }
        } else if ($check_msg_for === 'Home Care Provider (HCP)') {

            $check_HCPClient = $row['HCP_email'];
            if ($check_HCPClient == 0) {
                $message_send = $dataa[0] . $reciver_first_name . $dataa[1] .$sender_first_name.','. $sender_tag . $dataa[2] . $reciver_first_name . $dataa[3] . $message . $dataa[4];
                // $message_send = $email_content;
                
                    $msg_output = 'Your mail has been sent successfully.';
                Send_mai_from_file($to,$subject,$message_send,$msg_output);
                    $sql_update_chat = "UPDATE chats SET HCP_email='1' WHERE id=$chat_id";

                    if ($conn->query($sql_update_chat) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                
            }
        } else if ($check_msg_for === 'Home Care Provider Staff') {

            $check_HCPClient = $row['HCPStaff_email'];
            if ($check_HCPClient == 0) {
                $message_send = $dataa[0] . $reciver_first_name . $dataa[1] .$sender_first_name.','. $sender_tag . $dataa[2] . $reciver_first_name . $dataa[3] . $message . $dataa[4];
                // $message_send = $email_content;
                
                    $msg_output = 'Your mail has been sent successfully.';
                    Send_mai_from_file($to,$subject,$message_send,$msg_output);
                    $sql_update_chat = "UPDATE chats SET HCPStaff_email='1' WHERE id=$chat_id";

                    if ($conn->query($sql_update_chat) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                
            }
        } else if ($check_msg_for === 'Dietician') {

            $check_HCPClient = $row['Nutritionists_email'];
            if ($check_HCPClient == 0) {
                $message_send = $dataa[0] . $reciver_first_name . $dataa[1] .$sender_first_name.','. $sender_tag . $dataa[2] . $reciver_first_name . $dataa[3] . $message . $dataa[4];
                // $message_send = $email_content;

                
                    $msg_output = 'Your mail has been sent successfully.';
                    Send_mai_from_file($to,$subject,$message_send,$msg_output);
                    
                    $sql_update_chat = "UPDATE chats SET Nutritionists_email='1' WHERE id=$chat_id";

                    if ($conn->query($sql_update_chat) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                
            }
        }

    }
} else {
    echo "0 results";
}


echo $output;
