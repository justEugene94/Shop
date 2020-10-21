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

                $('#np_json').empty().append($("<option></option>").text('Choose...'));

                $.each(warehouses, function (key, value){
                    $('#np_json').append($("<option></option>")
                        .attr("value", '{"DescriptionRu": "' +value['DescriptionRu'] +
                            '", "Ref": "' +value['Ref'] +
                            '", "CityRef": "' +value['CityRef'] + '"}')
                        .text(value['DescriptionRu']))
                });
            }
        });
    })

});
