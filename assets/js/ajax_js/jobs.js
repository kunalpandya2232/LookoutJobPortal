$(document).ready(function () {
    if ($("form#paging").length > 0) {
        let location = $(".location").val();
        let cat = $("#category").val();
        let type = $("#type").val();
        let limit = 1;
        let params = {
            'locate': location,
            'category': cat,
            'type': type,
            'limit': limit,
        };
        getJobs(jQuery, params);

        $("form#paging").on('change', function () {
            let location = $(".location").val();
            let cat = $("#category").val();
            let type = $("#type").val();
            let limit = 1;
            let params = {
                'locate': location,
                'category': cat,
                'type': type,
                'limit': limit
            };
            getJobs(jQuery, params)
        });
        $(".container").on('click', ".pagination .pagingdat", function () {
            let location = $(".location").val();
            let cat = $("#category").val();
            let type = $("#type").val();
            let limit = $(this).attr('data-page');
            let params = {
                'locate': location,
                'category': cat,
                'type': type,
                'limit': limit
            };
            getJobs(jQuery, params)
        });
    }

    $(".delete-job").click(function (e) {
        let _this = $(this);
        let record = _this.attr("data-jid");
        let url = $(".hiddenUrl.base").text();
        let near_this = _this.parents('.jobListarticle');

        $.ajax({
            url: url + '/etc/ajax/deleteApplyJob.php',
            method: "post",
            data: {'recordId': record, 'type': 'J'},
            dataType: 'JSON',
            success: function (data) {
                // console.log(data);
                if (data.result) {
                    near_this.fadeOut("slow");
                }
            }
        });
    });

    $(".my-delete-job").click(function (e) {
        let _this = $(this);
        let record = _this.attr("data-id");
        let url = $(".hiddenUrl.base").text();
        let near_this = _this.parents('.myjobListarticle');

        $.ajax({
            url: url + '/etc/ajax/deleteMyJob.php',
            method: "post",
            data: {'recordId': record, 'type': 'O'},
            dataType: 'JSON',
            success: function (data) {
                // console.log(data);
                if (data.result) {
                    near_this.fadeOut("slow");
                }
            }
        });
    });

    $(".browseJobs").on('click', '.browjob', function () {

    });

    function getJobs($, params) {
        let url = $("p.hiddenUrl.base").text();
        if ($(".browseJobs").length > 0) {
            $.ajax({
                url: url + '/etc/ajax/getBrowseJob.php',
                method: "post",
                data: params,
                dataType: 'JSON',
                success: function (data) {
                    if (data.result && data.res != "") {
                        $(".browseJobs").html(data.res);
                    } else {
                        $(".browseJobs").html('<article>\n <div class="brows-job-list center">\n No Jobs Found </div></article>');
                    }
                    if (data.result && data.res != "" && data.pagbut != '') {
                        $("ul.pagination").html(data.pagbut);
                    } else {
                        $("ul.pagination").html();
                    }
                }
            });
        }
        if ($(".getJobs").length > 0) {
            $.ajax({
                url: url + '/etc/ajax/getJob.php',
                method: "post",
                data: params,
                dataType: 'JSON',
                success: function (data) {
                    if (data.result && data.res != "") {
                        $(".getJobs").html(data.res);
                    } else {
                        $(".getJobs").html('<article>\n <div class="brows-job-list center">\n No Jobs Found </div></article>');
                    }
                    if (data.result && data.res != "" && data.pagbut != '') {
                        $("ul.pagination").html(data.pagbut);
                    } else {
                        $("ul.pagination").html();
                    }
                }
            });
        }
    }

    $(".accept-user").click(function () {
        let _this = $(this);
        let url = $("p.hiddenUrl.base").val();
        let uid = _this.attr('data-au-id');
        $.ajax({
            url: url + '/etc/ajax/acceptUser.php',
            method: 'post',
            data: {'uid': uid, 'mode': 'accept'},
            dataType: 'json',
            success: function (data) {
                if (data.result == 'success') {
                    _this.parents('.card-point').fadeOut();
                }
            }
        });
    });

    $(".deny-user").click(function () {
        let _this = $(this);
        let url = $("p.hiddenUrl.base").val();
        let uid = _this.attr('data-du-id');
        $.ajax({
            url: url + '/etc/ajax/acceptUser.php',
            method: 'post',
            data: {'uid': uid, 'mode': 'deny'},
            dataType: 'json',
            success: function (data) {
                if (data.result == 'success') {
                    _this.parents('.card-point').fadeOut();
                }
            }
        });
    });
    $(".getJobs").on('click', '.my-delete-job-admin', function (e) {
        let _this = $(this);
        let record = _this.attr("data-id");
        let url = $(".hiddenUrl.base").text();
        let near_this = _this.parents('.myjobListarticle');

        $.ajax({
            url: url + '/etc/ajax/deleteMyJob.php',
            method: "post",
            data: {'recordId': record, 'type': 'A'},
            dataType: 'JSON',
            success: function (data) {
                // console.log(data);
                if (data.result) {
                    near_this.fadeOut("slow");
                }
            }
        });
    });

    if ($("form#paging-job").length > 0) {
        let location = $(".location").val();
        let cat = $("#category").val();
        let type = $("#type").val();
        let limit = 1;
        let params = {
            'locate': location,
            'category': cat,
            'type': type,
            'limit': limit,
        };
        $("form#paging-job").on('change', function () {
            let location = $(".location").val();
            let cat = $("#category").val();
            let type = $("#type").val();
            let limit = 1;
            let params = {
                'locate': location,
                'category': cat,
                'type': type,
                'limit': limit
            };
            getMyJobs(jQuery, params)
        });
        $(".getMyJobPaging").on('click', ".pagination .pagingdat", function () {
            let location = $(".location").val();
            let cat = $("#category").val();
            let type = $("#type").val();
            let limit = $(this).attr('data-page');
            let params = {
                'locate': location,
                'category': cat,
                'type': type,
                'limit': limit
            };
            getMyJobs(jQuery, params)
        });
        $("#posted_job").click(function (e) {
            e.preventDefault();
            let url = $("p.hiddenUrl.base").text();
            let opt = '';
            let _this = $("#paging-job select#category");
            $.ajax({
                url: url + '/etc/ajax/getCategories.php',
                method: "post",
                dataType: 'JSON',
                success: function (data) {
                    if (data.result == 'success') {
                        for (x in data.categories) {
                            opt += '<optgroup label="' + x + '">';
                            for (y in data.categories[x]) {
                                opt += '<option value="' + data.categories[x][y] + '">' + data.categories[x][y] + '</option>'
                            }
                            opt += '</optgroup>';
                        }
                        _this.append(opt);
                    }
                }
            });
            getMyJobs(jQuery, params);
        });

        $(".getMyJob").on('click', '.my-delete-job', function (e) {
            let _this = $(this);
            let record = _this.attr("data-id");
            let url = $(".hiddenUrl.base").text();
            let near_this = _this.parents('.myjobListarticle');

            $.ajax({
                url: url + '/etc/ajax/deleteMyJob.php',
                method: "post",
                data: {'recordId': record, 'type': 'O'},
                dataType: 'JSON',
                success: function (data) {
                    // console.log(data);
                    if (data.result) {
                        near_this.fadeOut("slow");
                    }
                }
            });
        });
    }

    function getMyJobs($, params) {
        let url = $("p.hiddenUrl.base").text();
        $.ajax({
            url: url + '/etc/ajax/providedJobList.php',
            method: "post",
            data: params,
            dataType: 'JSON',
            success: function (data) {
                if (data.result && data.data != "") {
                    $(".getMyJob").html(data.data);
                } else {
                    $(".getMyJob").html('<article>\n <div class="brows-job-list center">\n No Jobs Found </div></article>');
                }
                if (data.result && data.data != "" && data.button != '') {
                    $(".getMyJobPaging ul.pagination").html(data.button);
                } else {
                    $(".getMyJobPaging ul.pagination").html();
                }
            }
        });
    }

    if($(".get-my-apply-job").length>0){
        var limit = 1;
        $("#job_apply").click(function (e) {
            e.preventDefault();
            getAppliedJobs(jQuery,limit);
        });
        $("#post-job").on('click','.paging ul.pagination .pagingdat',function (e) {
            e.preventDefault();
             limit = $(this).attr('data-page');
            getAppliedJobs(jQuery,limit);

        });
        function getAppliedJobs($,limit){
            let _this = $("#post-job .get-my-apply-job");
            let id = _this.attr('data-id');
            let url = $("p.hiddenUrl.base").text();
            $.ajax({
                url: url + '/etc/ajax/appliedJoblist.php',
                method: "post",
                data: {'id':id, 'limit':limit},
                dataType: 'JSON',
                success: function (data) {
                    if (data.result && data.data != "") {
                        _this.html(data.data);
                    } else {
                        _this.html('<article>\n <div class="brows-job-list center">\n No Jobs Found </div></article>');
                    }
                    if (data.result && data.data != "" && data.button != '') {
                        $("#post-job ul.pagination").html(data.button);
                    } else {
                        $("#post-job ul.pagination").html();
                    }
                }
            });
        }
    }

});
