<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Security Training Courses Bradford | Get Licensed Fast</title>
    <meta name="robots" content="index, follow">
    <meta name="description"
        content="Join accredited SIA security training courses in Bradford. Fast-track your license with expert instruction in door supervision, CCTV, and more.">
    <?php include "includes/head.php" ?>

    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #2d3748;
            --accent-color: #e53e3e;
            --light-gray: #f7fafc;
            --border-color: #e2e8f0;
            --text-color: #2d3748;
            --text-light: #718096;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .cart-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
            margin: 30px 0;
        }

        @media (min-width: 768px) {
            .cart-container {
                flex-direction: row;
            }
        }

        .cart-items {
            flex: 1;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }

        .cart-summary {
            width: 100%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }

        @media (min-width: 768px) {
            .cart-summary {
                width: 35%;
            }
        }

        .cart-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .cart-item {
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            border-bottom: 1px solid var(--border-color);
        }

        @media (min-width: 640px) {
            .cart-item {
                flex-direction: row;
                align-items: center;
            }
        }

        .item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 20px;
            margin-bottom: 15px;
        }

        @media (min-width: 640px) {
            .item-image {
                margin-bottom: 0;
            }
        }

        .item-details {
            flex: 1;
        }

        .item-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .item-date {
            color: var(--text-light);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .item-price {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .current-price {
            font-weight: 600;
            font-size: 18px;
        }

        .original-price {
            text-decoration: line-through;
            color: var(--text-light);
            font-size: 14px;
        }

        .discount-badge {
            color: #38a169;
            font-size: 14px;
            font-weight: 500;
        }

        .item-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 15px;
        }

        @media (min-width: 640px) {
            .item-actions {
                justify-content: flex-start;
                gap: 20px;
                margin-top: 0;
            }
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }

        .qty-btn {
            background: var(--light-gray);
            border: none;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
        }

        .qty-display {
            width: 40px;
            text-align: center;
            font-weight: 500;
        }

        .remove-btn {
            color: var(--accent-color);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            text-decoration: underline;
        }

        .cart-summary-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .promo-section {
            margin: 20px 0;
            padding: 15px;
            background: var(--light-gray);
            border-radius: 6px;
        }

        .promo-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .promo-form {
            display: none;
            margin-top: 10px;
        }

        .promo-form.active {
            display: block;
        }

        .promo-input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .apply-promo-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .total-row {
            font-weight: 600;
            font-size: 18px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .vat-note {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 5px;
            text-align: right;
        }

        .checkout-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 4px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .checkout-btn:hover {
            background: var(--secondary-color);
        }

        .empty-cart {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-cart p {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .continue-shopping {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
        }

        .feature-list {
            list-style: none;
            margin: 15px 0;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .feature-list li::before {
            content: "✔";
            color: #38a169;
            margin-right: 8px;
            font-weight: bold;
        }

        .info-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--text-light);
            color: white;
            text-align: center;
            line-height: 16px;
            font-size: 12px;
            margin-left: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCQD3VJQ" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <div>

        <?php include "includes/header.php" ?>
        <div class="container">
            <div class="cart-container">
                <!-- Cart Items Section -->
                <div class="cart-items">
                    <h2 class="cart-title">Order Summary</h2>

                    <!-- Subscription Plan Section -->
                    <div id="subscriptionPlan"
                        class="cart-item flex items-center justify-between rounded-lg p-4 my-4 shadow-sm bg-gray-50">
                        <div class="flex items-center gap-4">

                            <!-- Plan Details -->
                            <div>
                                <h3 id="planName" class="text-lg font-semibold text-gray-700">Subscription Plan</h3>
                                <p class="text-gray-600 text-sm">Access premium courses based on your subscription level
                                </p>
                                <p class="text-gray-500 text-xs mt-1">(Includes VAT)</p>
                            </div>
                        </div>

                        <!-- Price & Quantity -->
                        <div class="flex flex-col items-end gap-2">
                            <div id="planPrice" class="text-lg font-bold">£0.00</div>

                        </div>
                    </div>

                    <?php if (!empty($image)): ?>
                        <div class="mt-4 text-center">
                            <p class="text-gray-700 mb-2">Course Image:</p>
                            <img src="uploads/<?php echo htmlspecialchars($image); ?>"
                                class="w-48 h-48 object-cover mx-auto rounded-lg border">
                        </div>
                    <?php endif; ?>

                    <div id="cartItemsContainer">
                        <!-- Other cart items inserted dynamically -->
                    </div>
                </div>

                <!-- Cart Summary Section -->
                <div class="cart-summary">
                    <h3 class="cart-summary-title">CART TOTALS</h3>

                    <div class="promo-section">
                        <div class="promo-title cursor-pointer flex justify-between items-center" id="promoToggle">
                            <span>Apply promo or referral code</span>
                            <span>▼</span>
                        </div>
                        <div class="promo-form hidden mt-2" id="promoForm">
                            <input type="text" class="promo-input border rounded px-3 py-2 w-full mb-2"
                                placeholder="Enter code">
                            <button
                                class="apply-promo-btn bg-blue-600 text-white px-4 py-2 rounded w-full">Apply</button>
                        </div>
                    </div>

                    <div class="summary-row flex justify-between mt-4">
                        <span>Subtotal</span>
                        <span id="cartSubtotal">£199.00</span>
                    </div>

                    <div class="summary-row flex justify-between font-bold mt-2">
                        <span>Order Total</span>
                        <span id="cartTotal">£199.00</span>
                    </div>
                    <div class="vat-note text-xs text-gray-500 mt-1">(Price inclusive of VAT)</div>

                    <button id="checkoutBtn"
                        class="checkout-btn mt-4 w-full bg-yellow-800 text-white py-3 rounded-lg font-semibold hover:bg-yellow-900 transition">
                        PROCEED TO CHECKOUT
                    </button>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Retrieve cart items from localStorage
            const cartPackage = JSON.parse(localStorage.getItem('cartPackage')) || {};





            const container = document.getElementById('cartItemsContainer');
            const subtotalEl = document.getElementById('cartSubtotal');
            const totalEl = document.getElementById('cartTotal');
            const promoForm = document.getElementById('promoForm');
            const promoToggle = document.getElementById('promoToggle');

            // Toggle promo code form
            promoToggle.addEventListener('click', function () {
                promoForm.classList.toggle('active');
            });

            // If the cart is empty, display an empty cart message
            if (!cartPackage.course) {
                container.innerHTML = `
                    <div class="empty-cart">
                        <p>Your cart is empty.</p>
                        <a href="courses" class="continue-shopping">Continue Shopping</a>
                    </div>
                `;
                subtotalEl.textContent = '£0.00';
                totalEl.textContent = '£0.00';
                return;
            }

            // Calculate prices
            const planPrice = parseFloat(cartPackage.package_price) || 0;
            const quantity = cartPackage.quantity || 1;
            const originalPrice = parseFloat(cartPackage.original_price) || 0;
            const total = (planPrice * quantity);
            const saveCount = (originalPrice - planPrice).toFixed(2);

            // Display cart item
            container.innerHTML = `
                <div class="cart-item gap-4">
                  <img src="" id="courseImage" 
                             class="w-48 h-48 object-cover mx-auto rounded-lg border" 
                             alt="Course Image">
                    <div class="item-details">
                        <h3 class="item-title">${cartPackage.course || 'Course Title'}</h3>
                        <p class="item-date">${cartPackage.date || 'Date not specified'}</p>
                        <div class="item-price">
                            <span class="current-price">£${planPrice.toFixed(2)}</span>
                            <span class="original-price">£${parseFloat(originalPrice).toFixed(2)}</span>
                            <span class="discount-badge">SAVE £${saveCount}</span>
                        </div>
                        <ul class="feature-list">
                            <li>Learner Pack <span class="info-icon">i</span></li>
                            <li>Certificate fees <span class="info-icon">i</span></li>
                        </ul>
                    </div>
                    <div class="item-actions">
                        <div class="quantity-controls">
                            <button class="qty-btn change-qty" data-action="decrease">-</button>
                            <span class="qty-display">${quantity}</span>
                            <button class="qty-btn change-qty" data-action="increase">+</button>
                        </div>
                        <button class="remove-btn">Remove</button>
                    </div>
                </div>
            `;




            if (cartPackage.package === 'Platinum') {
                planName = "Platinum Subscription Plan";
                planColor = "text-gray-900 bg-gray-200";
            } else if (cartPackage.package === 'Gold') {
                planName = "Gold Subscription Plan";
                planColor = "text-yellow-800 bg-yellow-50";
            } else if (cartPackage.package === 'Bronze') {
                planName = "Bronze Subscription Plan";
                planColor = "text-orange-800 bg-orange-50";
            } else {
                planName = "Basic Plan";
                planColor = "text-gray-700 bg-gray-50";
            }

            // Update HTML dynamically
            document.getElementById('planName').textContent = planName;
            document.getElementById('planName').className = `text-lg font-semibold ${planColor}`;
            document.getElementById('planPrice').textContent = `£${(planPrice).toFixed(2)}`;

            // Update subtotal and total
            subtotalEl.textContent = `£${total.toFixed(2)}`;
            totalEl.textContent = `£${total.toFixed(2)}`;

            if (cartPackage.course) {
                fetch("image-api.php/?course_name=" + encodeURIComponent(cartPackage.course))
                    .then(res => res.json())
                    .then(data => {
                        if (data.image) {
                            const container = document.getElementById('cartItemsContainer');
                            const imgElement = document.getElementById('courseImage');
                            imgElement.src = data.image;
                        }
                    })
                    .catch(err => console.error("Error fetching image:", err));
            }

            // Quantity change and remove handlers
            container.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-btn')) {
                    // Clear cart from localStorage
                    localStorage.removeItem('cartPackage');
                    location.reload();
                }

                if (e.target.classList.contains('change-qty')) {
                    // Change quantity of the cart item
                    const action = e.target.dataset.action;
                    let qty = parseInt(cartPackage.quantity) || 1;
                    qty = action === 'increase' ? qty + 1 : Math.max(1, qty - 1);
                    cartPackage.quantity = qty;
                    localStorage.setItem('cartPackage', JSON.stringify(cartPackage));
                    location.reload();
                }
            });

            // Checkout button handler
            document.getElementById('checkoutBtn').addEventListener('click', () => {
                // Save cart total to localStorage for checkout page
                localStorage.setItem('cartTotal', total.toFixed(2));

                // Navigate to checkout page
                window.location.href = 'checkout';
            });
        });
    </script>
</body>

</html>