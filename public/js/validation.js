$(".formValidation").submit(function (event) {
    event.preventDefault();
    console.log(event);
    let isValid = true;
    // Validate inputs, selects, etc.
    $(this)
        .find("input, select, .emailVal, textarea")
        .each(function () {
            if ($(this).hasClass("noVal")) {
                $(this).removeClass("is-invalid");
                return;
            }

            // File validation
            if ($(this).is(":file")) {
                if (!this.files.length) {
                    $(this).addClass("is-invalid");
                    isValid = false;
                } else {
                    $(this).removeClass("is-invalid");
                }

                // Email validation
            } else if ($(this).is(".emailVal")) {
                let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test($(this).val().trim())) {
                    $(this).addClass("is-invalid");
                    isValid = false;
                } else {
                    $(this).removeClass("is-invalid");
                }

                // Select validation
            } else if ($(this).is("select")) {
                if ($(this).val().trim() === "") {
                    $(this).addClass("is-invalid");
                    isValid = false;
                } else {
                    $(this).removeClass("is-invalid");
                }

                // Checkbox validation
            } else if ($(this).is(":checkbox")) {
                if (!$(this).is(":checked")) {
                    $(this).addClass("is-invalid");
                    isValid = false;
                } else {
                    $(this).removeClass("is-invalid");
                }

                // CommaVal input validation
            } else if ($(this).is(".commaVal")) {
                if ($(this).val().trim() === "") {
                    $(this).addClass("is-invalid");
                    isValid = false;
                } else {
                    $(this).removeClass("is-invalid");
                }

                // Default input validation
            } else {
                if ($(this).val().trim() === "") {
                    $(this).addClass("is-invalid");
                    isValid = false;
                } else {
                    $(this).removeClass("is-invalid");
                }
            }
        });

    // Get the captcha token
    var captchaToken = $(".captcha_token").val();
    console.log(captchaToken, "asdasdasd");
    // Validate CAPTCHA
    if (!captchaToken) {
        $("#error_message").html("Please check the captcha").show();
        return;
    }

    // Submit form if valid and CAPTCHA exists
    if (isValid && captchaToken) {
        this.submit();
    }
});

function javascriptCallback(token) {
    console.log("Turnstile token:", token); // This will log the token for debugging
    $(".captcha_token").val(token); // Set the token in the hidden input field
}
window.onloadTurnstileCallback = function () {
    turnstile.render(".cf-turnstile", {
        sitekey: "0x4AAAAAACaQ4pOb2N21MgVw",
        callback: javascriptCallback,
    });
};
$(document).on("shown.bs.modal", function (e) {
    let $modal = $(e.target); // Get the current modal that was opened
    let $captchaContainer = $modal.find(".cf-turnstile"); // Find the CAPTCHA container

    if ($captchaContainer.length && !$captchaContainer.data("rendered")) {
        turnstile.render($captchaContainer[0], {
            sitekey: "0x4AAAAAACaQ4pOb2N21MgVw",
            callback: function (token) {
                console.log("Turnstile token (modal):", token);
                $("#captcha_token_modal").val(token); // Set the token value in the hidden input
            },
        });
        $captchaContainer.data("rendered", true); // Mark it as rendered
    }
});

// If the user enters input, remove is-invalid class
$(".formValidation")
    .find("input, select, textarea, .emailVal")
    .on("input change", function () {
        if ($(this).val().trim() !== "" || $(this).is(":checkbox:checked")) {
            $(this).removeClass("is-invalid");
        }
    });

// Phone validation to remove unnecessary characters
$(".formValidation .phoneVal").keydown(function (event) {
    const keyPressed = event.key;
    if (
        keyPressed === "+" ||
        keyPressed === "-" ||
        keyPressed === "e" ||
        keyPressed === "."
    ) {
        event.preventDefault();
    }
});

// Comma validation for inputs with .commaVal class
$(".formValidation .commaVal").keydown(function (event) {
    const keyPressed = event.key;
    // Allow digits (0-9), comma (,), backspace, tab, and arrow keys
    if (
        !(
            /[0-9,]/.test(keyPressed) ||
            keyPressed === "Backspace" ||
            keyPressed === "Tab" ||
            keyPressed.startsWith("Arrow")
        )
    ) {
        event.preventDefault(); // Prevent the default action if the key is not allowed
    }
});
