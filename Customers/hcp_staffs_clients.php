<?php
    
    require_once("header.php");
    require_once("../inc/db_connect.php");
    
 
$hcp_id = $_GET['customer_id'];

$customer_email= $_GET['customer_email'];

$customer_role = $_GET['customer_role'];

if($customer_role == 'HCPClient'){
$sql2 = "SELECT * FROM Customers WHERE  tags= 'HCPClient' AND hcp_id='$hcp_id'  ORDER BY id DESC;";
$customer = 'HCP Client of';
}
else{
    $sql2 = "SELECT * FROM Customers WHERE  tags= 'HCPStaff' AND hcp_id='$hcp_id'  ORDER BY id DESC;";
$customer = 'HCP Staff of';
}
    
     
     
    $result2 = $conn->query($sql2);
?>
    
 <div class="container-fluid mt-5">
    <h3 class="text-center mb-4"><?= $customer?> "<?= $customer_email?>"</h3>
<div class="mb-2" style="text-align:right;">
    <a href="customer_list.php"><button type="button" class="btn btn-primary" ><i class="fa fa-chevron-circle-left"></i> Back</button></a>
</div>
  <div class="table-responsive">
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Role</th>
      </tr>
    </thead>
    <tbody>
    
<?php

    if ($result2->num_rows > 0) {
          
        // output data of each row
        $index = 1;
        while ($value = $result2->fetch_assoc()) {
 ?>
           
                <tr>      <td><?php echo $index++;?></td>
                          <td><?php echo $value['first_name'];?></td>
                          <td><?php echo $value['last_name'];?></td>
                          <td><?php echo $value['email'];?></td>
                          <td><?php echo $value['tags'];?></td>
                </tr>

                    
  <?php
      
    } 
        
    }
    else {
        
  ?>
        <tr style="text-align:center;" >
                          <td colspan ="5"> No <?= $customer?>  Added yet.</td>
        </tr>
 <?php
  }
 ?>
    

<?php require_once("footer.php") ?>