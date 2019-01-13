
jQuery('#omnictrl-select-all').on('click', function(event) {
    event.preventDefault();
    jQuery('.omnictrl-checkbox').prop('checked', true);
});

jQuery('#omnictrl-unselect-all').on('click', function(event) {
    event.preventDefault();
    jQuery('.omnictrl-checkbox').prop('checked', false);
});
