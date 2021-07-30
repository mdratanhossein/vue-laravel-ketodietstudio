<template>
    <div id="payment-popup" class="mx-auto m-8 payment-popup">
        <div class="vx-row payment-title pl-5">
            <strong>Get your plan</strong>
        </div>
        <vs-divider class="my-6" />
        <div class="vx-row payment-method w-full ml-20 mr-20">
            <PayPal
            :amount="paypalAmount"
            currency="RUB" 
            :button-style="myStyle"
            :client="credentials"
            env="sandbox" 
            @payment-authorized="payment_authorized_cb"
            @payment-completed="payment_completed_cb"
            @payment-cancelled="payment_cancelled_cb"
            />
        </div>
        <vs-divider class="my-6" />
        <div id="stripe_payment_form">
            <section class="row payment-form">
                <h5 class="#e0e0e0 grey lighten-4">
                    Card Payment
                    <span class="right">${{stripeAmount}}</span>
                </h5>

                <div class="error red center-align white-text">{{stripeValidationError}}</div>

                <div class="col s12 card-element">
                    <label>Card Number</label>
                    <div id="card-number-element" class="input-value"></div>
                </div>

                <div class="col s6 card-element">
                    <label>Expiry Date</label>
                    <div id="card-expiry-element"></div>
                </div>

                <div class="col s6 card-element">
                    <label>CVC</label>
                    <div id="card-cvc-element"></div>
                </div>

                <div class="col s12 place-order-button-block">
                    <button class="btn col s12 #e91e63 pink" @click="placeOrderButtonPressed">Place Order</button>
                </div>
            </section>
        </div>
        <vs-divider class="my-6" />
        <div class="vx-row payment-footer pl-5">
            <strong>Total:&nbsp;<span class="text-primary">{{getTotalPrice()}}</span>&nbsp;&nbsp;billed every&nbsp;<span class="text-primary">{{getMonthValue()}}</span>&nbsp;months</strong>
        </div>
    </div>
    
</template>

<style lang="scss">
#stripe_payment_form {
    font-size: 14.5px;
    line-height: 1.5;
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    font-weight: normal;
    color: rgba(0,0,0,0.87);
    box-sizing: inherit;
    padding: 0 10px;

    h1, h2, h3, h4, h5, h6 {
        font-weight: 400;
        line-height: 1.3;
    }

    h5 {
        font-size: 1.64rem;
        line-height: 110%;
        margin: 1.0933333333rem 0 .656rem 0;
    }

    .center, .center-align {
        text-align: center;
    }

    .white-text {
        color: #fff !important;
    }
    .red {
        background-color: #F44336 !important;
    }

    .row .col.s12 {
        width: 100%;
        margin-left: auto;
        left: auto;
        right: auto;
    }

    .row .col.s6 {
        width: 50%;
        margin-left: auto;
        left: auto;
        right: auto;
    }

    .row .col {
        float: left;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        padding: 0 .75rem;
        min-height: 1px;
    }
    .card-element {
        margin-top: 5px;
    }

    label {
        font-size: .8rem;
        color: #9e9e9e;
    }

    .right {
        float: right !important;
    }

    .grey.lighten-4 {
        background-color: #f5f5f5 !important;
    }
    section {
        display: block;
    }

    .payment-form {
        max-width: 400px;
        margin: 20px auto;
        border: 1px solid #ececec;
    }

    .payment-form h5 {
        margin: 0;
        padding: 10px;
        font-size: 1.2rem;
    }

    .card-element {
        margin-top: 5px;
    }

    #card-number-element,
    #card-expiry-element,
    #card-cvc-element {
        background: white;
        padding: 5px;
        border: 1px solid #ececec;
        height: 30px;
    }
    .place-order-button-block {
        margin: 10px 0 20px 0px;
    }

    .btn, .btn-large, .btn-small {
        text-decoration: none;
        color: #fff;
        background-color: #26a69a;
        text-align: center;
        letter-spacing: .5px;
        -webkit-transition: background-color .2s ease-out;
        transition: background-color .2s ease-out;
        cursor: pointer;
    }
    .btn, .btn-large, .btn-small, .btn-floating, .btn-large, .btn-small, .btn-flat {
        font-size: 14px;
        outline: 0;
    }
    .btn, .btn-large, .btn-small, .btn-flat {
        border: none;
        border-radius: 2px;
        display: inline-block;
        height: 36px;
        line-height: 36px;
        padding: 0 16px;
        text-transform: uppercase;
        vertical-align: middle;
        -webkit-tap-highlight-color: transparent;
    }
    .z-depth-1, nav, .card-panel, .card, .toast, .btn, .btn-large, .btn-small, .btn-floating, .dropdown-content, .collapsible, .sidenav {
        -webkit-box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
        box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
    }
    .pink {
        background-color: #e91e63 !important;
    }
    button, input, optgroup, select, textarea {
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    }
    button, html [type="button"], [type="reset"], [type="submit"] {
        -webkit-appearance: button;
    }
    button, select {
        text-transform: none;
    }
    button, input {
        overflow: visible;
    }
    button, input, optgroup, select, textarea {
        font-family: sans-serif;
        font-size: 100%;
        line-height: 1.15;
        margin: 0;
    }
    *, *:before, *:after {
        -webkit-box-sizing: inherit;
        box-sizing: inherit;
    }
    user agent stylesheet
    button {
        -webkit-appearance: button;
        -webkit-writing-mode: horizontal-tb !important;
        text-rendering: auto;
        color: buttontext;
        letter-spacing: normal;
        word-spacing: normal;
        text-transform: none;
        text-indent: 0px;
        text-shadow: none;
        display: inline-block;
        text-align: center;
        align-items: flex-start;
        cursor: default;
        background-color: buttonface;
        box-sizing: border-box;
        margin: 0em;
        font: 400 13.3333px Arial;
        padding: 1px 6px;
        border-width: 2px;
        border-style: outset;
        border-color: buttonface;
        border-image: initial;
    }
}

