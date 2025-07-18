$(function () {

    try {
        document.getElementById('approveTrx').addEventListener('click', approve)
    } catch (e) {

    }

    function approve(e) {
        e.preventDefault();
        Swal.fire({
            title: "Are You Sure?",
            text: "Approve The transaction?. Please note this process cannot be reversed.",
            icon: "info",
            showCancelButton: true,
        }).then((approve) => {
            if (approve.isConfirmed) {
                loader()
                const _FORM = $('#approval-form')
                _FORM.find(".text-danger").remove();
                let formData = new FormData(_FORM[0]);
                // formData.append(proof_document, proof_document)
                axios.post(location.href, formData)
                    .then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                            if (response.data.status) {
                                response.data.redirectUrl ? location.href = response.data.redirectUrl : location.reload();
                            }
                        })
                    })
                    .catch((error) => {
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })

                    })
            }
        });
    }

})
