<template>
    <div class="w-full mx-auto">
        <div v-if="isDesktop" class="tabs-nav inner">
            <div class="tabs-wrapper">
                <router-link :to="{path: `/myplan/`}" class="tabs-logo">
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
                    <div class="navbar-wrapper mb-10">
                        <div class="container">
                            <div class="greet-user">
                                <h1 class="mb-4">
                                    Welcome, {{ summaryInfo.name }}!
                                </h1>
                                <p>Take a short quiz and receive a personalized meal plan. </p>
                            </div>
                        </div>
                    </div>
                    <div class="navbar-wrapper mb-10">
                        <div class="container">
                            <div class="greet-user">
                                <h1 class="mb-4">Today's Recipes</h1>
                            </div>
                        </div>
                    </div>
                    <div class="w-full" v-show="true">
                        <meal-plan-item ref="recipeItem" v-for="(item, index) in this.currDayPlan" :mealInfo="item" :key="index" :showOnly="true" />
                    </div>
                    <div class="vx-col fill-row-loading w-full text-center">
                        <vs-button @click="openMealPlan" type="relief" size="medium" class="mt-5 w-2/5 mx-auto" color="primary" style="padding-left: 0;padding-right: 0;"><strong>Open meal plan</strong></vs-button>                       
                        <vs-button @click="getNew" type="relief" size="medium" class="mt-5 w-2/5 mx-auto" color="primary"><strong>Get new</strong></vs-button>                       
                    </div>

                    <vs-divider class="mt-10 my-6 md:my-12 vs-divider"></vs-divider>

                    <div class="navbar-wrapper mb-10">
                        <div class="container">
                            <div class="greet-user">
                                <h1 class="mt-10">
                                    Learn Keto
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="learn-keto mb-10 vx-row" v-show="true">
                        <img class="mt-10 mb-6 mr-5 meal-photo" src="@assets/images/slides/bacon.png" @click="learnKeto" alt="1" />
                        <p class="sm:w-3/4 md:w-3/4 lg:w-3/4 mt-8 learn-title">What is Keto?</p>
                    </div>
                    
                    <div class="learn-keto mb-10 vx-row" v-show="true">
                        <img class="mt-10 mb-6 mr-5 meal-photo" src="@assets/images/slides/burger.png" alt="1" />
                        <p class="sm:w-3/4 md:w-3/4 lg:w-3/4 mt-8 learn-title">Do's and Don'ts</p>
                    </div>

                    <div class="navbar-wrapper">
                        <div class="container">
                            <div class="greet-user">
                                <h1 class="mb-4 mt-10">
                                    Ask us a question.
                                </h1>
                                <p>Take a short quiz and receive a personalized meal plan. </p>
                                <p>Take a short quiz and receive a personalized meal plan. </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-10 mb-8">
                        <h4>hello@ketodietstudio.com</h4>
                    </div>
                    <div class="contact__form-item">
                        <span class="wpcf7-form-control-wrap message"><textarea name="message" v-model="message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required form-control w-input" id="message" aria-required="true" aria-invalid="false" placeholder="Your message"></textarea></span>
                    </div>
                    <vs-button @click="sendMessage" color="primary" type="relief">Send Message</vs-button>
                </vx-card>
            </div>
        </div>  
    </div>
</template>

<style lang="scss">
.learn-title {
    font-size: 15pt;
    font-weight: bold;
    vertical-align: middle;
}
h1 {
    vertical-align: middle;
}
.container {
    min-height: 50px;
    width: 100%;
}

.navbar {
    position: relative;
    min-height: 50px;
    margin-bottom: 22px;
    border: 1px solid transparent;
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

.learn-keto {
    margin-bottom: 15px;
    border-radius: 9px;
    padding-bottom: 5px;
    background-color: #fff;
    box-shadow: 0 4px 11px 4px rgba(86, 70, 143, 0.3);  
}

.vs-divider {
    width: 100%;
    border-top: 1px solid rgb(5, 5, 5);
}

.contact__form-item {
    padding-bottom: 17px;

    .contact__form {
        font-size: 12px;
        width: 100%;
        height: 64px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    .wpcf7-form-control-wrap {
        position: relative;

        textarea {
            background: #f5f5f5;
            border: 1px solid #c9c9cf;
            padding: 0 24px;
            height: 56px;
            width: 100%;
            font-weight: 700;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #94949e;                
        }

        textarea {
            height: 168px;
            font-weight: 400;
            text-transform: none;
            padding: 15px 24px;
        }
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
        summaryId: null,
        summaryInfo: [],
        meal_prepared: false,
        meal_plan: [],
        message: '',
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
                
                let payload = {
                    summaryId: this.summaryId
                }

                this.$store.dispatch("keto/get_meal_plan", payload).then((response) => {
                    if(response.data.success) {
                        this.meal_plan = response.data.meal_plan
                        this.meal_prepared = true
                    } else {
                        this.meal_prepared = false
                    }
                })
            }
        })
      },
      openMealPlan() {
        let payload = {
            summaryId: this.summaryId,              
        }

        this.$store.dispatch("keto/get_meal_plan", payload).then((response) => {
            if(response.data.success) {
                this.$router.push({name: 'keto-user-plan', params: { id: response.data.summaryId}})
            }            
        })        
      },
      getNew() {
        let payload = {
            summaryId: this.summaryId,    
            currDay: this.currWeek * 7 + this.currWeekday,       
        }

        this.$store.dispatch("keto/update_currDay_meal", payload).then((response) => {
            if(response.data.success) {
                this.initPage()
            } else {
                alert(response.data.error)
            }            
        })         
      },
      learnKeto() {
        this.$router.push({name: 'keto-user-learnketo', params: {id : this.summaryId}})
      },
      sendMessage() {
        let payload = {
            user_message: this.message,
            user_name: "",
            user_emailAddr: "",
        }

        if (this.message == '') {
            alert('Please input your message.');
        } else {
            this.$store.dispatch("keto/send_email", payload).then((response) => {
                if(response.data.success){
                    alert('Sent your Email successfully!')
                }
                else {
                    alert(response.error)
                }
            })
        }
      }
  },
}
</script>
