
 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Manage Routing</h4>
                    <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#create_route_plan_modal"><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i> Add Routing</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="routing_plan_tbl">
                        <thead style="background-color:#f4f7f9;"> 
                          <tr>
                            <th>Plan name</th>
                            <th>Route</th>
                            <th>Gateway</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <!--<th>Call Barred</th>-->
                            <!--<th>Call Barred</th>-->
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="route_plan" id="route_plan">
                          <tr>
                            <td>1</td>
                            <td>Default</td>
                            <td>Active</td>
                            <td>2024-02-08 22:59:00</td>
                            <td>Active</td>
                            <!--<td>2024-02-08 22:59:00</td>-->
                            <!--<td>10000</td>-->
                            <td> 
                              <ul class="action"> 
                               
                                <li class="view"><a href="#"><i class="icon-envelope"></i></a></li>
                              </ul>
                            </td>
                          </tr>
                          
                          <tr>
                            <td>2</td>
                            <td>Default</td>
                            <td>Active</td>
                            <td>2024-02-08 22:59:00</td>
                            <td>Active</td>
                            <!--<td>2024-02-08 22:59:00</td>-->
                            <!--<td>10000</td>-->
                            <td> 
                              <ul class="action"> 
                               
                                <li class="view"><a href="#"><i class="icon-envelope"></i></a></li>
                              </ul>
                            </td>
                          </tr>
                          
                          <tr>
                            <td>3</td>
                            <td>Default</td>
                            <td>Active</td>
                            <td>2024-02-08 22:59:00</td>
                            <td>Active</td>
                            <!--<td>2024-02-08 22:59:00</td>-->
                            <!--<td>10000</td>-->
                            <td> 
                              <ul class="action"> 
                               
                                <li class="view"><a href="#"><i class="icon-envelope"></i></a></li>
                              </ul>
                            </td>
                          </tr>
                          <tr>
                            <td>4</td>
                            <td>Default</td>
                            <td>Active</td>
                            <td>2024-02-08 22:59:00</td>
                            <td>Active</td>
                            <!--<td>2024-02-08 22:59:00</td>-->
                            <!--<td>10000</td>-->
                            <td> 
                              <ul class="action"> 
                               
                                <li class="view"><a href="#"><i class="icon-envelope"></i></a></li>
                              </ul>
                            </td>
                          </tr>
                          
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
    <?php include_once('include/modal_forms/manage_gateway_modal.php'); ?>
    <script src="assets/js/route.js?=<?=time();?>"></script>
    <!-- <script src="assets/js/jquery.multiselect.js?=<?=time();?>"></script> -->