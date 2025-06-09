$(document).ready(() => {
    loadProducts();
    updateCartDisplay();
});

function loadProducts() {
    $.ajax({
        url: 'api_read.php',
        method: 'GET',
        dataType: 'json',
        success: function(products) {
            let html = '';
            products.forEach(product => {
                html += `
                    <div class="product-item" onclick="selectProduct(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.price})">
                        <img src="${product.img || 'product-items/placeholder.png'}" alt="${product.name}" class="img-fluid">
                        <div class="product-info">
                            <h4>${product.name}</h4>
                            <h5>${numberWithCommas(product.price)} THB</h5>
                        </div>
                    </div>
                `;
            });
            $("#productbox").html(html);
        },
        error: function(xhr, status, error) {
            console.error("Error loading products:", error);
            $("#productbox").html('<p>Failed to load products. Please refresh the page.</p>');
        }
    });
}

function selectProduct(mid, mname, mprice) {
    $.ajax({
        url: 'add.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id: mid, name: mname, price: mprice }),
        success: function(response) {
            updateCartDisplay(JSON.parse(response).cart, JSON.parse(response).total);
        },
        error: function(xhr, status, error) {
            console.error("Error adding product to cart:", error);
            alert("Error adding product to cart. Please try again.");
        }
    });
}

function updateCartDisplay(cart, total) {
    if (!cart) {
        $.ajax({
            url: 'get.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                renderCart(response.cart, response.total);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching cart data:", error);
            }
        });
    } else {
        renderCart(cart, total);
    }
}

function renderCart(cart, total) {
    var html = '';
    if (!cart || cart.length === 0) {
        html = '<p class="text-center">โปรดเลือกรายการ</p>';
    } else {
        cart.forEach(item => {
            var itemTotal = item.price * item.count;
            html += `
                <div class="list-item" data-index="${cart.indexOf(item)}">
                    <div class="d-flex justify-content-between">
                        <span>[x${item.count}] ${item.name}</span>
                        <span>${numberWithCommas(itemTotal)} THB</span>
                    </div>
                    <button class="btn btn-sm btn-danger remove-item" data-index="${cart.indexOf(item)}">Remove</button>
                </div>
            `;
        });
        html += `
            <div class="list-item list-summary">
                <div class="d-flex justify-content-between">
                    <strong>รวมราคา</strong>
                    <strong>${numberWithCommas(total)} THB</strong>
                </div>
            </div>
        `;
    }
    $("#listbox").html(html);
}

function numberWithCommas(x) {
    x = parseFloat(x).toFixed(2);
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function clearlist() {
    $.ajax({
        url: 'clear.php',
        method: 'POST',
        dataType: 'json',
        success: function(response) {
            $("#listbox").html('<p class="text-center">โปรดเลือกรายการ</p>');
        },
        error: function(xhr, status, error) {
            console.error("Error clearing cart:", error);
            alert("Error clearing cart. Please try again.");
        }
    });
}

function printlist() {
    $.ajax({
        url: 'get.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.cart.length > 0) {
                var orderData = { items: response.cart, total_amount: response.total };
                $.ajax({
                    url: 'api_create.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(orderData),
                    success: function(response) {
                        $.ajax({
                            url: 'set.php',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({ key: 'order_id', value: response.order_id }),
                            complete: function() {
                                window.location.href = 'slip.php';
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving order:', error);
                        alert('Error saving order. Please try again.');
                    }
                });
            } else {
                alert('Please select at least one item.');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching cart data:", error);
            alert("Error processing order. Please try again.");
        }
    });
}