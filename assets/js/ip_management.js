$(function(){
	load_block_ip_dtls();


});



        $(document).on( "click", '.delete_btn',function(e) {
  
    var id = $(this).data('id');

   
           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this blacklisted IP!",
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
        //var full_url = window.location.origin;

                            $.ajax({
                                        url: full_url+'/controller/ipmanagement_controller.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'list_type=delete_ip&id='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('Success','The IP address was successfully removed from the blacklist.!!','success').then((value) => {

                                                 window.location.reload(full_url+'/dashboard.php?page=number_block');
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete IP address from blacklist!!!'
                                                  
                                                });
                                           }
                                         
                                          
                                            
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                                            alert(data);
                                            //$('#content').html(errorMsg);
                                          }
                                    });
                        }
                });

   
    });

function load_block_ip_dtls()
{
	 //var full_url = window.location.origin;
	$('#ip_manage_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "cache": false, 
                    "url":full_url+"/controller/ipmanagement_controller.php",
                    "data":function (post) {
                            post.list_type='all_block_ips';
      
                        }
                  
         },
         "order": [[ 0, "desc" ]],
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

        } );

}

