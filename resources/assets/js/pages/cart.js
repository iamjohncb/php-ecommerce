(function () {
    'use strict';

    ACMESTORE.product.cart = function () {

        var Stripe = StripeCheckout.configure({
            key: $('#properties').data('stripe-key'),
            locale: "auto",
            image: "https://s3.amazonaws.com/stripe-uploads/acct_1AFi4XD6RN5QLHpHmerchant-icon-1496449193909-logo.PNG",
            token: function (token) {
                var data = $.param({stripeToken: token.id, stripeEmail:token.email});
                axios.post('/cart/payment', data).then(function (response) {
                    $(".notify").css("display", 'block').delay(4000).slideUp(300)
                        .html(response.data.success);
                    app.displayItems(200);
                }).catch(function (error) {
                    console.log(error);
                })
            }
        });

        var app = new Vue({
            el: '#shopping_cart',
            data: {
                items: [],
                cartTotal: [],
                loading: false,
                fail: false,
                message: '',
                authenticated: false,
                amountInCents: 0
            },
            methods: {
                displayItems: function (time) {
                    this.loading = true;
                    setTimeout(function () {
                        axios.get('/cart/items').then(function (response) {
                            if(response.data.fail){
                                app.fail = true;
                                app.message = response.data.fail;
                                app.loading = false;
                            }else{
                                app.items = response.data.items;
                                app.cartTotal = response.data.cartTotal;
                                app.loading = false;
                                app.authenticated = response.data.authenticated;
                                app.amountInCents = response.data.amountInCents;
                            }
                        });
                    }, time);
                },
                updateQuantity: function (product_id, operator) {
                    var postData = $.param({product_id:product_id, operator:operator});
                    axios.post('/cart/update-qty', postData).then(function (response) {
                        app.displayItems(200);
                        app.paypalCheckout();
                    })
                },
                removeItem: function (index) {
                    var postData = $.param({item_index:index});
                    axios.post('/cart/remove-item', postData).then(function (response) {
                        $(".notify").css("display", 'block').delay(4000).slideUp(300)
                            .html(response.data.success);
                        app.displayItems(200);
                        app.paypalCheckout();
                    })
                },
                emptyCart: function () {
                    axios.post('/cart/empty').then(function (response) {
                        $(".notify").css("display", 'block').delay(4000).slideUp(300)
                            .html(response.data.success);
                        app.displayItems(10);
                        app.paypalCheckout();
                    });
                },
                checkout: function (){
                    Stripe.open({
                        name: "ACME Store, Inc.",
                        description: "Shopping Cart Items",
                        email: $('#properties').data('customer-email'),
                        amount: app.amountInCents,
                        zipCode: true,
                        currency: 'USD'
                    });
                },
                paypalCheckout: function () {
                       setTimeout(function (){
                           paypal.Button.render({
                               env: 'sandbox',

                               commit: true, // Show a 'Pay Now' button

                               style: {
                                   color: 'gold',
                                   size: 'small'
                               },

                               payment: function(data) {

                               },

                               onAuthorize: function(data) {

                               }
                           }, '#paypalBtn');
                       },2000);
                }
            },
            created: function () {
                this.displayItems(2000);
            },
            mounted: function () {
                this.paypalCheckout();
            }
        });
    };
})();