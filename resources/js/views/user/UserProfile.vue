<template>
    <div id="user_plan">
        <div v-if="isDesktop" class="tabs-nav inner">
            <div class="tabs-wrapper">
                <router-link :to="{path: `/plan/profile/` + summaryId}" class="tabs-logo">
                    <img class="w-64" src="@assets/images/logo/logo.png" alt="KetoDietStudio">
                </router-link>
                <router-link :to="{path: `/plan/profile/` + summaryId}" class="profile-tab tab-item active">
                    <img src="@assets/images/icons/icon-profile.svg"> My profile
                </router-link>
                <router-link :to="{path: `/plan/progress/` + summaryId}" class="meals-tab tab-item">
                    <img src="@assets/images/icons/icon-progress.svg"> My progress
                </router-link>
                <router-link :to="{path: `/plan/meal/` + summaryId}" class="meals-tab tab-item">
                    <img src="@assets/images/icons/meal-list.svg"> Meals
                </router-link>
            </div>
        </div>
        <div v-else>
            <vertical-user-nav-menu />
        </div>

        <div class="user-plan-panel mx-auto">
            <div class="w-full mb-base">
                <vx-card>
                    <div class="w-full mt-5 mb-5">
                        <h2 class="font-bold">My Profile</h2>
                        <div class="cycle-columns">
                            <div class="cycle-col current-cycle">
                                <div class="cycle-label">Started at</div>
                                <div class="cycle-value">{{ getStartedMonthDate() }}</div>
                            </div>
                            <div class="cycle-col current-cycle">
                                <div class="cycle-label">Cycle progress</div>
                                <div class="cycle-value">{{ getCycleDate() }}/28</div>
                            </div>
                            <div class="cycle-col current-cycle">
                                <div class="cycle-label">Cycles completed</div>
                                <div class="cycle-value">{{ getCycleTotalDate() }}</div>
                            </div>
                        </div>
                        <p class="mt-5">
                            You can restart your Keto Cycle and get an updated meal plan at any given point in time by clicking the button below. Your new meal plan will be set up according to your latest weight entry.
                        </p>
                    </div>
                    <div class="vx-col fill-row-loading w-full">
                        <div v-show="curStatus==1" id="loading_restart" class="vs-con-loading__container loading-example" />
                        <vs-button @click="restartCycle" type="relief" size="large" class="mt-10 mb-6 w-full" color="primary"><strong>Restart Cycle</strong></vs-button>
                    </div>

                    <!--<div class="w-full mt-12 mb-12">
                        <h2 class="font-bold">Earn with keto</h2>
                        <div class="cycle-columns w-full">
                            <div class="cycle-col" style="width: 100% !important;">
                                <div class="cycle-label">Ref url</div>
                                <div class="cycle-value">{{ ref_url }}</div>
                            </div>
                        </div>
                        <p class="mt-5">

                        </p>
                    </div>-->

                    <vs-divider class="my-6"></vs-divider>
                    <div class="vx-col w-full mt-5 mb-5">
                        <h2 class="font-bold">Food Preferences</h2>
                        <p class="mt-5">
                            Select or deselect foods to be included in your meal plan.
                        </p>
                    </div>
                    <div class="vx-row mx-auto">
                        <div class="vx-col w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 product-group-first">
                            <select-button v-for="item in this.leftProducts" :key="item"  @click="selectPlan(item)" :isIcon="true" :query="item" :state="false">
                                {{ capitalize(item) }}
                            </select-button>
                        </div>
                        <div class="vx-col w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 mt-5">
                            <select-button v-for="item in this.rightProducts" :key="item"  @click="selectPlan(item)" :isIcon="true" :query="item" :state="false">
                                {{ capitalize(item) }}
                            </select-button>
                        </div>
                    </div>

                    <div class="vx-col w-full mt-1 mb-1">
                        <p class="mt-5 error-msg" v-show="this.errProductMsg != ''">
                            {{ this.errProductMsg }}
                        </p>
                    </div>

                    <div class="vx-col fill-row-loading w-full flex-column">
                        <div v-show="curStatus==2" id="loading_food" class="vs-con-loading__container loading-example" />
                        <vs-button @click="updateFoodPlan" type="relief" size="large" class="mt-10 mb-6 w-full" color="primary"><strong>Save food preferences</strong></vs-button>
                    </div>

                    <vs-divider class="my-6"></vs-divider>

                    <div class="vx-col w-full mt-5 mb-5">
                        <h2 class="font-bold">Profile Details</h2>
                    </div>

                    <div class="vx-row mx-auto">
                        <div class="vx-col w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2">
                            <vs-input v-validate="'required|email'" label="Email" name="email_addr" v-model="email_addr" type="text" class="mt-5 w-full" />
                            <span class="text-danger text-sm" v-show="errors.has('email_addr')">{{ errors.first('email_addr') }}</span>
                            <p class="mt-5 vs-input--label">Gender</p>
                            <v-select :clearable="false" v-model="gender" :options="genderOptions" placement="down" />
                            <vs-input v-validate="'required|between:5,250'" label="Target Weight" name="input_target_weight" v-model="target_weight" type="text" class="mt-5 w-full" />
                            <span class="text-danger text-sm" v-show="errors.has('input_target_weight')">{{ errors.first('input_target_weight') }}</span>
                            <p class="mt-5 vs-input--label">Motivation level</p>
                            <v-select :clearable="false" v-model="willing" :options="willingOption" placement="down" />
                        </div>
                        <div class="vx-col w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2">
                            <vs-input v-validate="'required|between:1,100'" label="Age(years)" name="age" v-model="age" type="text" class="mt-5 w-full" />
                            <span class="text-danger text-sm" v-show="errors.has('age')">{{ errors.first('age') }}</span>
                            <p class="mt-5 vs-input--label">Unit System</p>
                            <v-select label="Unit System" :clearable="false" v-model="unitSystem" :options="unitSystemOptions" placement="down" />
                            <p class="mt-5 vs-input--label">Physical activity level</p>
                            <v-select :clearable="false" v-model="physical" :options="physicalOption" placement="down" />
                            <p class="mt-5 vs-input--label">Preparation time</p>
                            <v-select :clearable="false" v-model="preparation" :options="preparationOption" placement="down" />
                        </div>
                    </div>

                    <div class="vx-col fill-row-loading w-full">
                        <div v-show="curStatus==3" id="loading_profile" class="vs-con-loading__container loading-example" />
                        <vs-button @click="updateProfile" type="relief" size="large" class="mt-10 mb-6 w-full" color="primary"><strong>Update my profile</strong></vs-button>
                    </div>
                </vx-card>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
