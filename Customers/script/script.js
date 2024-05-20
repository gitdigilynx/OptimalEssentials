
var base_url2 = 'https://app.optimalessentials.com.au/optimalessentials';

// var check_for the_updatehcp_client = 0;

var hcpclientlocation = window.location;
var newyrlclient = new URL(hcpclientlocation);
var urlcleinthcpcheck = newyrlclient.searchParams.get('tab_ative_hcp');
var check_nutritionists = newyrlclient.searchParams.get('check_nutritionists');
var newcountcheckhcpupdate = urlcleinthcpcheck;
// alert(urlcleinthcpcheck);

function GetDataFromDatabase(RoleValue, id) {
     $(".Assigned_nutitionist_div").css("display","none");
      $(".table-responsive").css("display","");
    $("#question_answer_table").css("display","none");
    $.ajax({
        url: base_url2+'/Customers/unassigned_hcp_client.php',
         data: { Role : RoleValue},
        type: "GET",
        /* or type:"GET" or type:"PUT" */
        success: function (result) {
            // console.log(result);
            $(".active-link").removeClass('active');
            $("#" + id).addClass('active');
            
            newcountcheckhcpupdate = 0;

            $("#output").html(result);
            
            // add display when the given if HCP Client
            if(RoleValue == 'hcp_client')
            {
            $("#Assigned_th").css("display", "");
             $("#Assigned_hcp_update").show();
             $("#Assigned_hcp_update").text("Edit");
           $("#Assigned_componey").hide();
            $("#Assigned_th").text("Assigned HCP");
            $("#role_th").hide();
            $("#update_th").hide();
            $("#Assigned_hcpstaff_th").hide();
            $("#Assigned_nutitionist_div").hide(); // assign nutitionist to client hide
            }
            else if(RoleValue == 'un'){
                $("#Assigned_th").css("display", "");
                $("#Assigned_hcp_update").hide();
                $("#Assigned_componey").hide();
                $("#Assigned_th").text("Assign HCP");
                $("#update_th").show();
                $("#role_th").show();
                $("#Assigned_hcpstaff_th").hide();
                $("#Assigned_nutitionist_div").hide(); // assign nutitionist to client hide
            }else if(RoleValue == 'hcp'){
                
                $("#Assigned_th").css("display", "");
                $("#Assigned_hcp_update").hide();
                $("#Assigned_componey").show();
                $("#Assigned_hcpstaff_th").show();
                $("#Assigned_componey").text("Componay");
                $("#Assigned_hcpstaff_th").text("HCP Staff");
                $("#Assigned_th").text("HCP Client");
                $("#update_th").hide();
                 $("#role_th").hide();
                 $("#Assigned_nutitionist_div").hide(); // assign nutitionist to client hide
            }else {
                 $("#width_email").css("width", "30%");
                $("#Assigned_th").css("display", "none");
                $("#Assigned_hcp_update").hide();
                $("#Assigned_componey").hide();
                $("#update_th").hide();
                $("#Assigned_hcpstaff_th").css("display", "none");
                 $("#role_th").hide();
                 $("#Assigned_hcpstaff_th").hide();
                 $("#Assigned_nutitionist_div").show(); // assign nutitionist to client show
            }
            

        },
        error: function () {
            console.log("error");
        }
    });

}

if(newcountcheckhcpupdate == 3)
            {
GetDataFromDatabase('hcp_client', 3);
}else{
    if(check_nutritionists == 'nutritionists')
    {
        GetDataFromDatabase('nutri', 4);
    }else{
        GetDataFromDatabase('hcp', 2);
    }
    
}
function myFunction(id)
{
    var id_client = id;
    // var id_hcp = $("#"+id).val();
    var staff_id = $("#"+id).val();
    // console.log(id_client);
    // console.log(staff_id);
   

    
    if(staff_id){
        $.ajax({
        url: base_url2+'/Customers/set_hcp_for_client.php',
         data: { 
             id_client : id_client,
             staff_id : staff_id
            //  id_hcp:id_hcp
             
         },
        type: "GET",
        /* or type:"GET" or type:"PUT" */
        success: function (result) {
            console.log(result);
            GetDataFromDatabase('un', 5)

        },
        error: function () {
            console.log("error");
        }
    });
    }else{
        Swal.fire({
          icon: 'info',
          title: 'Oops...',
          text: 'Please select an Home Care Provide (HCP)!'
        });
    }
     
   
}


//////////// update hcp of hcpclient table////////
 function updatehcpclient (id)
 {
    var hcp_id = $("#select_assign_hcp").val();
   var customer_id = id;
     
     
      $.ajax({
        url: base_url2+'/Customers/set_hcp_for_client.php',
         data: { 
             id_client : customer_id,
             staff_id : hcp_id
            //  id_hcp:id_hcp
             
         },
        type: "GET",
        /* or type:"GET" or type:"PUT" */
        success: function (result) {
            console.log(result);
            
        // if(result==='Success'){
            Swal.fire({
              
              icon: 'success',
              title: result+'Successfully!',
              showConfirmButton: false,
              timer: 1500
            });
            
            setTimeout(function() { 
                location.href = "customer_list.php?tab_ative_hcp=3";
            }, 1000);
        // }
        },
        error: function () {
            console.log("error");
        }
    });
 }
 
 
 $("#Assigned_nutitionist_div").click(function(){
    $.ajax({
        url: base_url2+'/Customers/assign_nutritionist_to_client.php',
         
        type: "GET",
        /* or type:"GET" or type:"PUT" */
        success: function (result) {
            // console.log(result);
            $('#output').html(result);
            $('#role_th').show();
            $('#Assigned_th').text('Assign Nutritionist');
            $('#Assigned_th').show();
            $('#update_th').show();
            $('#Assigned_nutitionist_div').hide();
            $('#Assigned_nutitionist_div_back').show();
        },
        error: function () {
            console.log("error");
        }
    });
  });
  
  
   $("#Assigned_nutitionist_div_back").click(function(){
        $('#Assigned_nutitionist_div_back').hide();
        GetDataFromDatabase('nutri',4);
   });
  
  
function update_nutritionist_to_client(cutomer_id)
{
   
    
    var nutitionist_id = $('#nutritionists_select_'+cutomer_id).val();
    if(nutitionist_id){
        
         $.ajax({
        url: base_url2+'/Customers/save_update_nutrtionist_for_client.php',
        data :{
            cutomer_id:cutomer_id,
            nutitionist_id:nutitionist_id
        },
        type: "GET",
        /* or type:"GET" or type:"PUT" */
        success: function (result) {
            console.log(result);
            Swal.fire({
              icon: 'success',
              title: result,
              showConfirmButton: false,
              timer: 1500
            });
        },
        error: function () {
            console.log("error");
        }
    });
         
    }else{
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Please select Nutrtionist',
        });
    }
    
}
 
 







