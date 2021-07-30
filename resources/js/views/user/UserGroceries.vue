<template>
    <div class="w-full mx-auto">
        <div v-if="isDesktop" class="tabs-nav inner">
            <div class="tabs-wrapper">
                <router-link :to="{path: `/plan/profile/` + summaryId}" class="tabs-logo">
                    <img class="w-64" src="@assets/images/logo/logo.png" alt="KetoDietStudio">
                </router-link>                    
                <router-link :to="{path: `/plan/profile/` + summaryId}" class="profile-tab tab-item">
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
                        </div>
                    </div>
                    <div class="w-full mt-5 mb-5">
                        <p class="grocery-list-title">Grocery list</p>
                    </div>
                    <div class="w-full" v-show="grocery_prepared">
                        <div v-for="item in grocery_list" :key="item.name">
                            <!-- <p class="ml-5 mt-5"><strong>{{ item.name }}</strong> - {{ getGroceryItem(item) }}</p> -->
                            <p class="ml-5 mt-5"><strong>{{ item.name }}</strong></p>
                        </div>
                    </div>
                </vx-card>
            </div>
        </div> 
    </div>
</template>

<style lang="scss">
.grocery-list-title {
    font-size: 23px;
    font-weight: 700;
}
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
        padding-top: 20px;
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
        @media (max-width:700px) { width: 14px !important; }
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
import VerticalUserNavMenu from "../../components/VerticalUserNavMenu.vue"

export default {
  components: {
      VerticalUserNavMenu,
  },
  data() {
      return {
        fetchInfo: false,
        currWeek: 0,
        currWeekday: 0,
        summaryId: null,
        summaryInfo: [],
        grocery_prepared: false,
        currTime: 0,
        grocery_list: [],
      }
  },
  created() {
      this.initPage()    
  },
  computed: {
    isDesktop() {
        return screen.width > 768 ? true : false
    },
    groceryList() {
        if(!this.grocery_prepared)
            return []
        
        if(!this.currWeek)
            return []
        
        if(!this.grocery_list) 
            return []

        return this.grocery_list
    },
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
                    summaryId: this.summaryId,
                    week: this.currWeek
                }

                this.$store.dispatch("keto/get_grocery_list", payload).then((response) => {
                    if(response.data.success) {
                        this.grocery_list = response.data.grocery
                        this.grocery_prepared = true
                    } else {
                        this.grocery_prepared = false
                    }
                })
            }
        })
      },
      getGroceryItem(list) {
          let retVal = ''
          for(var index of Object.keys(list)) {
            if(index != 'name') {
                if(index == '') 
                    retVal += list[index]
                else
                    retVal += list[index] + ' ' + index + ', '
            }
          }
          return retVal.substring(0, retVal.length - 1)
      },
      getCurrWeekDesc() {
          return (this.currWeek + 1)
      },
      prevWeek() {
        this.currWeek = ((this.currWeek + 3) % 4)

        let payload = {
            summaryId: this.summaryId,
            week: this.currWeek
        }

        this.$store.dispatch("keto/get_grocery_list", payload).then((response) => {
            if(response.data.success) {
                this.grocery_list = response.data.grocery
                this.grocery_prepared = true
            } else {
                this.grocery_prepared = false
            }
        })
      },
      nextWeek() {
        this.currWeek = ((this.currWeek + 5) % 4)

        let payload = {
            summaryId: this.summaryId,
            week: this.currWeek
        }

        this.$store.dispatch("keto/get_grocery_list", payload).then((response) => {
            if(response.data.success) {
                this.grocery_list = response.data.grocery
                this.grocery_prepared = true
            } else {
                this.grocery_prepared = false
            }
        })
      },
      capitalize(item) {
        if (typeof item !== 'string') return ''
        return item.charAt(0).toUpperCase() + item.slice(1)
      },
  },
  mounted() {
  }

}
</script>
