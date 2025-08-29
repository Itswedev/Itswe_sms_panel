
		<!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
			<div class="deznav-scroll">
				<ul class="metismenu" id="menu">
					<!-- <li class="menu-title">YASH ADMIN</li> -->
					<li><a href="<?php echo $baseURL;?>/dashboard.php" aria-expanded="false">
							<span class="nav-text">Dashboard</span>
						</a>
						
					</li>
					
					
					<li class="menu-title">SMS</li>
					<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
							<div class="menu-icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<g opacity="0.5">
										<path
											d="M9.34933 14.8577C5.38553 14.8577 2 15.47 2 17.9174C2 20.3666 5.364 21 9.34933 21C13.3131 21 16.6987 20.3877 16.6987 17.9404C16.6987 15.4911 13.3347 14.8577 9.34933 14.8577Z"
											fill="white" />
										<path opacity="0.4"
											d="M9.34935 12.5248C12.049 12.5248 14.2124 10.4062 14.2124 7.76241C14.2124 5.11865 12.049 3 9.34935 3C6.65072 3 4.48633 5.11865 4.48633 7.76241C4.48633 10.4062 6.65072 12.5248 9.34935 12.5248Z"
											fill="white" />
										<path opacity="0.4"
											d="M16.1734 7.84876C16.1734 9.19508 15.7605 10.4513 15.0364 11.4948C14.9611 11.6022 15.0276 11.7468 15.1587 11.7698C15.3407 11.7996 15.5276 11.8178 15.7184 11.8216C17.6167 11.8705 19.3202 10.6736 19.7908 8.87119C20.4885 6.19677 18.4415 3.79544 15.8339 3.79544C15.5511 3.79544 15.2801 3.82419 15.0159 3.87689C14.9797 3.88456 14.9405 3.9018 14.921 3.93247C14.8955 3.97176 14.9141 4.02254 14.9395 4.05608C15.7233 5.13217 16.1734 6.44208 16.1734 7.84876Z"
											fill="white" />
										<path
											d="M21.7791 15.1693C21.4318 14.444 20.5932 13.9466 19.3173 13.7023C18.7155 13.5586 17.0854 13.3545 15.5697 13.3832C15.5472 13.3861 15.5345 13.4014 15.5325 13.411C15.5296 13.4263 15.5365 13.4493 15.5658 13.4656C16.2664 13.8048 18.9738 15.2805 18.6333 18.3928C18.6187 18.5289 18.7292 18.6439 18.8672 18.6247C19.5335 18.5318 21.2478 18.1705 21.7791 17.0475C22.0737 16.4534 22.0737 15.7634 21.7791 15.1693Z"
											fill="white" />
									</g>
								</svg>

							</div>
							<span class="nav-text">Campaigns</span>
						</a>
						<ul aria-expanded="false">
							<li><a href="<?php echo $baseURL;?>dashboard.php?page=bulksms">Simple</a></li>
							<li><a href="<?php echo $baseURL;?>dashboard.php?page=dynamic_sms">Dynamic</a></li>
						</ul>
					</li>
					<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
							<div class="menu-icon">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
									width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"></rect>
										<path
											d="M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z"
											fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
										<path
											d="M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
											fill="#000000"></path>
									</g>
								</svg>
							</div>
							<span class="nav-text">Campaign Reports</span>
						</a>
						<ul aria-expanded="false">
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=today_summary_report">Today Report</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=archive_report">Campaign Report</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=api_job_summary">API Sent</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=scheduled_report">Schedule Report</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=url_tracking">URL Tracking</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=mis_report">Mis</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=download_report">Download Center</a></li>
						</ul>
					</li>
					<?php 
                    if($_SESSION['vas']=='Yes')
                    	{

              		?>
					<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
							<div class="menu-icon">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
									width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path
											d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
											fill="#000000" fill-rule="nonzero" opacity="0.3" />
										<path
											d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
											fill="#000000" fill-rule="nonzero" />
									</g>
								</svg>
							</div>
							<span class="nav-text">Vas</span><span
								class="badge badge-xs style-1 new-badge">New</span>
						</a>
						<ul aria-expanded="false">
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=longcode">Long Code</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=shortcode">Short Code</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=miss_call">Miss Call</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=longcode_report">VAS Report</a></li>
						</ul>
					</li>
					<?php
						}
					?>
					<li><a href="<?php echo $baseURL;?>dashboard.php?page=http-api" aria-expanded="false">
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
							<span class="nav-text">HTTP API</span><span
								class="badge badge-xs style-1 new-badge">New</span>
						</a>
					</li>
					<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
							<div class="menu-icon">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_14_1294)">
										<path
											d="M12.1498 18.1013H8.30563L7.86828 15.8455H5.15205L4.71469 18.1013H1.05469L3.67883 3.80664H9.52563L12.1498 18.1013ZM7.43092 13.1523L6.62526 8.04211H6.46413L5.65847 13.1523H7.43092Z" />
										<path d="M17.4903 3.80664H13.5771V18.1013H17.4903V3.80664Z" />
										<mask id="mask0_14_1294" style="mask-type:luminance" maskUnits="userSpaceOnUse"
											x="6" y="0" width="21" height="20">
											<path
												d="M16.6266 0.00350988L6.97803 9.84375L16.8183 19.4923L26.4668 9.65207L16.6266 0.00350988Z" />
										</mask>
										<g mask="url(#mask0_14_1294)">
											<path
												d="M14.7219 3.91233L14.8299 14.8991L18.7149 14.8609L18.609 4.09213L16.632 0.00825376L14.7219 3.91233ZM18.281 14.4355L15.2553 14.4652L15.1592 4.68853L15.3838 4.90622L15.8065 4.47173L16.2438 4.89717L16.6711 4.46324L17.1063 4.89177L17.5245 4.45487L17.9687 4.88023L18.1848 4.65719L18.281 14.4355ZM18.1324 4.09379L17.9573 4.27443L17.5112 3.84721L17.0972 4.27979L16.6664 3.85554L16.2373 4.29131L15.7981 3.86408L15.3748 4.29917L15.1532 4.08445L15.1525 4.00974L16.0974 2.07838L16.6448 2.43559L17.1599 2.08482L18.1324 4.09379ZM16.6397 1.91931L16.2877 1.68959L16.6299 0.990098L16.9707 1.69393L16.6397 1.91931Z" />
											<path
												d="M14.8359 15.545L18.7114 15.5068L18.7072 15.0772L14.8316 15.1153L14.8359 15.545Z" />
											<path
												d="M14.8521 17.1728C14.8573 17.7 15.2905 18.1248 15.8178 18.1196L17.7798 18.1003C18.0352 18.0978 18.2744 17.996 18.4532 17.8136C18.632 17.6312 18.7291 17.3901 18.7266 17.1347L18.7127 15.7235L14.8383 15.7616L14.8521 17.1728ZM18.297 17.1389C18.2984 17.2796 18.2449 17.4123 18.1465 17.5128C18.048 17.6132 17.9163 17.6693 17.7756 17.6707L15.8136 17.69C15.5232 17.6929 15.2846 17.4589 15.2818 17.1686L15.2721 16.1871L18.2874 16.1574L18.297 17.1389Z" />
										</g>
									</g>
									<defs>
										<clipPath id="clip0_14_1294">
											<rect width="20" height="20" />
										</clipPath>
									</defs>
								</svg>
							</div>
							<span class="nav-text">Manage DLT</span><span class="badge badge-xs style-1 new-badge">New</span>
						</a>
						<ul aria-expanded="false">
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=senderid">Manage Header</a></li>
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=template">Templates Upload</a></li>
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=manage_hash">Manage Hash</a></li>
						</ul>
					</li>

					<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
							<div class="menu-icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<g opacity="0.5">
										<path opacity="0.4"
											d="M11.776 21.8374C9.49292 20.4273 7.37062 18.7645 5.44789 16.8796C4.0905 15.5338 3.05386 13.8905 2.41716 12.0753C1.27953 8.53523 2.60381 4.48948 6.30111 3.2884C8.25262 2.67553 10.375 3.05175 12.007 4.29983C13.6396 3.05315 15.7614 2.67705 17.713 3.2884C21.4103 4.48948 22.7435 8.53523 21.6058 12.0753C20.9743 13.8888 19.9438 15.5319 18.5929 16.8796C16.6684 18.7625 14.5463 20.4251 12.2648 21.8374L12.0159 22L11.776 21.8374Z"
											fill="white" />
										<path
											d="M12.0109 22L11.776 21.8374C9.49013 20.4274 7.36487 18.7647 5.43902 16.8796C4.0752 15.5356 3.03238 13.8922 2.39052 12.0753C1.26177 8.53523 2.58605 4.48948 6.28335 3.2884C8.23486 2.67553 10.3853 3.05204 12.0109 4.31057V22Z"
											fill="white" />
										<path
											d="M18.2304 9.99922C18.0296 9.98629 17.8425 9.8859 17.7131 9.72157C17.5836 9.55723 17.5232 9.3434 17.5459 9.13016C17.5677 8.4278 17.168 7.78851 16.5517 7.53977C16.1609 7.43309 15.9243 7.00987 16.022 6.59249C16.1148 6.18182 16.4993 5.92647 16.8858 6.0189C16.9346 6.027 16.9816 6.04468 17.0244 6.07105C18.2601 6.54658 19.0601 7.82641 18.9965 9.22576C18.9944 9.43785 18.9117 9.63998 18.7673 9.78581C18.6229 9.93164 18.4291 10.0087 18.2304 9.99922Z"
											fill="white" />
									</g>
								</svg>
							</div>
							<span class="nav-text">Utility</span>
						</a>
						<ul aria-expanded="false">
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=add_remove_credits">Recharge</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=recharge_history">Transaction History</a></li>
                  			<li> <a href="<?php echo $baseURL ; ?>dashboard.php?page=ip_management">IP Logs</a></li>
                  			<li> <a href="<?php echo $baseURL ; ?>dashboard.php?page=number_block">Number Block</a></li>
							<li> <a href="<?php echo $baseURL ; ?>dashboard.php?page=group">Contacts</a></li>

						</ul>
					</li>
					<?php 
                    if($_SESSION['vas']=='Yes')
                    	{

              		?>
					<li class="menu-title">RCS</li>
					<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
							<div class="menu-icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<g opacity="0.5">
										<path opacity="0.4"
											d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z"
											fill="white" />
										<path fill-rule="evenodd" clip-rule="evenodd"
											d="M8.08002 6.64999V6.65999C7.64902 6.65999 7.30002 7.00999 7.30002 7.43999C7.30002 7.86999 7.64902 8.21999 8.08002 8.21999H11.069C11.5 8.21999 11.85 7.86999 11.85 7.42899C11.85 6.99999 11.5 6.64999 11.069 6.64999H8.08002ZM15.92 12.74H8.08002C7.64902 12.74 7.30002 12.39 7.30002 11.96C7.30002 11.53 7.64902 11.179 8.08002 11.179H15.92C16.35 11.179 16.7 11.53 16.7 11.96C16.7 12.39 16.35 12.74 15.92 12.74ZM15.92 17.31H8.08002C7.78002 17.35 7.49002 17.2 7.33002 16.95C7.17002 16.69 7.17002 16.36 7.33002 16.11C7.49002 15.85 7.78002 15.71 8.08002 15.74H15.92C16.319 15.78 16.62 16.12 16.62 16.53C16.62 16.929 16.319 17.27 15.92 17.31Z"
											fill="white" />
									</g>
								</svg>
							</div>

							<span class="nav-text">RCS Campaigns</span>
						</a>
						<ul aria-expanded="false">
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=rcs">Single RCS</a></li>
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=dynamic_rcs">Dynamic RCS</a></li>
						</ul>
					</li>
					<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
							<div class="menu-icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<g opacity="0.5">
										<path opacity="0.4"
											d="M6.70555 12.8905C6.18944 12.8905 5.77163 13.3145 5.77163 13.8383L5.51416 18.4171C5.51416 19.0846 6.04783 19.625 6.70555 19.625C7.36328 19.625 7.89577 19.0846 7.89577 18.4171L7.63947 13.8383C7.63947 13.3145 7.22167 12.8905 6.70555 12.8905Z"
											fill="white" />
										<path
											d="M7.98037 3.67345C7.98037 3.67345 7.71236 3.39789 7.54618 3.27793C7.30509 3.09264 7.00783 3 6.71173 3C6.37936 3 6.07039 3.10452 5.81877 3.30169C5.77313 3.34801 5.57886 3.5226 5.41852 3.68532C4.41204 4.6367 2.76539 7.12026 2.26215 8.42083C2.18257 8.618 2.01053 9.11685 2 9.38409C2 9.63827 2.05618 9.88294 2.17087 10.1145C2.3312 10.4044 2.58282 10.6372 2.88009 10.7642C3.08606 10.8462 3.70282 10.9733 3.71453 10.9733C4.38981 11.1016 5.48757 11.1704 6.70003 11.1704C7.85514 11.1704 8.90727 11.1016 9.59308 10.997C9.60478 10.9852 10.3702 10.8581 10.6335 10.7179C11.1133 10.4626 11.4118 9.96371 11.4118 9.43041V9.38409C11.4001 9.03608 11.1016 8.30444 11.0911 8.30444C10.5879 7.07394 9.02079 4.64858 7.98037 3.67345Z"
											fill="white" />
										<path opacity="0.4"
											d="M17.2947 11.1096C17.8108 11.1096 18.2286 10.6856 18.2286 10.1618L18.4849 5.58296C18.4849 4.91543 17.9524 4.375 17.2947 4.375C16.637 4.375 16.1033 4.91543 16.1033 5.58296L16.3608 10.1618C16.3608 10.6856 16.7786 11.1096 17.2947 11.1096Z"
											fill="white" />
										<path
											d="M21.8292 13.8853C21.6688 13.5955 21.4172 13.3639 21.1199 13.2356C20.914 13.1536 20.296 13.0265 20.2855 13.0265C19.6102 12.8983 18.5124 12.8294 17.3 12.8294C16.1449 12.8294 15.0928 12.8983 14.4069 13.0028C14.3952 13.0147 13.6298 13.1429 13.3665 13.2819C12.8855 13.5373 12.5883 14.0361 12.5883 14.5706V14.617C12.6 14.965 12.8972 15.6954 12.9089 15.6954C13.4122 16.926 14.9781 19.3526 16.0197 20.3265C16.0197 20.3265 16.2877 20.6021 16.4538 20.7209C16.6938 20.9074 16.991 21 17.2895 21C17.6207 21 17.9285 20.8955 18.1812 20.6983C18.2269 20.652 18.4212 20.4774 18.5815 20.3158C19.5868 19.3633 21.2346 16.8796 21.7367 15.5802C21.8175 15.3831 21.9895 14.883 22 14.617C22 14.3616 21.9438 14.1169 21.8292 13.8853Z"
											fill="white" />
									</g>
								</svg>
							</div>
							<span class="nav-text">Manage RCS</span>
						</a>
						<ul aria-expanded="false">
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=access_token">Access Token</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=rcs_template">Templates</a></li>
						</ul>
					</li>

					<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
							<div class="menu-icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<g opacity="0.5">
										<path opacity="0.4"
											d="M2.00018 11.0785C2.05018 13.4165 2.19018 17.4155 2.21018 17.8565C2.28118 18.7995 2.64218 19.7525 3.20418 20.4245C3.98618 21.3675 4.94918 21.7885 6.29218 21.7885C8.14818 21.7985 10.1942 21.7985 12.1812 21.7985C14.1762 21.7985 16.1122 21.7985 17.7472 21.7885C19.0712 21.7885 20.0642 21.3565 20.8362 20.4245C21.3982 19.7525 21.7592 18.7895 21.8102 17.8565C21.8302 17.4855 21.9302 13.1445 21.9902 11.0785H2.00018Z"
											fill="white" />
										<path
											d="M11.2454 15.3842V16.6782C11.2454 17.0922 11.5814 17.4282 11.9954 17.4282C12.4094 17.4282 12.7454 17.0922 12.7454 16.6782V15.3842C12.7454 14.9702 12.4094 14.6342 11.9954 14.6342C11.5814 14.6342 11.2454 14.9702 11.2454 15.3842Z"
											fill="white" />
										<path fill-rule="evenodd" clip-rule="evenodd"
											d="M10.2113 14.5564C10.1113 14.9194 9.7623 15.1514 9.38431 15.1014C6.8333 14.7454 4.39531 13.8404 2.33731 12.4814C2.12631 12.3434 2.00031 12.1074 2.00031 11.8554V8.3894C2.00031 6.2894 3.71231 4.5814 5.81731 4.5814H7.78431C7.97231 3.1294 9.20231 2.0004 10.7043 2.0004H13.2863C14.7873 2.0004 16.0183 3.1294 16.2063 4.5814H18.1833C20.2823 4.5814 21.9903 6.2894 21.9903 8.3894V11.8554C21.9903 12.1074 21.8633 12.3424 21.6543 12.4814C19.5923 13.8464 17.1443 14.7554 14.5763 15.1104C14.5413 15.1154 14.5073 15.1174 14.4733 15.1174C14.1343 15.1174 13.8313 14.8884 13.7463 14.5524C13.5443 13.7564 12.8213 13.1994 11.9903 13.1994C11.1483 13.1994 10.4333 13.7444 10.2113 14.5564ZM13.2863 3.5004H10.7043C10.0313 3.5004 9.46931 3.9604 9.30131 4.5814H14.6883C14.5203 3.9604 13.9583 3.5004 13.2863 3.5004Z"
											fill="white" />
									</g>
								</svg>
							</div>
							<span class="nav-text">RCS Reports</span>
						</a>
						<ul aria-expanded="false">
							<li> <a href="user-profile.html">Today</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=rcs_job_summary">Campaign Report</a></li>
                  			<li> <a href="edit-profile.html">Schedule Report</a></li>
                  			<li> <a href="edit-profile.html">Download</a></li>
                  			<li> <a href="edit-profile.html">MIS</a></li>
						</ul>
							</li>
						<?php
						}
						?>	
					
					<?php 
                    if($_SESSION['vas']=='Yes')
                    	{

              		?>

					<li class="menu-title">OBD</li>
					<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
							<div class="menu-icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<g opacity="0.5">
										<path opacity="0.4"
											d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z"
											fill="white" />
										<path fill-rule="evenodd" clip-rule="evenodd"
											d="M8.08002 6.64999V6.65999C7.64902 6.65999 7.30002 7.00999 7.30002 7.43999C7.30002 7.86999 7.64902 8.21999 8.08002 8.21999H11.069C11.5 8.21999 11.85 7.86999 11.85 7.42899C11.85 6.99999 11.5 6.64999 11.069 6.64999H8.08002ZM15.92 12.74H8.08002C7.64902 12.74 7.30002 12.39 7.30002 11.96C7.30002 11.53 7.64902 11.179 8.08002 11.179H15.92C16.35 11.179 16.7 11.53 16.7 11.96C16.7 12.39 16.35 12.74 15.92 12.74ZM15.92 17.31H8.08002C7.78002 17.35 7.49002 17.2 7.33002 16.95C7.17002 16.69 7.17002 16.36 7.33002 16.11C7.49002 15.85 7.78002 15.71 8.08002 15.74H15.92C16.319 15.78 16.62 16.12 16.62 16.53C16.62 16.929 16.319 17.27 15.92 17.31Z"
											fill="white" />
									</g>
								</svg>
							</div>
							
							<span class="nav-text">Manage Campaign</span>
						</a>
						<ul aria-expanded="false">
							<li> <a href="user-profile.html">Create Campaign</a></li>
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=multimedia">Upload Audio</a></li>
						</ul>
							</li>

							<li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
							<div class="menu-icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<g opacity="0.5">
										<path opacity="0.4"
											d="M16.191 2H7.81C4.77 2 3 3.78 3 6.83V17.16C3 20.26 4.77 22 7.81 22H16.191C19.28 22 21 20.26 21 17.16V6.83C21 3.78 19.28 2 16.191 2Z"
											fill="white" />
										<path fill-rule="evenodd" clip-rule="evenodd"
											d="M8.08002 6.64999V6.65999C7.64902 6.65999 7.30002 7.00999 7.30002 7.43999C7.30002 7.86999 7.64902 8.21999 8.08002 8.21999H11.069C11.5 8.21999 11.85 7.86999 11.85 7.42899C11.85 6.99999 11.5 6.64999 11.069 6.64999H8.08002ZM15.92 12.74H8.08002C7.64902 12.74 7.30002 12.39 7.30002 11.96C7.30002 11.53 7.64902 11.179 8.08002 11.179H15.92C16.35 11.179 16.7 11.53 16.7 11.96C16.7 12.39 16.35 12.74 15.92 12.74ZM15.92 17.31H8.08002C7.78002 17.35 7.49002 17.2 7.33002 16.95C7.17002 16.69 7.17002 16.36 7.33002 16.11C7.49002 15.85 7.78002 15.71 8.08002 15.74H15.92C16.319 15.78 16.62 16.12 16.62 16.53C16.62 16.929 16.319 17.27 15.92 17.31Z"
											fill="white" />
									</g>
								</svg>
							</div>
							
							<span class="nav-text">OBD Reports</span>
						</a>
						<ul aria-expanded="false">
							<li> <a href="<?php echo $baseURL;?>dashboard.php?page=today_voice_summary_report">Today</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=voice_call_summary">Campaign Report</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=scheduled_voice_report">Schedule Report</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=download_report">Download</a></li>
                  			<li> <a href="<?php echo $baseURL;?>dashboard.php?page=voice_mis_report">MIS</a></li>
						</ul>
							</li>
						<?php
						}
						?>	
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
						</ul>					
				<div class="copyright">
					<p>It'sWe Admin Sales Management System © <span class="current-year">2024</span> All Rights Reserved
					</p>
					<p>Made with <span class="heart"></span> by It'sWe</p>
				</div>
			</div>
		</div>

		<!--**********************************
            Sidebar end
        ***********************************-->