<template>
    <div class="w-full mx-auto">
        <div v-if="isDesktop" class="tabs-nav inner">
            <div class="tabs-wrapper">
                <router-link :to="{path: `/plan/profile/` + summaryId}" class="tabs-logo">
                    <img class="w-64" src="@assets/images/logo/logo.png" alt="KetoDietStudio">
                </router-link>                    
                <router-link :to="{path: `/plan/profile/` + summaryId}" class="profile-tab tab-item ">
                    <img src="@assets/images/icons/icon-profile.svg"> My profile
                </router-link>
                <router-link :to="{path: `/plan/progress/` + summaryId}" class="meals-tab tab-item ">
                    <img src="@assets/images/icons/icon-progress.svg"> My progress
                </router-link>
                <router-link :to="{path: `/plan/meal/` + summaryId}" class="meals-tab tab-item active">
                    <img src="@assets/images/icons/meal-list.svg"> Meals
                </router-link>
            </div>
        </div>
        <div v-else>
            <vertical-user-nav-menu />            
        </div>
        <div class="user-plan-panel mx-auto">
            <div class="w-full mb-5">
                <vx-card>   
                    <div class="navbar-wrapper">
                        <div class="container">
                            <div class="week-data">
                                Week <span>{{ getCurrWeekDesc() }}</span>
                            </div>
                            <div class="week-nav">
                                <img @click="prevWeek" src="@assets/images/icons/arrow-left.svg" class="week-prev">
                                <img @click="nextWeek" src="@assets/images/icons/forward-male.svg" class="week-next">
                            </div>
                            <div class="e-productlist">
                                <router-link :to="{path: `/plan/groceries/` + summaryId}" class="">
                                    <img src="@assets/images/icons/shopping-list.svg">
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="week-days mt-10">
                        <a @click="setCurrWeekday(0)" href="#" data-day="1" :class="`weekday-1 ` + getWeekdayActive(0)">M <span></span></a>
                        <a @click="setCurrWeekday(1)" href="#" data-day="2" :class="`weekday-1 ` + getWeekdayActive(1)">T <span></span></a>
                        <a @click="setCurrWeekday(2)" href="#" data-day="3" :class="`weekday-1 ` + getWeekdayActive(2)">W <span></span></a>
                        <a @click="setCurrWeekday(3)" href="#" data-day="4" :class="`weekday-1 ` + getWeekdayActive(3)">T <span></span></a>
                        <a @click="setCurrWeekday(4)" href="#" data-day="5" :class="`weekday-1 ` + getWeekdayActive(4)">F <span></span></a>
                        <a @click="setCurrWeekday(5)" href="#" data-day="6" :class="`weekday-1 ` + getWeekdayActive(5)">S <span></span></a>
                        <a @click="setCurrWeekday(6)" href="#" data-day="7" :class="`weekday-1 ` + getWeekdayActive(6)">S <span></span></a>
                    </div>
                    <div class="w-full" v-show="true">
                        <meal-plan-item ref="recipeItem" v-for="(item, index) in this.currDayPlan" :mealInfo="item" :key="index" />
                    </div>
                    <div class="vx-col fill-row-loading w-full">
                        <!--<vs-button :click="updateProfile" type="relief" size="large" class="mt-10 mb-6 w-full" color="primary"><strong>Get my plan</strong></vs-button>                        -->
                    </div>
                </vx-card>
            </div>
        </div> 
        <vs-popup class="replace-popup" background-color="rgba(152,152,152,.7)" :background-color-popup="colorx" title="Select alternative recipe" :active.sync="popupActive">
            <div class="replace-item-view" v-for="(item, index) in replaceItems" :key="index">
                <img :src="getReplaceItemPhoto(item.image_url)" class="replace-meal-photo" alt="meal">
                <div class="w-full replace-meal-data">
                    <div class="meal-title">
                        <div class="w-full">
                            <p class="replace-meal-title">{{ getTrimDesc(item.title) }}</p>
                        </div>
                        <div class="w-full">
                            <p class="w-1/2 replace-meal-energy">{{ item.energy }} kcal</p>
                            <p class="w-1/2 replace-meal-prepare">{{ item.prep }}</p>
                        </div>
                        <div class="w-full">
                            <button @click="selectRecipe(item.id)" class="select-recipe-item">
                                Select recipe
                            </button>
                        </div>
                    </div>
                </div> 
            </div>
        </vs-popup>     
    </div>
</template>

