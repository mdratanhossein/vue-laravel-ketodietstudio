<template>
    <div class="mx-auto w-full lg:w-2/4 max-w-screen-md">
        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <router-link :to="{name: 'keto-main'}">
                    <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
                </router-link>
            </div>
        </div>
        <div class="vx-row">
            <div class="vx-col w-full mb-base">
                <vx-card>
                    <div class="vx-col w-full mt-5">
                        <h2 class="font-bold">My plan</h2>
                        <p class="mt-5">
                            Enter your email to gain access to your diet plan.
                        </p>
                    </div>

                    <div class="mb-5">
                        <div class="vx-row">
                            <div class="vx-col w-full">
                                <vs-input v-validate="'required|email'" label="Email Address" name="email" v-model="email" class="mt-5 w-full" />
                                <span class="text-danger text-sm" v-show="errors.has('email')">{{ errors.first('email') }}</span>
                                
                            </div>                            
                        </div>
                        <div class="mt-5">
                            <vs-button @click.prevent="submitForm" type="relief" size="large" class="mb-6 w-full" color="primary"><strong>Next</strong></vs-button>                        
                            <!-- <p>We respect your privacy. We will never sell, rent or share your email address. That's more than a policy, it's our personal guarantee!</p> -->
                        </div>
                    
                    </div>
                    <div class="vx-col w-full mb-5" v-show="isErrorActive">
                        <p class="text-danger text-center">
                            Cannot found {{ email }} in our registered list. Try again.
                        </p>
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
export default {
  data() {
      return {
        email: null,
        showError: false,
      }
  },
  computed: {
      isErrorActive() {
          return this.showError
      }
  },
  methods: {
      submitForm() {
            this.$validator.validateAll().then(result => {
                if(result) { 
                    this.$store.dispatch("keto/search_email_addr", this.email).then((response) => {
                        if(response.data.success == false) {
                            this.showError = true
                            this.hideError()
                        } else {
                            if(response.data.paid)
                                this.$router.push({name: 'keto-user-index', params: { id: response.data.result }})
                            else
                                this.$router.push({name: 'keto-subscribe', params: { id: response.data.result }})
                        }
                    })
                }
            })
        },  
        hideError() {
            var vm = this
            setTimeout(function() {
                vm.showError = false
            }, 5000)
        },
  }
}
</script>
