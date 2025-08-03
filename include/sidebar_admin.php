<aside class="page-sidebar"> 
          <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
          <div class="main-sidebar" id="main-sidebar">
            <ul class="sidebar-menu" id="simple-bar">
              <li class="pin-title sidebar-main-title">  
                <div> 
                  <h5 class="sidebar-title f-w-700">Pinned</h5>
                </div>
              </li>
              <li class="sidebar-main-title">
                <div>
                  <h5 class="lan-1 f-w-700 sidebar-title">General</h5>
                </div>
              </li>
              <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="<?php echo $baseURL;?>./dashboard.php"> 
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Home-dashboard"></use>
                  </svg>
                  <h6>Dashboard</h6><span class="badge"></span><i class="iconly-Arrow-Right-2 icli"></i></a>
              </li>

              <li class="sidebar-main-title">
                <div>
                  <h5 class="f-w-700 sidebar-title pt-3">SMS</h5>
                </div>
              </li>

              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Info-circle"></use>
                  </svg>
                  <h6 class="f-w-600">Campaigns</h6><i class="iconly-Arrow-Right-2 icli"></i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=bulksms">Simple</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=dynamic_sms">Dynamic </a></li>
                </ul>
              </li>

              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Bag"></use>
                  </svg>
                  <h6 class="f-w-600">Campaign Reports</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=today_summary_report">Today Report</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=archive_report">Campaign Report</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=gateway_report">Gateway Report</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=api_job_summary">API Sent</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=scheduled_report">Schedule Report</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=url_tracking">URL Tracking</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=mis_report">Mis</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=download_report">Download Center</a></li>
              </li>
                </ul>
              </li>
             
              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Chat"></use>
                  </svg>
                  <h6 class="f-w-600">VAS</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=longcode">Long Code</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=shortcode">Short Code</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=miss_call">Miss Call</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=longcode_report">VAS Report</a></li>
                </ul>
              </li>
              
              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="<?php echo $baseURL;?>dashboard.php?page=http-api">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Bookmark"></use>
                  </svg>
                  <h6 class="f-w-600">HTTP API</h6></a></li>
              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <h6 class="f-w-600">Manage DLT</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=senderid">Manage Header</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=template">Templates Upload</a></li>
                </ul>
              </li>

              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <h6 class="f-w-600">Manage Users</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="<?php echo $baseURL ; ?>dashboard.php?page=manage_user">Users</a></li>
                  <li> <a href="<?php echo $baseURL ; ?>dashboard.php?page=branding">Branding</a></li>
                  <li> <a href="edit-profile.html">Account Manager</a></li>
                  <li> <a href="<?php echo $baseURL ; ?>dashboard.php?page=group">Contacts</a></li>
                </ul>
              </li>

              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <h6 class="f-w-600">Utility</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=add_remove_credits">Recharge</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=recharge_history">Transaction History</a></li>
                  <li> <a href="<?php echo $baseURL ; ?>dashboard.php?page=ip_management">IP Logs</a></li>
                  <li> <a href="<?php echo $baseURL ; ?>dashboard.php?page=number_block">Number Block</a></li>
                </ul>
              </li>

              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <h6 class="f-w-600">Panel Control</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=add_gateway">SMS Gateway</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=voice_gateway">OBD Gateway</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=create_plan">Create Plan</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=manage_route">Manage Route</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=routing_plan">Routing Plan</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=sender_routing">Sender Routing</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=smpp_services">SMPP Error Codes</a></li>
                  <li><a href="<?php echo $baseURL;?>dashboard.php?page=update_dlr">Update Dlr</a></li>
                  <li><a href="<?php echo $baseURL;?>dashboard.php?page=check_storage">Storage Check</a></li>
                </ul>
              </li>

              </h6></a></li>
              <li class="sidebar-main-title">
                <div>
                  <h5 class="f-w-700 sidebar-title pt-3">RCS</h5>
                </div>
              </li>

              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <h6 class="f-w-600">RCS Campaigns</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=rcs">Single RCS</a></li>
                  <li> <a href="edit-profile.html">Dynamic RCS</a></li>
                </ul>
              </li>

              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <h6 class="f-w-600">Manage RCS</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=access_token">Access Token</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=rcs_template">Templates</a></li>
                </ul>
              </li>
              
              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
              <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <h6 class="f-w-600">RCS Reports</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="user-profile.html">Today</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=rcs_job_summary">Campaign Report</a></li>
                  <li> <a href="edit-profile.html">Schedule Report</a></li>
                  <li> <a href="edit-profile.html">Download</a></li>
                  <li> <a href="edit-profile.html">MIS</a></li>
                </ul>
              </li>

              </h6></a></li>
              <li class="sidebar-main-title">
                <div>
                  <h5 class="f-w-700 sidebar-title pt-3">OBD</h5>
                </div>
              </li>

              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <h6 class="f-w-600">Manage Campaign</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="user-profile.html">Create Campaign</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=multimedia">Upload Audio</a></li>
                </ul>
              </li> 

              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <h6 class="f-w-600">OBD Reports</h6><i class="iconly-Arrow-Right-2 icli"> </i></a>
                <ul class="sidebar-submenu">
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=today_voice_summary_report">Today</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=voice_call_summary">Campaign Report</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=scheduled_voice_report">Schedule Report</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=download_report">Download</a></li>
                  <li> <a href="<?php echo $baseURL;?>dashboard.php?page=voice_mis_report">MIS</a></li>
                </ul>
              </li>  
              <li><a href="<?php echo $baseURL;?>back_to_admin.php" aria-expanded="false">
							<div class="menu-icon">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
									width="24px" height="25px" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="25" height="25" />
										<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
										<path
											d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 L7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
											fill="#000000" opacity="0.3" />
									</g>
								</svg>
							</div>
							<span class="nav-text">Return To Admin</span><span
								class="badge badge-xs style-1 new-badge">New</span>
							</a>
						</li>
  

              <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="logout.php">
                  <svg class="stroke-icon">
                    <use href="assets2/svg/iconly-sprite.svg#Bookmark"></use>
                  </svg>
                  <h6 class="f-w-600">Log Out</h6></a></li>
          </div>
          <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </aside>