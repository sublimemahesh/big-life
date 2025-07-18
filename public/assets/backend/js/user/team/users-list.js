$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#team-users').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        //fixedHeader: true,
        responsive: true,
        order: [[4, 'asc']],
        //stateSave: true,
        ajax: location.href,
        columns: [
            //{data: "profile_photo", name: 'id', searchable: true, orderable: false},
            {data: "user_details", name: 'username', searchable: true, orderable: false},
            {data: "contact_details", name: 'email', searchable: true, orderable: false},
            {data: "sponsor", name: 'super_parent_id', searchable: false, orderable: false},
            {data: "parent", name: 'parent_id', searchable: false, orderable: false},
            {data: "joined", name: 'created_at', searchable: false},
            {data: "suspended", name: 'suspended_at', searchable: false},
        ],
        columnDefs: [

            {
                render: function (data, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;"> ${data} </div>`;
                },
                targets: [0, 1, 2, 3, 4, 5],
            }
        ],
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });


})
