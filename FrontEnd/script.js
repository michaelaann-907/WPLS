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




/* -------------- catalog.html -------------- */
document.addEventListener("DOMContentLoaded", function() {
    // Add an event listener to the "Add Item" button
    document.getElementById("addItemBtn").addEventListener("click", function() {
        var addItemForm = document.getElementById("addItemFormContainer");
        addItemForm.style.display = "block";
    });

    // Add an event listener to the "Close" button
    document.getElementById("closeFormBtn").addEventListener("click", function() {
        var addItemForm = document.getElementById("addItemFormContainer");
        addItemForm.style.display = "none";
    });

    // Generate Label Button Click Event
    document.getElementById("generateLabelBtn").addEventListener("click", function() {
        // Get the form input values
        var title = document.getElementById("title").value;
        var author = document.getElementById("author").value;
        var year = document.getElementById("year").value;
        var locCode = document.getElementById("locCode").value;
        var shelfCode = document.getElementById("shelfCode").value;
        var cost = document.getElementById("cost").value;
        var itemType = document.getElementById("itemType").value;
        var branch = document.getElementById("branch").value;

        // Generate the label content
        var labelContent = `
            <h3>Library Label</h3>
            <p><strong>Title:</strong> ${title}</p>
            <p><strong>Author:</strong> ${author}</p>
            <p><strong>Year:</strong> ${year}</p>
            <p><strong>Library of Congress Code:</strong> ${locCode}</p>
            <p><strong>Shelf Location Code:</strong> ${shelfCode}</p>
            <p><strong>Cost:</strong> ${cost}</p>
            <p><strong>Item Type:</strong> ${itemType}</p>
            <p><strong>Branch:</strong> ${branch}</p>
        `;

        // Create a new popup window for the label
        var labelPopup = window.open("", "Label Popup", "width=600, height=400");

        // Populate the popup window with the label content
        labelPopup.document.open();
        labelPopup.document.write(`
            <html>
            <head>
                <title>Library Label</title>
            </head>
            <body>
                <button id="printLabelBtn">Print</button>
                <button id="exitLabelBtn">Exit</button>
                ${labelContent}
            </body>
            </html>
        `);
        labelPopup.document.close();

        // Print Label Button Click Event in the popup
        labelPopup.document.getElementById("printLabelBtn").addEventListener("click", function() {
            labelPopup.print(); // Print the label in the popup window
        });

        // Exit Label Button Click Event in the popup
        labelPopup.document.getElementById("exitLabelBtn").addEventListener("click", function() {
            labelPopup.close(); // Close the popup window
        });
    });
});




// JavaScript for catalog.html
document.addEventListener("DOMContentLoaded", function () {
    const addItemBtn = document.getElementById("addItemBtn");
    const addItemFormContainer = document.getElementById("addItemFormContainer");

    // Add Item Button Click Event
    addItemBtn.addEventListener("click", toggleAddItemForm);

});






/* -------------- checkout.html -------------- */
// Function to print the receipt and close the popup
document.getElementById("printReceipt").addEventListener("click", function () {
    var bookID = document.getElementById("bookID").value;
    var patronName = document.getElementById("patronName").value;
    var patronID = document.getElementById("patronID").value;
    var dueDate = document.getElementById("dueDate").value;

    // Create a receipt content
    var receiptContent = "Book ID: " + bookID + "\n";
    receiptContent += "Patron Name: " + patronName + "\n";
    receiptContent += "Patron ID: " + patronID + "\n";
    receiptContent += "Due Date: " + dueDate + "\n";

    // Create a new window for printing
    var printWindow = window.open('', '', 'width=600,height=600');
    printWindow.document.open();
    printWindow.document.write('<html><body><pre>' + receiptContent + '</pre></body></html>');
    printWindow.document.close();

    // Print and close the window
    printWindow.print();
    printWindow.close();
});
/* -------------- page -------------- */
/* -------------- page -------------- */
/* -------------- page -------------- */
