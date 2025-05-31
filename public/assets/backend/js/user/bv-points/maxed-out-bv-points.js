$(document).ready(function() {
    // Initialize DataTable with export buttons
    $('#maxed-out-bv-points-table').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "paging": false,
        "info": false,
        "searching": true,
        "order": [[0, "desc"]]
    });
});