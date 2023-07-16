$(document).ready(function () {
    var limit = 1;
    var url =$("p.hidden.admin-url").text();
    var data ='';
    if($("#getOrg").length>0){
        var type = $(".u_type").val();
        var sort = 'date';
        let data = {
            'location':'',
            'sort':sort,
            'type_user':type,
            'limit':limit,
        };
        getUserList($,data);

        $("#search-go-button").click(function (e) {
            e.preventDefault();
            let params={};
            let location = $(".search-value").val();
            data['location']=location;
            data['sort']= sort;
            getUserList($,data);
        });
        $(".select-button-sort ul .select-option").click(function (e) {
            e.preventDefault();
            let params={};
            let location = $(".search-value").val();
            sort = $(this).children("a").attr("data-sort");
            data['location']=location;
            data['sort']= sort;
            data['limit']= 1;
            getUserList($,data);
        });
        $("#getOrgButton ul.pagination").on('click','.paginate_button a.pagingdat',function (e) {
            e.preventDefault();
            let location = $(".search-value").val();
            limit = $(this).attr("data-page");
            data['limit']=limit;
            data['sort']= sort;
            data['location']=location;
            getUserList($,data);

        });

    }

    function getUserList($,params){
        $.ajax({
            url:url+'/etc/ajax/getUsersList.php',
            method:'post',
            dataType:'json',
            data:params,
            success:function (data) {
                $("#getOrg").html(data.res);
                $("#getOrgButton div ul").html(data.pagbut);
            }
        });
    }


});

