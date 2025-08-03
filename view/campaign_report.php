 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Campaign Report</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="basic-1">
                        <thead>
                          <tr>
                            <th>Campaign Name</th>
                            <th>Total</th>
                            <th>Submitted</th>
                            <th>Delivered</th>
                            <th>Failed</th>
                            <th>DND</th>
                            <th>Call Barred</th>
                            <!--<th>Action</th>-->
                          </tr>
                        </thead>
                        <tbody id="today_summary_list">                   
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
        <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>
        <script type="text/javascript" src="assets/js/campaign_report.js?=<?=time();?>"></script>
  </body>
</html>