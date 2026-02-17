$(document).ready(function() {
    // Helper to get CSRF token
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    // Add to cart
    $('.add-to-cart').click(function() {
        var productId = $(this).data('product-id');
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: 1,
                _token: getCsrfToken()
            },
            success: function(response) {
                if (response.success) {
                    $('.cart-count').text(response.cartCount);
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Error adding to cart. Please try again.');
            }
        });
    });

    // Update quantity on cart page
    $('.quantity-input').on('change', function() {
        var row = $(this).closest('tr');
        var productId = row.data('product-id');
        var quantity = $(this).val();

        $.ajax({
            url: '/cart/update',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                _token: getCsrfToken()
            },
            success: function(response) {
                if (response.success) {
                    row.find('.item-total').text('$' + response.itemTotal);
                    $('.cart-total').text('$' + response.total);
                    $('.cart-count').text(response.cartCount);
                }
            },
            error: function() {
                alert('Error updating quantity.');
            }
        });
    });

    // Remove item
    $('.remove-item').click(function() {
        var row = $(this).closest('tr');
        var productId = row.data('product-id');

        $.ajax({
            url: '/cart/remove',
            method: 'POST',
            data: {
                product_id: productId,
                _token: getCsrfToken()
            },
            success: function(response) {
                if (response.success) {
                    row.remove();
                    $('.cart-total').text('$' + response.total);
                    $('.cart-count').text(response.cartCount);
                    if (response.cartCount == 0) {
                        location.reload(); // reload to show empty cart message
                    }
                }
            },
            error: function() {
                alert('Error removing item.');
            }
        });
    });
});