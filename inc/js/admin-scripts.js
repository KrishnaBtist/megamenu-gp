jQuery(document).ready(function($) {
    $(document).on('change', '.field-mega-menu select', function() {
        var value = $(this).val();
        var menuId = $(this).attr('id').replace('edit-menu-item-mega-menu-', '');
        $('#menu-item-mega-menu-' + menuId).val(value);
    });
    $('.imc_gp_logo_button').on('click', function(e) {
        e.preventDefault();
        var frame = wp.media({
            title: 'Upload or Select Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            console.log(attachment.id);
            $('#imc_gp_logo').val(attachment.id);
            $('.imc-gp-image-preview').html('<img src="' + attachment.url + '" alt="Tag Image" width="200">');
            $('.imc-gp-filename').text(attachment.filename);
        });
        frame.open();
    });
    $('.remove-imc-gp-image').on('click', function(e) {
        e.preventDefault();
        $('#imc_gp_logo').val('');
        $('.imc-gp-image-preview').html('');
        $('.imc-gp-filename').text('');
    });
});
