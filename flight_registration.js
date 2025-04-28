$(document).ready(function() {
    // Initially disable the arrival city dropdown
    $("#arrivalCity").prop("disabled", true);

    // Enable arrival city dropdown and filter options based on selected departure city
    $("#departureCity").change(function() {
        var selectedDepartureCity = $(this).val();
        $("#arrivalCity").prop("disabled", false);

        // Enable all options in arrival city dropdown
        $("#arrivalCity option").prop("disabled", false);

        // Disable the option with the same value as the selected departure city
        $("#arrivalCity option[value='" + selectedDepartureCity + "']").prop("disabled", true);

        // Reset the arrival city selection if it was the same as the new departure city
        if ($("#arrivalCity").val() === selectedDepartureCity) {
            $("#arrivalCity").val("");
        }
    });

    // Add a visual cue when the terms and conditions are checked
    $("#termsAndConditions").change(function() {
        if (this.checked) {
            $(this).closest(".form-check").addClass("terms-agreed");
        } else {
            $(this).closest(".form-check").removeClass("terms-agreed");
        }
    });

    // Basic submit event handling
    $("form").submit(function(event) {
        event.preventDefault();

        var passengerName = $("#passengerName").val();
        var departureCity = $("#departureCity").val();
        var arrivalCity = $("#arrivalCity").val();
        var termsAgreed = $("#termsAndConditions").prop("checked");

        if (passengerName && departureCity && arrivalCity && termsAgreed) {
            alert("Registration submitted!\nName: " + passengerName + "\nFrom: " + departureCity + "\nTo: " + arrivalCity);
            // In a real application, you would send this data to a server using AJAX
        } else {
            alert("Please fill in all required fields and agree to the terms.");
        }
    });
});