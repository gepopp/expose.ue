$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('[data-toggle="tooltip"]').each(function (i,v) {


        if($(v).data('show') == "1"){
            setTimeout(function(){
                $(v).tooltip('show');
            },500);
            setTimeout(function () {
                $(v).tooltip('hide');
            },3000)
        }
    });
})
