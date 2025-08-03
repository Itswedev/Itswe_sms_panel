<div class="page-body">
<span id="page_name" style="display:none;">Administrator</span>
          <!-- Container-fluid starts-->
          <div class="container-fluid default-dashboard"> 
            <div class="row widget-grid">
              <div class="col-xl-4 col-md-4 proorder-xl-1 proorder-md-1">  
                <div class="card profile-greeting p-0">
                  <div class="card-body">
                    <div class="img-overlay">
                      <h1>Good day, <?php echo ucfirst($uname); ?></h1>
                      <p>Welcome to the Vapio family! We are delighted that you have choose us to serve you.</p>
                      <a class="btn" href="<?php echo $baseURL;?>dashboard.php?page=bulksms">Start Campaign</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-md-6 proorder-xl-2 proorder-md-2">
                <div class="card" style="height: 248px;">
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                      <h4>Weekly Trend</h4>
                      <!-- <div class="dropdown icon-dropdown">
                        <button class="btn dropdown-toggle" id="userdropdown17" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown17"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a></div>
                      </div> -->
                    </div>
                  </div>
                  <div class="card-body pb-0 opening-box">
                    <div class="d-flex align-items-center gap-2"> 
                      <!-- <h2>$ 12,463</h2> -->
                      <div class="d-flex">
                        <!-- <p class="mb-0 up-arrow"></p><span class="f-w-500 font-success"></span> -->
                      </div>
                    </div>
                    <div id="growthchart"> </div>
                  </div>
                </div>
              </div>
               <div class="col-xl-4 col-md-5 proorder-xl-3 proorder-md-3"> 
                <div class="card shifts-char-box">
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top"> 
                      <h4>Analysis - <span id="show_analysis"></span></h4>
                      <div class="d-flex align-items-center gap-3"> 
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="load_analysis_btn" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        <!-- <div class="location-menu dropdown">
                          <button class="btn dropdown-toggle" id="locationdropdown" data-bs-toggle="dropdown" aria-expanded="false">Location</button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown"><a class="dropdown-item" href="#">Address Selection</a><a class="dropdown-item" href="#">Geo-Menu</a><a class="dropdown-item" href="#">Place Picker</a></div>
                        </div> -->
                        <div class="dropdown icon-dropdown">
                          <button class="btn dropdown-toggle" id="userdropdown16" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown16"><a class="dropdown-item check_analysis" href="#">Today</a><a class="dropdown-item check_analysis" href="#">Weekly</a><a class="dropdown-item check_analysis" href="#">Monthly</a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row"> 
                      <div class="col-5"> 
                        <div class="overview" id="shifts-overview"></div>
                      </div>
                      <div class="col-5 shifts-overview">
                        <div class="d-flex gap-2"> 
                          <div class="flex-shrink-0"><span class="bg-primary"> </span></div>
                          <div class="flex-grow-1"> 
                            <h6>Mismatch</h6>
                          </div><span id='mismatch'>0</span>
                        </div>
                        <div class="d-flex gap-2"> 
                          <div class="flex-shrink-0"><span class="bg-secondary"></span></div>
                          <div class="flex-grow-1"> 
                            <h6>Sent</h6>
                          </div><span id='sent'>0</span>
                        </div>
                        <div class="d-flex gap-2"> 
                          <div class="flex-shrink-0"><span class="bg-warning"> </span></div>
                          <div class="flex-grow-1"> 
                            <h6>Delivered</h6>
                          </div><span id='delivered'>0</span>
                        </div>
                        <div class="d-flex gap-2"> 
                          <div class="flex-shrink-0"><span class="bg-tertiary"></span></div>
                          <div class="flex-grow-1"> 
                            <h6>Failed</h6>
                          </div><span id='failed'>0</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-md-7 proorder-xl-4 box-col-6 proorder-md-6"> 
                <div class="card">
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                      <h4>Yearly Traffic</h4>
                      <div class="dropdown icon-dropdown">
                        <button class="btn dropdown-toggle" id="userdropdown11" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown11"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body pb-0">
                    <div id="customer-transaction"></div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-xl-70 col-md-12 proorder-md-6"> 
                <div class="card" style="height: 93%;">
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                      <h4>Sender Performance</h4>
                      <div class="dropdown icon-dropdown">
                        <button class="btn dropdown-toggle" id="userdropdown2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown2"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body p-0 projects">
                    <div class="table-responsive theme-scrollbar">
                      <table class="table display" id="recent-product" style="width:100%">
                        <thead>
                          <tr>
                            <th>
                             <!-- <div class="form-check">-->
                            <!--    <input class="form-check-input" type="checkbox" value="">
                            </div>-->
                            </th>
                            <th>Sender</th>
                            <th>0-5s</th>
                            <th>6-10s </th>
                            <th>11-20s</th>
                            <th>21-30s </th>
                            <th>30s</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td></td>
                            <td> HDFCBK</td>
                            <td>40</td>
                            <td>90</td>
                            <td>100</td>
                            <td>30</td>
                            <td>50</td>
                          </tr>
                          <tr>
                            <td>
                            </td>
                            <td>ICICBK</td>
                            <td>40</td>
                            <td>90</td>
                            <td>78</td>
                            <td>30</td>
                            <td>50</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-5 col-xl-7 box-col-7 proorder-xl-9 proorder-md-10"> 
                <div class="card">
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                      <h4>Template Summary</h4>
                      <div class="dropdown icon-dropdown">
                        <button class="btn dropdown-toggle" id="userdropdown15" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown15"><a class="dropdown-item check_summary" href="#">Today</a><a class="dropdown-item check_summary" href="#">Weekly</a><a class="dropdown-item check_summary" href="#">Monthly</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body sales-product px-0 pb-0">
                    <div class="table-responsive theme-scrollbar" style="height:431px;">
                      <table class="table display" style="width:100%" id="template_summary">
                        <thead>
                          <tr>
                            <th>Template Name / ID</th>
                            <th>Total</th>
                            <th>Sent</th>
                            <th>Delivered</th>
                          </tr>
                        </thead>
                        <tbody id="template_summary_body">
                       
                      
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-xl-40 col-md-6 proorder-md-1"> 
                <div class="card" style="height:92%;">
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                      <h4>Campaign Status</h4>
                      <div class="dropdown icon-dropdown">
                        <button class="btn dropdown-toggle" id="userdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body project-status-col">
                    <div class="row"> 
                      <div class="col-6">
                        <div class="btn-light1-primary b-r-10"> 
                          <div class="upcoming-box"> 
                            <div class="upcoming-icon bg-primary"> <img src="assets/images/dashboard-2/svg-icon/calendar.png" alt=""></div>
                            <h6>Upcomings</h6>
                            <p><span id="upcoming_campaign"></span> Projects</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="btn-light1-secondary b-r-10"> 
                          <div class="upcoming-box"> 
                            <div class="upcoming-icon bg-secondary"> <img src="assets/images/dashboard-2/svg-icon/check.png" alt=""></div>
                            <h6>Completed</h6>
                            <p><span id="completed_campaign"></span> Projects</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="btn-light1-warning b-r-10"> 
                          <div class="upcoming-box mb-0"> 
                            <div class="upcoming-icon bg-warning"> <img src="assets/images/dashboard-2/svg-icon/processing.png" alt=""></div>
                            <h6>In Progress</h6>
                            <p><span id="progress_campaign"></span> Projects</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="btn-light1-tertiary b-r-10"> 
                          <div class="upcoming-box mb-0"> 
                            <div class="upcoming-icon bg-tertiary"> <img src="assets/images/dashboard-2/svg-icon/total.png" alt=""></div>
                            <h6>Total</h6>
                            <p><span id="total_campaign"></span> Projects</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-12 col-xl-12 box-col-12 proorder-xl-8 proorder-md-9"> 
                <div class="card">
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                      <h4>Today Statistic</h4><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="load_today_graph_btn" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw" style="margin-left:-81%;"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                      <div class="dropdown icon-dropdown">
                        <button class="btn dropdown-toggle" id="userdropdown14" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown14"><a class="dropdown-item check_statistic" href="#">Today</a><a class="dropdown-item check_statistic" href="#">Weekly</a><a class="dropdown-item check_statistic" href="#">Monthly</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body sale-statistic">
                    <div class="row"> 
                      <div class="col-2 statistic-icon">    
                        <div class="light-card balance-card widget-hover">
                          <div class="icon-box"><img src="assets/images/dashboard/icon/customers.png" alt=""></div>
                          <div> <span class="f-w-500 f-light">Total</span>
                            <h5 class="mt-1 mb-0" id="today_total">0</h5>
                          </div>
                          <div class="ms-auto text-end">
                            <!-- <div class="dropdown icon-dropdown">
                              <button class="btn dropdown-toggle" id="incomedropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="incomedropdown"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday </a></div>
                            </div><span class="f-w-600 font-success">+3,7%</span> -->
                          </div>
                        </div>
                      </div>
                      <div class="col-2 statistic-icon"> 
                        <div class="light-card balance-card widget-hover">
                          <div class="icon-box"><img src="assets/images/dashboard/icon/revenue.png" alt=""></div>
                          <div> <span class="f-w-500 f-light">Delivered</span>
                            <h5 class="mt-1 mb-0" id="today_delivered">0   </h5>
                          </div>
                          <div class="ms-auto text-end">
                            <!-- <div class="dropdown icon-dropdown">
                              <button class="btn dropdown-toggle" id="expensedropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="expensedropdown"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday </a></div>
                            </div><span class="f-w-600 font-danger">-0,10%</span> -->
                          </div>
                        </div>
                      </div>
                      <div class="col-2 statistic-icon">
                        <div class="light-card balance-card widget-hover" >
                          <div class="icon-box"><img src="assets/images/dashboard/icon/profit.png" alt=""></div>
                          <div> <span class="f-w-500 f-light">Failed</span>
                            <h5 class="mt-1 mb-0" id="today_failed">0</h5>
                          </div>
                          <div class="ms-auto text-end">
                            <!-- <div class="dropdown icon-dropdown">
                              <button class="btn dropdown-toggle" id="cashbackdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cashbackdropdown"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday </a></div>
                            </div><span class="f-w-600 font-success">+11,6%</span> -->
                          </div>
                        </div>
                      </div>

                      <div class="col-2 statistic-icon">
                        <div class="light-card balance-card widget-hover">
                          <div class="icon-box"><img src="assets/images/dashboard/icon/profit.png" alt=""></div>
                          <div> <span class="f-w-500 f-light">Sent</span>
                            <h5 class="mt-1 mb-0" id="today_sent">0</h5>
                          </div>
                          <div class="ms-auto text-end">
                            <!-- <div class="dropdown icon-dropdown">
                              <button class="btn dropdown-toggle" id="cashbackdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cashbackdropdown"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday </a></div>
                            </div><span class="f-w-600 font-success">+11,6%</span> -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="chart-dash-2-line"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>

        <script type="text/javascript" src="assets/js/dashboard.js?=<?=time();?>"></script>