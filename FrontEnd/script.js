


/* -----------------------Add Page Name----------------------- */

/* ---------------------- index.html  ----------------------- */
// Function to fetch and display PatronAccount table data
// All pages using PatronAccount table
function fetchTableData() {
    $.ajax({
        url: 'fetch_patron_data.php',
        type: 'GET',
        dataType: 'html',
        success: function(data) {
            $('#tableData').html(data); // Display PatronAccount table data
        },
        error: function() {
            console.error('Failed to fetch PatronAccount data.');
        }
    });
}
// Add click event handler for delete buttons using event delegation
$(document).on("click", ".delete-button", function() {
    var $button = $(this); // Store the reference to $(this)

    var itemIdToDelete = $button.attr("data-id");
    console.log("Deleting item with ID:", itemIdToDelete);

    // Perform AJAX request to delete the item with itemIdToDelete
    $.ajax({
        url: 'delete_item.php',
        type: 'POST',
        data: { itemId: itemIdToDelete },
        success: function () {
            console.log("Item deleted successfully.");
            // Remove the corresponding row from the table
            $button.closest("tr").remove();
        },
        error: function (xhr, status, error) {
            console.error('Failed to delete item with ID:', itemIdToDelete, 'Status:', status, 'Error:', error);
        }
    });
});




// * Patron Form Submission *
// Wait for the document to be fully loaded
$(document).ready(function() {

    // Fetch and display PatronAccount table data when the page loads
    // Page: All pages using PatronAccount table
    fetchTableData();

    // Handle form submission using AJAX
    $('#patronForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Validate the "identityConfirmed" field
        var identityConfirmed = $('#identityConfirmed').val();
        if (identityConfirmed !== "yes") {
            alert('Please confirm identity with "Yes" to submit the form.');
            return;
        }

        // Continue with form submission
        $.ajax({
            url: 'process_patron_form.php',
            type: 'POST',
            data: $('#patronForm').serialize(), // Serialize the form data
            success: function() {
                fetchTableData(); // Update the displayed PatronAccount table data
                $('#patronForm')[0].reset(); // Clear the form fields
            },
            error: function() {
                console.error('Failed to add a patron.');
            }
        });
    });
});

/* -------------- Phone Number Input Formatting -------------- */

// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
    // Get the phone number input element
    var phoneNumberInput = document.getElementById("phoneNumber");

    // Add an event listener for input changes
    phoneNumberInput.addEventListener("input", function () {
        // Remove non-numeric characters
        // Page: All pages with a phone number input
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

// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
    // Get the zipcode input element
    // Page: All pages with a zipcode input
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

// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
    // Get the country and state input elements
    // Page: All pages with country and state inputs
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












/* ----------------------- catalog.html ----------------------- */
$(document).ready(function() {
    // Page: catalog.html
    // Add an event listener to the "Add Item" button
    $("#addItemBtn").click(function() {
        var addItemForm = $("#addItemFormContainer");
        addItemForm.css("display", "block");
    });

    // Add an event listener to the "Close" button
    $("#closeFormBtn").click(function() {
        var addItemForm = $("#addItemFormContainer");
        addItemForm.css("display", "none");
    });

    // Generate Label Button Click Event
    $("#generateLabelBtn").click(function() {
        // Get the form input values
        var title = $("#title").val();
        var author = $("#author").val();
        var year = $("#year").val();
        var locCode = $("#locCode").val();
        var shelfCode = $("#shelfCode").val();
        var cost = $("#cost").val();
        var itemType = $("#itemType").val();
        var branch = $("#branch").val();

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







// Function to fetch and display Inventory table data
    function fetchInventoryTableData() {
        $.ajax({
            url: 'inventory.php',
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                $('#inventoryTable tbody').html(data);
            },
            error: function () {
                console.error('Failed to fetch Inventory table data.');
            }
        });
    }

// Function to fetch and display inventory data
    function loadInventoryData() {
        $.ajax({
            type: "GET",
            url: "inventory.php",
            dataType: "json",
            success: function (data) {
                displayInventoryData(data);
            },
            error: function (error) {
                console.log("Error fetching inventory data: " + error);
            }
        });
    }

// Function to display inventory data in the table
    function displayInventoryData(data) {
        var tableBody = $("#inventoryTableBody");
        tableBody.empty();

        $.each(data, function(index, item) {
            var row = $("<tr>");
            row.append($("<td>").text(item.itemID));
            row.append($("<td>").text(item.title));
            row.append($("<td>").text(item.author));
            row.append($("<td>").text(item.year));
            row.append($("<td>").text(item.libraryOfCongressCode));
            row.append($("<td>").text(item.shelfLocationCode));
            row.append($("<td>").text(item.cost));
            row.append($("<td>").text(item.lateFee));
            row.append($("<td>").text(item.itemType));
            row.append($("<td>").text(item.duration));
            row.append($("<td>").text(item.branch));
            row.append($("<td>").text(item.inStock));

            // Add delete button to the action column
            var deleteButton = $("<button>").addClass("delete-button").attr("data-id", item.itemID).text("Delete");
            var actionColumn = $("<td>").append(deleteButton);
            row.append(actionColumn);

            tableBody.append(row);
        });

        // Add click event handler for delete buttons
        $(".delete-button").click(function() {
            var itemIdToDelete = $(this).attr("data-id");
            // Perform AJAX request to delete the item with itemIdToDelete
            // Assuming you have an endpoint like 'delete_item.php'
            $.ajax({
                url: 'delete_item.php',
                type: 'POST',
                data: { itemId: itemIdToDelete },
                success: function() {
                    // Remove the corresponding row from the table
                    $(this).closest("tr").remove();
                },
                error: function() {
                    console.error('Failed to delete item with ID: ' + itemIdToDelete);
                }
            });
        });
    }


// Fetch and display inventory data on page load
    $(document).ready(function () {
        fetchInventoryTableData();
        setInterval(fetchInventoryTableData, 5000); // Refresh table data every 5 seconds (adjust as needed)

        // Handle form submission using AJAX
        $('#addSubmitBtn').click(function (event) {
            event.preventDefault(); // Prevent the default form submission

            // Continue with form submission
            $.ajax({
                url: 'inventory.php',
                type: 'POST',
                data: $('#addItemFormContainer form').serialize(),
                success: function () {
                    loadInventoryData(); // Update the displayed inventory data
                    fetchInventoryTableData(); // Update the displayed inventory table data
                    $('#addItemFormContainer').css("display", "none");
                    $('#addItemFormContainer form')[0].reset();
                },
                error: function () {
                    console.error('Failed to add an item.');
                }
            });
        });
    });





    /* ----------------------- checkout.html ----------------------- */
    // Function to populate patron dropdown
    function populatePatronDropdown(dropdown, data, defaultText) {
        dropdown.empty();
        dropdown.append($('<option>', {
            value: '',
            text: defaultText,
            disabled: true,
            selected: true
        }));

        $.each(data, function (index, value) {
            dropdown.append($('<option>', {
                value: value.patronID,
                text: `${value.patronID} - ${value.firstName} ${value.lastName}`
            }));
        });
    }

    // Function to populate item dropdown
    function populateItemDropdown(dropdown, data, defaultText) {
        dropdown.empty();
        dropdown.append($('<option>', {
            value: '',
            text: defaultText,
            disabled: true,
            selected: true
        }));

        $.each(data, function (index, value) {
            dropdown.append($('<option>', {
                value: value.itemID,
                text: `${value.itemID} - ${value.title} - ${value.author} - ${value.itemType}`
            }));
        });
    }


    // Fetch and populate dropdowns
    $.ajax({
        url: 'checkout.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log('Data received:', data);
            var patronDropdown = $('#patronID');
            var itemDropdown = $('#itemID');

            // Populate patron dropdown
            populatePatronDropdown(patronDropdown, data.patronData, 'Select Patron');

            // Populate item dropdown
            populateItemDropdown(itemDropdown, data.itemData, 'Select Item');
        },
        error: function (xhr, status, error) {
            console.error('Failed to fetch data. Status:', status, 'Error:', error);
        }
    });
});



/* -----------------------Add Page Name----------------------- */
/* -----------------------Add Page Name----------------------- */
/* -----------------------Add Page Name----------------------- */
/* -----------------------Add Page Name----------------------- */