<style lang="scss">
.replace-popup {
    .replace-item-view {
        margin-bottom: 15px;
        position: relative;
        border-radius: 9px;
        min-height: 100px;
        width: 100%;
        padding-bottom: 5px;
        background-color: #fff;
        -webkit-box-shadow: 0 4px 11px -2px rgba(86,70,143,.3);
        box-shadow: 0 4px 11px -2px rgba(86,70,143,.3);
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: start;
        -ms-flex-align: start;
        align-items: flex-start;
    }
    .replace-meal-photo {
        max-width: 100px;
        @media (max-width:700px) { width: 60px !important; }
        float: left;
        margin: 10px;
    }
    .replace-meal-data {
        // padding-top: 20px;
        @media (max-width:700px) { padding-top: 10px !important; }
    }
    .select-recipe-item {
        background-color: #ff3464;
        color: #fff;
        padding: 7px 30px;
        @media (max-width:700px) { padding: 4px 10px !important; }
        border: 0;
        border-radius: 6px;
        margin-top: 5px;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        -webkit-appearance: button;
        cursor: pointer;
    }
    .replace-meal-title {
        opacity: 1;
        color: #ff3464;
        font-family: Karla,Montserrat;
        font-size: 18px;
        // @media (max-width:700px) { width: 14px !important; }
        font-weight: 700;
        letter-spacing: .47px;
        line-height: 20px;
        margin-bottom: 5px;
    }
    .replace-meal-prepare {
        opacity: 1;
        color: #444;
        font-family: Karla,Montserrat;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .47px;
        line-height: 20px;
        margin-bottom: 5px;
    }
    .replace-meal-energy {
        opacity: 1;
        color: #444;
        font-family: Karla,Montserrat;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .47px;
        line-height: 20px;
        margin-bottom: 5px;
    }
}
.e-productlist {
    max-width: 20px;
    margin-left: auto;
    position: absolute;
    right: 15px;
    top: 25px;
    // bottom: 0;
    margin: auto;
    height: 30px;
}
.week-nav img {
    cursor: pointer;
}
.week-days {
    text-align: center;
    padding: 30px 0 10px 0;
    border-bottom: 1px solid #f6f6f6;
    margin-top: -25px;
    margin-bottom: 25px;
    a {
        display: inline-block;
        padding: 2px 17px;
        @media (max-width:700px) { padding: 2px 12px !important; }
        opacity: .3;
        color: #444;
        font-family: Karla,Montserrat;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .47px;
        line-height: 17px;
        text-align: center;

        span {
            height: 6px;
            width: 6px;
            display: block;
            border-radius: 50%;
            margin: 0 auto;
            margin-top: 5px;
            background-color: #c6c6c6;
        }        
    }
    a.active {
        color: #ff3464;
        font-family: Karla,Montserrat;
        font-size: 16px;
        text-decoration: none;
        opacity: 1;
        font-weight: 700;
        letter-spacing: .68px;
        line-height: 20px;
        span {
            background-color: #ff3464;
        }
    }
}
.container {
    min-height: 50px;
    width: 100%;
}
.week-data {
    opacity: .9;
    color: #56468f;
    font-family: Karla,Montserrat;
    line-height: 48px;
    font-size: 22px;
    letter-spacing: .75px;
    text-align: center;
    margin: auto;
    position: absolute;
    left: 0;
    right: 0;
    height: 50px;
}
.week-nav {
    position: absolute;
    right: 15px;
    top: 35px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    left: 0!important;
    right: 0!important;
    margin: auto;
    max-width: 150px;
    padding-top: 2px;
}
.navbar {
    position: relative;
    min-height: 50px;
    margin-bottom: 22px;
    border: 1px solid transparent;
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
    position: fixed;
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
</style>

<script>
import MealPlanItem from "../../components/MealPlanItem.vue"
import VerticalUserNavMenu from "../../components/VerticalUserNavMenu.vue"

export default {
  components: {
      MealPlanItem,
      VerticalUserNavMenu,
  },
  data() {
      return {
        fetchInfo: false,
        currWeek: 0,
        currWeekday: 0,
        isMyPlan: false,
        summaryId: null,
        summaryInfo: [],
        products: ['chicken', 'pork', 'beef', 'fish', 'lamb', 'veal', 'vegetarian',],
        selected_products: [],
        kg2lbs: 2.20462,
        lbs2kg: 0.453592,
        breakfast: [],
        morning_snack: [],
        lunch: [],
        evening_snack: [],
        dinner: [],
        breakfast_options: [],    
        morning_snack_options: [],
        lunch_options: [],
        evening_snack_options: [],
        dinner_options: [],
        meal_prepared: false,
        replaceItems: [],
        colorx: "#ffffff", //"#def1d1",
        popupActive: false,
        currTime: 0,
        meal_plan: [],
      }
  },
  created() {
      this.initPage()    
  },
  computed: {
    isDesktop() {
          return screen.width > 768 ? true : false
      },
    currDayPlan() {
        if(this.meal_plan.length != 140) return []

        let currDay = this.currWeek * 7 + this.currWeekday
        let retPlan = []
        const select_recipe = (day, time) =>  
        { 
            return this.$_.filter(this.meal_plan, function(item) {
                return item.pivot.cycle == parseInt(day) && item.pivot.mealtime == parseInt(time)
            })
        } 

        for(let i=0; i<5; i<i++) {
            let recipe = select_recipe(currDay, i)[0]
            retPlan.push(recipe)
        }

        return retPlan
    }
  },
  methods: {   
      initPage() {
        if(this.$route.params.id == undefined)
            this.$router.push({name: 'page-error-404'})        
        else if(this.$route.params.id.length != 32)
            this.$router.push({name: 'page-error-404'})

        this.summaryId = this.$route.params.id
        this.$store.dispatch("keto/get_summary_info", this.summaryId).then((response) => {
            if(!response.data.success || this.summaryId != response.data.summaryId) {
                this.$router.push({name: 'page-error-404'})
            } else {
                this.summaryInfo = response.data.userInfo
                
                if(this.summaryInfo.started_at != undefined) {

                    let start = this.$moment(this.summaryInfo.started_at)
                    let current = this.$moment()

                    let dateNo = current.diff(start, 'days') % 28
                    this.currWeek = parseInt(dateNo / 7)
                    this.currWeekday = dateNo % 7
                }

                this.breakfast.length = 28
                this.morning_snack.length = 28
                this.lunch.length = 28
                this.evening_snack.length = 28
                this.dinner.length = 28
                
                let payload = {
                    summaryId: this.summaryId
                }

                this.$store.dispatch("keto/get_meal_plan", payload).then((response) => {
                    if(response.data.success) {
                        // this.breakfast = response.data.meal_plan.breakfast.split('/')
                        // this.morning_snack = response.data.meal_plan.morning_snack.split('/')
                        // this.lunch = response.data.meal_plan.lunch.split('/')
                        // this.evening_snack = response.data.meal_plan.evening_snack.split('/')
                        // this.dinner = response.data.meal_plan.dinner.split('/')

                        this.meal_plan = response.data.meal_plan
                        this.meal_prepared = true
                    } else {
                        this.meal_prepared = false
                    }
                })
            }
        })
      },
      getReplaceItemPhoto(val) {
            if(this.fetchInfo) return val.replace('localhost', 'ketodietstudio-dev.com')
            else return '/images/food-placeholder.png'
        },   
      selectRecipe(val) {
          let payload = {
              summaryId: this.summaryId,
              date: this.currWeek * 7 + this.currWeekday,
              time: this.currTime,
              mealId: val,
          }
          this.$store.dispatch("keto/update_meal_item", payload).then((response) => {              
              if(response.data.success) {
                this.popupActive = false
                this.initPage()                                      
              }
          })
      },
      getReplaceItemPrepareDesc(val) {
            if(val == 31)
                return 'More than 30min'
            else if(val == 60)
                return 'Up to 1hour'
            else if(val == 61)
                return 'More than 1hour'
            else if(val == 90)
                return 'Up to 1hour 30min'
            else if(val == 91)
                return 'More than 1hour 30min'
            else if(val == 120)
                return 'Up to 2hours'
            else if(val == 121)
                return 'More than 2hours'
            else 
                return 'Up to ' + val + 'min'
        },
      getTrimDesc(val) {
        let maxLen = screen.width > 768 ? 20 : 16
        if(val.length > maxLen)
            return val.substr(0, maxLen)
        else    
            return val
    },
      showReplacePopup(val) {
        let payload = {
            summaryId: this.summaryId,
            time: val              
        }
        this.currTime = val
        this.$store.dispatch("keto/get_replace_item", payload).then((response) => {
            if(response.data.success) {
                this.replaceItems = response.data.items
                this.fetchInfo = true
                this.popupActive = true
            }            
        })
      },
      prevWeek() {
          this.currWeek = ((this.currWeek + 3) % 4)
      },
      nextWeek() {
          this.currWeek = ((this.currWeek + 5) % 4)
      },
      getCurrWeekDesc() {
          return (this.currWeek + 1)
      },
      setCurrWeekday(val) {
          this.currWeekday = val
      },
      getWeekdayActive(val) {
          if(this.currWeekday == val)   return 'active'
          else return ''
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

      },
      updateFoodPlan() {
          
      }
  },
  mounted() {
    this.$root.$on("replace_recipe_item", (data) => {
        this.showReplacePopup(data.time)
    })
  }

}
</script>
