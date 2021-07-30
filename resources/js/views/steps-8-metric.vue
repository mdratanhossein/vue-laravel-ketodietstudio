<template>
    <form class="mb-10">
        <div class="vx-row">
            <div class="vx-col w-full">
                <vs-input v-validate="'required|between:1,100'" label="Age(years)" name="age" v-model="age" type="text" class="mt-5 w-full" />
                <span class="text-danger text-sm" v-show="errors.has('age')">{{ errors.first('age') }}</span>
            </div>
            <div class="vx-col w-full">
                <vs-input v-validate="'required|between:30,250'" label="Height(cm)" name="height_cm" v-model="height_cm" type="text" class="mt-5 w-full" />
                <span class="text-danger text-sm" v-show="errors.has('height_cm')">{{ errors.first('height_cm') }}</span>
            </div>
            <div class="vx-col w-full">
                <vs-input v-validate="'required|between:5,250'" label="Weight(kg)" name="weight_kg" v-model="weight_kg" type="text" class="mt-5 w-full" />
                <span class="text-danger text-sm" v-show="errors.has('weight_kg')">{{ errors.first('weight_kg') }}</span>
            </div>
            <div class="vx-col w-full">
                <vs-input v-validate="'required|between:5,250'" label="Target Weight(kg)" name="target_kg" v-model="target_kg" type="text" class="mt-5 w-full" />
                <span class="text-danger text-sm" v-show="errors.has('target_kg')">{{ errors.first('target_kg') }}</span>
            </div>
            <div class="vx-col fill-row-loading w-full">
                <div v-show="curStatus==1" id="loading_metric" class="vs-con-loading__container loading-example" />
                <vs-button v-show="curStatus==0" @click.prevent="submitForm" type="relief" size="large" class="mt-10 mb-6 w-full" color="primary"><strong>Next</strong></vs-button>                        
            </div>
        </div>
        <!-- <vs-button @click.prevent="submitForm" type="relief" size="large" class="mt-10 mb-6 w-full" color="primary"><strong>Next</strong></vs-button>                         -->
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
        container: '#loading_metric',
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
                        unit:               1,
                        age:                Math.floor(this.age),
                        height_cm:          Math.floor(parseFloat(this.height_cm)),
                        height_ft:          null,
                        height_in:          null,
                        weight_kg:          Math.round(parseFloat(this.weight_kg)),
                        weight_lb:          null,
                        target_kg:          Math.round(parseFloat(this.target_kg)),
                        target_lb:          null,                        
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
