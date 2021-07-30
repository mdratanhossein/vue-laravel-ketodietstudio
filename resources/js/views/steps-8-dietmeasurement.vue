<template>
    <div class="mx-auto w-full lg:w-2/4 max-w-screen-md">
        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <router-link :to="{name: 'keto-quiz-step7'}">
                    <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
                </router-link>
            </div>
        </div>
        <div class="vx-row">
            <div class="vx-col w-full mb-base">
                <vx-card>
                    <vs-progress class="block" :percent="85" color="primary"></vs-progress>

                    <div class="pt-10 pb-10 mx-auto button-group" style="">
                        <vs-button @click="selectUnit(0)" type="relief" class="w-1/3 mr-20 text-dark" :color="btn_color(0)"><strong>Imperial</strong></vs-button>
                        <vs-button @click="selectUnit(1)" type="relief" class="w-1/3 text-dark" :color="btn_color(1)"><strong>Metric</strong></vs-button>
                    </div>

                    <div class="vx-col w-full mt-5">
                        <h2 class="font-bold">Measurements</h2>
                    </div>

                    <imperial-form v-show="!curUnit" />
                    <metric-form v-show="curUnit" />

                    <vs-divider class="mt-10 mb-6"></vs-divider>

                    <div class="text-center">
                        <router-link :to="{name: 'keto-quiz-step7'}">
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
.button-group {
    text-align: center;
    background: #e4e5e7;
}
</style>

<script>
import ImperialForm from "./steps-8-imperial.vue"
import MetricForm from "./steps-8-metric.vue"

export default {
  components: {
      ImperialForm,
      MetricForm,
  },
  data() {
      return {
        curUnit: 0,
        age: null,        
        height_cm: null,
        weight_kg: null,
        target_kg: null,        
        height_in: null,
        height_ft: null,
        weight_lb: null,
        target_lb: null,
      }
  },
  beforeRouteEnter(to, from, next) {
    //   if(from.name != 'keto-quiz-step7') {
    //       next({
    //           name: 'keto-main',
    //       })
    //   } else {
    //       next()
    //   }

    next()
  },
  methods: {
    selectUnit(index) {
        this.curUnit = index
    },
    btn_color(index) {
        return this.curUnit == index ? '#ffffff' : '#aaaaaa'
    }
  }
}
</script>
