	<!--**********************************
        Scripts
    ***********************************-->
	<!-- Required vendors -->
	<script src="assets2/vendor/global/global.min.js"></script>
	<script src="assets2/vendor/chart-js/chart.bundle.min.js"></script>
	<script src="assets2/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="assets2/vendor/apexchart/apexchart.js"></script>

	<!-- Dashboard 1 -->
	<script src="assets2/js/dashboard/dashboard-1.js"></script>
	<script src="assets2/vendor/draggable/draggable.js"></script>
	<script src="assets2/vendor/swiper/js/swiper-bundle.min.js"></script>

	<script src="assets2/vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="assets2/vendor/datatables/js/dataTables.buttons.min.js"></script>
	<script src="assets2/vendor/datatables/js/buttons.html5.min.js"></script>
	<script src="assets2/vendor/datatables/js/jszip.min.js"></script>
	<script src="assets2/js/plugins-init/datatables.init.js"></script>
<!-- Popper js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  


	<!-- Apex Chart -->

	<script src="assets2/vendor/bootstrap-datetimepicker/js/moment.js"></script>
	<script src="assets2/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- Tagify js -->
<!-- <script src="assets2/js/tagify.js"></script>
<script src="assets2/js/tagify.polyfills.min.js"></script> -->
	<!-- Vectormap -->
	<script src="assets2/vendor/jqvmap/js/jquery.vmap.min.js"></script>
	<script src="assets2/vendor/jqvmap/js/jquery.vmap.world.js"></script>
	<script src="assets2/vendor/jqvmap/js/jquery.vmap.usa.js"></script>

	<script src="assets2/vendor/select2/js/select2.full.min.js"></script>
    <script src="assets2/js/plugins-init/select2-init.js"></script>
	<script src="assets2/js/custom.min.js"></script>
	<script src="assets2/js/deznav-init.js"></script>
	<script src="assets2/js/demo.js"></script>
	<script src="assets2/js/styleSwitcher.js"></script>
	<script src="assets/js/tagify.js"></script>
    <script src="assets/js/tagify.polyfills.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js?<?= time() ; ?>"></script>

	<!-- calender js -->
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

	<script>
		jQuery(document).ready(function () {
			setTimeout(function () {
				dzSettingsOptions.version = 'light';
				new dzSettings(dzSettingsOptions);

				setCookie('version', 'light');
			}, 1500)
		});
	</script>