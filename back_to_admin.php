<?php
session_start();

            $_SESSION['user_id']            =$_SESSION['prev_user_id']                      ;
            $_SESSION['user_name']         	=$_SESSION['prev_user_name']         			;
            $_SESSION['client_name']        =$_SESSION['prev_client_name']       			;
            $_SESSION['status']            	=$_SESSION['prev_status']            			;
            $_SESSION['user_role']         	=$_SESSION['prev_user_role']         			;
            $_SESSION['parent_id']         	=$_SESSION['prev_parent_id']         			;
            $_SESSION['miscall_access']     =$_SESSION['prev_miscall_access']    			;
            $_SESSION['vsms_access']        =$_SESSION['prev_vsms_access']       			;
            $_SESSION['rcs_access']         =$_SESSION['prev_rcs_access']        			;
            $_SESSION['acct_manager']      	=$_SESSION['prev_acct_manager']      			;
            $_SESSION['rcs']               	=$_SESSION['prev_rcs']               			;
            $_SESSION['lms']               	=$_SESSION['prev_lms']               			;
            $_SESSION['vas']               	=$_SESSION['prev_vas']               			;
            $_SESSION['voice_call']         =$_SESSION['prev_voice_call']        			;
            $_SESSION['campaign_report']   	=$_SESSION['prev_campaign_report']   			;
            $_SESSION['miscall_report']     =$_SESSION['prev_miscall_report']    			;
            $_SESSION['gvsms']             	=$_SESSION['prev_gvsms']             			;
            $_SESSION['BlockNum']          	=$_SESSION['prev_BlockNum']          			;
            $_SESSION['restricted_tlv']     =$_SESSION['prev_restricted_tlv']    			;
            $_SESSION['api_key']           	=$_SESSION['prev_api_key']           			;
            $_SESSION['restricted_report'] 	=$_SESSION['prev_restricted_report'] 			;
            $_SESSION['profile_pic']        =$_SESSION['prev_profile_pic']       			;


            header('Location:dashboard.php');	





?>