$(function(){

// $(".template_msg").css('display','none');
$("#muliselect_div").css('width','80%');
	$(".suggestion_dropdown").change(function(){
		var suggestion=$(".suggestion_dropdown").val();
		if(suggestion=="text")
		{

			$(".title").css('display','none');
			$(".postback").css('display','none');
			$(".url").css('display','none');
				$(".rich_dial_number").css('display','none');
			$(".weburl").css('display','none');
			$(".location").css('display','none');
			$(".number").css('display','none');
			$(".media").css('display','none');
			$(".suggested_reply").css('display','none');
			$(".image_url").css('display','none');
			$(".thumbnail_url").css('display','none');
			$(".suggested_reply_standalone").css('display','none');
			$(".add_suggestion_btn").css('display','none');
			$(".carousal").css('display','none');
			$(".carousal_btn").css('display','none');
			$(".card_remove").css('display','none');
			$(".message_desc").css('display','none');
			$(".open_url").css('display','none');
			$(".dial_action").css('display','none');
			
		}
		else if(suggestion=="open_url")
		{
			$(".title").css('display','');
			$(".postback").css('display','');
		/*	$(".weburl").css('display','');*/
			$(".rich_dial_number").css('display','none');
			$(".location").css('display','none');
			$(".number").css('display','none');
			$(".media").css('display','none');
			$(".suggested_reply").css('display','none');
			$(".image_url").css('display','none');
			$(".thumbnail_url").css('display','none');
			$(".suggested_reply_standalone").css('display','none');
			$(".add_suggestion_btn").css('display','none');
			$(".carousal").css('display','none');
			$(".carousal_btn").css('display','none');
			$(".card_remove").css('display','none');
			$(".message_desc").css('display','none');
			$(".open_url").css('display','');
			$(".dial_action").css('display','none');
		}
		else if(suggestion=="dial")
		{
			$(".title").css('display','');
			$(".postback").css('display','');
			$(".url").css('display','none');
				$(".rich_dial_number").css('display','none');
			$(".weburl").css('display','none');
			$(".location").css('display','none');
			$(".number").css('display','');
			$(".media").css('display','none');
			$(".suggested_reply").css('display','none');
			$(".image_url").css('display','none');
			$(".thumbnail_url").css('display','none');
			$(".suggested_reply_standalone").css('display','none');
			$(".add_suggestion_btn").css('display','none');
			$(".carousal").css('display','none');
			$(".carousal_btn").css('display','none');
			$(".card_remove").css('display','none');
			$(".message_desc").css('display','none');
			$(".open_url").css('display','none');
			$(".dial_action").css('display','');
		}
		else if(suggestion=="media")
		{
			$(".media").css('display','');
			$(".title").css('display','none');
			$(".postback").css('display','none');
			$(".url").css('display','none');
			$(".rich_dial_number").css('display','none');
			$(".weburl").css('display','none');
			$(".location").css('display','none');
			$(".number").css('display','none');
			$(".suggested_reply").css('display','none');
			$(".image_url").css('display','none');
			$(".thumbnail_url").css('display','none');
			$(".suggested_reply_standalone").css('display','none');
			$(".add_suggestion_btn").css('display','none');
			$(".carousal").css('display','none');
			$(".carousal_btn").css('display','none');
			$(".card_remove").css('display','none');
			$(".message_desc").css('display','none');
			$(".open_url").css('display','none');
			$(".dial_action").css('display','none');
		}
		else if(suggestion=="location")
		{
			$(".title").css('display','none');
			$(".postback").css('display','');
			$(".url").css('display','none');
			$(".rich_dial_number").css('display','none');
			$(".weburl").css('display','none');
			$(".location").css('display','');
			$(".number").css('display','none');
			$(".media").css('display','none');
			$(".image_url").css('display','none');
			$(".thumbnail_url").css('display','none');
			$(".suggested_reply").css('display','none');
			$(".suggested_reply_standalone").css('display','none');
			$(".add_suggestion_btn").css('display','none');
			$(".carousal").css('display','none');
			$(".carousal_btn").css('display','none');
			$(".card_remove").css('display','none');
			$(".message_desc").css('display','none');
			$(".open_url").css('display','none');
			$(".dial_action").css('display','none');

		}
		else if(suggestion=="standalone")
		{
			$(".title").css('display','');
			$(".suggested_reply_standalone").css('display','');
			$(".postback").css('display','none');
			$(".url").css('display','');
			$(".rich_dial_number").css('display','');
			$(".weburl").css('display','none');
			$(".location").css('display','none');
			$(".number").css('display','none');
			$(".media").css('display','none');
			$(".image_url").css('display','');
			$(".thumbnail_url").css('display','');
			$(".suggested_reply").css('display','none');
			$(".add_suggestion_btn").css('display','');
			$(".carousal").css('display','');
			$(".carousal_btn").css('display','none');	
			$(".card_remove").css('display','none');
			$(".message_desc").css('display','none');
			$(".open_url").css('display','none');
			$(".dial_action").css('display','none');
			var repeat_section=$(".repeat_section");
    		$(repeat_section).closest(".duplicate").remove();


		}
		else if(suggestion=="carousel")
		{
			$(".title").css('display','');
			$(".suggested_reply_standalone").css('display','');
			$(".postback").css('display','none');
			$(".url").css('display','');
			$(".rich_dial_number").css('display','');
			$(".weburl").css('display','none');
			$(".location").css('display','none');
			$(".number").css('display','none');
			$(".media").css('display','none');
			$(".image_url").css('display','');
			$(".thumbnail_url").css('display','');
			$(".suggested_reply").css('display','none');
			$(".open_url").css('display','none');
			$(".dial_action").css('display','none');
			$(".add_suggestion_btn").css('display','');
			$(".carousal").css('display','');
			$(".carousal_btn").css('display','');	

			$(".card_remove").css('display','');

			$(".message_desc").css('display','');		
		}
	})

	$("#card_repeat").click(function(){

		var repeat_section=$(".repeat_section:last");

		var card_name=$(".card_count:last").html();
		var card_name_arr=card_name.split(" ");
		var card_count=parseInt(card_name_arr[1]);
		card_count=card_count+1;
		
		if(card_count<=10)
		{
		 $(repeat_section).clone().addClass('duplicate').insertAfter(repeat_section);
		 $(".card_count:last").html("#Card "+card_count);
		 $(".card_remove:first").css('display','none');
		}
		else
		{
			alert('Cannot add more than 10 cards');
		}
		
	})



$("#importBtn_bulk").click(function(){
    /*alert('text');*/
/*  e.preventDefault();*/
    var full_url = window.location.origin+"/itswe_sms_app";
    var file_data = $('#uploadfile').prop('files')[0];
var bar = $('#bar');
     if(file_data != undefined) {
        var form_data = new FormData();   
        form_data.append('uploadfile', file_data); 
        form_data.append('sender_type','import1');
     $.ajax({
                url: full_url+'/controller/rcs_function.php',
                type: 'post',
                data:form_data,
                dataType: 'json',
                cache: false,             // To unable request pages to be cached
                contentType: false,
                 processData: false,        // To send DOMDocument or non processed data file it is set to false
                beforeSend: function(){
                    var percentVal = '0%';
                  bar.width(percentVal);
                  bar.html(percentVal);
                
                   },
                   uploadProgress: function(event, position, total, percentComplete) {
                  var percentVal = percentComplete + '%';
                  bar.width(percentVal);
                   bar.html(percentVal);
                 
                },
                complete: function(){
                   // $("#loading_modal").modal('hide');
                   },
                success: function(data){
                    var percentVal = '100%';
                	bar.width(percentVal);
                 	bar.html(percentVal);
                    var response = JSON.parse(JSON.stringify(data));  
               		console.log(response);
               		  var data_len = response['header'].length;
               		 var table_data="";
               		   var table_header="<tr>";

               		   var custom_param= response['var'];
               		   console.log(custom_param);
               		 for(var i = 1; i < data_len; i++) {
                       var num_header=response['header'][0];
            		   numbers+=response['data'][i][num_header]+"\n";
            
           				}

           				 for(var i = 0; i < data_len; i++) {

            			table_header+="<th>"+response['header'][i]+"</th>";

           

                
           				}

           				table_header+="</tr>";

           				for(var i = 0; i < 2; i++) {
				            for(var j = 0; j < response['header'].length; j++) {
				                header=response['header'][j];
				            	table_header+="<td style='word-break: break-all;'>"+response['data'][i][header]+"</td>"; 

				           }
				            var num_header=response['header'][0];
				            table_header+="</tr>";
           				}


				           $("#numbers").text('');
				           $("#numbers").text(numbers);

				            $("#numbers_var").text('');
				           $("#numbers_var").text(JSON.stringify(custom_param));
           				   $("#table_data").append(table_header);
           
        

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
    }
})



	  $(document).on('click', '.card_remove', function(){
       $(this).closest('.repeat_section').remove();
    });
	$(".msg_format").change(function(){

		var msg_format_type=$(this).val();
		if(msg_format_type=='numbers')
		{
			$("#msg_format_lbl").html('Mobile Numbers');
			$('.numbers').css('display','');
			$('.csv_xls_txt').css('display','none');
			$('#number_area').css('display','');
			$('.groups').css('display','none');
			$('#add_group_btn').css('display','none');
			$('#importBtn').css('margin-top','');
			$('#number_area').css('margin-top','');
			$('#msg-btn-mb-cnt').css('display','');
			$('#numbers').val('');
			$('#numbers').css('display','');
			$("#counti").html(0);
			$('#muliselect_div').css('display','none');

		}
		else if(msg_format_type=='groups')
		{
			$("#msg_format_lbl").html('Select Groups');
			$('#numbers').css('display','none');
			$('.csv_xls_txt').css('display','none');
			$('.groups').css('display','');
			$('#number_area').css('display','none');

			$('#add_group_btn').css('display','');
			$('#importBtn').css('margin-top','');
			$('#msg-btn-mb-cnt').css('display','');
			$("#counti").html(0);
			$('#muliselect_div').css('display','');

		}
		else if(msg_format_type=='csv_xls_txt')
		{
			$("#msg_format_lbl").html('Upload File');
			$('#numbers').css('display','none');
			$('.csv_xls_txt').css('display','');
			$('#number_area').css('display','none');

			$('.groups').css('display','none');
			$('#add_group_btn').css('display','none');
			$('#msg-btn-mb-cnt').css('display','');
			$('#importBtn').css('margin-top','-4%');
			$('#muliselect_div').css('display','none');
			
			
		}
	})

$("#group_id").change(function(){

		var group_id=$("#group_id").val();
		//alert(group_id);
        var full_url = window.location.origin+"/itswe_sms_app";
	
            $.ajax({
                url: full_url+'/controller/group_function.php',
                type: 'post',
                cache: false, 
                data:'type=fetch_group_contacts&group_id='+group_id,
                success: function(data){
                
                 // alert(data);

                  if(data!='1')
                  {
                  	var d = data.split('|');
					$('#numbers').val(d[0].trim());
					$('#counti').html(d[1]);
                  }
                  else{
                  	alert('Contact Number list empty in this group');
                  }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });	

	});

	$("#send_rcs_sms").click(function(){
	/*	alert('test');*/
        $( "#sendRCSSMSForm" ).validate({
            rules: {
            	bot_type: "required",
                template: "required",
                numbers: "required",
               
               


            },
            messages: {
            	bot_type: "Please Select RCS Message Type",
                template: "Please Enter Message Title",
                numbers: "Please Enter Mobile Number",
               
                
            },
            errorElement: "em",

            errorPlacement: function ( error, element ) {
                // Add the `invalid-feedback` class to the error element
                error.addClass( "invalid-feedback" );
                error.insertAfter(element.next(".pmd-textfield-focused"));
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            },
            submitHandler: function(form,e) {
            e.preventDefault();
            console.log('Form submitted');

            swal.fire({
					  title: 'Are you sure?',
					  text: "You want to send this message!",
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
					        var full_url = window.location.origin+"/itswe_sms_app";
					   $.ajax({
                    url: full_url+'/controller/sending_dynamic_rcs.php',
                    type: 'post',
                    cache: false, 
                    data:$("#sendRCSSMSForm").serialize(),
                    success: function(data){
                    /*	alert(data);*/
                       console.log(data);

                      if(data.trim()=='Message Successfully Send')
                       {
                            swal.fire('',data,'success').then((value) => {
                              window.location.reload();
                              $("#sendRCSSMSForm").trigger('reset');
                            });
                       }
                       else
                       {
                            swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: data,
                              footer: ''
                            })
                       }

                    
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
           

  }
})
        
        }

        } );
});

});


$("#template").change(function(){
	var temp_name=$(this).val();

	var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/rcs_function.php',
                type: 'post',
                cache: false, 
                data:'type=sms_type&template_name='+temp_name,
                success: function(data){
                	if(data!=0)
                	{
                		$("#message").val(data);
                		$("#sms_type").val('dynamic');
                		 // const regex = /\[([^\]]+)\]/g;

    					 // let uniqueVariables = new Set();

						 //    let match;
						 //    $("#dynamicTable tbody").empty();
						 //    while ((match = regex.exec(data)) !== null) {
						 //        // Extract the variable name (without the square brackets)
						 //        const variable = match[1];

						 //        // Add to table only if it's not already in the set
						 //        if (!uniqueVariables.has(variable)) {
						 //            // Add the variable to the set
						 //            uniqueVariables.add(variable);

						 //            // Create a new row in the table for each unique variable with an empty textbox for input
						 //            $("#dynamicTable tbody").append(
						 //                `<tr>
						 //                    <td>${variable}</td>
						 //                    <td><input type="text" name="var_${variable}" placeholder="Enter ${variable}"></td>
						 //                </tr>`
						 //            );
						 //        }
						 //    }
						                		

						   // $(".template_msg").css('display','');
                	}
                	else
                	{

                		$("#message").val('');
                		$("#sms_type").val('simple');
                		//$(".template_msg").css('display','none');
                	}

                
           
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });

});

$("#bot_type").change(function(){
	var bot_type = $(this).val();
	var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/rcs_function.php',
                type: 'post',
                cache: false, 
                data:'type=load_bot_template_dynamic&bot_type='+bot_type,
                success: function(data){
                	/*alert(data);*/

                	$("#template").empty();
                	$("#template").append(data);

           
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });

})
     


