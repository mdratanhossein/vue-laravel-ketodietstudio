<template>
    <div class="mx-auto w-full lg:w-2/4 max-w-screen-md">
        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <router-link :to="{name: 'keto-quiz-step6'}">
                    <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
                </router-link>
            </div>
        </div>
        <div class="vx-row">
            <div class="vx-col w-full mb-base">
                <vx-card>
                    <vs-progress class="block" :percent="75" color="primary"></vs-progress>

                    <div class="vx-col w-full mt-10">
                        <h2 class="mb-1 font-bold">How willing are you to lose weight?</h2>
                    </div>

                    <vs-divider class="my-6"></vs-divider>

                    <select-button @click="selectVesion(0)">
                        I just want to try the Keto diet
                    </select-button>

                    <select-button @click="selectVesion(1)">                        
                        I want to try it and lose some weight
                    </select-button>

                    <select-button @click="selectVesion(2)">
                        I want to lose the maximum amount of weight
                    </select-button>

                    <vs-divider class="mt-10 mb-6"></vs-divider>

                    <div class="text-center">
                        <router-link :to="{name: 'keto-quiz-step6'}">
                            Back
                        </router-link>
                    </div>
                </vx-card>
            </div>
            <div class="vx-col w-1/8 mb-2" />
        </div> 
    </div>
</template>

<script>
export default {
  data() {
      return {

      }
  },
  beforeRouteEnter(to, from, next) {
      if(from.name != 'keto-quiz-step6' && from.name != 'keto-quiz-step8') {
          next({
              name: 'keto-main',
          })
      } else {
          next()
      }
  },
  methods: {
      selectVesion(version) {
        this.$store.dispatch("keto/set_willing_option", version).then(() => {
            this.$router.push({name: 'keto-quiz-step8'})
        })  
      }
  }
}
</script>
