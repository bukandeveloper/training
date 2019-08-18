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
    $('li#menu-admins').addClass('menu-open active');
    $('li#menu-admins').find('.treeview-menu').css('display', 'block');
    $('li#menu-admins').find('.treeview-menu').find('.list-admins a').addClass('sub-menu-active');

    // call tabulator function and create tables
    $("#datalist").tabulator({
        layout: "fitColumns",
        placeholder: "Data Kosong",
        responsiveLayout: false,
        resizableColumns: true,
        pagination: "local",
        paginationSize: 25,
        langs: {
            "ja-jp": {
                "pagination": {
                    "first": "First",
                    "first_title": "First Title",
                    "last": "Last",
                    "last_title": "Last Title",
                    "prev": "Prev",
                    "prev_title": "Prev Title",
                    "next": "Next",
                    "next_title": "Next Title",
                },
            },
        },
        columns: [
            {title: "ID", field: "id", width: 45, headerFilter: "input", sorter: "number", headerFilterPlaceholder: " "},
            // {title: "氏名", minWidth: 161, field: "display_name", headerFilter: "input", headerFilterPlaceholder: " "},
            {title: "Email", minWidth: 161, field: "email", headerFilter: "input", headerFilterPlaceholder: " "},
            // Declare sorter for date fields as string because it's treated as string
            {title: "Created at", minWidth: 161, field: "created_at", headerFilter: "input", headerFilterPlaceholder: " ", sorter: "string"},
            {title: "Updated at", minWidth: 164, field: "updated_at", headerFilter: "input", headerFilterPlaceholder: " ", sorter: "string"},
            {title: "Action", field: "action", align: "center", headerFilter: false, width: 100, formatter: "html", headerFilterPlaceholder: " ", headerSort: false, frozen: true},
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

    $('#datalist').tabulator('setData', rootUrl + '/api/admins/getAdminsTabular');
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
        if(confirm('Are you sure to delete this data?')) {
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
