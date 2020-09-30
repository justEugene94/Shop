jQuery(document).ready(function(){

    $('.create').submit(function (e) {
        e.preventDefault();

        let values = $(this).serializeArray();
        let data = mapSerializeArray(values);
        let token = $('meta[name="csrf-token"]').attr('content');

        let url = `/products/${data.id}/add-to-cart`;
        $.ajax({
            type:'POST',
            url: url,
            headers: {'X-CSRF-TOKEN': token, '_method': 'post'},
            success: function (result) {
                $('.cart-total').text("(" + result.qty + ")");
                $('#cart-total').text(result.price);
                $('.product').after(result.div);
            }
        });
    });

    $('.delete').submit(function (e) {
        e.preventDefault();

        let values = $(this).serializeArray();
        let data = mapSerializeArray(values);
        let token = $('meta[name="csrf-token"]').attr('content');

        $(this).parent().parent().fadeOut('slow', function() {
            $(this).remove();
        });
        $.ajax({
            url: `/products/${data.id}/delete-from-cart`,
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': token, '_method': 'delete'},
            success: function (result) {
                $('.cart-total').text("(" + result.qty + ")");
                $('#cart-total').text(result.price);
            },
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
