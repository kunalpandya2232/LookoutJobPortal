$(document).ready(function () {
    var url = '';
    $('label.email_error').hide();
    $('#register_form #email, #verify_email_form input#verify_email,#login_form #email, #forgot_pass_form  input#email').on('change', function (e) {
        e.preventDefault();
        url = $("p.hiddenUrl.base").text();
        let email = $(this).val();
        let form = $(this).parents("form").attr("id");

        $.ajax({
            url: url + '/etc/ajax/ajaxEmail.php',
            method: "post",
            data: {'email': email},
            dataType: "json",
            success: function (data) {
                // console.log(!$(e.target).hasClass('error'));
                if (data.status === 'error' && !$(e.target).hasClass('error')) {
                    $("#" + form + " label.email_error").show();
                    $("#" + form + " label.email_error").text('Enter valid email');
                    $("#" + form + " label.email_error").css('color', 'red');
                } else {
                    $("#" + form + " label.email_error").hide();
                    $("#" + form + " label.email_error").text('');
                    if (data.status === 'success') {
                        if (data.valid) {
                            $("#" + form + " label.email_error").show();
                            $("#" + form + " label.email_error").css('color', 'green');
                            $("#" + form + " label.email_error").text('Valid');
                            $(".verify").text("true");

                        } else if (data.page == "register") {
                            $("#" + form + " label.email_error").show();
                            $("#" + form + " label.email_error").css('color', 'red');
                            $("#" + form + " label.email_error").text(email + ' is registered');
                            $(".verify").text("");

                        } else if (data.page == "login" || data.page == "forgot-pass" ) {
                            $("#" + form + " label.email_error").show();
                            $("#" + form + " label.email_error").css('color', 'red');
                            $("#" + form + " label.email_error").text(email + ' not is registered');
                            $(".verify").text("");

                        }
                    }
                }
            }
        });
    });
});
