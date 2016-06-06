$('#login-form').submit(function($e) {
    $e.preventDefault();
    var formData = $(this).serialize();
    $.post('/resources/library/login.php', formData, function(result) {
        if (result.success) {
            if (result.accessLevel == 'admin') {
                window.location.replace('admin.php');
            } else {
                window.location.replace('/');
            }
        } else {
            $('.login-error').fadeOut().text(result.message).fadeIn();
            $('.tooltip-error').tooltip('show');
        }
    });
});
