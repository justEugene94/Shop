jQuery(document).ready(function(){
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    $('form').submit(function (e) {
        e.preventDefault();

        let values = $(this).serializeArray();
        let data = mapSerializeArray(values);

        let url = `/products/${data.id}/add-to-cart`;
        $.ajax({
            type:'POST',
            // data: {"csrf-token": data._token},
            url: url,
            headers: {'X-CSRF-TOKEN': data._token, '_method': 'post'},
            success: function (res) {
                $('.cart-total').text(res);
            }
        });
    });

    function mapSerializeArray(unindexed_array) {
        let indexed_array = {};
        $.map(unindexed_array, function (n, i) {
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }
});
