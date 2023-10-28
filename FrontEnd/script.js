/* -------------- addpatron.html page -------------- */

/* -------------- Phone Number Format - 10-digit in style XXX-XXX-XXXX -------------- */

// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
    // Get the phone number input element
    var phoneNumberInput = document.getElementById("phoneNumber");

    // Add an event listener for input changes
    phoneNumberInput.addEventListener("input", function () {
        // Remove non-numeric characters
        var value = this.value.replace(/\D/g, '');

        // Limit to 10 digits
        if (value.length > 10) {
            value = value.slice(0, 10);
        }

        // Format phone number with dashes
        if (value.length >= 3 && value.length <= 6) {
            value = value.slice(0, 3) + "-" + value.slice(3);
        } else if (value.length > 6) {
            value = value.slice(0, 3) + "-" + value.slice(3, 6) + "-" + value.slice(6);
        }

        // Update the input value with the formatted phone number
        this.value = value;
    });

    // Add an event listener for the Backspace key
    phoneNumberInput.addEventListener("keydown", function (e) {
        if (e.key === "Backspace") {
            // Allow backspace to delete digits
            var value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
            if (value.length >= 4) {
                value = value.slice(0, value.length - 1);
                this.value = value;
            } else {
                this.value = "";
            }
            e.preventDefault();
        }
    });
});


/* -------------- Zipcode Format - 5-digit -------------- */

document.addEventListener("DOMContentLoaded", function () {
    // Get the zipcode input element
    var zipcodeInput = document.getElementById("zipcode");

    // Add an event listener for input changes
    zipcodeInput.addEventListener("input", function () {
        // Remove non-numeric characters
        var value = this.value.replace(/\D/g, '');

        // Limit to 5 characters
        if (value.length > 5) {
            value = value.slice(0, 5);
        }

        // Update the input value with the formatted zipcode
        this.value = value;
    });
});


/* -------------- State Required Field - For United States Only -------------- */
document.addEventListener("DOMContentLoaded", function () {
    // Get the country and state input elements
    var countrySelect = document.getElementById("country");
    var stateInput = document.getElementById("state");

    // Add an event listener for the country select input
    countrySelect.addEventListener("change", function () {
        if (this.value === "United States") {
            // Enable state input if United States is selected
            stateInput.removeAttribute("disabled");
        } else {
            // Clear the state input and disable it for non-U.S. countries
            stateInput.value = "";
            stateInput.setAttribute("disabled", "disabled");
        }
    });
});




/* -------------- page -------------- */
/* -------------- page -------------- */
/* -------------- page -------------- */
/* -------------- page -------------- */
/* -------------- page -------------- */
