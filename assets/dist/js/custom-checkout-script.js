jQuery(document).ready(function ($) {
    /**
     * Hides all delivery details fields
     */
    function hideAllDeliveryFields() {
        $(".new-post-address").hide();
        $("#billing_postcode_field").hide();
    }
    // Show/hide field based on the selected delivery method
    $(document).on('change', checkout_params.delivery_method_selector, function (e) {
        hideAllDeliveryFields();
        switch ($(this).val()) {
            case "flat_rate:2":
                $(".new-post-address").show();
                break;
            case "flat_rate:3":
                $("#billing_postcode_field").show();
                break;
        }
    });

    $(checkout_params.delivery_method_selector + ":checked").change();
});