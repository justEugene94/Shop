jQuery(document).ready(function (e){

    $('#city').focusout(function () {
        let city = $('#city').val()
        let token = $('meta[name="csrf-token"]').attr('content')
        let url = '/nova-poshta/warehouses'

        $.ajax({
            type:'POST',
            url: url,
            headers: {'X-CSRF-TOKEN': token, '_method': 'post'},
            data: {'city': city},
            success: function (result) {
                let warehouses = result.result;

                $('#department').empty().append($("<option></option>").text('Choose...'));

                $.each(warehouses, function (key, value){
                    $('#department').append($("<option></option>")
                        .attr("value", value['DescriptionRu'])
                        .text(value['DescriptionRu']))
                });
            }
        });
    })

});
