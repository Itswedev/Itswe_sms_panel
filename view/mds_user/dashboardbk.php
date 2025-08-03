<div class="page-body">
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-2"> 
          <div class="row">
              <div class="col-sm-12 col-xl-12 box-col-12">
                <div class="card">
                  <div class="card-header">
                  <h4>Traffic Overview <span> </span></h4>

                    </div>
                    <div class="card-body chart-block">
                    <div class="chart-overflow" id="column-chart1"></div>
                  </div>
                </div>
                </div>
                </div>
            <div class="row">
            <div class="col-xl-3 col-xl-40 col-md-6 proorder-md-1"> 
                <div class="card">  
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                      <h4>Today Report</h4>
                      <div class="dropdown icon-dropdown">
                        <button class="btn dropdown-toggle" id="userdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a></div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body project-status-col">
                    <div class="row"> 
                      <div class="col-6">
                        <div class="btn-light1-primary b-r-10"> 
                          <div class="upcoming-box"> 
                            <div class="upcoming-icon bg-primary"> <img src="<?php echo $baseURL ; ?>assets/images/dashboard-2/svg-icon/calendar.png" alt=""></div>
                            <h6>Total Sent</h6>
                            <p>5000000</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="btn-light1-secondary b-r-10"> 
                          <div class="upcoming-box"> 
                            <div class="upcoming-icon bg-secondary"> <img src="<?php echo $baseURL ; ?>assets/images/dashboard-2/svg-icon/check.png" alt=""></div>
                            <h6>DELIVRD</h6>
                            <p>3000000</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="btn-light1-warning b-r-10"> 
                          <div class="upcoming-box mb-0"> 
                            <div class="upcoming-icon bg-warning"> <img src="<?php echo $baseURL ; ?>assets/images/dashboard-2/svg-icon/processing.png" alt=""></div>
                            <h6>Undeliv</h6>
                            <p>1500000</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="btn-light1-tertiary b-r-10"> 
                          <div class="upcoming-box mb-0"> 
                            <div class="upcoming-icon bg-tertiary"> <img src="<?php echo $baseURL ; ?>assets/images/dashboard-2/svg-icon/total.png" alt=""></div>
                            <h6>Pending Dlr</h6>
                            <p>500000</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-5 col-xl-70 col-md-12 proorder-md-3"> 
                <div class="card">
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                      <h4>Sender Performance</h4>
                      <div class="dropdown icon-dropdown">
                        <button class="btn dropdown-toggle" id="userdropdown2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-more-alt"></i></button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown2"><a class="dropdown-item" href="#">Weekly</a><a class="dropdown-item" href="#">Monthly</a><a class="dropdown-item" href="#">Yearly</a></div>
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
                            <td></td>
                            <td>30</td>
                            <td>50</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>              
              <div class="col-xxl-5 col-xl-6 box-col-6 proorder-xl-7 proorder-md-8"> 
                <div class="card">
                  <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                      <h4>Schedule Jobs</h4>
                    </div>
                  </div>
                  <div class="card-body appointments relative">
                    <div class="row"> 
                      <div class="col-6"> 
                        <ul class="appointments-user">
                        <li class="d-flex align-items-center">
                            <div class="flex-shrink-0"></div>
                            <div class="flex-grow-1">
                            <h5>Username</h5></a>
                            </div>
                          </li>
                          <li class="d-flex align-items-center">
                            <div class="flex-shrink-0"><img src="../assets/images/dashboard/user/05.png" alt=""></div>
                            <div class="flex-grow-1">
                            <h5>Joshua Wood</h5></a><span>2024-03-03</span>
                            </div>
                          </li>
                          <li class="d-flex align-items-center">
                            <div class="flex-shrink-0"><img src="../assets/images/dashboard/user/06.png" alt=""></div>
                            <div class="flex-grow-1"><a href="private-chat.html">
                            <h5>Joshua Wood</h5></a><span>2024-03-05</span>
                            </div>
                          </li>
                          <li class="d-flex align-items-center">
                            <div class="flex-shrink-0"><img src="../assets/images/dashboard/user/07.png" alt=""></div>
                            <div class="flex-grow-1"><a href="private-chat.html">
                            <h5>Joshua Wood</h5></a><span>2024-03-07</span>
                            </div>
                          </li>
                          <li class="d-flex align-items-center">
                            <div class="flex-shrink-0"><img src="../assets/images/dashboard/user/08.png" alt=""></div>
                            <div class="flex-grow-1"><a href="private-chat.html">
                            <h5>Joshua Wood</h5></a><span>2024-03-10</span>
                             
                              <p class="members-box background-light-primary text-center b-light-primary font-primary"> Away</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="col-6"> 
                      <ul class="appointments-user">
                      <li class="d-flex align-items-center">
                            <div class="flex-shrink-0"></div>
                            <div class="flex-grow-1">
                            <h5>Details</h5>
                            </div>
                          </li>  
                      <li class="d-flex align-items-center">
                            <div class="flex-shrink-0"></div>
                            <div class="flex-grow-1"><a href="#">
                            <h5>200000</h5></a><span>Job-abhdtgdljdshpkjdsj</span>
                            </div>
                          </li>
                          <li class="d-flex align-items-center">
                            <div class="flex-shrink-0"></div>
                            <div class="flex-grow-1"><a href="#">
                            <h5>30000</h5></a><span>Job-amhsiuljdshpkjdsj</span>
                            </div>
                          </li>
                          <li class="d-flex align-items-center">
                            <div class="flex-shrink-0"></div>
                            <div class="flex-grow-1"><a href="#">
                            <h5>700000</h5></a><span>Job-abhdtgdmkdyu9jdsj</span>
                            </div>
                          </li>
                          <li class="d-flex align-items-center">
                            <div class="flex-shrink-0"></div>
                            <div class="flex-grow-1"><a href="#">
                            <h5>100000</h5></a><span>Job-abhnhdgstyalljdshpkjdsj</span>
                             
                              <p class="members-box background-light-primary text-center b-light-primary font-primary"> Away</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>             
              
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <script src="assets/js/chart/google/google-chart-loader.js?<?= time(); ?>"></script>
        <script src="assets/js/chart/google/google-chart.js?<?= time(); ?>"></script>
        <script src="assets/js/chart/apex-chart/apex-chart.js?=<?=time();?>"></script>
        <script src="assets/js/chart/apex-chart/stock-prices.js?=<?=time();?>"></script>
        <script src="assets/js/chart/apex-chart/moment.min.js?=<?=time();?>"></script>
        <script src="assets/js/dashboard/dashboard_2.js?=<?=time();?>"></script>