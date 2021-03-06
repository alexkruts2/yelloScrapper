var table;
$(function () {
    $("#setting").on("click",function(){
        $('#setting-modal').modal();
        showOverlay();
        $.ajax({
            url:'/admin/crawler/realestate/getCrawler',
            type:"POST",
            success:function(response){
                hideOverlay();
                var source_code = response.data.source_code;
                var webhook_url = response.data.webhook_url;
                $("#source_code").html(source_code);
                $("#webhook_url").val(webhook_url);
            },
            error:function(e){
                hideOverlay();
                console.log(e);
                Swal.fire({
                    position: 'top-end',
                    type: 'error',
                    text: 'Internal Error ' + e.status + ' - ' + e.responseJSON.message,
                    title: '错误',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    });

    $('#setting-form').submit(function (e) {
        e.preventDefault();
        showOverlay();
        var form = new FormData($(this)[0]);
        $.ajax({
            url: '/admin/crawler/realestate/setCrawler',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (resp) {
                hideOverlay();
                if (resp.code == 0) {
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        text: '',
                        title: '保存成功',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    hideOverlay();
                    Swal.fire({
                        position: 'top-end',
                        type: 'error',
                        text: resp.message,
                        title: '错误',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            },
            error: function (e) {
                hideOverlay();
                Swal.fire({
                    position: 'top-end',
                    type: 'error',
                    text: 'Internal Error ' + e.status + ' - ' + e.responseJSON.message,
                    title: '错误',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        })
    });

    $("#shenjian_ctrl_button").on("click",function () {
        showOverlay();
        $.ajax({
            url:"/admin/crawler/realestate/start",
            type:"GET",
            success:function(response){
                hideOverlay();
                if(response.data=='starting')
                    Swal.fire({
                        position: 'top-end',
                        type: '',
                        text: '',
                        title: '启动中',
                        showConfirmButton: false,
                        timer: 3000
                    });
                else if(response.data=='stopping')
                    Swal.fire({
                        position: 'top-end',
                        type: '',
                        text: '',
                        title: '停止中',
                        showConfirmButton: false,
                        timer: 3000
                    });
                setCrawlerStatus(response.data);
            },
            error:function(e){
                hideOverlay();
                console.log(e);
                Swal.fire({
                    position: 'top-end',
                    type: 'error',
                    text: 'Internal Error ' + e.status + ' - ' + e.responseJSON.message,
                    title: '错误',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        })
    });

    setInterval(function(){
        $.ajax({
            url:"/admin/crawler/realestate/status",
            type:"GET",
            success:function(response){
                var json = response;
                var status = json.data.state;
                setCrawlerStatus(status);
            }
        });
    }, 10000);
    $("#state").on("change",function(){
        drawTable();
    })
    drawTable();
    showOverlay();
    $.ajax({
        url:"/admin/crawler/realestate/status",
        type:"GET",
        success:function(response){
            hideOverlay();
            var json = response;
            var status = json.data.state;
            setCrawlerStatus(status);
        }
    });

});
function drawTable(){
    // showOverlay();
    if(table!=undefined&&table!=''&&table!=null)
        table.destroy();
    table = $('#table').DataTable({
        "processing":true,
        'searching': false,
        "serverSide":true,
        "order": [[0, "asc"]],
        "pageLength": 10,
        "aLengthMenu":[10,20,50],
        "ajax":{
            "type":"GET",
            "url": '/admin/crawler/realestate/data',
            "dataType":"json",
        },
        columns: [
            {data: 'property_id'},
            {data: 'property_type'},
            {data: 'url'},
            {data: 'address_street'},
            {data: 'title'},
            {data: 'agent_name'},
            {data: 'agent_phone'}
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Chinese.json"
        },
        "aoColumnDefs": [
            {
                "mRender":function(data,type,full){
                    return data.length > 10 ?
                        data.substr( 0, 10 ) +'…' :
                        data;
                }
            },
            {"className": "text-center", "targets": "_all"}
        ],
    });
}