.user-plan-panel {
    @media (max-width:700px) { width: 100% !important; }
    @media (min-width:1025px) { width: 60% !important; }
    @media (min-width:1200px) { width: 50% !important; }
    @media (min-width:1600px) { width: 40% !important; }
}
.product-group-first {
    border-bottom:rgba(86, 70, 143) 1px solid;
    @media (min-width:1025px) { border: none !important; }
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
.error-msg {
    text-align: center;
    margin-top: 25px;
    color: #ff3464;
    font-size: 12px;
}
div.vs__selected-options {
    overflow: hidden !important;
    height: 30px !important;
}
span.vs__selected {
    white-space: nowrap !important;
    height: 30px !important;
    position: absolute;
}
.cycle-label {
    color: #969696;
    font-weight: 400;
}

.cycle-columns .cycle-col .cycle-value, .cycle-columns .cycle-col .weight-value, .cycle-columns .weight-col .cycle-value, .cycle-columns .weight-col .weight-value, .weight-columns .cycle-col .cycle-value, .weight-columns .cycle-col .weight-value, .weight-columns .weight-col .cycle-value, .weight-columns .weight-col .weight-value {
    font-weight: 600;
    font-size: 18px;
}

.cycle-columns, .weight-columns {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 100%;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    margin-top: 30px;
    margin-bottom: 30px;
}

.cycle-columns .cycle-col,
.cycle-columns .weight-col,
.weight-columns .cycle-col,
.weight-columns .weight-col {
    -webkit-box-shadow: 0 4px 11px -2px rgba(86, 70, 143, .3);
    box-shadow: 0 4px 11px -2px rgba(86, 70, 143, .3);
    padding: 15px;
    border-radius: 9px;
    width: 175px;
    text-align: center;
}

.tabs-nav.inner {
    z-index: 999!important;
    top: 0!important;
    bottom: auto!important;
}

.tabs-nav {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #fff;
    -webkit-box-shadow: 0 4px 11px 4px rgba(86, 70, 143, .3);
    box-shadow: 0 4px 11px 4px rgba(86, 70, 143, .3);
    margin-left: 0!important;
    margin-right: 0!important;
}

.tabs-wrapper {
    max-width: 1000px;
    margin: 0 auto;
    height: 65px;
    line-height: 65px;

    img {
        //max-width: 125px;
        padding-left: 25px;
        vertical-align: middle;
    }
}

.tabs-nav.inner .tab-item.profile-tab {
    border-right: 0!important;
}

.tabs-nav.inner .tab-item {
    height: 65px;
    line-height: 65px;
    border-top: 0!important;
    border-left: 1px solid #ebebeb;
    border-bottom: 3px solid #fff;
    float: right;
    width: 17%;
}

.tabs-nav .tab-item {
    text-decoration: none;
}

.tabs-nav .tab-item {
    color: #56468f;
    font-family: Karla, Montserrat;
    text-align: center;
    cursor: pointer;
    font-size: 13px;
    letter-spacing: .44px;
    line-height: 15px;
    font-weight: 400;
    height: 50px;
    line-height: 50px;
    border-top: 3px solid #fff;
}

.tabs-nav.inner .tab-item.active {
    border-bottom: 3px solid #56468f;
}
.tabs-nav.inner .tab-item.profile-tab {
    border-right: 0!important;
}

.tabs-nav .tab-item.active {
    font-weight: 700;
    border-top: 3px solid #56468f;
    border-left: 1px solid #ebebeb;
    border-right: 1px solid #ebebeb;
    margin-left: -1px;
    margin-right: -1px;
}

#landing .vx-card {
    background-color: transparent !important;
    box-shadow: none !important;
}
.greet-user h1 {
    color: #ff3464;
    font-family: Lato,Montserrat;
    font-size: 36px;
    font-weight: 900;
    letter-spacing: 1.36px;
    display: block;
    max-width: 400px;
    line-height: 46px;
}

