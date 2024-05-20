<?php





$output .='<div class="">
<form id="staff_from" class="Form Form--spacingTight" action="https://app.optimalessentials.com.au/optimalessentials/shopifyapp_ajax_call/save_hcp_staff.php"  method="POST" >
    <header style="margin-bottom: 34px;" class="Segment">
          <h2 class="Segment__Title Heading u-h7">Add Staff</h2>
        </header>
    <div class="Form__Item">      
      <input
        type="text"
        class="Form__Input"
        name="customer[first_name]"
        id="RegisterForm-FirstName"
        {% if form.first_name %}value=""
        autocomplete="given-name"
        placeholder="First Name"
        autofocus=""
      >
      <label class="Form__FloatingLabel" for="RegisterForm-FirstName">
       First Name
      </label>
    </div>
    <div class="Form__Item">
      <input
        type="text"
        class="Form__Input"
        name="customer[last_name]"
        id="RegisterForm-LastName"
        {% if form.last_name %}value=""
        autocomplete="family-name"
        placeholder="Last Name"
      >
      <label class="Form__FloatingLabel" for="RegisterForm-LastName">
        Last Name
      </label>
    </div>
    <div class="Form__Item">      
      <input
      class="Form__Input"
        type="email"
        name="customer[email]"
        id="RegisterForm-email"
        {% if form.email %} value=""
        spellcheck="false"
        autocapitalize="off"
        autocomplete="email"
        aria-required="true"
        
        placeholder="Email"
      >
      <label class="Form__FloatingLabel" for="RegisterForm-email">
      Email
      </label>
    </div>
   
        
      </span>
 




  <!--     Custom code added for Role  start -->
           
      <input
        type="text"
        name="customer[tags]"
        id="RegisterForm-tag"
        aria-required="true"
        placeholder="Tags"
        value="HCPStaff"
       hidden>
       
      <input
        type="text"
        name="customer[hcp_id]"
        id="RegisterForm_idstaff"
        aria-required="true"
        placeholder="Tags"
        value=""
       hidden>
   
    <!--      Custom code added for Role  start -->


            
    <div class="Form__Item">     
      <input
      class="Form__Input"
        type="password"
        name="customer[password]"
        id="RegisterForm-password"
        aria-required="true"
        placeholder="Password"
      >
      <label class="Form__FloatingLabel" for="RegisterForm-password">
       Password
      </label>
    </div>
 
    <button class="Form__Submit Button Button--primary Button--full" >
      Add Staff
    </button>
 </form>
</div>';
echo $output;
?>