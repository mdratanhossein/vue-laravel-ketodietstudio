<template>
    <div id="landing">

        <div class="w-full sm:w-full md:w-full lg:w-full xl:w-2/3 mb-8 mx-auto text-center">
            <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
            <vx-card slot="no-body" class="text-center">
            <div class="greet-user text-center">
                <h1 class="mb-4">
                    Weight loss has never been this easy and tasty!
                </h1>
                <p>Take a short quiz and receive a personalized meal plan. </p>
            </div>
            </vx-card>
        </div>

        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 mb-4 mx-auto">
                <div class="vx-row justify-center">
                    <div class="vx-col w-full sm:w-full md:w-1/3 lg:w-1/3 xl:w-2/6 mb-6" style="cursor: pointer;">
                        <div @click="toFemalePage" class="bg-yellow-500 text-white font-bold py-5 px-4 border-b-4 border-red-900 rounded shadow">
                            Women Start Here <feather-icon icon="ArrowRightIcon" class="float-right" style="top:-6px;" svgClasses="h-10 w-10" />
                        </div>
                    </div>
                    <div class="vx-col w-full sm:w-full md:w-1/3 lg:w-1/3 xl:w-2/6 mb-6" style="cursor: pointer;">
                        <div @click="toMalePage" class="bg-green-600 text-white font-bold py-5 px-4 border-b-4 border-indigo-900 rounded shadow">
                            Men Start Here <feather-icon icon="ArrowRightIcon" class="float-right" style="top:-6px;" svgClasses="h-10 w-10" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="text-center">
            <img class="w-full md:w-2/4 lg:w-1/4" src="@assets/images/burger.png" alt="Keto Burger" />
            <p>Yes. This is a full Keto burger. <br> We have prepared various recipies for any taste.</p>
        </div> -->
        <div class="vx-row clearfix">
            <div class="vx-col w-full sm:w-full md:w-1/4 lg:w-1/4 xl:w-1/4" />
            <div class="vx-col w-full md:w-2/4 lg:w-2/4 text-center top-slide">
                <!-- <div class="flex h-100">
                    <div class="prev">
                        <a @click="prev" href="#">&#10094;</a>
                    </div>
                    <transition-group name="fade" tag="div">
                        <div v-for="i in [currentIndex]" :key="i">
                            <img class="w-full" :src="currentImg" :alt="currentAlt" />
                            <p class="slide-description">{{ currentDescription }}</p>
                        </div>
                    </transition-group>
                    <div class="next">
                        <a @click="next" href="#">&#10095;</a>
                    </div>
                </div> -->

                <VueSlickCarousel v-bind="settings">
                    <div class="slider-item">
                        <img class="w-full" src="/images/slides/burger.png" alt="3" />
                        <p class="slide-description my-5">Yes. This is a full Keto burger. <br> We have prepared various recipes for any taste.</p>
                    </div>
                    <div class="slider-item">
                        <img class="w-full" src="/images/slides/salad.png" alt="2" />
                        <p class="slide-description my-5">More than 100+ salad recipes.</p>
                    </div>
                    <div class="slider-item">
                        <img class="w-full" src="/images/slides/bacon.png" alt="3" />
                        <p class="slide-description my-5">You will find no complicated food recipes here, only the most simpliest ways how to cook your meals in a fast and efficient way to gain results fast.</p>
                    </div>
                </VueSlickCarousel>
            </div>
            <div class="vx-col w-full sm:w-full md:w-1/4 lg:w-1/4 xl:w-1/4" />
        </div>

        <vs-divider class="my-6 lg:my-12"></vs-divider>

        <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/5 mt-8 mx-auto text-center">
            <div class="mb-2">If you have account already registered</div>
            <div @click="accessMyPlan" style="cursor: pointer;" class="text-green-500 font-bold p-4 border-solid border border-b-2 border-green-500 rounded shadow">
                Access My Plan
            </div>
        </div>


    </div>
</template>

<style lang="scss">
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
.greet-user h1 {
    color: #8bb51f;
    font-family: Lato,Montserrat;
    font-size: 36px;
    font-weight: 900;
    letter-spacing: 1.36px;
    display: block;

    line-height: 46px;
    @media (max-width:700px) { 
        font-size: 24px !important; 
        letter-spacing: 1px;
        line-height: 28px;
    }
}

h1 {
    @media (max-width:700px) { 
        font-size: 24px !important; 
    }
}

.custom-alignment {
    &>* {
        margin-right: 1.5rem;
        margin-top: 1.5rem;
    }
}
</style>

<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
  // optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
  components: {
      VueSlickCarousel,
  },
  data() {
      return {
        timer: null,
        currentIndex: 0,
        settings: {
            "dots": true,
            "dotsClass": "slick-dots custom-dot-class",
            "edgeFriction": 0.35,
            "infinite": false,
            "speed": 500,
            "slidesToShow": 1,
            "slidesToScroll": 1,
            "adaptiveHeight": true
        },
      }
  },
  created() {
      
  },
  mounted() {
      this.startSlide()
  },
  computed: {
      currentImg() {
          return this.slides[Math.abs(this.currentIndex) % this.slides.length].image
      },
      currentAlt() {
          return this.slides[Math.abs(this.currentIndex) % this.slides.length].alt
      },
      currentDescription() {
          return this.slides[Math.abs(this.currentIndex) % this.slides.length].description
      },
  },
  methods: {
      startSlide() {
          this.timer = setInterval(this.next, 30000)
      },
      next() {
          this.currentIndex += 1
      },
      prev() {
          this.currentIndex -= 1
      },
      accessMyPlan() {
          this.$router.push('/myplan').catch(() => {})
      },
      toMalePage() {
        this.$store.dispatch("keto/set_gender", 1).then(() => {
            this.$router.push('/quiz/step1').catch(() => {})
        })  
      },
      toFemalePage() {
        this.$store.dispatch("keto/set_gender", 0).then(() => {
            this.$router.push('/quiz/step1').catch(() => {})
        })  
      }
  }
}
</script>
