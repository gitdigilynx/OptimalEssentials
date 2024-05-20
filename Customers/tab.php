<?php 


require_once("header.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

?>



<div class="container-fulid mt-5">
  <h3 class="text-center mb-4" >Customers</h3>
   <div class="row">
  <div class="col-3">
      
  </div>
  <div class="col-6">
      <ul class=" nav nav-tabs ">
    <!--<li class="nav-item">-->
    <!--  <a class="nav-link active-link active" id="1" onclick="GetDataFromDatabase('all',this.id)">All</a>-->
    <!--</li>-->
    <li class="nav-item">
      <a class="nav-link active-link " id="2"  onclick="GetDataFromDatabase('hcp',this.id)" >HCP</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active-link " id="3"  onclick="GetDataFromDatabase('hcp_client',this.id)" >HCP Client</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active-link " id="4"  onclick="GetDataFromDatabase('nutri',this.id)" >Nutritionist</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active-link " id="5"  onclick="GetDataFromDatabase('un',this.id)" >UnAssigned</a>
    </li>
  </ul>
  </div>
  

   <div class="col-3">
      <div class="mb-4" style="text-align:center;">
                    <a href="/optimalessentials/shopifyapp_ajax_call/add_Nutritionists.php"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add Nutritionist</button></a>
                </div>
  </div>
  </div>
</div>

  <div  class="col-12 d-flex">
    <div class="col-9"></div>
       <div class="col-2 text-end" style="margin-left: 6%;">
           <button id="Assigned_nutitionist_div" class="btn btn-primary Assigned_nutitionist_div">Assign Nutritionist to client</button>
           
           <button style="display:none;" id="Assigned_nutitionist_div_back" class="btn btn-primary Assigned_nutitionist_div_back">Back</button> <!--back button-->
           </div>
</div>
  


