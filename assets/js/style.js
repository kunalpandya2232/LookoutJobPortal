$(document).ready(function () {
    if ($("#post_job_form select#category").length > 0) {
        // if (false) {

        let url = $("p.hiddenUrl.base").text();
        let opt = '';
        let _this = $("#post_job_form select#category");
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
                if($("#cat-hidden").length>0){
                    let cat_val = $("#cat-hidden").val();
                    let catt=$("#category option[value='"+cat_val+"']").prop("selected",true);
                }
            }
        });

    }

    if ($("#paging select#category").length > 0) {

        let url = $("p.hiddenUrl.base").text();
        let opt = '';
        let _this = $("#paging select#category");
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
    }
});
