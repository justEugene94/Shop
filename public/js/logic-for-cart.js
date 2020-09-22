jQuery(document).ready(function(){

    $('form').submit(function (e) {
        e.preventDefault();

        let values = $(this).serializeArray();
        let data = mapSerializeArray(values);

        let url = `/products/${data.id}/add-to-cart`;
        $.ajax({
            type:'POST',
            url: url,
            headers: {'X-CSRF-TOKEN': data._token, '_method': 'post'},
            success: function (result) {
                span = $('.cart-total')
                qty = Number(span.text().match(/\d+/)[0]) + 1;
                span.text("(" + qty + ")");
                $('.product').after(result);
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
