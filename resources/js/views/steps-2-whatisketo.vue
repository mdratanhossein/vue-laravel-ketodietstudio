<template>
    <div class="mx-auto w-full lg:w-2/4 max-w-screen-md">
        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <router-link :to="{name: 'keto-quiz-step1'}">
                    <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
                </router-link>
            </div>
        </div>
        <div class="vx-row">
            <div class="vx-col w-full mb-base">
                <vx-card>
                    <vs-progress class="block" :percent="20" color="primary"></vs-progress>

                    <div class="vx-col w-full mt-6">
                        <h2 class="mb-1 font-bold">What is Keto diet?</h2>
                        <p class="mt-5">
                            The ketogenic diet is a very low-carb, high-fat diet. To achieve positive results, this diet has to be very low in carbohydrates, high in dietary fat and include a moderate amount of proteins. This reduction in carbs puts your body into a metabolic state called ketosis. When this happens, your body becomes incredibly efficient at burning fat for energy.
                        </p>
                        <div class="max-w-screen-sm text-center">
                            <div class="video-container mx-auto my-4">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/Bspqlf7fgnw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>


                        <h2 class="mt-10 mb-5 font-bold">Benefits of keto diet:</h2>
                        <ul class="info-inside">
                            <li>
                                <feather-icon icon="SmileIcon" class="inline-block align-middle" svgClasses="h-5 w-5 text-green-500" />
                                <span class="inline-block align-middle">Weight loss</span>
                            </li>
                            <li>
                                <feather-icon icon="SmileIcon" class="inline-block align-middle" svgClasses="h-5 w-5 text-green-500" />
                                Reduced blood pressure
                            </li>
                            <li>
                                <feather-icon icon="SmileIcon" class="inline-block align-middle" svgClasses="h-5 w-5 text-green-500" />
                                Slower ageing process
                            </li>
                            <li>
                                <feather-icon icon="SmileIcon" class="inline-block align-middle" svgClasses="h-5 w-5 text-green-500" />
                                Improved sleep and mood
                            </li>
                            <li>
                                <feather-icon icon="SmileIcon" class="inline-block align-middle" svgClasses="h-5 w-5 text-green-500" />
                                Increased energy efficiency
                            </li>
                        </ul>
                    </div>

                    <vs-divider class="my-6"></vs-divider>

                    <!-- <select-button @click="selectVesion('top')">
                        Expert
                    </select-button> -->

                    <div class="text-center">
                        <vs-button @click="nextpage" type="relief" size="large" class="mb-6 mx-auto w-full xl:w-2/4" color="primary"><strong>Got it</strong></vs-button>
                    </div>

                    <vs-divider class="mt-10 mb-6"></vs-divider>

                    <div class="text-center">
                        <router-link :to="{name: 'keto-quiz-step1'}">
                            Back
                        </router-link>
                    </div>
                </vx-card>
            </div>
            <div class="vx-col w-1/8 mb-2" />
        </div> 
    </div>
</template>

<style lang="scss">
.info-inside li {
    line-height: 24px;
    margin-bottom: 6px;
    font-size: 15px;
}

.info-inside li i {
    font-weight: 900;
    margin-right: 5px;
    color: #56468f;
}
</style>

<script>

export default {
  data() {
      return {

      }
  },
  beforeRouteEnter(to, from, next) {
      if(from.name != 'keto-quiz-step1' && from.name != 'keto-quiz-step3') {
          next({
              name: 'keto-main',
          })
      } else {
          next()
      }
  },
  methods: {
      nextpage(version) {
          this.$router.push({name: 'keto-quiz-step3'})
      }
  }
}
</script>
