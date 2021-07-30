<template>
    <div class="mx-auto w-full text-center" id="summary_info">
        <div class="mx-auto lg:w-2/4 max-w-screen-md">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
            </div>
        </div>

        <modals-container/>

        <div class="mx-auto lg:w-2/4 max-w-screen-md">            
            <div class="vx-col w-full mb-base">
                <div class="mx-auto text-center mb-10">
                    <h1 class="font-bold text-primary">Get your personalized Keto Diet</h1>
                    <h3 class="font-bold text-dark mt-5">The most popular Keto diet! Over 51 567 plans ordered</h3>
                    <vs-button size="large" class="mt-5 mb-6 w-full" color="primary">
                        <strong>The discount expires in</strong> <br>
                        <span class="time is-pulsing">{{remainedTimeStr}}</span>
                    </vs-button>                        
                </div>
                <div class="vx-row">
                    <div class="vx-col w-full sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2 mb-base no-border">
                        <h3>Select your plan</h3>
                        <billing-plan @click="selectPlan(0)" optionValue=0 />
                        <billing-plan @click="selectPlan(1)" optionValue=1 />
                        <billing-plan @click="selectPlan(2)" optionValue=2 />
                        <vs-button @click="subscribe()" type="relief" size="medium" class="mt-5 mb-6 w-full" color="primary">
                            <strong>Click here to get your plan</strong>
                        </vs-button>
                    </div>
                    <div class="vx-col w-full sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2 mb-base no-border">
                        <h3 class="text-left mb-5">All plans include</h3>
                        <ul>
                            <li class="e-feature">
                                <i class="fas fa-check" style=""></i> Professional Keto nutrition analysis
                            </li>
                            <li class="e-feature">
                                <i class="fas fa-check" style=""></i> Personalized Keto meal plan
                            </li>
                            <li class="e-feature">
                                <i class="fas fa-check" style=""></i> FREE BONUS: Keto for beginners e-book
                            </li>
                            <li class="e-feature">
                                <i class="fas fa-check" style=""></i> Easy-to-follow, delicious recipes
                            </li>
                            <li class="e-feature">
                                <i class="fas fa-check" style=""></i> Simple ingredients from any store
                            </li>
                            <li class="e-feature">
                                <i class="fas fa-check" style=""></i> 24/7 nutritionist support
                            </li>
                            <li class="e-feature">
                                <i class="fas fa-check" style=""></i> Digital access on any device
                            </li>
                            <li class="e-feature">
                                <i class="fas fa-check" style=""></i> Printable grocery list
                            </li>
                        </ul>

                        <div class="mt-10">
                            <div class="text-center"><img class="w-2/4" src="@assets/images/money-back@2x.png" alt="100% money back" /></div>
                            <h3 class="text-left mb-5">100% Money Back Guarantee</h3>
                            <p>We’re certain that you’ll love the plan we create for you. If for any reason you aren’t fully satisfied, just send us a quick email and we will refund your purchase, no questions asked.</p>
                        </div>

                        <vs-button @click="subscribe()" type="relief" size="medium" class="mt-5 mb-6 w-full sm:invisible" color="primary">
                            <strong>Click here to get your plan</strong>
                        </vs-button>
                    </div>
                </div>                
            </div>
        </div>

        <div class="mx-auto lg:w-4/5 max-w-screen-md">            
            <VueSlickCarousel v-if="isDesktop" v-bind="settings1">
                <!-- <div v-for="i in [currentIndex]" :key="i">
                    <img class="w-full" :src="currentImg" :alt="currentAlt" />
                    <p class="slide-description">{{ currentDescription }}</p>
                </div> -->
                <div class="slider-item">
                    <img class="w-full" src="@assets/images/slides/checkout-slider-img1.jpg" alt="1" />
                    <p class="slide-description">I have followed your instructions for the last 5 weeks or so, and have effortlessly lost over 22 pounds. I haven't felt this great in many years, and will continue to eat this way from now on.</p>
                    <b>Victoria P.</b>
                </div>
                <div class="slider-item">
                    <img class="w-full" src="@assets/images/slides/checkout-slider-img2.jpg" alt="2" />
                    <p class="slide-description">I have followed your instructions for the last 5 weeks or so, and have effortlessly lost over 22 pounds. I haven't felt this great in many years, and will continue to eat this way from now on.</p>
                    <b>Victoria P.</b>
                </div>
                <div class="slider-item">
                    <img class="w-full" src="@assets/images/slides/checkout-slider-img3.jpg" alt="3" />
                    <p class="slide-description">I have followed your instructions for the last 5 weeks or so, and have effortlessly lost over 22 pounds. I haven't felt this great in many years, and will continue to eat this way from now on.</p>
                    <b>Victoria P.</b>
                </div>
                <div class="slider-item">
                    <img class="w-full" src="@assets/images/slides/checkout-slider-img4.jpg" alt="1" />
                    <p class="slide-description">I have followed your instructions for the last 5 weeks or so, and have effortlessly lost over 22 pounds. I haven't felt this great in many years, and will continue to eat this way from now on.</p>
                    <b>Victoria P.</b>
                </div>
            </VueSlickCarousel>

            <VueSlickCarousel v-else v-bind="settings2">
                <div class="slider-item">
                    <img class="w-full" src="@assets/images/slides/checkout-slider-img1.jpg" alt="1" />
                    <p class="slide-description">I have followed your instructions for the last 5 weeks or so, and have effortlessly lost over 22 pounds. I haven't felt this great in many years, and will continue to eat this way from now on.</p>
                    <b>Victoria P.</b>
                </div>
                <div class="slider-item">
                    <img class="w-full" src="@assets/images/slides/checkout-slider-img2.jpg" alt="2" />
                    <p class="slide-description">I have followed your instructions for the last 5 weeks or so, and have effortlessly lost over 22 pounds. I haven't felt this great in many years, and will continue to eat this way from now on.</p>
                    <b>Victoria P.</b>
                </div>
                <div class="slider-item">
                    <img class="w-full" src="@assets/images/slides/checkout-slider-img3.jpg" alt="3" />
                    <p class="slide-description">I have followed your instructions for the last 5 weeks or so, and have effortlessly lost over 22 pounds. I haven't felt this great in many years, and will continue to eat this way from now on.</p>
                    <b>Victoria P.</b>
                </div>
                <div class="slider-item">
                    <img class="w-full" src="@assets/images/slides/checkout-slider-img4.jpg" alt="1" />
                    <p class="slide-description">I have followed your instructions for the last 5 weeks or so, and have effortlessly lost over 22 pounds. I haven't felt this great in many years, and will continue to eat this way from now on.</p>
                    <b>Victoria P.</b>
                </div>
            </VueSlickCarousel>    
        </div>
    </div>
