$(function () {

    try {
        document.getElementById('approveWithdraw').addEventListener('click', createWithdraw)
    } catch (e) {

    }

    function createWithdraw(e) {
        e.preventDefault();
        let proof_document = $('#proof_document').val();
        if (proof_document === null || proof_document.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please provide the proof that was paid for this withdraw request!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Confirm The payout?. Please note this process cannot be reversed.",
                icon: "info",
                showCancelButton: true,
            }).then((issue) => {
                if (issue.isConfirmed) {
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
                            console.error(error.response.data)
                            let errorMap = [];
                            document.querySelectorAll('input[data-input=payout]').forEach(input => {
                                errorMap.push(input.id)
                            })
                            errorMap.map(id => {
                                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
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
