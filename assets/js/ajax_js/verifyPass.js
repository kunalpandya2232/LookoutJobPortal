$(document).ready(function () {
    var url = $("p.hiddenUrl.base").text();

    $("input#oldpass").on('change',function (e) {
        $("span.pass_error").hide();
        e.preventDefault();
        let pass = $("input#oldpass").val();
        $.ajax({
            url: url + '/etc/ajax/verifyPass.php',
            method: "post",
            data: {'pass': pass},
            dataType: 'json',
            success: function (data) {
                if(data.result!='true'){
                    $("span.pass_error").html(data.error);
                    $("span.pass_error").show();
                }else{
                    $("span.pass_error").hide();
                }
            }
        });
    });

    $("button.confirm_pass_button").click(function (e) {
        e.preventDefault();
        let pass = $("#change-password input#oldpass").val();
        let new_pass = $("#change-password input#newpass").val();
        let c_pass = $("#change-password input#cpass").val();
        let data ={
            'pass':pass,
          'new_pass': new_pass,
            'c_pass':c_pass
        };

        $.ajax({
            url: url + '/etc/ajax/validToConfirmPass.php',
            method: "post",
            data: data,
            dataType: 'json',
            success: function (data) {
                if(data.result=='success'){
                    $("div.verify-msg.pass").html("<div class='alert alert-success'>Password Update sucessfully <button class='close_err'>X</button></div>")
                }else{
                    $("div.verify-msg.pass").html("<div class='alert alert-success'>"+data.error+"<button class='close_err'>X</button></div>")
                }
            }
        });
    });
});
