jQuery(document).ready(function($){

    var quantity = 1;
    var price =parseInt($("#price").val())
    var price_page =parseInt($("#price_pages").val())
    var qnt = $('.nixwood_total_pages_qnt')

    $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        quantity = $input.val()
        total()
        qnt.text(quantity)
    });

    $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        quantity = $input.val()
        total()
        qnt.text(quantity)
    });





    $('#price_pages').on('change' ,function(e) {

        if ($(this).is(':checked')) {
            $('.nixwood_total_pages').removeClass('hidden')
            qnt.text(quantity)
            total()
        }
        else {
            $('.nixwood_total_pages').addClass('hidden')
            total()
        }

    });

    function total()
    {
        var total = price
        if ($('#price_pages').is(':checked')){
             total = price_page * quantity + price
            $('#total').text(total)
        }

         $('#total').text(total)
    }

        $(document).on('submit', '#checkout-nixwood_form' ,function(e) {
        e.preventDefault()

            var price_pages = "";
            if ($('#price_pages').is(':checked')) {
                price_pages = price_page
            }

           $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'total_handle',
                price: price,
                price_page: price_pages,
                quantity: quantity
            },
            beforeSend: function (){

            },
            success: function (data) {
                console.log(data)
               // $('#nixwood-checkout').replaceWith(data)
            }
        });
    });
});