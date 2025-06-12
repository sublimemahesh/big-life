$(document).ready(function() {
    // Initialize flatpickr for date range picker
    flatpickr("#maxed-out-date-range", {
        mode: "range",
        dateFormat: "Y-m-d",
    });

    // Initialize DataTable with export buttons
    var table = $('#maxed-out-bv-points-table').DataTable({
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

    // Filter button click event
    $('#filter-button').on('click', function() {
        var userId = $('#user_id').val();
        var dateRange = $('#maxed-out-date-range').val();
        
        // Construct URL with query parameters
        var url = window.location.pathname + '?';
        if (userId) {
            url += 'user_id=' + userId + '&';
        }
        if (dateRange) {
            url += 'date_range=' + dateRange;
        }
        
        // Redirect to the filtered URL
        window.location.href = url;
    });
});