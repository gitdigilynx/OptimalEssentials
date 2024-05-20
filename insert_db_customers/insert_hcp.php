<?php
?>
// exit();


//   check data for insert and update
// $sql = "SELECT * FROM nutritionists";
// $result = $conn->query($sql);











foreach ($customer1 as $customer) :
    foreach ($customer as $key => $value) :

        $select_sql = "SELECT * FROM nutritionists";

        $select_sql_result = $conn->query($select_sql);

        if ($select_sql_result->num_rows > 0) {
            // output data of each row
            while ($row = $select_sql_result->fetch_assoc()) {
                if ($row['customer_id'] == $value['id']) {

                    $sql = "UPDATE nutritionists SET first_name='$value[first_name]',last_name='$value[last_name]',email='$value[email]',tags='$value[tags]' WHERE customer_id=$value[id]";
                    if ($conn->query($sql) === TRUE) {
                        echo "New record updated successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        } else {

            $sql = "INSERT INTO nutritionists (customer_id, first_name, last_name,email,tags)
                VALUES ('$value[id]', '$value[first_name]', '$value[last_name]','$value[email]','$value[tags]')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }


    endforeach;

endforeach;
$conn->close();
