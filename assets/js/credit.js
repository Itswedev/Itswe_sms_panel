$(function(){
    load_username_dropdown();
    load_credit_details();
    /*load_route_dropdown();*/
    
    $("#usernames").change(function(){
    
        var u_id=$("#username").val();
       
        //var full_url = window.location.origin;
               $.ajax({
                        url: full_url+'/controller/credit_controller.php',
                        type: 'post',
                        cache: false, 
                        data: 'type=fetch_route&u_id='+u_id,
                        success: function(data){
                            console.log(data);
                            //alert(data);
                           $("#route").empty();
                           $('#route').html(data);
                         
                            
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                            alert(errorMsg);
                            //$('#content').html(errorMsg);
                          }
                    });
    });
    
    
            $("#save_credit").click(function(){
    
              
    
                 var credit =  $.trim( $('#credit').val() );
                //  var username =  $.trim( $('#add_credit_form select[name=username]').val() );
                var username =  $.trim( $('#add_credit_form input[name=username]').val() );
                 var credit_type =  $.trim( $('#add_credit_form select[name=credit_type]').val() );
                 var remark =  $.trim( $('#add_credit_form textarea[name=remark]').val() );
                // alert(credit+" - "+username+" - "+credit_type+" - "+remark);
                if (credit == "" || username == "" ||credit_type == "" ||remark == ""  ) {
                    alert("Complete Form values");
                }
                else if(credit==0)
                {
                    alert("Please do not enter 0 for cerdit value");
                }
                else
                {
                        //var full_url = window.location.origin;
                        $.ajax({
                        url: full_url+'/controller/credit_controller.php',
                        type: 'post',
                        cache:false,
                        data:$("#add_credit_form").serialize(),
                        success: function(data){
                          // alert(data);
                           if(data==0)
                           {
                                 Swal.fire({icon: 'error',title: 'Oops..',text: 'Failed to add transaction details'})
                           }
                           else if(data==1)
                           {
    
                                if(credit_type=='1')
                                {
                                    Swal.fire("Successful !", "Credit Details added successfully", "success").then((value) => {
                                      window.location.href="dashboard.php?page=add_remove_credits";
                                    });
                                }
                                else if(credit_type=='2')
                                {
                                    Swal.fire("Successful !", "Credit refund successfully", "success").then((value) => {
                                      window.location.href="dashboard.php?page=add_remove_credits";
                                    });
                                }
                                else if(credit_type=='0')
                                {
                                    Swal.fire("Successful !", "Amount Debited successfully", "success").then((value) => {
                                      window.location.href="dashboard.php?page=add_remove_credits";
                                    });
                                }
                                 
                           }
                           else if(data==-1)
                           {
                                 Swal.fire({icon: 'error',title: 'Oops..',text: 'Available balance less than your debit count'})
                           }
                            else if(data==2)
                           {
                                 Swal.fire({icon: 'error',title: 'Oops..',text: 'Less Parent Balance!! Please Check!!'})
                           }
                           else if(data==3)
                           {
                                 Swal.fire({icon: 'error',title: 'Oops..',text: 'The limit of overselling has been exceeded.!! Please contact with admin!!'})
                           }
    
                           
                           /* alert(data);
                            location.reload();*/
                         
                            
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
    
    
    function load_username_dropdown()
    {
            //var full_url = window.location.origin;
                $.ajax({
                    url: full_url+'/controller/user_controller.php',
                    type: 'post',
                    cache: false,
                    dataType:'json', 
                    data:'list_type=dropdown_user_search&page=add_credit',
                    success: function(data){
                    
                       if(data!=0)
                       {
                        var input = document.querySelector("input[name=usernames]");
                        var whitelist = [];
                        data.forEach(function(item) {
                            // Create an object with both sid and senderid properties
                            var whitelistItem = {
                                value: item.user_name,
                                uid: item.userid
                            };
                            // Add the object to the whitelist array
                            whitelist.push(whitelistItem);
                        });
                       
    
                        tagify = new Tagify(input, {
                            enforceWhitelist: true,
                            mode: "select",
                            whitelist: whitelist,
                            blacklist: ["foo", "bar"],
                          });
    
                          tagify.on('add', function(e) {
                            updateSelectedSids();
                        });
    
                        // Listen for 'remove' event on Tagify to update selected sids
                        tagify.on('remove', function(e) {
                            updateSelectedSids();
                        });
                 
                       }
                       updateSelectedSids();
                       function updateSelectedSids() {
                        var selectedSids = tagify.value.map(function(tagData) {
                            return tagData.uid;
                        });
                        // Get the first element of the array (if exists)
                        var firstSelectedSid = selectedSids.length > 0 ? selectedSids[0] : null;
                        document.getElementById('username').value = firstSelectedSid;
                    }
                       
    
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
    }
    
    function load_credit_details()
    {
            //var full_url = window.location.origin;
                $.ajax({
                    url: full_url+'/controller/credit_controller.php',
                    type: 'post',
                    cache: false, 
                    data:'type=load_table_dtls',
                    success: function(data){
                    
                       if(data!=0)
                       {
    
                        $('#credit_list').html(data);
                        $("#credit_tbl").DataTable();
                       }
                        
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
    }
    
    
    
    function load_route_dropdown()
    {
        //var full_url = window.location.origin;
        
                $.ajax({
                    url: full_url+'/controller/manage_gateway_controller.php',
                    type: 'post',
                    cache: false, 
                    data:'list_type=route_dropdown&page=compose',
                    success: function(data){
                        //alert(data);
                       if(data!=0)
                       {
                        $('#route').empty();
                        $('#route').html(data);
                       }
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
    }