.custom-alignment {
    &>* {
        margin-right: 1.5rem;
        margin-top: 1.5rem;
    }
}
</style>

<script>
import VerticalUserNavMenu from "../../components/VerticalUserNavMenu.vue"

export default {
  components: {
      VerticalUserNavMenu,
  },
  data() {
      return {
        curStatus: 0,
        isMyPlan: false,
        summaryId: null,
          ref_url: null,
        summaryInfo: [],
        products: [],
        leftProducts: [], //['chicken', 'pork', 'beef', 'fish', 'lamb', 'veal', 'vegetarian',],
        rightProducts: [], //[ 'onions', 'mushrooms', 'eggs', 'nuts', 'cheese', 'butter', 'milk', 'avocado', 'seafood', 'olives', 'capers', 'coconut', 'goat-cheese',],
        selected_products: [],
        unitSystemOptions: ["Metric", "Imperial"],
        age: null,
        unitSystem: "Metric",
        email_addr: null,
        gender: 'Male',
        genderOptions: ['Male', 'Female'],
        target_weight: null,
        willing: {value: 0, label: 'I just want to try the Keto diet'},
        willingOption: [
            {value: 0, label: 'I just want to try the Keto diet'},
            {value: 1, label: 'I want to try it and lose some weight'},
            {value: 2, label: 'I want to lose the maximum amount of weight'},
        ],
        physical: {value: 0, label: 'A newbie (Just starting)'},
        physicalOption: [
            {value: 0, label: 'A newbie (Just starting)'},
            {value: 1, label: 'Light-mode (1-2 workouts /week)'},
            {value: 2, label: 'Workout hero (3-5 workouts / week)'},
        ],
        preparation: {value: 0, label: 'Up to 30 min'},
        preparationOption: [
            {value: 0, label: 'Up to 30 min'},
            {value: 1, label: 'Up to 1 hour'},
            {value: 2, label: 'More than 1 hour'},
        ],
        errProductMsg: '',
        kg2lbs: 2.20462,
        lbs2kg: 0.453592,
      }
  },
  watch: {
      selected_products: function(after, before) {
        if(after.length > 0 && this.errProductMsg != '')
            this.errProductMsg = ''
      },
      unitSystem: function(after, before) {
        if(this.curStatus == -1) {
            this.curStatus = 0
        } else {
            if(before == 'Imperial' && after == 'Metric') {
                this.target_weight = Math.round(parseFloat(this.target_weight) * this.lbs2kg)
            } else if(before == 'Metric' && after == 'Imperial') {
                this.target_weight = Math.round(parseFloat(this.target_weight) * this.kg2lbs)
            }
        }
      },
  },
  created() {
    this.startPage()
  },
  computed: {
      isDesktop() {
          return screen.width > 768 ? true : false
      }
  },
  methods: {
      startPage() {
        if(this.$route.params.id == undefined)
            this.$router.push({name: 'page-error-404'})
        else if(this.$route.params.id.length != 32)
            this.$router.push({name: 'page-error-404'})

        let payload = {
            type: false
        }
        this.$store.dispatch("keto/get_products", payload).then((response) => {
            if(response.data.success) {
                this.leftProducts = response.data.products

                let payload = {
                    type: true
                }
                this.$store.dispatch("keto/get_products", payload).then((response) => {
                    if(response.data.success) {
                        this.rightProducts = response.data.products

                        this.summaryId = this.$route.params.id
                        this.$store.dispatch("keto/get_summary_info", this.summaryId).then((response) => {
                            if(!response.data.success || this.summaryId != response.data.summaryId || !response.data.paid) {
                                this.$router.push({name: 'page-error-404'})
                            }
                            this.summaryInfo    = response.data.userInfo
                            this.summaryId      = response.data.summaryId
                            this.products       = response.data.products
                            this.ref_url       = response.data.ref_url

                            this.email_addr     = this.summaryInfo.email
                            this.age            = this.summaryInfo.age
                            this.curStatus      = parseInt(this.summaryInfo.unit) ? 0 : -1
                            this.unitSystem     = parseInt(this.summaryInfo.unit) ? "Metric" : "Imperial"
                            this.gender         = this.summaryInfo.gender ? "Male" : "Female"

                            if(this.summaryInfo.willingOption == 0)
                                this.willing = {value: 0, label: 'I just want to try the Keto diet'}
                            else if(this.summaryInfo.willingOption == 1)
                                this.willing = {value: 1, label: 'I want to try it and lose some weight'}
                            else if(this.summaryInfo.willingOption == 2)
                                this.willing = {value: 2, label: 'I want to lose the maximum amount of weight'}

                            if(this.summaryInfo.physical_active == 0)
                                this.physical = {value: 0, label: 'A newbie (Just starting)'}
                            else if(this.summaryInfo.physical_active == 1)
                                this.physical = {value: 1, label: 'Light-mode (1-2 workouts /week)'}
                            else if(this.summaryInfo.physical_active == 2)
                                this.physical = {value: 2, label: 'Workout hero (3-5 workouts / week)'}

                            if(this.summaryInfo.preparation == 0)
                                this.preparation = {value: 0, label: 'Up to 30 min'}
                            else if(this.summaryInfo.preparation == 1)
                                this.preparation = {value: 1, label: 'Up to 1 hour'}
                            else if(this.summaryInfo.preparation == 2)
                                this.preparation = {value: 2, label: 'More than 1 hour'}

                            this.target_weight = parseInt(this.summaryInfo.unit) ? this.summaryInfo.target_kg : this.summaryInfo.target_lb

                            // let meat_plan = this.summaryInfo.meat_plan.split('/')
                            // this.$store.dispatch("keto/set_meat_plan", meat_plan)
                            // let product_plan = this.summaryInfo.meal_product.split('/')
                            // this.$store.dispatch("keto/set_meat_products", product_plan)

                            this.selected_products = this.products;

                            this.$root.$emit("userProfileMealProducts", {
                                data: this.products
                            });
                        })
                    }
                })
            }
        })


      },
      getStartedMonthDate() {
        if(this.summaryInfo.started_at == undefined) return ''
        return this.$moment(this.summaryInfo.started_at).format('MMM Do')
      },
      getCycleDate() {
        if(this.summaryInfo.started_at == undefined) return ''

        let start = this.$moment(this.summaryInfo.started_at)
        let current = this.$moment()

        return current.diff(start, 'days') % 28 + 1
      },
      getCycleTotalDate() {
        if(this.summaryInfo.started_at == undefined) return ''

        let start = this.$moment(this.summaryInfo.started_at)
        let current = this.$moment()

        return current.diff(start, 'days') + 1
      },
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
      updateProfile() {
          this.curStatus = 3
          setTimeout(() => {
            let payload = {
                summaryId: this.summaryId,
                email: this.email_addr,
                gender: this.gender == 'Female' ? 0 : 1,
                age: this.age,
                unit: this.unitSystem == 'Imperial' ? 0 : 1,
                target: Math.round(parseFloat(this.target_weight)),
                physical: this.physical.value,
                willing: this.willing.value,
                prepare: this.preparation.value
            }

            this.$store.dispatch("keto/update_profile", payload).then((response) => {
                if(response.data.success) {
                    this.startPage()
                } else {
                    console.log('failed')
                }
                this.curStatus = 0
            })
          }, 3000)
      },
      updateFoodPlan() {
        this.curStatus = 2
        setTimeout(() => {
            let checkLeftPanel = false
            for(var i=0; i<this.selected_products.length; i++) {
                if(this.leftProducts.includes(this.selected_products[i])) {
                    checkLeftPanel = true
                    break
                }
            }
            if(!checkLeftPanel) {
                this.errProductMsg = "Please select at least one of products from the first group."
                this.curStatus = 0
                return
            }
            let checkRightPanel = false
            let nCnt = 0
            for(var i=0; i<this.selected_products.length; i++) {
                if(this.rightProducts.includes(this.selected_products[i])) {
                    nCnt++
                    if(nCnt >= 5) {
                        checkRightPanel = true
                        break
                    }
                }
            }
            if(!checkRightPanel) {
                this.errProductMsg = "Please select more products in order to get a complete and diversified meal plan from the second group."
                this.curStatus = 0
                return
            }

            // let updated_meal_products = this.selected_products.join("/")
            let payload = {
                summaryId: this.summaryId,
                products: this.selected_products
            }
            this.$store.dispatch("keto/update_meal_product", payload).then((response) => {
                if(response.data.success) {
                    this.startPage()
                } else {
                    console.log('failed')
                }
                this.curStatus = 0
            })
        }, 3000)
      },
      restartCycle() {
        this.curStatus = 1
        setTimeout(() => {
            let payload = {
                summaryId: this.summaryId
            }
            this.$store.dispatch("keto/restart_cycle", payload).then((response) => {
                if(response.data.success) {
                    this.startPage()
                } else {
                    console.log('failed')
                }
                this.curStatus = 0
            })
        }, 3000)
      },
  },
  mounted() {
      this.$vs.loading({
        container: '#loading_restart',
        type: 'default',
        text:'Processing',
      })
      this.$vs.loading({
        container: '#loading_food',
        type: 'default',
        text:'Processing',
      })
      this.$vs.loading({
        container: '#loading_profile',
        type: 'default',
        text:'Processing',
      })
      this.curStatus = 0
  }
}
</script>
