<?php 
session_start();

// error_reporting(0);

include_once('include/connection.php');
include('include/config.php');

global $dbc;
$user_role=$_SESSION['user_role'];


include_once('controller/page_setup_function.php');



if($user_role=='mds_adm')
{
  $display_role="Administrator";
}
else if($user_role=='mds_ad')
{
  $display_role="Admin";

}
else if($user_role=='mds_rs')
{
  $display_role="Reseller";

}
else if($user_role=='mds_usr')
{
  $display_role="User";

}
$userids=$_SESSION['user_id'];
$uname=$_SESSION['user_name'];

$otp_status=$_SESSION['otp_status'];
$otp_match_status=$_SESSION['otp_match_status'];
$chk_sql="select userid from az_user where userid='$userids' and user_name='$uname'";
$res=mysqli_query($dbc,$chk_sql);

$count_userid=mysqli_num_rows($res);

$minDate=date('Y-m-d', strtotime('-90 days', strtotime(date('d-m-Y'))));
$maxDate=date('Y-m-d');

if($count_userid==0)
{
    header('Location:index.php');
}


if($otp_status=='on' && $otp_match_status=='no')
{
    session_destroy();
    header('Location:index.php');
}

if(!isset($_SESSION['user_id']))
{
    session_destroy();
    header('Location:index.php');
}
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
//$navigation=choose_navigation($user_role);
$dashboard=choose_dashboard($user_role);

 if (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                    
                    $user_role =$_SESSION['user_role']; 
                    //$dashboard=choose_dashboard($user_role);
                    if($user_role=='mds_sub_usr' and $page=='bulksms')
                    {
                        header("Location:dashboard.php");
                      //header("Location:dashboard.php");
                    }
                        switch ($page) {
                              case 'bulksms' : {
                                    $page_name = 'view/bulk_sms.php';
                                    break;
                                }
                                 case 'bulkui' : {
                                    $page_name = 'view/bulkUI.php';
                                    break;
                                }
                                case 'bulksms1' : {
                                    $page_name = 'view/bulk_sms1.php';
                                    break;
                                }
                              case 'senderid' : {
                                    $page_name = 'view/senderid.php';
                                    break;
                                }
                                case 'senderid1' : {
                                  $page_name = 'view/senderid1.php';
                                  break;
                              }
                              case 'access_token' : {
                                    $page_name = 'view/access_token.php';
                                    break;
                                }
                              case 'rcs_template' : {
                                    $page_name = 'view/rcs_template.php';
                                    break;
                                }
                              case 'group' : {
                                    $page_name = 'view/group.php';
                                    break;
                                }
                              case 'template' : {
                                    $page_name = 'view/template.php';
                                    break;
                                }
                              case 'dynamic_sms' : {
                                    $page_name = 'view/dynamic_sms.php';
                                    break;
                                }
                                case 'dynamic_rcs' : {
                                  $page_name = 'view/dynamic_rcs.php';
                                  break;
                              }
                              case 'dynamic_test' : {
                                    $page_name = 'view/dynamic_test.php';
                                    break;
                                }
                                case 'error_description' : {
                                    $page_name = 'view/error_description.php';
                                    break;
                                }
                             case 'split_sms' : {
                                    $page_name = 'view/split_sms.php';
                                    break;
                                }
                             case 'click_analytics' : {
                                    $page_name = 'view/click_analytics.php';
                                    break;
                                }
                             case 'bitly_count' : {
                                    $page_name = 'view/bitly_count.php';
                                    break;
                                }
                               case 'server_ticket' : {
                                    $page_name = 'view/server_ticket.php';
                                    break;
                                }
                              case 'multimedia_sms' : {
                                    $page_name = 'view/multimedia_sms.php';
                                    break;
                                }
                              case 'sender_block' : {
                                    $page_name = 'view/senderid_block.php';
                                    break;
                                }
                             case 'lead_count_dtls' : {
                                    $page_name = 'view/lead_count_dtls.php';
                                    break;
                                }
                              case 'voice_call_test' : {
                                    $page_name = 'view/voice_call_test.php';
                                    break;
                                }
                             case 'multimedia' : {
                                    $page_name = 'view/multimedia.php';
                                    break;
                                }
                                case 'caller_id' : {
                                    $page_name = 'view/caller_id.php';
                                    break;
                                }
                              case 'create_plan' : {
                                    $page_name = 'view/create_plan.php';
                                    break;
                                }
                                case 'longcode_report' : {
                                    $page_name = 'view/longcode_report.php';
                                    break;
                                }
                              case 'add_gateway' : {
                                    $page_name = 'view/add_gateway.php';
                                    break;
                                }
                              case 'voice_gateway' : {
                                    $page_name = 'view/voice_gateway.php';
                                    break;
                                }
                                case 'campaign_report' : {
                                    $page_name = 'view/campaign_report.php';
                                    break;
                                }
                                case 'campaign_dtl_report' : {
                                    $page_name = 'view/campaign_dtl_report.php';
                                    break;
                                }
                              case 'manage_route' : {
                                    $page_name = 'view/manage_route.php';
                                    break;
                                }
                              case 'routing_plan' : {
                                    $page_name = 'view/routing_plan.php';
                                    break;
                                }
                              case 'sender_routing' : {
                                    $page_name = 'view/sender_routing.php';
                                    break;
                                }
                              case 'smpp_error_code' : {
                                    $page_name = 'view/smpp_error_code.php';
                                    break;
                                }
                              case 'today_report' : {
                                    $page_name = 'view/today_report.php';
                                    break;
                                }
                                case 'today_report1' : {
                                  $page_name = 'view/today_report1.php';
                                  break;
                              }
                            case 'today_report_test' : {
                                    $page_name = 'view/today_report_test.php';
                                    break;
                                }
                                case 'gateway_report' : {
                                    $page_name = 'view/gateway_summary_report.php';
                                    break;
                                }
                                 case 'today_voice_report' : {
                                    $page_name = 'view/today_voice_report.php';
                                    break;
                                }
                              case 'today_summary_report' : {
                                    $page_name = 'view/today_summary_report.php';
                                    break;
                                }
                                case 'today_summary_report_test' : {
                                    $page_name = 'view/today_summary_report_test.php';
                                    break;
                                }
                                case 'today_voice_summary_report' : {
                                    $page_name = 'view/today_voice_summary_report.php';
                                    break;
                                }
                              case 'send_job' : {
                                    $page_name = 'view/send_job.php';
                                    break;
                                }
                                case 'api_job' : {
                                  $page_name = 'view/api_job.php';
                                  break;
                              }
                                case 'voice_call_dtls' : {
                                    $page_name = 'view/send_voice_job.php';
                                    break;
                                }
                                   case 'rcs_job' : {
                                    $page_name = 'view/rcs_job.php';
                                    break;
                                }
                              case 'send_job_summary' : {
                                    $page_name = 'view/send_job_summary.php';
                                    break;
                                }
                                case 'api_job_summary' : {
                                  $page_name = 'view/api_job_summary_uat.php';
                                  break;
                              }
                              case 'api_job_summary_uat' : {
                                $page_name = 'view/api_job_summary_uat.php';
                                break;
                            }
                                 case 'rcs_job_summary' : {
                                    $page_name = 'view/rcs_job_summary.php';
                                    break;
                                }
                              case 'archive_report' : {
                                    $page_name = 'view/archive_report.php';
                                    break;
                                }
                              case 'scheduled_report' : {
                                    $page_name = 'view/scheduled_report.php';
                                    break;
                                }
                                  case 'scheduled_voice_report' : {
                                    $page_name = 'view/scheduled_voice_report.php';
                                    break;
                                }
                              case 'mis_report' : {
                                    $page_name = 'view/mis_report.php';
                                    break;
                                }
                                case 'voice_mis_report' : {
                                    $page_name = 'view/voice_mis_report.php';
                                    break;
                                }
                              case 'add_remove_credits' : {
                                    $page_name = 'view/add_remove_credits.php';
                                    break;
                                }
                              case 'add_new_user' : {
                                    $page_name = 'view/add_new_user.php';
                                    break;
                                }
                              case 'recharge_history' : {
                                    $page_name = 'view/recharge_history.php';
                                    break;
                                }
                              case 'recharge_history1' : {
                                    $page_name = 'view/recharge_history1.php';
                                    break;
                                }
                              case 'manage_user' : {
                                    $page_name = 'view/manage_user.php';
                                    break;
                                }
                              case 'edit_user' : {
                                    $page_name = 'view/edit_user.php';
                                    break;
                                }
                                   case 'misscall_report' : {
                                    $page_name = 'view/misscall_report.php';
                                    break;
                                }
                              case 'user_report' : {
                                    $page_name = 'view/user_summary.php';
                                    break;
                                }
                              case 'rcs' : {
                                    $page_name = 'view/rcs_sms.php';
                                    break;
                                }
                                case 'voice_call_summary' : {
                                    $page_name = 'view/voice_call_summary.php';
                                    break;
                                }
                            case 'http-api' : {
                                    $page_name = 'view/http-api.php';
                                    break;
                                }
                                 case 'settings' : {
                                    $page_name = 'view/settings.php';
                                    break;
                                }
                                case 'branding' : {
                                    $page_name = 'view/branding.php';
                                    break;
                                }
                                case 'live_jobs' : {
                                    $page_name = 'view/live_job_summary.php';
                                    break;
                                }
                                case 'ip_logs' : {
                                    $page_name = 'view/ip_logs.php';
                                    break;
                                }
                                case 'number_block' : {
                                    $page_name = 'view/number_block.php';
                                    break;
                                }
                                  case 'account_manager' : {
                                    $page_name = 'view/add_acct_manager.php';
                                    break;
                                }
                                 case 'ip_management' : {
                                    $page_name = 'view/ip_management.php';
                                    break;
                                }
                                case 'profile' : {
                                    $page_name = 'view/profile.php';
                                    break;
                                }
                                case 'login_users' : {
                                    $page_name = 'view/login_users.php';
                                    break;
                                }
                                case 'inactive_user' : {
                                    $page_name = 'view/inactive_user.php';
                                    break;
                                }
                                 case 'url_tracking' : {
                                    $page_name = 'view/url_tracking.php';
                                    break;
                                }
                                 case 'download_report_bk' : {
                                    $page_name = 'view/download_archive_report.php';
                                    break;
                                }
                                 case 'download_report' : {
                                    $page_name = 'view/download_archive_report_test.php';
                                    break;
                                }
                                case 'spam_keyword' : {
                                    $page_name = 'view/spam_keywords.php';
                                    break;
                                }
                                 case 'url_tracking_dtls' : {
                                    $page_name = 'view/url_tracking_dtls.php';
                                    break;
                                }
                                case 'longcode' : {
                                    $page_name = 'view/longcode.php';
                                    break;
                                }
                                case 'shortcode' : {
                                    $page_name = 'view/shortcode.php';
                                    break;
                                }
                                case 'miss_call' : {
                                    $page_name = 'view/miss_call.php';
                                    break;
                                }
                                case 'dashboard' : {
                                    $page_name = 'dashboard.php';
                                    break;
                                }
                                case 'smpp_services' : {
                                  $page_name = 'view/smpp_services.php';
                                  break;
                                }
                                case 'repush' : {
                                  $page_name = 'view/repush_message.php';
                                  break;
                                }
                                case 'update_dlr' : {
                                  $page_name = 'view/update_dlr.php';
                                  break;
                                }
                                case 'create_ticket' : {
                                  $page_name = 'view/support_ticket.php';
                                  break;
                                }
                                case 'check_storage' : {
                                  $page_name = 'view/check_storage.php';
                                  break;
                                }
                                case 'rcs_mis' : {
                                  $page_name = 'view/rcs_mis.php';
                                  break;
                                }  
                              default : {
                                    $page_name = 'dashboard.php';
                                    break;
                                }
                            }
                        }
                        else
                        {
                            $page_name=$dashboard;
                        }
                        
                        
       
        if($user_role=='mds_adm')
        {
          $user_role_view="Administrator";
          
        }
        else if($user_role=='mds_ad')
        {
          $user_role_view="Admin";
          
        }
        else if($user_role=='mds_rs')
        {
          $user_role_view="Reseller";
          
        }
        else if($user_role=='mds_usr')
        {
          $user_role_view="User";
          
        }
        else if($user_role=='mds_sub_usr')
        {
          $user_role_view="Sub User";
          
        }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php include("include/header_files.php"); ?>

