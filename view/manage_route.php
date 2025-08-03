
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Manage Route</h4>
                    <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#add_route"><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i> Create Route</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="manage_route_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                            <th>Sr No</th>
                            <th>Route Name</th>
                            <th>Start time</th>
                            <th>End time</th>
                            <th>Balancer</th>
                            <th>Sender</th>
                            <th>DND Check</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="route_list" id="route_list">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>

        <!-- footer start-->
       <?php include('../include/footer.php'); ?>
       <script>
    document.addEventListener("DOMContentLoaded", function() {
     flatpickr(".datetimepicker", {
       minDate: <?php echo "'".$minDate."'"; ?>, // Set your minimum date here
       // Set your maximum date here
        noCalendar: true,
        enableTime: true,
            dateFormat: "h:i K",
            time_24hr: false,
     });
   });
</script>

       <?php include_once('include/modal_forms/manage_gateway_modal.php'); ?>

      <?php include('include/datatable_js.php');?>
      <script src="assets/js/route.js?=<?=time();?>"></script>
      <script src="assets/js/jquery.multiselect.js"></script>
