$(document).ready(function () {
    $("div.verify-msg").hide();
    if ($("#submi-edit-profile").length > 0) {
        $("#submi-edit-profile").click(function (e) {
            e.preventDefault();
            let url = $("p.hiddenUrl.base").val();
            let param = {};
            param['fname'] = $("#jobseeker_edit_form #fname").val();
            param['lname'] = $("#jobseeker_edit_form #lname").val();
            param['contact_no'] = $("#jobseeker_edit_form #contact_no").val();
            param['dob'] = $("#jobseeker_edit_form #dob").val();
            param['address'] = $("#jobseeker_edit_form #address").val();
            param['city'] = $("#jobseeker_edit_form #city").val();
            param['state'] = $("#jobseeker_edit_form #state").val();
            param['country-id'] = $("#jobseeker_edit_form #country").val();
            param['gender'] = $("#jobseeker_edit_form .gender:checked").val();
            param['user_exp'] = $("#jobseeker_edit_form #user_exp").val();
            param['user_occ'] = $("#jobseeker_edit_form #user_occ").val();
            if ($("#jobseeker_edit_form #orgName").length > 0) {
                param['orgName'] = $("#jobseeker_edit_form #orgName").val();
            }
            param['uid'] = $("#jobseeker_edit_form #uid").val();

            $.ajax({
                url: url + '/etc/ajax/editProfile.php',
                method: 'post',
                data: param,
                dataType: 'json',
                success: function (data) {
                    if (data.result == "success") {
                        $("div.verify-msg.prof").html("<div class='alert alert-success'>Profile Updated <button class='close_err'>X</button></div>");
                        $("div.verify-msg.prof").show();
                    }
                },
            });
        });
    }

    if ($(".confirm_pass_button").length > 0) {
        $(".confirm_pass_button").click(function () {
            let pass = $("input#pass").val();
            let newpass = $("input#newpass").val();
            let cpass = $("input#cpass").val();

            if (cpass !== '' && newpass !== " " && pass != '') {
                if (newpass == cpass && newpass <= 16) {
                    $.ajax({
                        url: url + '/etc/ajax/editProfile.php',
                        method: 'post',
                        data: param,
                        dataType: 'json',
                        success: function (data) {
                            if (data.result == "success") {
                                $("div.verify-msg.pass").html("<div class='alert alert-success'>Password Updated <button class='close_err'>X</button></div>");
                                $("div.verify-msg.pass").show();
                            }
                        },
                    });
                }
            }


        });
    }

    if ($(".link_button").length > 0) {
        $(".link_button").click(function () {
            let facebook = $("input#facebook").val();
            let twitter = $("input#twitter").val();
            let instagram = $("input#instagram").val();
            let linkedIn = $("input#linkin").val();
            if (facebook !== '' || twitter !== " " || instagram != '' || linkin != '') {
                let url = $("p.hiddenUrl.base").val();
                let param = {
                    'facebook': facebook,
                    'twitter': twitter,
                    'instagram': instagram,
                    'linkedIn': linkedIn,
                    'uid': $("#jobseeker_link_form #uid_link").val()
                };

                $.ajax({
                    url: url + '/etc/ajax/linkedit.php',
                    method: 'post',
                    data: param,
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == "success") {
                            $("div.verify-msg.links").html("<div class='alert alert-success'>Links Updated <button class='close_err'>X</button></div>");
                            $("div.verify-msg.links").show();
                        }
                    },
                });
            }
        });
    }

    $(".upload_resumeBtn").click(function (e) {
        let resume = $(".resume").prop("files")[0];
        let url = $("p.hiddenUrl.base").val();

        if (resume != '' && typeof resume =="object") {
            let form = new FormData();
            form.append('file', resume);
            $.ajax({
                url: url + '/etc/checker/validToResume.php',
                method: 'post',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    if(data.result==true ) {
                        $("div.verify-msg.links").html("<div class='alert alert-success'>Resume Uploaded<button class='close_err'>X</button></div>");
                        $("div.verify-msg.links").show();
                    }else if(data.result==false){
                        $("div.verify-msg.links").html("<div class='alert alert-danger'>"+data.err+"<button class='close_err'>X</button></div>");
                        $("div.verify-msg.links").show();
                    }
                }

            });
        }
    });

    if($(".removeResume").length){
        $(".removeResume").click(function (e) {
            e.preventDefault();
            let url = $("p.hiddenUrl.base").val();
            let idd = $("#uid_link").val();
            $.ajax({
                url: url + '/etc/checker/validToResume.php',
                method: 'post',
                data: {'id':idd},
                dataType: 'json',
                success: function (data) {
                    if(data.result==true ) {
                        $("div.verify-msg.links").html("<div class='alert alert-success'>Resume Uploaded<button class='close_err'>X</button></div>");
                        $("div.verify-msg.links").show();
                    }else if(data.result==false){
                        $("div.verify-msg.links").html("<div class='alert alert-danger'>"+data.err+"<button class='close_err'>X</button></div>");
                        $("div.verify-msg.links").show();
                    }
                }
            });
        });
    }

    $(".update_image_button").click(function () {
        $(".update_image_button_file").trigger("click");
    });
    $(".update_image_button_file").change(function (e) {
        e.preventDefault();
        let newImage= $(".update_image_button_file").prop("files")[0];
        let url = $("p.hiddenUrl.base").val();

        if (newImage != '' && typeof newImage =="object") {
            let form = new FormData();
            form.append('file', newImage);
            if(confirm("Sure to change your Profile Image?")){
                $.ajax({
                    url: url + '/etc/checker/validToUpdatImage.php',
                    method: 'post',
                    data:form,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if(data.result == true){
                            $(".update_img").attr('src',data.imgSrc);
                        }else{
                            let err = '';
                            if(data.result == false){
                                $(Object.values(data.err)).each(function (obj,ee) {
                                        err += ee+'. ';
                                });
                            }else{
                                err = "Image is not Uploaded";
                            }
                            alert(err);
                        }
                    }
                });
            }
        }
    });
});
