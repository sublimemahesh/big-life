$(function () {

    try {
        document.getElementById('reject-kyc').addEventListener('click', rejectKyc)
    } catch (e) {

    }

    function rejectKyc(e) {
        e.preventDefault();
        let repudiate_note = $('#repudiate_note').val();
        let document = $('#document').val();
        let kyc = $('#kyc').val();
        if (repudiate_note === null || repudiate_note.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please provide the reject reason!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Reject Kyc Document??. Please note this process cannot be reversed.",
                icon: "info",
                showCancelButton: true,
            }).then((reject) => {
                if (reject.isConfirmed) {
                    loader()
                    const _FORM = $('#reject-kyc-form')
                    _FORM.find(".text-danger").remove();
                    let formData = new FormData(_FORM[0]);
                    // formData.append(proof_document, proof_document)
                    axios.post(`${APP_URL}/admin/users/kyc-documents/${document}/status`, {
                        status: 'reject',
                       repudiate_note
                    }).then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                            if (response.data.status) {
                                location.href = APP_URL + '/admin/users/kycs/' + kyc;
                            }
                        })
                    }).catch((error) => {
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                        console.error(error.response.data)
                        let errorMap = [];
                        document.querySelectorAll('input[data-input=payout]').forEach(input => {
                            errorMap.push(input.id)
                        })
                        errorMap.map(id => {
                            error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
                        })
                    })
                }
            });
        }

        function appendError(id, html) {
            try {
                let el = $(document.getElementById(id));
                $(el).next(".text-danger").remove();
                $(html).insertAfter(el)
            } catch (e) {

            }
        }

    }

})
