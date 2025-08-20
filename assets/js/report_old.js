
	var table;
	var frmDate = "";
    var toDate = "";
 
var today_report_type="";
			
$(function() {

    /*$("#user_role_dropdown").chosen();
     $("#user_role_dropdown_chosen").css('width','80%');*/
         /*$("#user_dropdown").chosen();
         $(`#user_dropdown_chosen`).trigger("chosen:updated");
     $("#user_dropdown_chosen").css('width','80%');*/

	var page_name=$("#page_name").html();
	if(page_name=='Today Summary Report')
	{
        var user_role=$("#user_role").val();
        if(user_role=="mds_rs" || user_role=="mds_ad" || user_role=="mds_adm")
        {
            $("#user_dropdown").change(function(){
       
            load_today_summary_report();

            })
        }
        else
        {
            load_today_summary_report();
            
        }


    
		
	}
	else if(page_name=='Today Report')
	{

		 //today_report_type="total";
		 var list_type="today_report";
		 var today_report=$("#report_type").val();
          var selected_role=$("#selected_role").val();

 var user_role=$("#user_role").val();

 var uid=$("#uid").val();
         var full_url = window.location.origin;
		 table= $('#today_report_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
         			"type":"POST",
         			"url":full_url+"/controller/report_controller.php",
         			"data":function (post) {
	         					post.list_type=list_type;
	         					post.report_type=today_report;
                                post.user_role=user_role; 
                                post.uid=uid; 
                                post.selected_role=selected_role; 
                               
                               
	         					if(frmDate!="" && toDate!="")
	         					{
	         						 post.frmDate = frmDate;
	                            	post.toDate = toDate;
	         					}
         				

                           
                        }
         },
        /* "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(total);
        },*/
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 500]],
         /* "dom": 'Blfrtip',
        "buttons":[{
				  extend: 'collection',
				  className: 'exportButton btn btn-primary',
				  text: 'Data Export',
				  titleAttr: 'Today Report',
				  buttons: [{ extend: 'csv', className: 'btn btn-primary',title:'Today Report' },
				  { extend: 'excel', className: 'btn btn-primary',title:'Today Report' },
				  { extend: 'pdf', className: 'btn btn-primary',title:'Today Report' },
				  { extend: 'print', className: 'btn btn-primary',title:'Today Report' },],
				  exportOptions: {
				  modifer: {
				  page: 'all',
				     }
				  },

				}],
          stateSave: true,*/
         "order": [[ 8, "desc" ]],
          "columnDefs": [
        				{"className": "dt-center", "targets": "_all"}
      		]

    	} );

	}
	else if(page_name=='Archive Report')
	{






 var user_role=$("#user_role").val();
        if(user_role=="mds_rs" || user_role=='mds_ad')
        {
            $("#user_dropdown").change(function(){
       
            load_archive_report();

            })
        }
        else if(user_role=='mds_adm')
        {
           // load_username_dropdown();
           
            load_archive_report();
        }
        else
        {

           load_archive_report();
        }

		/*download archive report*/
            $(document).on('click','#download_report_btn',function(){
            
            var list_type="archive_report"; 
            var full_url = window.location.origin;

            var data_string="list_type="+list_type+"&frmDate="+frmDate+"&toDate="+toDate;
                 $.ajax({
                    url: full_url+"/controller/download_report_controller.php",
                    type: 'post',
                    data: data_string,
                    cache: false,
                    beforeSend: function(){
                     $('.ajax-loader').css("visibility", "visible");
                   },
                   complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                   },
                    success: function(data){
                        //alert(data);
                    window.open(full_url+"/controller/download_report_controller.php?"+data_string);
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });


            
            })


            

		
	}
        else if(page_name=='download report')
    {

         $(document).on('click','#search_submit',function(){
            
       
                var full_url = window.location.origin;
          
               $.ajax({
                    url: full_url+'/controller/report_controller.php',
                    type: 'post',
                    cache: false, 
                    data:$("#download_report_form").serialize(),
                    async:true,
                     beforeSend: function(){
                         $('.ajax-loader').css("visibility", "visible");
                       },
                       complete: function(){
                        $('.ajax-loader').css("visibility", "hidden");
                       },
                    success: function(data){
                       /* console.log(data);*/
                        $(".download_archive_report_list").empty();
                        $(".download_archive_report_list").append(data);
                       
                       // console.log(data);
                 
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
            
            })


              $(document).on('click','#download_count_report',function(){
            
       
                var full_url = window.location.origin;
          
               $.ajax({
                    url: full_url+'/controller/download_report_controller.php',
                    type: 'post',
                    cache: false, 
                    data:$("#download_report_form").serialize(),
                    async:true,
                     beforeSend: function(){
                         $('.ajax-loader').css("visibility", "visible");
                       },
                       complete: function(){
                        $('.ajax-loader').css("visibility", "hidden");
                       },
                    success: function(){
                      
                       
                       // console.log(data);
                 
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
            
            })


 var user_role=$("#user_role").val();
        if(user_role=="mds_rs" || user_role=='mds_ad')
        {
            $("#user_dropdown").change(function(){
       
           // load_downlaod_report();

            })
        }
        else if(user_role=='mds_adm')
        {
           // load_username_dropdown();
           
          //  load_downlaod_report();
        }
        else
        {

          // load_downlaod_report();
        }

        /*download archive report*/
     /*       $(document).on('click','#download_report_btn',function(){
            
            var list_type="download_report"; 
            var full_url = window.location.origin;

            var data_string="list_type="+list_type+"&frmDate="+frmDate+"&toDate="+toDate;
                 $.ajax({
                    url: full_url+"/controller/download_report_controller.php",
                    type: 'post',
                    data: data_string,
                    cache: false,
                    beforeSend: function(){
                     $('.ajax-loader').css("visibility", "visible");
                   },
                   complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                   },
                    success: function(data){
                        //alert(data);
                    window.open(full_url+"/controller/download_report_controller.php?"+data_string);
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });


            
            })*/
        
    }
	else if(page_name=='Scheduled Report')
	{
        var user_role=$("#user_role").val();
        if(user_role=="mds_rs" || user_role=='mds_ad' || user_role=='mds_adm')
        {
            $("#user_dropdown").change(function(){
       
            load_scheduled_report();

            })
        }
        else
        {
            load_scheduled_report();
        }
		



         $(document).on( "click", '.delete_message_job_btn',function(e) {

            
            var msg_id = $(this).data('id');
            var table_name = $(this).data('tblname');
            
        /*  alert(table_name);*/

        swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this schedule!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#2c7be5',
  cancelButtonColor: '#748194',
  confirmButtonText: 'Yes',
  showClass: {
    popup: 'animate__animated animate__heartBeat'
  },
  hideClass: {
    popup: 'animate__animated animate__fadeOutUp'
  }
}).then((result) => {
  if (result.isConfirmed) {
    var full_url = window.location.origin;
               $.ajax({
                url: full_url+'/controller/report_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=delete_schedule&msg_id='+msg_id+'&table_name='+table_name,
                success: function(data){
                   swal.fire('',data,'success').then((value) => {
                             location.reload();
                            });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });

           }
        });


          
        });


    	
		

		
	}




	$(document).on("click",".report_type", function (e) {
   		var report_status=$(this).attr('name');
        var user_role = $(this).data('role');
        var selected_role = $(this).data('selected_role');

        var uid = $(this).data('uid');
   		//sessionStorage.setItem("report_type",report_status);
   		window.location.href="dashboard.php?page=today_report&report_type="+report_status+"&user_role="+user_role+"&uid="+uid+"&selected_role="+selected_role;
});


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
		 
});
function load_username_dropdown()
{
        var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=archive_dropdown_user',
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#user_dropdown').empty();
                    $('#user_dropdown').html(data);

                      $(`#user_dropdown_chosen`).trigger("chosen:updated");
                   $("#user_dropdown_chosen").css('width','100%');

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_archive_report()
{
    
        var list_type="archive_report";
        var full_url = window.location.origin;
        var selected_role=$("#user_role_dropdown").val();
        var user_role=$("#user_role").val();
        var u_id=$("#user_dropdown").val();

     /*   $('#archive_report_tbl thead th').each(function(){
            var title =$(this).text();
            $(this).html(title+"<input type='text' class='col-search-input form-control' placeholder='Search "+title+"'>");
        });
*/

         table= $('#archive_report_tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/report_controller.php",
                    "data":function (post) {
                           post.list_type=list_type;
                            post.user_role=user_role;
                            post.uid=u_id; 
                            post.selected_role=selected_role; 

                          
                            if(frmDate!="" && toDate!="")
                            {
                                 post.frmDate = frmDate;
                                post.toDate = toDate;
                            }
                           
                        }
         },
          stateSave: false,
         "order": [[ 1, "desc" ]],
        
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all","orderable": false,"width":"20%"},
                        { 'visible': false, 'targets': [8] }
            ]

        });

          /* table.columns.every(function(){
                var table2=this;

                $('input',this.header()).on('keyup change',function (){
                if(table2.search()!=this.value)
                {
                    table2.search(this.value).draw();
                }
                });
           })*/

            $('#archive_report_tbl thead th').each(function () {
            var title = $(this).text();
            $(this).html(title+' <br><input type="text" id="input' + $(this).index() + '" class="col-search-input" placeholder="Search ' + title + '"  style="width:100%;"/>');
        });
        
        table.columns().every(function () {
            var table = this;
             var val;
                val = $('#input' + $(this).index()).val();

                var title = $(this).text();
                console.log('title =' + title);
            $('input', this.header()).on('keyup change', function () {
                if (table.search() !== this.value) {
                       table.search(this.value).draw();
                }
            });
        });




        
}



function load_downlaod_report()
{
    
        var list_type="download_archive_report";
        var full_url = window.location.origin;
        var selected_role=$("#user_role_dropdown").val();
        var user_role=$("#user_role").val();
        var u_id=$("#user_dropdown").val();
        var full_url = window.location.origin;
        var data_string="";
        var role=$("#user_role_dropdown").val();
        data_string='list_type='+list_type+'&role='+role;
        if(frmDate!="" && toDate!="")
            {
                                
                                data_string+="&frmDate="+frmDate+"&toDate="+toDate;

            }
    $(".role_name").text(role);
           $.ajax({
                url: full_url+'/controller/report_controller.php',
                type: 'post',
                cache: false, 
                data:data_string,
                async:true,
                 beforeSend: function(){
                     $('.ajax-loader').css("visibility", "visible");
                   },
                   complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                   },
                success: function(data){
                    console.log(data);
                 $(".download_archive_report_list").empty();
                 $(".download_archive_report_list").append(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });

     /*   $('#archive_report_tbl thead th').each(function(){
            var title =$(this).text();
            $(this).html(title+"<input type='text' class='col-search-input form-control' placeholder='Search "+title+"'>");
        });
*/

/*         table= $('#download_archive_report_tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/report_controller.php",
                    "data":function (post) {
                           post.list_type=list_type;
                            post.user_role=user_role;
                            post.uid=u_id; 
                            post.selected_role=selected_role; 
                            if(frmDate!="" && toDate!="")
                            {
                                 post.frmDate = frmDate;
                                post.toDate = toDate;
                            }
                           
                        }
         },
          stateSave: false,
         "order": [[ 0, "desc" ]],
         "bDestroy": true,
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all","orderable": false,"width":"20%"}
                        
            ]

        });*/

          /* table.columns.every(function(){
                var table2=this;

                $('input',this.header()).on('keyup change',function (){
                if(table2.search()!=this.value)
                {
                    table2.search(this.value).draw();
                }
                });
           })*/

          /*  $('#download_archive_report_tbl thead th').each(function () {
            var title = $(this).text();
            $(this).html(title+' <br><input type="text" id="input' + $(this).index() + '" class="col-search-input" placeholder="Search ' + title + '"  style="width:100%;"/>');
        });
        */
       /* table.columns().every(function () {
            var table = this;
             var val;
                val = $('#input' + $(this).index()).val();

                var title = $(this).text();
                console.log('titre =' + title);
            $('input', this.header()).on('keyup change', function () {
                if (table.search() !== this.value) {
                       table.search(this.value).draw();
                }
            });
        });*/
}
function load_scheduled_report()
{
        var list_type="schedule_report";
        var full_url = window.location.origin;
        var selected_role=$("#user_role_dropdown").val();
        var user_role=$("#user_role").val();
        var u_id=$("#user_dropdown").val();
         table= $('#scheduled_report_tbl').DataTable({
        "processing": true,
        "serverSide": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/report_controller.php",
                    "data":function (post) {
                            post.list_type=list_type;
                            post.user_role=user_role;
                            post.u_id=u_id; 
                            post.selected_role=selected_role; 

                            if(frmDate!="" && toDate!="")
                            {
                                 post.frmDate = frmDate;
                                post.toDate = toDate;
                            }
                           
                        }
         },
          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 500]],
          stateSave: false,
         "order": [[ 0, "desc" ]],
         "bDestroy": true
        

        });

        table.column(8).visible(false);
}

function load_users()
{
    var full_url = window.location.origin;

    var role=$("#user_role_dropdown").val();
    $(".role_name").text(role);
           $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_userslist&role='+role,
                async:true,

                success: function(data){
                  /*alert(data);*/
                  $("#user_dropdown").empty();
                  $("#user_dropdown").append(data);

                 $(`#user_dropdown_chosen`).trigger("chosen:updated");
                   $("#user_dropdown_chosen").css('width','100%');

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


    var full_url = window.location.origin;
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

function load_today_summary_report()
{
	//alert('summary');
    var full_url = window.location.origin;
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


function load_today_voice_summary_report()
{
    //alert('summary');
    var full_url = window.location.origin;
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