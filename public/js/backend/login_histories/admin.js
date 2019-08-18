$(function () {

    const TRIANGLE_IMAGE_FOR_FILTER = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAAJCAYAAAA/33wPAAAAvklEQVQoFY2QMQqEMBBFv7ERa/EMXkGw11K8QbDXzuN4BHv7QO6ifUgj7v4UAdlVM8Uwf+b9YZJISnlqrfEUZVlinucnBGKaJgghbiHOyLyFKIoCbdvecpyReYvo/Ma2bajrGtbaC58kCdZ1RZ7nl/4/4d5EsO/7nzl7IUtodBexMMagaRrs+06JLMvcNWmaOv2W/C/TMAyD58dxROgSmvxFFMdxoOs6lliWBXEcuzokXRbRoJRyvqqqQvye+QDMDz1D6yuj9wAAAABJRU5ErkJggg==';

    var editorStyles = {
        "padding": "4px",
        "width": "100%",
        "box-sizing": "border-box",
        "-webkit-appearance": "none",
        "background-color": "white",
        "background-image": "url(" + TRIANGLE_IMAGE_FOR_FILTER + ")",
        "background-position": "right center",
        "background-repeat": "no-repeat",
        "padding-right": "1.5em",
        "border": "solid 1px #ccc",
        "border-radius": "0",
    };

    // init: side menu for current page
    // $('li#menu-login-histories').addClass('menu-open active');
    // $('li#menu-login-histories').find('.treeview-menu').css('display', 'block');
    // $('li#menu-login-histories').find('.treeview-menu').find('.histories-admins a').addClass('sub-menu-active');
    $('li#menu-login-histories').addClass('menu-open active');
    $('li#menu-login-histories').find('.treeview-menu').css('display', 'block');
    $('li#menu-login-histories').find('.treeview-menu').find('.histories-admins a').addClass('sub-menu-active');

    // call tabulator function and create tables
    $("#datalist").tabulator({
        pagination: "remote",
        paginationSize: 20,
        ajaxConfig: "POST",
        ajaxURL: rootUrl + "/api/login-histories/getAdminLoginHistoriesTabular",
        ajaxFiltering: true,
        ajaxSorting: true,
        layout: "fitColumns",
        placeholder: "データがありません",
        responsiveLayout: false,
        resizableColumns: false,
        langs: {
            "ja-jp": {
                "pagination": {
                    "first": "最初",
                    "first_title": "最初",
                    "last": "最後",
                    "last_title": "最後",
                    "prev": "前へ",
                    "prev_title": "前へ",
                    "next": "次へ",
                    "next_title": "次へ",
                },
            },
        },
        columns: [
            {title: "ID", field: "id", width: 60, headerFilter: "input", sorter: "number", headerFilterPlaceholder: " "},
            {title: "管理者", field: "email", minWidth: 150, headerFilter: "input", headerFilterPlaceholder: " "},
            {title: "ログイン日時", field: "login_at", minWidth: 150, headerFilter: "input", headerFilterPlaceholder: " ", sorter: "date"},
            {title: "失敗したログインID", field: "not_exist_user", headerFilter: "input", headerFilterPlaceholder: " "},
            {title: "失敗したログイン日時", field: "failed_login_at", headerFilter: "input", headerFilterPlaceholder: " "},
            {title: "IPアドレス", field: "ip_address", minWidth: 150, headerFilter: "input", headerFilterPlaceholder: " "}

        ],
        ajaxResponse: function (url, params, response) {
            $('#datalist-total-data').html(response.total);
            $('#total-data').val(response.total);
            return response;
        },
        columnResized: function (column) {
            // none
        },
        dataFiltered:function(filters, rows){
            var pageSize = $("#datalist").tabulator("getPageSize");
            if(rows.length < pageSize) {
                pageSize = rows.length;
            }

            if(pageSize == 0) {
                $('#datalist-header').css({visibility:'hidden'});
            } else {
                $('#datalist-header').css({visibility:'visible'});
            }

            $('#datalist-max-data').html(pageSize);
        },
        pageLoaded: function (pageno) {
            // display datalist information : Showing xx to yy of zz entries
            var totalData = $('#total-data').val();
            var pageSize = $("#datalist").tabulator("getPageSize");
            var dataMin = ((pageno * pageSize) + 1) - pageSize;
            var dataMax = pageno * pageSize;
            if (totalData < dataMax) {
                dataMax = totalData;
            }
            $('#datalist-min-data').html(dataMin);
            $('#datalist-max-data').html(dataMax);
            $('#datalist-header').removeClass('invisible');
            if (totalData > 0) {
                $('#datalist-header').css('visibility', 'visible');
            } else {
                $('.tabulator-placeholder').css('width', $('.tabulator-table').width());
            }
        },
    });

    $('#datalist').tabulator('setLocale', 'en');

    $('.tabulator-cell').click(function() {
        $(this).removeClass('tabulator-editing');
    });

    $(window).resize(function () {
        redrawTabulator();
    });

    $('.sidebar-toggle').click(function () {
        redrawTabulator();
    });

    // tabulator column display filter
    $('.col-choose').click(function () {
        var val = $(this).val();
        if ($(this).is(':checked')) {
            $('#datalist').tabulator('showColumn', val) // show column
            showColumns.push(val);
        } else {
            $('#datalist').tabulator('hideColumn', val) // hide column
            showColumns = showColumns.filter(function (value, index) {
                return value != val;
            });
        }
        $('.tabulator .tabulator-tableHolder').css('overflow', 'auto');
        redrawTabulator();
    });
});

// redraw tabulator column
function redrawTabulator() {
    setTimeout(function () {
        $('#datalist').tabulator('redraw', true);
    }, 300);
}