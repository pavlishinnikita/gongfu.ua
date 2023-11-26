jQuery(document).ready(function ($) {
    // Hide custom field on page load
    $(checkout_params.custom_field_selector).hide();

    // Show/hide custom field based on the selected delivery method
    $(document).on('change', checkout_params.delivery_method_selector, function (e) {
        if ($(this).val() == checkout_params.trigger_value) {
            $(checkout_params.custom_field_selector).show();
        } else {
            $(checkout_params.custom_field_selector).hide();
        }
    });

    $(checkout_params.delivery_method_selector + ":checked").change();
});