<?php
$mon_yr=date('M Y');

?>

<span id="page_name" style="display:none;">Administrator</span>
<span id="login_user_role" style="display:none;"><?php echo $user_role;?></span>
				<div class="row">
					<div class="col-xl-6">
						<div class="card overflow-hidden">
							<div class="card-body">
								<div class="any-card">
									<div class="c-con">
										<h4 class="heading mb-0">Congratulations <strong><?php echo $uname;?>!!</strong><img src="assets2/images/crm/party-popper.png" alt=""></h4>
										<span><?php echo $display_role; ?></span>
										<p class="mt-3">Lorem Ipsum is simply dummy 😎 text </p>
										 
										<a href="dashboard.php?page=profile" class="btn btn-primary btn-sm">View Profile</a>
									</div>
									<img src="assets2/images/analytics/developer_male.png" class="harry-img" alt="">
									
								</div>	
							</div>
						</div>
					</div>
					<div class="col-xl-6">
										<div class="row">
											<div class="col-xl-6 col-sm-6">
												<div class="card bg-primary text-white">
													<div class="card-header border-0 flex-wrap">
														<div class="revenue-date">
															<span>Weekly Summary</span>
															<!-- <h4 class="text-white">.435</h4> -->
														</div>
														<!-- <div class="avatar-list avatar-list-stacked me-2">
															<img src="assets2/images/contacts/pic555.jpg"
																class="avatar rounded-circle" alt="">
															<img src="assets2/images/contacts/pic666.jpg"
																class="avatar rounded-circle" alt="">
															<span class="avatar rounded-circle">25+</span>
														</div> -->

													</div>
													<div
														class="card-body pb-0 custome-tooltip d-flex align-items-center">
														<div id="chartBar" class="chartBar"></div>
														<div>
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																xmlns="http://www.w3.org/2000/svg">
																<circle cx="10" cy="10" r="10" fill="white" />
																<g clip-path="url(#clip0_3_443)">
																	<path opacity="0.3"
																		d="M13.0641 7.54535C13.3245 7.285 13.3245 6.86289 13.0641 6.60254C12.8038 6.34219 12.3817 6.34219 12.1213 6.60254L6.46445 12.2594C6.2041 12.5197 6.2041 12.9419 6.46445 13.2022C6.7248 13.4626 7.14691 13.4626 7.40726 13.2022L13.0641 7.54535Z"
																		fill="black" />
																	<path
																		d="M7.40729 7.26921C7.0391 7.26921 6.74062 6.97073 6.74062 6.60254C6.74062 6.23435 7.0391 5.93587 7.40729 5.93587H13.0641C13.4211 5.93587 13.7147 6.21699 13.7302 6.57358L13.9659 11.9947C13.9819 12.3626 13.6966 12.6737 13.3288 12.6897C12.961 12.7057 12.6498 12.4205 12.6338 12.0526L12.4258 7.26921H7.40729Z"
																		fill="black" />
																</g>
																<defs>
																	<clipPath id="clip0_3_443">
																		<rect width="16" height="16" fill="white"
																			transform="matrix(-1 0 0 -1 18 18)" />
																	</clipPath>
																</defs>
															</svg>
															<span class="d-block font-w600">45%</span>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6">
												<div class="card bg-secondary text-white">
													<div class="card-header border-0">
														<div class="revenue-date">
															<span class="text-black">Balance</span>
															<h5 class="text-black">Trans - 920.035</h5>
															<h5 class="text-black">PROMO - 920.035</h5>
															<h5 class="text-black">OTP - 920.035</h5>
														</div>
														<!-- <div class="avatar-list avatar-list-stacked me-2">
															<span class="avatar rounded-circle">
																<a href="#">
																	<svg width="14" height="15" viewBox="0 0 14 15"
																		fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path fill-rule="evenodd" clip-rule="evenodd"
																			d="M5.83333 6.27083V1.60417C5.83333 0.959834 6.35567 0.4375 7 0.4375C7.64433 0.4375 8.16667 0.959834 8.16667 1.60417V6.27083H12.8333C13.4777 6.27083 14 6.79317 14 7.4375C14 8.08183 13.4777 8.60417 12.8333 8.60417H8.16667V13.2708C8.16667 13.9152 7.64433 14.4375 7 14.4375C6.35567 14.4375 5.83333 13.9152 5.83333 13.2708V8.60417H1.16667C0.522334 8.60417 0 8.08183 0 7.4375C0 6.79317 0.522334 6.27083 1.16667 6.27083H5.83333Z"
																			fill="#222B40" />
																	</svg>
																</a>
															</span>
														</div> -->

													</div>
													<div
														class="card-body pb-0 custome-tooltip d-flex align-items-center">
														<!-- <div id="expensesChart" class="chartBar"></div> -->
														<!-- <div>
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																xmlns="http://www.w3.org/2000/svg">
																<circle cx="10" cy="10" r="10" fill="#222B40" />
																<g clip-path="url(#clip0_3_473)">
																	<path opacity="0.3"
																		d="M13.0641 7.54535C13.3245 7.285 13.3245 6.86289 13.0641 6.60254C12.8038 6.34219 12.3817 6.34219 12.1213 6.60254L6.46446 12.2594C6.20411 12.5197 6.20411 12.9419 6.46446 13.2022C6.72481 13.4626 7.14692 13.4626 7.40727 13.2022L13.0641 7.54535Z"
																		fill="white" />
																	<path
																		d="M7.40728 7.26921C7.03909 7.26921 6.74061 6.97073 6.74061 6.60254C6.74061 6.23435 7.03909 5.93587 7.40728 5.93587H13.0641C13.4211 5.93587 13.7147 6.21699 13.7302 6.57358L13.9659 11.9947C13.9819 12.3626 13.6966 12.6737 13.3288 12.6897C12.9609 12.7057 12.6498 12.4205 12.6338 12.0526L12.4258 7.26921H7.40728Z"
																		fill="white" />
																</g>
																<defs>
																	<clipPath id="clip0_3_473">
																		<rect width="16" height="16" fill="white"
																			transform="matrix(-1 0 0 -1 18 18)" />
																	</clipPath>
																</defs>
															</svg>
															<span class="d-block font-w600 text-black">45%</span>
														</div> -->
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6">
												<div class="card">
													<div class="card-body depostit-card">
														<div
															class="depostit-card-media d-flex justify-content-between style-1">
															<div>
																<h6>Schedules for <?php echo $mon_yr; ?></h6>
																<h3>20</h3>
															</div>
															<div class="icon-box bg-secondary">
																<svg width="24" height="24" viewBox="0 0 24 24"
																	fill="none" xmlns="http://www.w3.org/2000/svg">
																	<g clip-path="url(#clip0_3_566)">
																		<path opacity="0.3" fill-rule="evenodd"
																			clip-rule="evenodd"
																			d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z"
																			fill="#222B40" />
																		<path fill-rule="evenodd" clip-rule="evenodd"
																			d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z"
																			fill="#222B40" />
																		<path fill-rule="evenodd" clip-rule="evenodd"
																			d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z"
																			fill="#222B40" />
																	</g>
																	<defs>
																		<clipPath id="clip0_3_566">
																			<rect width="24" height="24" fill="white" />
																		</clipPath>
																	</defs>
																</svg>
															</div>
														</div>
														<div class="progress-box mt-0">
															<div class="d-flex justify-content-between">
																<p class="mb-0">Complete Task</p>
																<p class="mb-0">20/28</p>
															</div>
															<div class="progress">
																<div class="progress-bar bg-secondary"
																	style="width:50%; height:5px; border-radius:4px;"
																	role="progressbar"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6">
												<div class="card same-card">
													<div class="card-body depostit-card p-0">
														<div
															class="depostit-card-media d-flex justify-content-between pb-0">
															<div>
																<h6>Used Balance</h6>
																<h3>1200.00</h3>
															</div>
															<div class="icon-box bg-primary">
																<svg width="12" height="20" viewBox="0 0 12 20"
																	fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path
																		d="M11.4642 13.7074C11.4759 12.1252 10.8504 10.8738 9.60279 9.99009C8.6392 9.30968 7.46984 8.95476 6.33882 8.6137C3.98274 7.89943 3.29927 7.52321 3.29927 6.3965C3.29927 5.14147 4.93028 4.69493 6.32655 4.69493C7.34341 4.69493 8.51331 5.01109 9.23985 5.47964L10.6802 3.24887C9.73069 2.6333 8.43112 2.21342 7.14783 2.0831V0H4.49076V2.22918C2.12884 2.74876 0.640949 4.29246 0.640949 6.3965C0.640949 7.87005 1.25327 9.03865 2.45745 9.86289C3.37331 10.4921 4.49028 10.83 5.56927 11.1572C7.88027 11.8557 8.81873 12.2813 8.80805 13.691L8.80799 13.7014C8.80799 14.8845 7.24005 15.3051 5.89676 15.3051C4.62786 15.3051 3.248 14.749 2.46582 13.9222L0.535522 15.7481C1.52607 16.7957 2.96523 17.5364 4.4907 17.8267V20.0001H7.14783V17.8735C9.7724 17.4978 11.4616 15.9177 11.4642 13.7074Z"
																		fill="#fff" />
																</svg>
															</div>
														</div>
														<div id="NewExperience"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
				

					<div class="col-xl-9 col-lg-7">
						<div class="card overflow-hidden">
							<div class="card-header border-0 pb-0 flex-wrap">
								<h4 class="heading mb-0">Reports</h4>
								<ul class="nav nav-pills mix-chart-tab" id="pills-tab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" data-series="today" id="pills-today-tab" data-bs-toggle="pill" data-bs-target="#pills-today" type="button" role="tab" aria-selected="false">Today</button>
								  </li>
								  <li class="nav-item" role="presentation">
									
									<button class="nav-link " data-series="week" id="pills-week-tab" data-bs-toggle="pill" data-bs-target="#pills-week" type="button" role="tab" aria-selected="true">Week</button>
								  </li>
								  <li class="nav-item" role="presentation">
									<button class="nav-link" data-series="month" id="pills-month-tab" data-bs-toggle="pill" data-bs-target="#pills-month" type="button" role="tab" aria-selected="false">Month</button>
								  </li>
								  
								   <li class="nav-item" role="presentation">
									<button class="nav-link" data-series="all" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-selected="false">All</button>
								  </li>
								</ul>
							</div>
							<div class="card-body custome-tooltip p-0">
									<div id="overiewChart"></div>
								<div class="ttl-project ds-chart">
									<div class="pr-data">
										<h5>12,721</h5>
										<span>Submitted</span>
									</div>
									<div class="pr-data">
										<h5 class="text-primary">721</h5>
										<span>Delivered</span>
									</div>
									<div class="pr-data">
										<h5>2,50,523</h5>
										<span>Undelivered</span>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6">
										<div class="card">
											<div class="card-body">
												<div id="redial"></div>
												<span class="right-sign">
													<svg width="93" height="93" viewBox="0 0 93 93" fill="none"
														xmlns="http://www.w3.org/2000/svg">
														<g filter="url(#filter0_d_3_700)">
															<circle cx="46.5" cy="31.5" r="16.5" fill="#F8B940" />
														</g>
														<g clip-path="url(#clip0_3_700)">
															<path
																d="M52.738 25.3524C53.0957 24.9315 53.7268 24.8804 54.1476 25.2381C54.5684 25.5957 54.6196 26.2268 54.2619 26.6476L45.7619 36.6476C45.3986 37.0751 44.7549 37.1201 44.3356 36.7474L39.8356 32.7474C39.4228 32.3805 39.3857 31.7484 39.7526 31.3356C40.1195 30.9229 40.7516 30.8857 41.1643 31.2526L44.9002 34.5733L52.738 25.3524Z"
																fill="#222B40" />
														</g>
														<defs>
															<filter id="filter0_d_3_700" x="0" y="0" width="93"
																height="93" filterUnits="userSpaceOnUse"
																color-interpolation-filters="sRGB">
																<feFlood flood-opacity="0"
																	result="BackgroundImageFix" />
																<feColorMatrix in="SourceAlpha" type="matrix"
																	values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
																	result="hardAlpha" />
																<feOffset dy="15" />
																<feGaussianBlur stdDeviation="15" />
																<feComposite in2="hardAlpha" operator="out" />
																<feColorMatrix type="matrix"
																	values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" />
																<feBlend mode="normal" in2="BackgroundImageFix"
																	result="effect1_dropShadow_3_700" />
																<feBlend mode="normal" in="SourceGraphic"
																	in2="effect1_dropShadow_3_700" result="shape" />
															</filter>
															<clipPath id="clip0_3_700">
																<rect width="24" height="24" fill="white"
																	transform="translate(35 19)" />
															</clipPath>
														</defs>
													</svg>
												</span>
												<div class="redia-date text-center">
													<h4>Cutting data</h4>
													<p>
														Lorem ipsum dolor sit amet, consectetur
													</p>
													<a href="crm.html" class="btn btn-secondary text-black">More
														Details</a>
												</div>
											</div>

										</div>
									</div>

							<div class="col-xl-6">
								<div class="card">
									<div class="card-body p-0">
										<div class="table-responsive active-projects task-table">
											<div class="tbl-caption">
												<h4 class="heading mb-0">Bulk Traffic Boxes</h4>    
									
											</div>
											<table id="live_gateway1" class="table market-update">
												<thead>
													<tr>
														<th>Out/In</th>
														<th>Total</th>
														<th>Queue</th>
														<th>Store Size</th>
														<th>TPS</th>
														<!-- <th>Action</th> -->
													</tr>
												</thead>
												<tbody>
													
													<tr>
														<td>
															<div class="d-flex align-items-center">
																<img src="assets2/images/crm/dribble.png" class="avatar avatar-lg" alt="">
																<div class="ms-2 dr-data">
																	<h6 class="mb-0">SMS</h6>
																	
																</div>
															</div>
														</td>
														<td id="sms_total_sent">0</td>
														<td class="text-success" id="sms_total_queued"><i class="fa-solid fa-arrow-trend-up me-1"></i>0</td>
														<td id="sms_total_store_size">0</td>
														<td id="sms_total_inbound"><span class="badge badge-success light border-0">0</span></td>
														
													</tr>
													<tr>
														<td>
															<div class="d-flex align-items-center">
																<img src="assets2/images/crm/facebook.png" class="avatar avatar-lg" alt="">
																<div class="ms-2 dr-data">
																	<h6 class="mb-0">DLR</h6>
																	
																</div>
															</div>
														</td>
														<td id="dlr_total_sent">0</td>
														<td class="text-danger" id="dlr_total_queued"><i class="fa-solid fa-arrow-trend-down me-1"></i> 0</td>
														<td id="dlr_total_store_size">0</td>
														<td id="dlr_total_inbound"><span class="badge badge-danger light border-0">0</span></td>
														
													</tr>
													
													<tr class="heading-data">
														<td colspan="5" class="text-start">Gateway Status-Bulk : <span id="gateway_status"></span>			
														<form method="post" id="form">
														<input type="hidden" id="action" name="action" value=""/><input type="hidden" name="smsc" id="smsc" value=""/><input type="hidden" name="level" id="level" value=""/>
														</form>
														</td>
													
													</tr>
													<table id="" class="table market-update">
												<thead>
													<tr>
														<th>Gateway</th>
														<th>Queue</th>
														<th>Sessions</th>
														<th>Status</th>
														<th>Action</th>
														<!-- <th>Action</th> -->
													</tr>
												</thead>
												<tbody id="gateway_dtls_tbl">
													<!-- <tr>
														<td>
															<div class="d-flex align-items-center">
																<img src="assets2/images/crm/bing.png" class="avatar avatar-lg" alt="">
																<div class="ms-2 dr-data">
																	<h6 class="mb-0">Bing</h6>
																	<span>30-50 Ads</span>
																</div>
															</div>
														</td>
														<td>Meta</td>
														<td class="text-success"><i class="fa-solid fa-arrow-trend-down me-1"></i> 2.556</td>
														<td>$4,3655</td>
														<td><span class="badge badge-primary light border-0">Pending</span></td>
													
													</tr> -->
													
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6">
								<div class="card">
									<div class="card-body p-0">
										<div class="table-responsive active-projects task-table">
											<div class="tbl-caption">
												<h4 class="heading mb-0">OTP Traffic</h4>
											</div>
											<table id="" class="table market-update">
												<thead>
													<tr>
														<th>Out/In</th>
														<th>Total</th>
														<th>Queue</th>
														<th>Store Size</th>
														<th>TPS</th>
														<!-- <th>Action</th> -->
													</tr>
												</thead>
												<tbody>
													<tr class="heading-data">
														
													</tr>
													<tr>
														<td>
															<div class="d-flex align-items-center">
																<img src="assets2/images/crm/dribble.png" class="avatar avatar-lg" alt="">
																<div class="ms-2 dr-data">
																	<h6 class="mb-0">SMS</h6>
																
																</div>
															</div>
														</td>
														<td id="sms_total_sent2">0</td>
														<td class="text-success" id="sms_total_queued2"><i class="fa-solid fa-arrow-trend-up me-1"></i>0</td>
														<td id="sms_total_store_size2">0</td>
														<td id="sms_total_inbound2"><span class="badge badge-success light border-0">0</span></td>
														
													</tr>
													<tr>
														<td>
															<div class="d-flex align-items-center">
																<img src="assets2/images/crm/facebook.png" class="avatar avatar-lg" alt="">
																<div class="ms-2 dr-data">
																	<h6 class="mb-0">DLR</h6>
																	
																</div>
															</div>
														</td>
														<td id="dlr_total_sent2">0</td>
														<td class="text-danger" id="dlr_total_queued2"><i class="fa-solid fa-arrow-trend-down me-1"></i> 0</td>
														<td id="dlr_total_store_size2">0</td>
														<td id="dlr_total_inbound2"><span class="badge badge-danger light border-0">0</span></td>
														
													</tr>
												
													<tr class="heading-data">
														<td colspan="5" class="text-start">Gateway Status-OTP</td>
														<!-- <td>
															<svg xmlns="http://www.w3.org/2000/svg" id="Icons1" viewBox="0 0 60 60" width="22" height="22"><path d="M2.245,29H4a1,1,0,0,1,1,1A24.943,24.943,0,0,0,17.2,51.465a6.144,6.144,0,0,1,1.976-3.195l.188-.163A20.9,20.9,0,0,1,9,30a1,1,0,0,1,1-1h1.755a.229.229,0,0,0,.222-.141.218.218,0,0,0-.037-.25L7.186,23.084a.247.247,0,0,0-.371,0L2.06,28.609a.218.218,0,0,0-.037.25A.229.229,0,0,0,2.245,29Z"/><path d="M11.738,19.167l.163.19A20.869,20.869,0,0,1,30,9a1,1,0,0,1,1,1v1.755a.229.229,0,0,0,.141.222.219.219,0,0,0,.25-.037l5.524-4.754a.247.247,0,0,0,0-.372L31.391,2.06a.221.221,0,0,0-.25-.037A.229.229,0,0,0,31,2.245V4a1,1,0,0,1-1,1A24.94,24.94,0,0,0,8.535,17.2a6.2,6.2,0,0,1,3.2,1.971Z"/><path d="M28.859,48.023a.252.252,0,0,0-.1-.023.223.223,0,0,0-.147.06l-5.526,4.754a.248.248,0,0,0,0,.372l5.525,4.754a.221.221,0,0,0,.25.037A.229.229,0,0,0,29,57.755V56a1,1,0,0,1,1-1A24.943,24.943,0,0,0,51.466,42.8a6.246,6.246,0,0,1-3.2-1.98v0l-.155-.179A20.9,20.9,0,0,1,30,51a1,1,0,0,1-1-1V48.245A.229.229,0,0,0,28.859,48.023Z"/><path d="M51,30a1,1,0,0,1-1,1H48.245a.229.229,0,0,0-.222.141.218.218,0,0,0,.037.25l4.754,5.524a.216.216,0,0,0,.371,0l4.755-5.525a.218.218,0,0,0,.037-.25A.229.229,0,0,0,57.755,31H56a1,1,0,0,1-1-1A24.941,24.941,0,0,0,42.8,8.534a6.239,6.239,0,0,1-1.98,3.2l-.181.156A20.9,20.9,0,0,1,51,30Z"/></svg>
														</td> -->
														<table id="" class="table market-update">
												<thead>
													<tr>
														<th>Gateway</th>
														<th>Queue</th>
														<th>Sessions</th>
														<th>Status</th>
														<th>Action</th>
														<!-- <th>Action</th> -->
													</tr>
												</thead>
														
													</tr>
													
													<!-- <tr>
														<td>
															<div class="d-flex align-items-center">
																<img src="assets2/images/crm/twitter.png" class="avatar avatar-lg" alt="">
																<div class="ms-2 dr-data">
																	<h6 class="mb-0">Twitter Ads</h6>
																	<span>20-60 Ads</span>
																</div>
															</div>
														</td>
														<td>Tesla</td>
														<td class="text-danger"><i class="fa-solid fa-arrow-trend-down me-1"></i> 2.556</td>
														<td>$4,3655</td>
														<td><span class="badge badge-danger light border-0">Pending</span></td>
														
													</tr> -->
													<tbody id="gateway_dtls_tbl2">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
				<div class="row">
					<div class="col-xl-6 col-xxl-12">
						<div class="card">
							<div class="card-body p-0">
								<div class="table-responsive active-projects">
									<div class="tbl-caption">
										<h4 class="heading mb-0">Major Campaigns > 20k from archive table</h4>
									</div>
									<table id="projects-tbl" class="table">
										<thead>
											<tr>
												<th>User Name</th>
												<th>Campaign Id</th>
												<th>SMS Count</th>
												<th>Parent</th>
												<th>Status</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Batman</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Liam Risher</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														
														<span class="text-primary">51000</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-primary light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Bender Project</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="assets2/images/contacts/pic2.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Oliver Noah</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														
														<span class="text-danger">300200</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-danger light border-0">Pending</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Canary</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="assets2/images/contacts/pic888.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Elijah James</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														
														<span class="text-success">40000</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="assets2/images/contacts/pic666.jpg"
															class="avatar avatar-md  rounded-circle" alt="">
														<img src="assets2/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic666.jpg"
															class="avatar avatar-md  rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-success light border-0">Completed</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Casanova</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">William Risher</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														
														<span class="text-primary">53000</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-primary light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Bigfish</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="assets2/images/contacts/pic777.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Donald Benjamin</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														
														<span class="text-danger">300000</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic777.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-danger light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Matadors</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="assets2/images/contacts/pic888.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Liam Risher</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-primary"
																style="width:53%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-primary">53%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="assets2/images/contacts/pic777.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-primary light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Mercury</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="assets2/images/contacts/pic2.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Oliver Noah</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-danger"
																style="width:30%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-danger">30%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic777.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-danger light border-0">Pending</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Whistler</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="assets2/images/contacts/pic999.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Elijah James</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-success"
																style="width:40%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-success">40%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="assets2/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic666.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-success light border-0">Completed</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Time Projects</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="assets2/images/contacts/pic2.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">Lucas</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-danger"
																style="width:33%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-primary">33%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic999.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-primary light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>
											<tr>
												<td>Fast Ball</td>
												<td>
													<div class="d-flex align-items-center">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<p class="mb-0 ms-2">William Risher</p>
													</div>
												</td>
												<td class="pe-0">
													<div class="tbl-progress-box">
														<div class="progress">
															<div class="progress-bar bg-primary"
																style="width:53%; height:5px; border-radius:4px;"
																role="progressbar"></div>
														</div>
														<span class="text-primary">53%</span>
													</div>
												</td>
												<td class="pe-0">
													<div class="avatar-list avatar-list-stacked">
														<img src="assets2/images/contacts/pic1.jpg"
															class="avatar avatar-md  rounded-circle" alt="">
														<img src="assets2/images/contacts/pic555.jpg"
															class="avatar avatar-md rounded-circle" alt="">
														<img src="assets2/images/contacts/pic999.jpg"
															class="avatar avatar-md rounded-circle" alt="">
													</div>
												</td>
												<td class="pe-0">
													<span class="badge badge-primary light border-0">Inprogress</span>
												</td>
												<td>
													<span>06 Sep 2021</span>
												</td>
											</tr>

										</tbody>

									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-xl-6 col-xxl-8 col-lg-7">
						<div class="card h-auto">
							<div class="card-header border-0 pb-3">
								<h4 class="heading mb-0">Our Services</h4>
								<a href="javascript:void(0)" class="btn btn-sm btn-primary">View All</a>
							</div>
							<div class="card-body pt-0">
								<div class="swiper mySwiper">
									<div class="swiper-wrapper">
										<div class="swiper-slide">
											<div class="card">
												<div class="card-body">
													<div class="card-media">
														<img src="assets2/images/p1.gif" alt="">
													</div>
													<div class="media-data">
														<h4><a href="project.html">Development planning</a></h4>
														<div class="d-flex align-items-center">
															<div class="avatar-list avatar-list-stacked">
																<img src="assets2/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
																<img src="assets2/images/contacts/pic555.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="assets2/images/contacts/pic1.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="assets2/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
															</div>
															<span>21+ Team</span>
														</div>
														<div
															class="dateformat d-flex justify-content-between align-items-end">
															<div>
																<p>Due Date</p>
																<span>06 Sep 2021</span>
															</div>
															<span
																class="badge badge-danger light border-0">Pending</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="swiper-slide">
											<div class="card">
												<div class="card-body">
													<div class="card-media">
														<img src="assets2/images/p3.gif" alt="">
													</div>
													<div class="media-data">
														<h4><a href="project.html">Desinging planning</a></h4>
														<div class="d-flex align-items-center">
															<div class="avatar-list avatar-list-stacked">
																<img src="assets2/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
																<img src="assets2/images/contacts/pic555.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="assets2/images/contacts/pic1.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="assets2/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
															</div>
															<span>21+ Team</span>
														</div>
														<div
															class="dateformat d-flex justify-content-between align-items-end">
															<div>
																<p>Due Date</p>
																<span>06 Sep 2021</span>
															</div>
															<span
																class="badge badge-info light border-0">Inprogress</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="swiper-slide">
											<div class="card">
												<div class="card-body">
													<div class="card-media">
														<img src="assets2/images/p.gif" alt="">
													</div>
													<div class="media-data">
														<h4><a href="project.html">Frontend Designing</a></h4>
														<div class="d-flex align-items-center">
															<div class="avatar-list avatar-list-stacked">
																<img src="assets2/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
																<img src="assets2/images/contacts/pic555.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="assets2/images/contacts/pic1.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="assets2/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
															</div>
															<span>21+ Team</span>
														</div>
														<div
															class="dateformat d-flex justify-content-between align-items-end">
															<div>
																<p>Due Date</p>
																<span>06 Sep 2021</span>
															</div>
															<span
																class="badge badge-warning light border-0">Inprogress</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="swiper-slide">
											<div class="card">
												<div class="card-body">
													<div class="card-media">
														<img src="assets2/images/p2.gif" alt="">
													</div>
													<div class="media-data">
														<h4>Compete this projects Monday</h4>
														<div class="d-flex align-items-center">
															<div class="avatar-list avatar-list-stacked">
																<img src="assets2/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
																<img src="assets2/images/contacts/pic555.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="assets2/images/contacts/pic1.jpg"
																	class="avatar avatar-md rounded-circle" alt="">
																<img src="assets2/images/contacts/pic666.jpg"
																	class="avatar avatar-md  rounded-circle" alt="">
															</div>
															<span>21+ Team</span>
														</div>
														<div
															class="dateformat d-flex justify-content-between align-items-end">
															<div>
																<p>Due Date</p>
																<span>06 Sep 2021</span>
															</div>
															<span
																class="badge badge-primary light border-0">Inprogress</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="col-xl-3 respo col-xxl-4 col-lg-5">
						<div class="row">
							<div class="col-xl-12">
								<div class="card my-calendar">
									<div class="card-body schedules-cal p-2">
										<input type="text" class="form-control d-none" id="datetimepicker1">
										<div class="events">
											<h6>events</h6>
											<div class="dz-scroll event-scroll">
												<div class="event-media">
													<div class="d-flex align-items-center">
														<div class="event-box">
															<h5 class="mb-0">20</h5>
															<span>Mon</span>
														</div>
														<div class="event-data ms-2">
															<h5 class="mb-0"><a href="project.html">Development
																	planning</a></h5>
															<span>w3it Technologies</span>
														</div>
													</div>
													<span class="text-white">12:05 PM</span>
												</div>
												<div class="event-media">
													<div class="d-flex align-items-center">
														<div class="event-box">
															<h5 class="mb-0">20</h5>
															<span>Mon</span>
														</div>
														<div class="event-data ms-2">
															<h5 class="mb-0"><a href="project.html">Desinging
																	planning</a></h5>
															<span>w3it Technologies</span>
														</div>
													</div>
													<span class="text-white">12:05 PM</span>
												</div>
												<div class="event-media">
													<div class="d-flex align-items-center">
														<div class="event-box">
															<h5 class="mb-0">20</h5>
															<span>Mon</span>
														</div>
														<div class="event-data ms-2">
															<h5 class="mb-0"><a href="project.html">Frontend
																	Designing</a></h5>
															<span>w3it Technologies</span>
														</div>
													</div>
													<span class="text-white">12:05 PM</span>
												</div>
												<div class="event-media">
													<div class="d-flex align-items-center">
														<div class="event-box">
															<h5 class="mb-0">20</h5>
															<span>Mon</span>
														</div>
														<div class="event-data ms-2">
															<h5 class="mb-0"><a href="project.html">Software
																	planning</a></h5>
															<span>w3it Technologies</span>
														</div>
													</div>
													<span class="text-white">12:05 PM</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card same-card chart-chart">
									<div class="card-body d-flex align-items-center  py-2">
										<div id="AllProject"></div>
										<ul class="project-list">
											<li>
												<h6>All Projects</h6>
											</li>
											<li>
												<svg width="10" height="10" viewBox="0 0 10 10" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<rect width="10" height="10" rx="3" fill="#3AC977" />
												</svg>
												Compete
											</li>
											<li>
												<svg width="10" height="10" viewBox="0 0 10 10" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<rect width="10" height="10" rx="3" fill="var(--primary)" />
												</svg>
												Pending
											</li>
											<li>
												<svg width="10" height="10" viewBox="0 0 10 10" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<rect width="10" height="10" rx="3" fill="var(--secondary)" />
												</svg>
												Not Start
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div> -->
			

				<script type="text/javascript" src="assets/js/dashboard.js?=<?=time();?>"></script>