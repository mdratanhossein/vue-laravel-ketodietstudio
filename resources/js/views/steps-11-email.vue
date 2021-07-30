<template>
    <div class="mx-auto w-full lg:w-2/4 max-w-screen-md">
        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
            </div>
        </div>
        <div class="vx-row">
            <div class="vx-col w-full mb-base">
                <vx-card>
                    <div class="vx-col w-full mt-5">
                        <h2 class="font-bold">We've created a personalized Keto diet plan that will help you to achieve your goals.</h2>
                        <p class="mt-5">
                            Where should we send your plan?
                        </p>
                    </div>

                    <div class="mb-10">
                        <div class="vx-row">
                            <div class="vx-col w-full">
                                <vs-input v-validate="'required|email'" label="Email Address" name="email" v-model="email" class="mt-5 w-full" />
                                <span class="text-danger text-sm" v-show="errors.has('email')">{{ errors.first('email') }}</span>
                                
                            </div>                            
                        </div>
                        <div class="mt-5">
                            <vs-button @click.prevent="submitForm" type="relief" size="large" class="mb-6 w-full" color="primary"><strong>Next</strong></vs-button>                        
                            <p>We respect your privacy. We will never sell, rent or share your email address. That's more than a policy, it's our personal guarantee!</p>
                        </div>
                    
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
        summaryId: null,
      }
  },  
  created() {    
    if(this.$route.params.id == undefined || this.$route.params.id == null) 
        this.$router.push({name: 'page-error-404'})
    else if(this.$route.params.id != this.$store.state.keto.summaryId)
        this.$router.push({name: 'page-error-404'})
    
    this.summaryId = this.$route.params.id
  },
  beforeRouteEnter(to, from, next) {
    next()
  },
  methods: {
      submitForm() {
            this.$validator.validateAll().then(result => {
                let payload = {
                    email_addr: this.email,
                    summaryId: this.summaryId
                }
                if(result) {
                    this.$store.dispatch("keto/set_email_addr", payload).then((response) => {
                        if(response.success && response.summaryId == this.summaryId) {
                            this.nextpage()
                        } else {
                            if(response.paid) {
                                this.$router.push({name: 'keto-user-plan', params: { id: response.summaryId }})
                            } else {
                                this.$router.push({name: 'keto-main'})
                            }
                        }
                    })
                }
            })
        },  
      nextpage() {
        // this.$router.push({name: 'keto-subscribe'})
        this.$router.push({name: 'keto-subscribe', params: { id: this.summaryId }})
      },
  }
}
</script>
