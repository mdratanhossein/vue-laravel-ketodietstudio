<template>
    <div class="mx-auto w-full lg:w-2/4 max-w-screen-md">
        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <router-link to="/">
                    <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
                </router-link>
            </div>
        </div>
        <div class="vx-row">
            <div class="vx-col w-full mb-base">
                <vx-card>
                    <vs-progress class="block" :percent="10" color="primary"></vs-progress>

                    <div class="vx-col w-full mt-6">
                        <h2 class="mb-1 font-bold">How familiar are you with the Keto diet?</h2>
                    </div>

                    <vs-divider class="my-6"></vs-divider>

                    <select-button @click="selectVesion(2)">
                        Expert
                    </select-button>

                    <select-button @click="selectVesion(1)">
                        I've heard a thing or two
                    </select-button>

                    <select-button @click="selectVesion(0)">
                        Beginner
                    </select-button>

                    <vs-divider class="mt-10 mb-6"></vs-divider>

                    <div class="text-center">
                        <router-link to="/">
                            Back
                        </router-link>
                    </div>
                </vx-card>
            </div>
            <!-- <div class="vx-col w-1/8 mb-2" /> -->
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
      if(from.name != 'keto-main' && from.name != 'keto-quiz-step2' && from.name != 'keto-quiz-step3') {
          next({
              name: 'keto-main',
          })
      } else {
          next()
      }
  },
  created() {
  },
  methods: {
      selectVesion(version) {
        if (version == 2) {
            this.$store.dispatch("keto/set_familiar_index", version).then(() => {
                this.$router.push({name: 'keto-quiz-step3'})          
            })           
        } else {
            this.$store.dispatch("keto/set_familiar_index", version).then(() => {
                this.$router.push({name: 'keto-quiz-step2'})          
            })         
        }
      }
  }
}
</script>
