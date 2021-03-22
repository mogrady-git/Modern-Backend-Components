const form = document.querySelector(".signup form"),
    continueBtn = form.querySelector(".button input"),
    errorText = form.querySelector(".error-text");

form.onsubmit = (e) => {
    e.preventDefault(); // prevent the form from submitting
}

continueBtn.onclick = () => { // AJAX Request
    let xhr = new XMLHttpRequest(); // XML Object Created
    xhr.open("POST", "php/signup.php", true); // Pass in required file and post method
    xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.response;
                    if (data === "success") {
                        location.href = "users.php";
                    } else {
                        errorText.style.display = "block";
                        errorText.textContent = data;
                    }
                }
            }
        }
        // send form data through ajax to php
    let formData = new FormData(form);
    xhr.send(formData); // send the form data
}