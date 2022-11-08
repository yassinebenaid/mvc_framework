export class FormProccessor {

    getErrors(uri, form) {
        return new Promise((success, reject) => {
            let url = `${window.location.protocol}//${window.location.host}/${uri}`
            let xhr = new XMLHttpRequest
            xhr.open("POST", url, true)
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    if (xhr.response !== "success") {
                        success(JSON.parse(xhr.response));
                    } else {
                        reject()
                    }
                }
            }

            let data = new FormData(form)
            xhr.send(data);
        });
    }

    proccessForm(form, url) {
        form?.addEventListener("submit", (e) => {
            e.preventDefault();
            let errorFeedback = document.createElement('div')
            errorFeedback.setAttribute("class", "error-feedback")

            form.querySelectorAll(".error-feedback").forEach(el => el.remove())

            this.getErrors(url, form).then((data) => {
                form.querySelectorAll("input").forEach(input => {
                    if (data[input.name]) {
                        input.classList.add('is-invalid')
                        errorFeedback.textContent = data[input.name][0] || "";
                        input.after(errorFeedback.cloneNode(true))
                    } else {
                        input.classList.remove('is-invalid')
                    }
                })
            }).catch(() => window.location.href = "/")
        })
    }
}