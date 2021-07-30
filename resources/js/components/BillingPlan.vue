<template>
    <div :class="{active: isActive, billingPlan: optionValue, 'pricing-option': true, 'mt-5': true}" @click="callback($event)">
        <div class="tick">
            <i>
                <i class="mt-2 fas fa-check text-white" />                
            </i>
        </div>
        <div class="option-title text-primary">
            <strong v-if="isActive">
                {{planTitle}}
            </strong>
            <p v-else>
                {{planTitle}}
            </p>
            <div class="billing-period text-dark">{{getTotalPrice}} charged every {{planTitle}}</div>
        </div>
        <div class="option-price single-month currency-USD">
            <div class="plan-price">{{ planPrice }}</div>
            <div class="per-week">per week</div>
            <div class="old-price">$5</div>
        </div>
    </div>
</template>

<style lang="scss">
.plan-price {
    // font-size: 14px;
}
.option-price .old-price {
    position: absolute;
    top: 2px;
    font-family: Karla,Montserrat;
    font-style: normal;
    font-weight: 400;
    width: 100%;
    font-size: 18px!important;
    line-height: 22px!important;
    text-align: center!important;
    letter-spacing: 1.1875px!important;
    color: #444!important;
    mix-blend-mode: normal!important;
    opacity: .5;
}
.old-price, .pricing {
    color: #56468f;
    font-family: Karla,Montserrat;
    text-align: center;
    letter-spacing: 1.19px;
}
.old-price {
    font-size: 32px;
    margin-top: -10px;
    text-decoration: line-through;
    margin-bottom: 30px;
}
.old-price, .pricing {
    text-align: left;
}
.per-week {
    position: absolute;
    font-size: 11px;
    top: 48px;
    left: 0;
    min-width: 100%;
    width: 80px;
    text-align: center;
}
.pricing-option .option-price {
    padding-top: 22px!important;
}
.option-price {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    font-family: Karla,Montserrat;
    font-style: normal;
    -ms-flex-item-align: stretch;
    align-self: stretch;
    font-weight: 400;
    font-size: 30px;
    padding-top: 15px;
    position: relative;
    line-height: 35px;
    text-align: center;
    letter-spacing: 1.1875px;
    color: #444;
}
.option-title .billing-period {
    margin-top: -2px;
    font-size: 12px;
    opacity: .7;
}
.option-title {
    -webkit-box-flex: 3;
    -ms-flex: 3;
    flex: 3;
    font-family: Karla,Montserrat;
    font-style: normal;
    font-weight: 400;
    font-size: 22px;
    line-height: 27px;
    letter-spacing: -.2px;
    color: #444;
}
.pricing-option {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: stretch;
    -ms-flex-pack: stretch;
    justify-content: stretch;
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
    cursor: pointer;
    position: relative;
    border: 2px solid rgba(68,68,68,.243635);
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border-radius: 4px;
    padding: 20px;
    margin-bottom: 20px;
}
.pricing-option.active {
    border: 2px solid #786ba5;
}
.pricing-option {
    min-height: 120px;
}
.pricing-option .tick {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    padding-top: 10px;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
}
.pricing-option.active .tick i {
    background: #ff3464;
}

.pricing-option .tick i {
    width: 30px;
    height: 30px;
    background: rgba(68,68,68,.104977);
    display: block;
    text-align: center;
    border-radius: 50%;
}
</style>

<script>
export default {
    props: {
        optionValue: String,
    },
    mounted() {
        if(this.optionValue == 1) 
            this.isActive = true
        this.$root.$on("billingPlanSelected", (payload) => {
            if(payload.index == this.optionValue)
                this.isActive = true
            else    
                this.isActive = false
        })
    },
    computed: {
        planTitle() {
            if(this.optionValue == '0') {
                return '3 months'
            } else if(this.optionValue == '1') {
                return '12 months'
            } else if(this.optionValue == '2') {
                return '6 months'
            }
        },
        planPrice() {
            if(this.optionValue == '0') {
                return '$2.5'
            } else if(this.optionValue == '1') {
                return '$1.25'
            } else if(this.optionValue == '2') {
                return '$1.75'
            }
        },
        getTotalPrice() {
            if(this.optionValue == 0)
                return '$ 33.00'
            else if(this.optionValue == 1)
                return '$ 66.00'
            else if(this.optionValue == 2)
                return '$ 46.00'
        },
    },
    methods: {
        callback: function(e) {
            // this.isActive = !this.isActive
            this.$emit('click', e);
        },
    },
    data() {
        return {
            isActive: false,            
        }
    }
}
</script>