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
        order: [[5, 'desc']],
        columns: [
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "from", searchable: false, orderable: false},
            {data: "package", searchable: false, orderable: false},
            {data: "left", searchable: false, orderable: false},
            {data: "right", searchable: false, orderable: false},
            {data: "date", name: "created_at", searchable: false},
        ],
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;" class="text-right"> ${date} </div>`;
                }, targets: 5,
            },
            {
                render: function (point, type, full, meta) {
                    return `<div style="min-width:100px" class="text-right"> ${point} </div>`;
                }, targets: [4, 3],
            }
        ]
    });

    flatpickr("#rewards-date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#rewards-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#rewards-date-range").val());
        // urlParams.set("status", $("#rewards-status").val());
        urlParams.set("user_id", $("#user_id").val());
        // urlParams.set("type", $("#type").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });
})