.payment-title {
    justify-content: left;
    margin: 4px !important;
    font-size: 18px;
}
.payment-footer {
    justify-content: left;
    margin: 4px !important;
}
.payment-method {
    justify-content: center;
    margin: 4px !important;
    // padding-top: 50px;
    // height: 180px;
}
</style> 

<script>

import PayPal from "vue-paypal-checkout"

export default {
    name: 'PaymentPopup',
    components: {
        PayPal,
        // 'vue-stripe-checkout': StripeCheckout,
        // Card, CardNumber, CardExpiry, CardCvc,
    },
    props: {
        planId: Number,
        summaryId: String,
    },
    computed: {        
        paypalAmount() {
            let usd2rub = 78.13;
            if(this.planId == 0)
                return (33 * usd2rub).toString();
            else if(this.planId == 1)
                return (66 * usd2rub).toString();
            else if(this.planId == 2)
                return (46 * usd2rub).toString();
            else 
                return '';
        },
        stripeAmount() {
            if(this.planId == 0)
                return 33
            else if(this.planId == 1)
                return 66
            else if(this.planId == 2)
                return 46
        }
    },
    data () {
        return { 
            stripe: null,
            cardNumberElement: null,
            cardExpiryElement: null,
            cardCVCElement: null,
            stripeValidationError: "",
            credentials: {
                sandbox: 'AXUwIbqvN-QknLIgEXuRo4bJbn7ydIZ5_RsFNyd91SwmyDJBSOJ-Yjg6o5XeZ_UNvO3JvS0xbHjRuMru',
                production: 'AaZU9EwXR8WShhdm6SmkBcU2xYO46wGbgw1tl4KDkTy594JufZ06AeElg9f2QuFr1RVU1wYefXbEtMbF'
            },
            myStyle: {
                label: 'checkout',
                size:  'medium',
                shape: 'pill',
                color: 'gold'
            },
            publishableKey: 'pk_test_wFJhPaCcQajibzncS7IyYTVY00T6cWOAH7',
            secretKey: 'sk_test_veARH2pu6kZjFtxzZAYWMzDg00Dxn7JVL9',
            items: [
                {
                    sku: 'sku_GsBV9LwjFEUuk1', 
                    quantity: 1
                },
                {
                    sku: 'sku_GsF9Ury3YeYzFN', 
                    quantity: 1
                },
                {
                    sku: 'sku_GsF9lQ5V5GRDdq', 
                    quantity: 1
                },
            ],
        }
    },
    created() {
        
    },
    methods: {
        createAndMountFormElements() {
            var style = {
                base: {
                    color: "#32325d",
                }
            };
            var elements = this.stripe.elements();

            this.cardNumberElement = elements.create("cardNumber", {style: style});
            this.cardNumberElement.mount("#card-number-element");

            this.cardExpiryElement = elements.create("cardExpiry", {style: style});
            this.cardExpiryElement.mount("#card-expiry-element");

            this.cardCvcElement = elements.create("cardCvc", {style: style});
            this.cardCvcElement.mount("#card-cvc-element");

            this.cardNumberElement.on("change", this.setValidationError);
            this.cardExpiryElement.on("change", this.setValidationError);
            this.cardCvcElement.on("change", this.setValidationError);

        },
        setValidationError(event) {
            this.stripeValidationError = event.error ? event.error.message : "";
        },
        placeOrderButtonPressed() {
            this.$root.$emit("start_stripe_payment")

            this.stripe.createToken(this.cardNumberElement).then(result => {
                if (result.error) {
                    this.stripeValidationError = result.error.message
                    this.$root.$emit("end_stripe_payment")

                } else {
                    let stripeObject = {
                        summaryId: this.summaryId,
                        plan: this.planId,
                        token: result.token.id
                    };

                    this.stripeTokenHandler(stripeObject);
                }
            });
        },

        stripeTokenHandler(stripeObject) {
            this.$store.dispatch("keto/stripe_payment_request", stripeObject).then((response) => {
                if(response.data.success) {
                    this.$router.push({name: 'keto-success-payment', params: { id: response.data.summaryId }})
                } else {
                    this.stripeValidationError = response.data.error
                }

                this.$root.$emit("end_stripe_payment")
            })
        },
        payment_authorized_cb(response) {
        },
        payment_completed_cb(response) {
            let paymentInfo = {
                summaryId: this.$store.state.keto.summaryId,
                paymentId: response.id,
                method: 0, // 0=>paypal, 1=>stripe
                email_addr: response.payer.payer_info.email,
                option: this.planId,
                amount: response.transactions[0].amount.total,
                currency: response.transactions[0].amount.currency,
                detail: JSON.stringify(response),
            }
            this.$root.$emit("payment_paypal_completed", {
                data: paymentInfo
            }) 
        },
        payment_cancelled_cb(response) {
        },
        getTotalPrice() {
            if(this.planId == 0)
                return '$ 33.00'
            else if(this.planId == 1)
                return '$ 66.00'
            else if(this.planId == 2)
                return '$ 46.00'
        },
        getMonthValue() {
            if(this.planId == 0)
                return '3'
            else if(this.planId == 1)
                return '12'
            else if(this.planId == 2)
                return '6'
        },
    },
    watch: {
    },
    mounted() {
        this.stripe = Stripe(this.publishableKey)
        this.createAndMountFormElements()
    }
}
</script>