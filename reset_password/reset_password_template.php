<?php
$output = '';
$output = '<form class="reset_pass_form" name="reset_pass_form" autocomplete="off" >
    <header style="margin-bottom: 34px;" class="Segment">
    <p style="font-size: 12px !important;display:none;" class=" password_rest_alert Form__Alert Alert Alert--error SectionHeader--center"></p>
          <h2 class="Segment__Title Heading u-h7">Reset Password</h2>
        </header>
    
            
    <div class="Form__Item">     
      <input class="Form__Input" type="text" name="password12" id="password12"  placeholder="Password" autocomplete="off"/>
      <label class="Form__FloatingLabel" for="password12">
       Password
      </label>
    </div>
    <div class="Form__Item">     
      <input class="Form__Input" type="text" name="confirm_password12" id="confirm_password12"  placeholder="Confirm Password" autocomplete="off"/>
      <label class="Form__FloatingLabel" for="confirm_password12">
       Confirm Password
      </label>
    </div>
 
    <button class="Form__Submit Button Button--primary Button--full reset_button">
      Reset
    </button>
 </form>';
 
 echo $output;

?>