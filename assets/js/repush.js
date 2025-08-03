$(function() {

   
    $('#repush_job_modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var item_id = button.data('item-id');
        $('#repush_job_id').val(item_id);
        $('#job_id').text(item_id);


        var full_url = window.location.origin;
        $.ajax({
            type: "POST",
            url: full_url+"/controller/repush_controller.php",
            data: "type=load_status_gateway&job_id="+item_id,
            beforeSend: function () {
            // $('#createsenderid').html('<img src="assets/images/loading.gif" style="width:30%;" />');
            },
            success: function (data)
            {
                var optionsArray = data.split('|');
            $("#status").empty().append(optionsArray[0]);
            $("#gateway_id").empty().append(optionsArray[1]);

            }
        });


      });

      $("#push_job_btn").click(function(){

        var full_url = window.location.origin;
        $.ajax({
            type: "POST",
            url: full_url+"/controller/repush_controller.php",
            data:$("#repush_job_form").serialize(),
            beforeSend: function () {
            // $('#createsenderid').html('<img src="assets/images/loading.gif" style="width:30%;" />');
            },
            success: function (data)
            {
                if(data==1)
                {
                    swal.fire('Success','Campaign repush successfully!!','success').then((value) => {
                        $('#repush_job_modal').modal('hide');
                         $("#repush_job_form").trigger('reset');
                         window.location.reload(full_url+'/view/include/modal_forms/repush_modal.php');
                     
                       
                    });

                }
                else if(data==1)
                {
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select status and gateway'
                        
                      });
                }
                else{
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to repush campaign'
                        
                      });
                }

            }
        });

      });

      $(document).on('click', '.pause_btn', function(){
        var full_url = window.location.origin;

        var job_id=$(this).data('item-id');
        
        $.ajax({
            type: "POST",
            url: full_url+"/controller/repush_controller.php",
            data:"job_id="+job_id+"&type=pause_campaign",
            beforeSend: function () {
            // $('#createsenderid').html('<img src="assets/images/loading.gif" style="width:30%;" />');
            },
            success: function (data)
            {
               // alert(data);
               
                if(data==1)
                {
                    swal.fire('Success','Campaign pause successfully!!','success').then((value) => {
                        window.location.reload();
                       
                    });

                }
                else{
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to repush campaign'
                        
                      });
                }

            }
        });

    });


    $(document).on('click', '.play_btn', function(){
        var full_url = window.location.origin;

        var job_id=$(this).data('item-id');
        
        $.ajax({
            type: "POST",
            url: full_url+"/controller/repush_controller.php",
            data:"job_id="+job_id+"&type=play_campaign",
            beforeSend: function () {
            // $('#createsenderid').html('<img src="assets/images/loading.gif" style="width:30%;" />');
            },
            success: function (data)
            {
               //alert(data);
                if(data==1)
                {
                    swal.fire('Success','Campaign resume successfully!!','success').then((value) => {
                        window.location.reload();
                       
                    });

                }
                else{
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to resume campaign'
                        
                      });
                }

            }
        });

    });


     
});