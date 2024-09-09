<!-- jQuery -->
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>

<!-- jQuery UI (Optional, if you need it) -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<!-- Chart.js (Only if needed) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Other Plugins (Load only if needed) -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- AdminLTE (If using AdminLTE template) -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<!-- DataTables Initialization -->
<script>
    $(document).ready(function() {
        $('#RegTable').DataTable();
        $('#example2').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
        });
        
        // Initialize Select2 Elements
        $('.select2').select2();
    });
</script>

