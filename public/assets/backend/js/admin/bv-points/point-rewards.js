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
        order: [[3, 'desc']],
        columns: [
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "points", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "date", name: "created_at", searchable: false},
            {data: "amount", searchable: false, orderable: false},
            {data: "paid", searchable: false, orderable: false},
            {data: "lost", searchable: false, orderable: false},
        ],
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div> ${date} </div>`;
                }, targets: 3,
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="min-width:100px" class="text-right"> ${amount} </div>`;
                }, targets: [4, 5, 6],
            }
        ]
    });

    flatpickr("#rewards-date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#rewards-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#rewards-date-range").val());
        urlParams.set("status", $("#rewards-status").val());
        urlParams.set("user_id", $("#user_id").val());
        // urlParams.set("type", $("#type").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });
})
