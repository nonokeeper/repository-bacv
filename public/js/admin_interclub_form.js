$(document).ready(function() {
    var $teamhomeSelect = $('.js-interclub-form-teamhome');
    var $locationTarget = $('.js-specific-teamhome-target');

    $teamhomeSelect.on('change', function(e) {
        $.ajax({
            url: $teamhomeSelect.data('specific-teamhome-url'),
            data: {
                teamhome: $teamhomeSelect.val()
            },
            success: function (html) {
                if (!html) {
                    $locationTarget.find('select').remove();
                    $locationTarget.addClass('d-none');
                    return;
                }
                // Replace the current field and show
                $locationTarget
                    .html(html)
                    .removeClass('d-none');
            }
        });
    });
});