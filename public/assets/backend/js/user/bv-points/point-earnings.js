$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#earnings').DataTable({
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
            }
        },
        lengthMenu: [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "All"],],
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        //stateSave: true,
        ajax: location.href,
        order: [[4, 'desc']],
        columns: [
            {data: "from", searchable: false, orderable: false},
            {data: "package", searchable: false, orderable: false},
            {data: "left", searchable: false, orderable: false},
            {data: "right", searchable: false, orderable: false},
            {data: "date", name: "created_at", searchable: false},
        ],
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;"> ${date} </div>`;
                }, targets: 4,
            },
            {
                render: function (point, type, full, meta) {
                    return `<div style="min-width:100px"> ${point} </div>`;
                }, targets: [2, 3],
            }
        ]
    });

})