</head>

<body>


	<!--*******************
        Preloader start
    ********************-->
	<div id="preloader">
		<div>
			<img src="assets2/images/pre.gif" alt="">
		</div>
	</div>
	<!--*******************
        Preloader end
    ********************-->

	<!--**********************************
        Main wrapper start
    ***********************************-->
	<div id="main-wrapper">
   
    <?php include("include/header.php"); ?>

    <?php 
        if($user_role=='mds_adm')
        {
          $user_role_view="Administrator";
          include('include/sidebar_administrator.php'); 
        }
        else if($user_role=='mds_ad')
        {
          $user_role_view="Admin";
          include('include/sidebar_admin.php'); 
        }
        else if($user_role=='mds_rs')
        {
          $user_role_view="Reseller";
          include('include/sidebar_reseller.php'); 
        }
        else if($user_role=='mds_usr')
        {
          $user_role_view="User";
          include('include/sidebar_user.php'); 
        }
        else if($user_role=='mds_sub_usr')
        {
          $user_role_view="Sub User";
          include('include/sidebar_subuser.php'); 
        }
        
        
        ?>
		

		<!--**********************************
            Content body end
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
            <?php 
                include_once($page_name);  
            ?>  
            </div>
        </div>
        

		<!--**********************************
           Support ticket button start
        ***********************************-->

		<!--**********************************
           Support ticket button end
        ***********************************-->


	</div>
	<!--**********************************
        Main wrapper end
    ***********************************-->

    <?php include('include/footer_js.php'); ?> 
    <!-- <script type="text/javascript" src="assets/js/dashboard.js?=<?=time();?>"></script> -->

</body>

</html>