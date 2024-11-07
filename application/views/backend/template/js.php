<!-- Has in Dashboard1 page -->
<script src="<?= base_url('assets/'); ?>plugins/jquery/jquery.min.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/jquery-ui/jquery-ui.min.js"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<script src="<?= base_url('assets/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/chart.js/Chart.min.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/sparklines/sparkline.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/jquery-knob/jquery.knob.min.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/moment/moment.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/daterangepicker/daterangepicker.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/summernote/summernote-bs4.min.js"></script>

<script src="<?= base_url('assets/'); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<script src="<?= base_url('assets/template/backend/'); ?>dist/js/adminlte.js?v=3.2.0"></script>

<!-- <script src="<?= base_url('assets/template/backend/'); ?>dist/js/demo.js"></script> -->

<script src="<?= base_url('assets/template/backend/'); ?>dist/js/pages/dashboard.js"></script>

<!-- SweetAlert2 -->
<script src="<?= base_url('assets/'); ?>plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- Has in Tables Page -->
<script src="<?= base_url('assets/'); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- <script src="<?= base_url('assets/template/backend/'); ?>dist/js/adminlte.min.js?v=3.2.0"></script> -->

<!-- Config Datatables -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "language": {
                "searchPlaceholder": 'Cari sesuatu disini...',
                "search": 'Pencarian',
                "buttons": {
                    "copy": 'Salin',
                    "excel": 'Excel',
                    "print": 'Cetak',
                    "colvis": 'Kolom',
                    "copySuccess": {
                        "1": "satu baris disalin ke papan klip",
                        "_": "%d baris disalin ke papan klip",
                    },
                    "copyTitle": "Salin ke Papan klip",
                },
                "info": 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                "zeroRecords": 'Tidak ditemukan data yang sesuai',
                "infoEmpty": 'Menampilkan 0 entri',
                "infoFiltered": '(disaring dari _MAX_ entri keseluruhan)',
                "paginate": {
                    "first": 'Pertama',
                    "last": 'Terakhir',
                    "next": 'Selanjutnya',
                    "previous": 'Sebelumnya',
                },
            }
            // "language": {
            //     "url": '//cdn.datatables.net/plug-ins/2.0.7/i18n/id.json',
            // },
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#example2').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv"],
            "language": {
                "searchPlaceholder": 'Cari sesuatu disini...',
                "search": 'Pencarian',
                "buttons": {
                    "copy": 'Salin',
                    "excel": 'Excel',
                    "print": 'Cetak',
                    "colvis": 'Kolom',
                    "copySuccess": {
                        "1": "satu baris disalin ke papan klip",
                        "_": "%d baris disalin ke papan klip",
                    },
                    "copyTitle": "Salin ke Papan klip",
                },
                "info": 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                "zeroRecords": 'Tidak ditemukan data yang sesuai',
                "infoEmpty": 'Menampilkan 0 entri',
                "infoFiltered": '(disaring dari _MAX_ entri keseluruhan)',
                "paginate": {
                    "first": 'Pertama',
                    "last": 'Terakhir',
                    "next": 'Selanjutnya',
                    "previous": 'Sebelumnya',
                },
            }
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    });
</script>