</template>

<style lang="scss">
.checkout-carousel {
    font-size: 14px;
    line-height: 24px;
    text-align: center;
    color: #494950;
    width: 100%;

    .container {
        padding: 0 50px;
        max-width: 1240px;
        margin: 0 auto;
        width: 100%;
        @media (max-width: 768px) { padding: 0 10px; }

        .slick-dots {
            position: absolute;
            bottom: -25px;
            display: block;
            width: 100%;
            padding: 0;
            margin: 0;
            list-style: none;
            text-align: center;

            li {
                display: inline-block;
                width: auto;
                height: auto;
                margin: 0 10px;
            }

            li.slick-active button {
                background: #000;
            }

            button {
                width: 8px;
                height: 8px;
                background: #c4c4c4;
                border-radius: 50%;
                font-size: 0;
                line-height: 0;
                display: block;
                padding: 5px;
                color: transparent;
                border: 0;
                outline: none;
                cursor: pointer;
            }
        }

        h2 {
            padding-bottom: 45px;
            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            line-height: 32px;
            color: #161622;
        }

        .slick-list, .slick-slider {
            position: relative;
            display: block;
        }

        .slick-slider {
            box-sizing: border-box;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
            -khtml-user-select: none;
            -ms-touch-action: pan-y;
            touch-action: pan-y;
            -webkit-tap-highlight-color: transparent;
        }

        .slick-dotted.slick-slider {
            margin-bottom: 30px;
        }

        .slick-slider .slick-list, .slick-slider .slick-track {
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
        }

        .slick-list {
            overflow: hidden;
            margin: 0;
            padding: 0;

            .checkout-carousel__item {
                width: 380px;
                @media (max-width: 768px) { width: 100%; }
            }

            .slick-track {
                position: relative;
                top: 0;
                left: 0;
                display: block;
                width: 2280px;       
                // @media (max-width: 768px) { width: 1920px; }        
            }

            .slick-track-mobile {
                position: relative;
                top: 0;
                left: 0;
                display: block;
                width: 100%;
            }

            .slick-initialized .slick-slide {
                display: block;
            }

            .slick-slide {
                display: block !important;
                float: left;
                height: 100%;
                min-height: 1px;
            }

            .slick-active {
                display: block !important;
            }

            article {
                padding: 0 25px;
            }

            figure {
                margin-bottom: 25px;

                img {
                    display: block;
                    margin: 0 auto;
                    width: 100%;
                    max-width: 298px;
                }
            }

            p {
                font-size: 14px;
                line-height: 24px;
                color: #494950;
                padding-bottom: 7px;
                display: block;
                margin-block-start: 1em;
                margin-block-end: 1em;
                margin-inline-start: 0px;
                margin-inline-end: 0px;
            }

            h6 {
                font-weight: 700;
                font-size: 14px;
                line-height: 24px;
                color: #494950;
                padding-bottom: 24px;
            }
        }
    }
}
.button-group {
    text-align: center;
    background: #e4e5e7;
}
#summary_info {
    .vx-card__body {
        min-height: 200px;
    }
}
.e-feature {
    margin-top: 6px;
    margin-bottom: 6px;
    margin-left: 0;
    text-align: left;
    font-family: Karla,Montserrat;
    font-style: normal;
    font-weight: 500;
    font-size: 12px;
    line-height: 24px;
    letter-spacing: .508928px;
    width: 100%;
    padding-left: 10px;
}
.e-feature .fa-check:before {
    content: "\F00C";
    font-family: FontAwesome;
    font-weight: 400;
    color: #ff3c6f; 
    font-size: 20px;
    position: relative;
    left: -5px;
}

