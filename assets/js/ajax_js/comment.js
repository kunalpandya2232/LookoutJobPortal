$(document).ready(function () {
    getComments(jQuery);
    $(".comment .addComment").click(function (e) {
        e.preventDefault();
        let comment = $('#commentField').val();
        let url = $("p.hiddenUrl.base").text();
        let id = $("#commentJid").val();
        let uid = $(".uid").text();
        let type = $(".userType").val();
        let mode = 'insert';
        if(comment.length<=200 && comment!==''){
            $.ajax({
                url: url+'/etc/ajax/addComment.php',
                method:'post',
                data:{'id':id,'uid':uid,'comment':comment,'type':type,'mode':mode},
                dataType:"json",
                success:function (data) {
                    if(data.result=='success'){
                        getComments(jQuery);
                    }
                }
            });
        }
    });
    $("#commentField").keyup(function () {
        let fieldVal = $("#commentField").val();
        if(fieldVal.length<=200){
            $(".countComment").text(fieldVal.length+'/200');
        }else{
            $(".countComment").text('More than 200 letters not allowed');
        }
    });

    function getComments($){
        let url = $("p.hiddenUrl.base").text();
        let id = $("#commentJid").val();
        let uid = $(".uid").text();
        let mode = 'getall';
        $.ajax({
            url: url+'/etc/ajax/addComment.php',
            method:'post',
            data:{'id':id,'uid':uid,'mode':mode},
            dataType:"json",
            success:function (data) {
                if(data.result=='sucess'){
                    $('.commentList div').html(data.status);
                }
            }
        });
    }

});
