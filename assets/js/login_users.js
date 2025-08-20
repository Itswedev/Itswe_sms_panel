$(function(){
    $.ajaxSetup ({
        cache: false
    });


    load_all_login_users();
    //setInterval(load_all_login_users,10000);
});


function load_all_login_users()
{
var full_url = window.location.origin;

  //  alert('ok');
           $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_all_login_users',
                dataType:'json',
                async:true,
                success: function(data){
                    var username,logintime,profile_pic,hrs,mins,displaytime;
                    var login_record="";
                    var res = JSON.parse(JSON.stringify(data));
                    //console.log(res);
                    var len=res.length;

                      for(var i=0;i<len;i++)
                      {
                            displaytime="";
                            username=res[i]['user_name'];
                            logintime=res[i]['login_time'];
                            hrs=res[i]['hrs'];
                            mins=res[i]['minutes'];
                            if(hrs!=0)
                            {
                                displaytime=hrs+" hr ";
                            }

                            if(mins!=0)
                            {
                                displaytime+=mins+" mins ago";
                            }
                            else
                            {
                                displaytime+"ago";
                            }

                            if(hrs=='0' && mins=='0')
                            {
                                displaytime="Just Now";
                            }
                            
                            var dt=new Date(logintime);
                            profile_pic=res[i]['profile_pic'];
                            if(profile_pic==null || profile_pic=='')
                            {
                                profile_pic='profile_default.png';
                            }
                            login_record +="<div class='list-group-item'><a class='notification notification-flush notification-unread' href='#!'>"+
                            "<div class='notification-avatar'>"+
                              "<div class='avatar avatar-2xl me-3 status-online'>"+
                                "<div class='avatar-name rounded-circle'>"+
                                  "<img class='rounded-circle' src='assets/images/profile/"+profile_pic+"' alt='' />"+
                                "</div>"+
                              "</div>"+
                            "</div>"+
                            "<div class='notification-body'>"+
                              "<p class='mb-1'><strong>"+username+"</strong></p>"+
                              "<span class='notification-time'><span class='me-2 fab fa-gratipay text-danger'></span>"+displaytime+"</span>"+
                            "</div>"+
                          "</a>"+
                        "</div>";
                      }

                       $("#all_active_users").empty();
                      $("#all_active_users").append(login_record);
                   
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