.slider-item {
    padding: 0px 15px;
}
.slick-prev, .slick-next {
    @media (max-width:768px) { 
        display: none !important;
    }
}

.slick-prev:before, .slick-next:before {
    font-family: 'slick';
    font-size: 20px;
    line-height: 1;
    opacity: 0.75;
    color: black;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.fade-enter-active,
.fade-leave-active {
    display: block;
    transition: all 0.5s ease-in-out;
    overflow: hidden;
    visibility: visible;
    position: relative;
    // width:100%;
    opacity: 1;
}

.fade-enter,
.fade-leave-to {
    display: none;
    visibility: hidden;
    // width: 100%;
    opacity: 0;
}

p {
    padding-top: 20px;
    padding-bottom: 10px;
}
</style>

<script>
import BillingPlan from "../components/BillingPlan.vue"
import PaymentPopup from "../components/PaymentPopup.vue"

import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
  // optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

import VerticalUserNavMenu from "../components/VerticalUserNavMenu.vue"

export default {
  components: {
      BillingPlan,
      VueSlickCarousel,
      VerticalUserNavMenu,
  },
  data() {
      return {
        timer: null,
        currentIndex: 0,
        settings1: {
            "dots": true,
            "dotsClass": "slick-dots custom-dot-class",
            "edgeFriction": 0.35,
            "infinite": true,
            "speed": 500,
            "slidesToShow": 3,
            "slidesToScroll": 1,
            "adaptiveHeight": true,
        },
        settings2: {
            "dots": true,
            "dotsClass": "slick-dots custom-dot-class",
            "edgeFriction": 0.35,
            "infinite": true,
            "speed": 500,
            "slidesToShow": 1,
            "slidesToScroll": 1,
            "adaptiveHeight": true,
        },
        planIndex: 1,
      }
  },
  created() {
    if(this.$route.params.id == undefined)
        this.$router.push({name: 'page-error-404'})
    else if(this.$route.params.id.length != 32)
        this.$router.push({name: 'page-error-404'})

    this.summaryId = this.$route.params.id
    this.$store.dispatch("keto/get_summary_info", this.summaryId).then((response) => {
        if(!response.data.success || this.summaryId != response.data.summaryId) {
            this.$router.push({name: 'page-error-404'})
        } else {
            if(response.data.paymentInfo) {
                this.$router.push({name: 'keto-success-payment', params: { id: response.data.summaryId }})
            } else {
                this.$store.dispatch("keto/set_summary_info", response).then(() => {
                    this.currentTime = 0
                    this.$store.dispatch("keto/set_submit_datetime", response.data.userInfo.updated_at).then(() => {
                        this.setCurrentDateTime()
                    })
                })
            }
        }
    })
  },
  mounted() {
    this.$root.$on("payment_paypal_completed", (payload) => {
        this.$store.dispatch("keto/set_payment_info", payload.data).then((response) => {
            if(response.data.success && response.data.summaryId) {
                this.$router.push({name: 'keto-success-payment', params: { id: response.data.summaryId }})
            }
        })
    })

    this.$root.$on("start_stripe_payment", (payload) => {
        this.startLoading()
    })

    this.$root.$on("end_stripe_payment", (payload) => {
        this.closeLoading()
    })
  },
  computed: { 
    isDesktop() {
        return screen.width > 768 ? true : false
    },
    currReviews() {
        let retArr = []
        for(var i=0; i<3; i++) {
            retArr[i] = this.reviews[(this.currIndex + i) % this.reviews.length]
        }
        return retArr
    },
    remainedTimeStr() {
        var submitDatetime = this.$store.state.keto.submitDatetime

        if(submitDatetime == null || submitDatetime == undefined) {
            return ''
        }
        
        var last = this.$moment(submitDatetime).add(15, 'minutes')
        var current = this.currentTime

        if(last > current) {
            this.isActive = true
        } else {
            this.isActive = false
        }
        return this.$moment(last - current).format('m [min] s [sec]')
    },
  },
  beforeRouteEnter(to, from, next) {
      next()
  },
  methods: {
      getActiveStatus(val) {
          if(this.currIndex == val)  return 'slick-active'
          else return ''
      },
      startLoading() {
        this.$vs.loading()
      },
      closeLoading() {
        this.$vs.loading.close()
      },
      setCurrentDateTime() {
          setTimeout(()=> {
              this.currentTime = this.$moment()
              this.setCurrentDateTime()
              if(!this.isActive) {
                let newSubmitDatetime = this.currentTime.format('YYYY-MM-DD HH:mm:ss')
                this.$store.dispatch("keto/set_submit_datetime", newSubmitDatetime)
              }
          }, 1000)
      },
      selectPlan(version) {
        this.planIndex = version
        this.$root.$emit("billingPlanSelected", {
            index: this.planIndex
        })
        if(this.planIndex == 0)
            this.amount = 33
        else if(this.planIndex == 1)
            this.amount = 66
        else if(this.planIndex == 2)
            this.amount = 46

        this.subscribe();
      },
      subscribe() {
        // this.popupActive = !this.popupActive
        let popupWidth = screen.width > 768 ? 440 : 340
        this.$modal.show(PaymentPopup, {planId: this.planIndex, summaryId: this.summaryId}, {height: '520', width: popupWidth})
        // this.popupActive = true
      },
      nextpage() {
        this.$router.push({name: 'keto-main'})
      },
  }
}
</script>
