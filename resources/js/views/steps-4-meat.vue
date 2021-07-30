<template>
    <div class="mx-auto w-full lg:w-2/4 max-w-screen-md">
        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <router-link :to="{name: 'keto-quiz-step3'}">
                    <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
                </router-link>
            </div>
        </div>
        <div class="vx-row">
            <div class="vx-col w-full mb-base">
                <vx-card>
                    <vs-progress class="block" :percent="40" color="primary"></vs-progress>

                    <div class="vx-col w-full mt-5 mb-5">
                        <h2 class="font-bold">Meat</h2>
                        <p class="mt-5">
                            Please select which products you would like included in the plan
                        </p>
                    </div>

                    <!-- <vs-divider class="my-6"></vs-divider> -->

                    <select-button v-for="item in this.products" :key="item"  @click="selectPlan(item)" :isIcon="true" :query="item">
                        {{ capitalize(item) }}
                    </select-button>

                    <!-- <vs-divider class="my-6"></vs-divider> -->
                    <div class="vx-col w-full mt-1 mb-1">
                        <p class="mt-5 error-msg" v-show="this.errMsg != ''">
                            {{ this.errMsg }}
                        </p>
                    </div>

                    <div class="text-center">
                        <vs-button @click="nextpage" type="relief" size="large" class="mt-3 mb-6 mx-auto w-full xl:w-2/4" color="primary"><strong>Next</strong></vs-button>
                    </div>

                    <vs-divider class="mt-10 mb-6"></vs-divider>

                    <div class="text-center">
                        <router-link :to="{name: 'keto-quiz-step3'}">
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
.error-msg {
    text-align: center;
    margin-top: 25px;
    color: #ff3464;
    font-size: 12px;
    // display: none;
}
</style>

<script>

export default {
  data() {
      return {
        // products: [
        //     'chicken', 'pork', 'beef', 'fish', 'lamb', 'veal', 'vegetarian',
        // ],
        products: [],
        selected_products: [],
        errMsg: '',
      }
  },
  created() {
    let payload = {
        type: false
    }
    this.$store.dispatch("keto/get_products", payload).then((response) => {
        if(response.data.success) {
            this.products = response.data.products
        }
    })
  },
  beforeRouteEnter(to, from, next) {
      if(from.name != 'keto-quiz-step3' && from.name != 'keto-quiz-step5') {
          next({
              name: 'keto-main',
          })
      } else {
          next()
      }
  },
  watch: {
      selected_products: function(after, before) {
          if(after.length > 0 && this.errMsg != '') 
            this.errMsg = ''
      }
  },
  methods: {
      capitalize(item) {
        if (typeof item !== 'string') return ''
        return item.charAt(0).toUpperCase() + item.slice(1)
      },
      selectPlan(query) {
        for(var i=0; i<this.selected_products.length; i++) {
            if(this.selected_products[i] == query) {
                this.selected_products.splice(i, 1)
                return
            }
        }
        this.selected_products.push(query)
      },
      nextpage() {
        if(!this.selected_products.length) {
            this.errMsg = "Please select an answer"
            return
        }
        this.$store.dispatch("keto/set_meat_plan", this.selected_products).then(() => {
            this.$router.push({name: 'keto-quiz-step5'})
        })        
      },
  }
}
</script>
