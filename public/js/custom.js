$(document).ready(function(){

    $('#orderform').on('submit', function(e){
        e.preventDefault();

        $("#submit").prop('disabled', true);

        $('#order-errors').html('');

        order = $('#formswitch').val();

        getRadioPeriods(order);

        var formData = new FormData($(this)[0]);
        
        $.ajax({
            type: 'POST',
            contentType: 'multipart/form-data',
            url: '/order/' + order,
            data: formData,
            processData: false,
            contentType: false,            
            success: function(result){
                if(result.result){
                    if (result.id.length > 1){
                        text = 'Заказы №' + result.id + ' сохранены в базе!';
                    }else if(result.id){
                        text = 'Заказ №' + result.id + ' сохранен в базе!';
                    }
                    $('#order-container').html('<div class="opt-flex-center opt-position-ref opt-full-height">' +
                        '<div class="col-xs-12 opt-content">' +
                        '<div class="alert alert-success">' +
                        '<h2>' + text + '</h2>' +
                        '<a href="/">вернуться на главную</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>');                    
                }else{
                    $('#order-errors').append('<div class="alert alert-danger">Неизвестная ошибка при формировании заказа</div>');                    
                }
            },
            error: function (xhr) {
                $.each(xhr.responseJSON.errors, function(key,value) {
                    $('#order-errors').append('<div class="alert alert-danger">'+value+'</div>');
                }); 
            },
        });
        $("#submit").prop('disabled', false);
    });

    function getRadioPeriods(order) {
        if (order != 'radio') return false;

        var periods = {};
        $(".radio-period-cell").each(function() {
            period = $(this).text();
            if (period) {
                periodID = $(this).attr("id");
                periods[ periodID ] = period;
            }
        });
        //console.log(periods);
        $jsonPeriods = JSON.stringify(periods);
        $('#radio-periods').val($jsonPeriods);
        return periods;
    }
    
    $('#multi-photographer').multifield({
        sectionAdd: '#multi-photographer-group',
        section: '.multi-photographer-elem',
        btnAdd:'#btnAdd-photographer',
        btnRemove:'.btnRemove-photographer',
    });

    $('#multi-promoter').multifield({
        sectionAdd: '#multi-promoter-group',
        section: '.multi-promoter-elem',
        btnAdd:'#btnAdd-promoter',
        btnRemove:'.btnRemove-promoter',
    });

    $('#multi-placement').multifield({
        sectionAdd: '#multi-placement-group',
        section: '.multi-placement-elem',
        btnAdd:'#btnAdd-placement',
        btnRemove:'.btnRemove-placement',
    });

    $(".btn-reset").click(function() {
        $(this).closest('form').find("input, textarea").not( '.date-now, input[type="hidden"]' ).val("");
        $(this).closest('form').find( 'input[type="radio"]' ).prop('checked', false);
    });

    $("#unfinished").click(function() {
        $('.order-done').toggle();
    });

    $('#orderform').keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
    });

});
