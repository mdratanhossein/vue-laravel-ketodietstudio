<template>
    <div class="success-panel mx-auto" id="success-page">
        <div class="vx-row">
            <div class="vx-col w-1/8 mb-2" />
            <div class="vx-col w-full mb-base">
                <div class="mx-auto text-center mb-10">
                    <h1 class="font-bold text-primary">Thanks for your payment</h1>
                </div>
            </div>
            <div class="vx-col w-1/8 mb-2" />
        </div> 
    </div>
</template>

<script>

export default {
  components: {
  },
  data() {
      return {
          summaryId: null,
      }
  },
  computed: {
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
        }
    })
  }, 
  beforeRouteEnter(to, from, next) {
    next()
  },
  methods: {
      gotoMainPage() {
        this.$router.push({name: 'keto-main'})
      },
      gotoProfilePage() {
        this.$router.push({name: 'keto-user-profile', params: { id: this.summaryId }})
      },
  },
  mounted() {
      setTimeout(this.gotoProfilePage, 5000)
  }
}
</script>
