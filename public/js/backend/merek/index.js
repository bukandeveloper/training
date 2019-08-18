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
    $('li#menu-merek').addClass('menu-open active');
    $('li#menu-merek').find('.treeview-menu').css('display', 'block');
    $('li#menu-merek').find('.treeview-menu').find('.list-merek a').addClass('sub-menu-active');

        // Formatter for edit/delete
    var formatActionField = function (row, cell, formatterParams) {
        var url = "merek";
        // To make 'delete button' works with csrf_field(), need to comment out VerifyCsrfToken in app/kernel.php
        // After that token can be parsed via ajax
        return '<form id="form-action-' + row.getData()['id'] + '" action="' + rootUrl + '/admin/'+ url +'/delete" method="post">\n\
        <a class="btn btn-primary" href="' + rootUrl + '/admin/'+ url +'/edit/' + row.getData()['id'] + '" title="edit">\n\
        <i class="fa fa-edit"></i></a>&nbsp;&nbsp;<input type="hidden" name="id" value="' + row.getData()['id'] + '">\n\
        <input type="hidden" name="jobs_statuses_id" value="5"><span onclick="javascript:if(confirm(\'Are you sure delete this data ?\')) \n\
        { document.getElementById(\'form-action-' + row.getData()['id'] + '\').submit(); } return false;" class="btn btn-warning btn-delete" title="hapus"><i class="fa fa-trash"></i></span></form>';
    };    // Formatter for edit/delete

    // call tabulator function and create tables
    $("#datalist").tabulator({
        layout: "fitColumns",
        placeholder: "empty",
        responsiveLayout: false,
        resizableColumns: true,
        pagination: "local",
        paginationSize: 25,
        langs: {
            "ja-jp": {
                "pagination": {
                    "first": "first",
                    "first_title": "first",
                    "last": "last",
                    "last_title": "last",
                    "prev": "prev",
                    "prev_title": "prev",
                    "next": "next",
                    "next_title": "next",
                },
            },
        },
        columns: [
            {title: "ID", field: "id", width: 45, headerFilter: "input", sorter: "number", headerFilterPlaceholder: " "},
            {title: "Nama Merek", minWidth: 161, field: "nama", headerFilter: "input", headerFilterPlaceholder: " "},
            // Declare sorter for date fields as string because it's treated as string
            {title: "Created At", minWidth: 161, field: "created_at", headerFilter: "input", headerFilterPlaceholder: " ", sorter: "string"},
            {title: "Updated At", minWidth: 164, field: "updated_at", headerFilter: "input", headerFilterPlaceholder: " ", sorter: "string"},
             {title:"Action", field:"action", align:"center", headerFilter:false, width:100, formatter:formatActionField, headerFilterPlaceholder:" ", headerSort:false, frozen:true},
        ],
        dataLoaded:function(data){
            setTimeout(function() {
              PageDataInfo();
            }, 300);
        },
        columnResized:function(column){
            // none
        },
        dataFiltered:function(filters, rows){
            setTimeout(function() {
              PageDataInfo();
            }, 300);
        },
        pageLoaded:function(pageno){
            setTimeout(function() {
                // display datalist information : Showing xx to yy of zz entries
                var totalData = $('#total-data').val();
                var pageSize = $("#datalist").tabulator("getPageSize");
                var dataMin = ((pageno * pageSize) + 1) - pageSize;
                var dataMax = pageno * pageSize;
                if(totalData < dataMax) {
                    dataMax = totalData;
                }
                $('#datalist-min-data').html(dataMin);
                $('#datalist-max-data').html(dataMax);
                $('#datalist-header').removeClass('invisible');
                if(totalData>0) {
                    $('#datalist-header').css('visibility','visible');
                }
            }, 1200);
        },
    });

    $('#datalist').tabulator('setData', rootUrl + '/api/merek/getMerekTabular');
    $('#datalist').tabulator('setLocale', 'en');

    // $('#page-size').change(function() {
    //     $('#datalist-total-data').html($('#page-size').val());
    // })

    // show or hide column refer tabulator cookie
    var tabulatorColumns = ['id', 'username', 'created_at', 'updated_at', 'user_role', 'display_name'];
    var defaultHideColumns = [];
    // DISABLE COOKIES FOR FIRST PART OF PROJECT
    // if tabulator-jobDatalist-filter cookie exist show column refer tabulator filter cookie
//    if(!!$.cookie('tabulator-jobDatalist-filter')) {
//        var tabulatorCookies = $.cookie('tabulator-jobDatalist-filter').split(',');
//        var hiddenColumns = $(tabulatorColumns).not(tabulatorCookies).get();
//        $('.col-choose').prop('checked', true)
//        // hide column
//        $.each(hiddenColumns, function(i, hiddenColumn) {
//            $('#datalist').tabulator('hideColumn', hiddenColumn);
//            $('#' + hiddenColumn).prop('checked', false);
//        });
//    }
    // if tabulator-jobDatalist-filter cookie not exist show default column
//    else {
        $.each(defaultHideColumns, function(i, defaultHideColumn) {
            $('#datalist').tabulator('hideColumn', defaultHideColumn);
        });
//    }

    $('.tabulator-cell').click(function() {
        $(this).removeClass('tabulator-editing');
    });

    $(window).resize(function(){
         redrawTabulator();
    });

    $('.sidebar-toggle').click(function() {
        redrawTabulator();
    });

    // case of the delete
    $('.btn-delete').click(function() {
        if(confirm('are you sure delete this data ?')) {
            $(this).parents("form").submit();
            return true;
        }
        return false;
    });

    $('#btn-pagination-filter select[name=page-size]').change(function() {
        $('#datalist').tabulator('setPageSize', $(this).val());
    });
});

// redraw tabulator column
function redrawTabulator() {
    setTimeout(function() {
        $('#datalist').tabulator('redraw', true);
        PageDataInfo();
    }, 300);
}

function PageDataInfo(data){
    var getDataCount = $("#datalist").tabulator("getDataCount");
    var getPage      = $("#datalist").tabulator("getPage");
    var getPageSize  = $("#datalist").tabulator("getPageSize");
    var getPageMax   = $("#datalist").tabulator("getPageMax");

    $('#datalist-total-data').html(getDataCount);
    $('#total-data').val(getDataCount);

    if(getDataCount < getPageSize) {
        getPageSize = getDataCount;
    }

    $('#datalist-max-data').html(getPageSize);

    if(getPageSize == 0) {
        $('#datalist-min-data').html(0);
    } else {
        $('#datalist-min-data').html(1);
    }

    $('#datalist-header').removeClass('invisible');
    $('#datalist-header').removeClass('visible');

    if(getDataCount > 0 ){
        $('#datalist-header').addClass('visible');
        $('#datalist-header').css('display', 'block');
    }else{
        $('#datalist-header').addClass('invisible');
    }
}
