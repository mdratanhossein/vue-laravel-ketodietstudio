<template>
    <form class="mb-10">
        <div class="vx-row">
            <div class="vx-col w-full">
                <vs-input v-validate="'required|between:1,100'" label="Age(years)" name="age" v-model="age" type="text" class="mt-5 w-full" />
                <span class="text-danger text-sm" v-show="errors.has('age')">{{ errors.first('age') }}</span>
            </div>
            <div class="vx-col w-1/2">
                <vs-input v-validate="'required|between:0,9'" label="Height(ft)" name="height_ft" v-model="height_ft" type="text" class="mt-5 w-full" />
                <span class="text-danger text-sm" v-show="errors.has('height_ft')">{{ errors.first('height_ft') }}</span>
            </div>
            <div class="vx-col w-1/2">
                <vs-input v-validate="'between:1,12'" label="(in)" name="height_in" v-model="height_in" type="text" class="mt-5 w-full" />
                <span class="text-danger text-sm" v-show="errors.has('height_in')">{{ errors.first('height_in') }}</span>
            </div>
            <div class="vx-col w-full">
                <vs-input v-validate="'required|between:50,500'" label="Weight(lb)" name="weight_lb" v-model="weight_lb" type="text" class="mt-5 w-full" />
                <span class="text-danger text-sm" v-show="errors.has('weight_lb')">{{ errors.first('weight_lb') }}</span>
            </div>
            <div class="vx-col w-full">
                <vs-input v-validate="'required|between:50,500'" label="Target Weight(lb)" name="target_lb" v-model="target_lb" type="text" class="mt-5 w-full" />
                <span class="text-danger text-sm" v-show="errors.has('target_lb')">{{ errors.first('target_lb') }}</span>
            </div>
            <div class="vx-col fill-row-loading w-full">
                <div v-show="curStatus==1" id="loading_default" class="vs-con-loading__container loading-example" />
                <vs-button v-show="curStatus==0" @click.prevent="submitForm" type="relief" size="large" class="mt-10 mb-6 w-full" color="primary"><strong>Next</strong></vs-button>                        
            </div>
        </div>
    </form>
</template>

<style lang="scss">
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
  data() {
      return {
        age: null,        
        height_cm: null,
        weight_kg: null,
        target_kg: null,        
        height_in: null,
        height_ft: null,
        weight_lb: null,
        target_lb: null,
        curStatus: null,
      }
  },
  mounted() {
      this.$vs.loading({
        container: '#loading_default',
        type: 'default',
        text:'Processing',
      })
      this.curStatus = 0
  },
  methods: {
        submitForm() {
            this.$validator.validateAll().then(result => {
                
                if(!result) {
                    return                    
                }
                this.curStatus = 1
                setTimeout(() => {
                    let meal_products = this.$store.state.keto.meatPlan.concat(this.$store.state.keto.productPlan)
                    let measurement = {
                        // ip_addr:            this.$store.state.keto.ip_addr,
                        gender:             this.$store.state.keto.gender,
                        familiar:           this.$store.state.keto.familiar,
                        preparation:        this.$store.state.keto.mealIndex,
                        // meal_product:       meal_products.join('/'),
                        meal_product:       meal_products,
                        physical_active:    this.$store.state.keto.physicalActive,
                        willing_option:     this.$store.state.keto.willingOption,
                        unit:               0,
                        age:                Math.floor(this.age),
                        height_cm:          null,
                        height_ft:          Math.floor(parseFloat(this.height_ft)),
                        height_in:          Math.floor(parseFloat(this.height_in)),
                        weight_kg:          null,
                        weight_lb:          Math.round(parseFloat(this.weight_lb)),
                        target_kg:          null,
                        target_lb:          Math.round(parseFloat(this.target_lb)),
                    } 
                    this.$store.dispatch("keto/set_measurement", measurement).then((response) => {
                        if(response.data.summaryId != undefined){
                            var summaryId = response.data.summaryId
                            this.$store.dispatch("keto/set_summary_id", response.data.summaryId).then(() => {
                                this.nextpage(summaryId)
                            })
                        }
                        else {
                            this.$router.push({name: 'keto-main'})
                        }
                    })
                }, 3000)
            })
        },  
        nextpage(summaryId) {
            this.$router.push({name: 'keto-quiz-step9', params: { id: summaryId}});
        },
  }
}
</script>
