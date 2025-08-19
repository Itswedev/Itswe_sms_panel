
    var table;
    var frmDate = "";
    var toDate = "";
 
var today_report_type="";
            
$(function() {


    
  

    var page_name=$("#page_name").html();

    load_gateway_dropdown();


    $(document).on("change","#user_role_dropdown", function (e) {

        var user_role=$("#user_role_dropdown").val();

        if(user_role!='All')
        {
            load_users();
        }
        else
        {
            if(page_name=='Today Summary Report')
            {
                load_today_summary_report();
            }
            else if(page_name=='Scheduled Report')
            {
                load_scheduled_report();
            }
            
        }
        
});

     // $("#gateway_dropdown").change(function(){
       
     //        load_today_gateway_summary_report();

     //        })
         
});
function load_gateway_dropdown()
{
        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/gateway_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=all_gateway_name',
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#gateway_dropdown').empty();
                    $('#gateway_dropdown').html(data);

                     

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}



function searchData() {
                frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
                toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
                table.draw();
            }

function searchData_archive_report() {

    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
   
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    table.draw();
}
function searchData_download_report() {

    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
   
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
   //load_downlaod_report();
}
function load_today_report()
{


    var full_url = window.location.origin+"/itswe_sms_app";
    $.ajax({
                url: full_url+'/controller/report_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_today_report',
                /*dataType:'json',*/
                success: function(data){
                    //var res = JSON.parse(JSON.stringify(data));
                    console.log(data);
                   $("#today_report_list").html(data);
                    
                   
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });



  
}

function load_today_gateway_summary_report()
{
    //alert('summary');
    var full_url = window.location.origin+"/itswe_sms_app";
    
    var gateway_id=$("#gateway_dropdown").val();
    var frmDate = $("#frmDate").val();
    var toDate = $("#toDate").val();
    var month = 0;
    var dataString="";

    if(frmDate!="" && toDate!="")
    {
        month_frm = new Date(frmDate).getMonth();
        month_to = new Date(frmDate).getMonth();
        //yr = new Date(frmDate).getYear();
        
        var year = new Date(frmDate).getFullYear(); 
        month_frm = month_frm + 1 ;
        month_to = month_to + 1 ;
        //console.log(year);
        if(month_frm!=month_to)
        {
            alert('Please select date from same month!!!');
        }
        else
        {
          dataString= 'list_type=load_gateway_summary'+'&gateway='+gateway_id+"&frmDate="+frmDate+"&toDate="+toDate+"&month="+month_frm+"&year="+year;   
        }
        
    }
    else
    {
        dataString= 'list_type=load_gateway_summary'+'&gateway='+gateway_id;
    }

    console.log(month);
    
    
       
    
     $.ajax({
                url: full_url+'/controller/report_controller.php',
                type: 'post',
                data:dataString,
                cache: false,
                beforeSend: function(){
                    $("#loading_modal").modal('show');
                  },
                  complete: function(){
                   $("#loading_modal").modal('hide');
                  },
                success: function(data){
                    // console.log(data);
                   if(data!=0)
                   {
                    $('#today_summary_list').empty();
                    $('#today_summary_list').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_today_voice_summary_report()
{
    //alert('summary');
    var full_url = window.location.origin+"/itswe_sms_app";
    var selected_role=$("#user_role_dropdown").val();
    var user_role=$("#user_role").val();
    var u_id=$("#user_dropdown").val();
    var dataString="";
    if(user_role=='mds_rs' || user_role=='mds_ad' || user_role=='mds_adm')
    {
        dataString='list_type=load_today_summary'+'&user_role='+user_role+'&u_id='+u_id+'&selected_role='+selected_role;
    }
    else
    {
       dataString= 'list_type=load_today_summary'+'&user_role='+user_role;
    }


     $.ajax({
                url: full_url+'/controller/report_controller.php',
                type: 'post',
                data:dataString,
                cache: false,
                    beforeSend: function(){
                     $('.ajax-loader').css("visibility", "visible");
                   },
                   complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                   },
                success: function(data){
                    /*console.log(data);*/
                   if(data!=0)
                   {
                    $('#today_summary_list').empty();
                    $('#today_summary_list').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}