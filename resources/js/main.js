// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    if (addToCartButtons) {
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                addToCart(productId, 1);
            });
        });
    }

    // Quantity input controls
    const quantityInputs = document.querySelectorAll('.quantity-input');
    if (quantityInputs) {
        quantityInputs.forEach(input => {
            const decrementBtn = input.previousElementSibling;
            const incrementBtn = input.nextElementSibling;

            decrementBtn.addEventListener('click', function() {
                if (input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                    if (input.hasAttribute('data-cart-item')) {
                        updateCartQuantity(input.getAttribute('data-cart-item'), input.value);
                    }
                }
            });

            incrementBtn.addEventListener('click', function() {
                input.value = parseInt(input.value) + 1;
                if (input.hasAttribute('data-cart-item')) {
                    updateCartQuantity(input.getAttribute('data-cart-item'), input.value);
                }
            });

            input.addEventListener('change', function() {
                if (parseInt(input.value) < 1 || isNaN(parseInt(input.value))) {
                    input.value = 1;
                }
                if (input.hasAttribute('data-cart-item')) {
                    updateCartQuantity(input.getAttribute('data-cart-item'), input.value);
                }
            });
        });
    }

    // Product image gallery
    const productThumbnails = document.querySelectorAll('.product-thumbnail');
    if (productThumbnails) {
        productThumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const mainImage = document.querySelector('.product-main-image');
                const activeThumb = document.querySelector('.product-thumbnail.active');

                if (activeThumb) {
                    activeThumb.classList.remove('active');
                }

                this.classList.add('active');
                mainImage.src = this.getAttribute('data-image');
            });
        });
    }

    // Functions
    function addToCart(productId, quantity) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count in header
                const cartCountBadge = document.querySelector('.cart-count');
                if (cartCountBadge) {
                    cartCountBadge.textContent = data.cart_count;
                }

                // Show success message
                showNotification('Sản phẩm đã được thêm vào giỏ hàng!', 'success');
            } else {
                showNotification('Có lỗi xảy ra. Vui lòng thử lại!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra. Vui lòng thử lại!', 'error');
        });
    }

    function updateCartQuantity(cartItemId, quantity) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                cart_item_id: cartItemId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update subtotal
                const subtotalElement = document.querySelector(`.cart-item-subtotal-${cartItemId}`);
                if (subtotalElement) {
                    subtotalElement.textContent = data.subtotal;
                }

                // Update cart total
                const cartTotalElement = document.querySelector('.cart-total');
                if (cartTotalElement) {
                    cartTotalElement.textContent = data.cart_total;
                }
            } else {
                showNotification('Có lỗi xảy ra khi cập nhật giỏ hàng!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra khi cập nhật giỏ hàng!', 'error');
        });
    }

    function showNotification(message, type) {
        // Check if notification container exists, if not create it
        let notificationContainer = document.querySelector('.notification-container');
        if (!notificationContainer) {
            notificationContainer = document.createElement('div');
            notificationContainer.className = 'notification-container';
            document.body.appendChild(notificationContainer);
        }

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <p>${message}</p>
            </div>
            <button class="notification-close">&times;</button>
        `;

        // Add to container
        notificationContainer.appendChild(notification);

        // Add close button functionality
        const closeButton = notification.querySelector('.notification-close');
        closeButton.addEventListener('click', function() {
            notification.remove();
        });

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
});
