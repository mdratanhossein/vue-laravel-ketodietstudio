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

                    <div class="vx-col w-full mt-5">
                        <h2 class="font-bold"  v-show="curStatus==0">Please input your first name.</h2>
                    </div>
                    <div class="vx-col w-full"  v-show="curStatus==0">
                        <vs-input v-validate="'required|alpha'" label="First Name" name="first_name" v-model="first_name" type="text" class="mt-5 w-full" />
                        <span class="text-danger text-sm" v-show="errors.has('first_name')">{{ errors.first('first_name') }}</span>
                    </div>
                    <div class="vx-col fill-row-loading w-full">
                        <div v-show="curStatus==1" id="loading_default" class="vs-con-loading__container loading-example" />
                        <div class="vx-col w-full text-center mt-5">
                            <p v-show="curStatus==1">{{ message }}</p>
                        </div>
                        <vs-button v-show="curStatus==0" @click="nextpage" type="relief" size="large" class="mt-10 mb-6 w-full" color="primary"><strong>Next</strong></vs-button>                        
                    </div>      

                    <vs-divider class="mt-10 mb-6"></vs-divider>

                    <div class="text-center">
                        <router-link :to="{name: 'keto-quiz-step8'}">
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
.fill-row-loading {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  .loading-example {
    width: 120px;
    float: left;
    height: 120px;
    box-shadow: 0px 5px 20px 0px rgba(0, 0, 0, 0.05);
    border-radius: 10px;
    margin: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
    &:hover {
      box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.05);
      transform: translate(0, 4px);
    }
    h4 {
      z-index: 40000;
      position: relative;
      text-align: center;
      padding: 10px;
    }
    &.activeLoading {
      opacity: 0 !important;
      transform: scale(0.5);
    }
  }
}
</style>

<script>

export default {
  components: {
  },
  data() {
      return {
        first_name: '',
        summaryId: null,
        curStatus : null,
        messageId: -1,
        messages : ['Calulating...', 'Please wait for a moment.', 'It takes a certain amount of time.', 'Finished almost.'],
      }
  },
  computed: {
    message() {
      if(this.messageId < 0) return ''
      return this.messages[this.messageId]
    }
  },
  mounted() {
    this.$vs.loading({
      container: '#loading_default',
      type: 'default',
      text:'Processing',
    })
    this.curStatus = 0
    this.$root.$on("first_name_input", (payload) => {
      this.nextMessage()
    })
  },
  beforeRouteEnter(to, from, next) {
      if(from.name != 'keto-quiz-step8') {
          next({
              name: 'keto-main',
          })
      } else {
          next()
      }
  },
  methods: {
    nextMessage() {
      this.messageId += 1
      if(this.messageId >= this.messages.length) {
        this.$router.push({name: 'keto-summary', params: { id: this.summaryId}});
        return
      }
      setTimeout(() => {
        this.nextMessage()
      }, 4000)
    },
    nextpage() {
      this.curStatus = 1

      let payload = {
        summaryId: this.$route.params.id,
        username: this.first_name
      }

      this.$store.dispatch("keto/set_firstname", payload).then((response) => {
        this.summaryId = response.data.summaryId
        this.$root.$emit("first_name_input", { }) 
      })
    },
  },
}
</script>
