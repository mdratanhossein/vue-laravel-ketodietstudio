<template>
    <div id="user_plan">
        <div v-if="isDesktop" class="tabs-nav inner">
            <div class="tabs-wrapper">
                <router-link :to="{path: `/plan/profile/` + summaryId}" class="tabs-logo">
                    <img class="w-64" src="@assets/images/logo/logo.png" alt="KetoDietStudio">
                </router-link>                    
                <router-link :to="{path: `/plan/profile/` + summaryId}" class="profile-tab tab-item ">
                    <img src="@assets/images/icons/icon-profile.svg"> My profile
                </router-link>
                <router-link :to="{path: `/plan/progress/` + summaryId}" class="meals-tab tab-item active">
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
            <!-- CARD 1: CONGRATS -->
            <div class="vx-col w-1/8 mb-2" />
            <div class="vx-col w-full mb-base">
                <vx-card>
                    <div class="vx-col w-full mt-5 mb-5">
                        <h2 class="font-bold">My Progress</h2>
                        <div class="cycle-columns">
                            <div class="cycle-col current-cycle">
                                <div class="cycle-label">Starting weight</div>
                                <div class="cycle-value">{{ getStartingWeight() }}</div>
                            </div>
                            <!-- <div class="cycle-col current-cycle mobile-only">
                                <div class="cycle-label">Ends at</div>
                                <div class="cycle-value">Apr 13th</div>
                            </div> -->
                            <div class="cycle-col current-cycle">
                                <div class="cycle-label">Current weight</div>
                                <div class="cycle-value">{{ curWeight }}</div>
                            </div>
                            <div class="cycle-col current-cycle">
                                <div class="cycle-label">Target weight</div>
                                <div class="cycle-value">{{ getTargetWeight() }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="fill-row-loading w-full mt-10">
                        <vue-apex-charts type="area" height="350" :options="chartoptions" :series="chartdata"></vue-apex-charts>
                    </div>

                    <vs-divider class="my-6"></vs-divider>
                    <div class="w-full mt-5 mb-5">
                        <h2 class="font-bold">Enter your current weight</h2>
                        <p class="mt-5">
                        </p>
                    </div>

                    <div v-if="parseInt(this.summaryInfo.unitSystem)">
                        <vs-input v-validate="'required|between:5,250'" label="" name="weight" v-model="current_weight" type="text" class="mt-5 w-full" />
                        <span class="text-danger text-sm" v-show="errors.has('weight')">{{ errors.first('weight') }}</span>
                    </div>

                    <div v-else>
                        <vs-input v-validate="'between:50,500'" label="" name="weight" v-model="current_weight" type="text" class="mt-5 w-full" />
                        <span class="text-danger text-sm" v-show="errors.has('weight')">{{ errors.first('weight') }}</span>
                    </div>
                    
                    <div class="fill-row-loading w-full">
                        <!-- <div v-show="curStatus==1" id="loading_metric" class="vs-con-loading__container loading-example" /> -->
                        <vs-button @click="saveWeightEntry" type="relief" size="large" class="mt-5 mb-6 w-full" color="primary"><strong>Save Weight Entry</strong></vs-button>                        
                    </div>
                    <vs-divider class="my-6"></vs-divider>

                    <div class="w-full mt-5 mb-5">
                        <h2 class="font-bold">Weight History</h2>
                    </div>

                    <div class="mx-auto">
                        <vs-table stripe :data="progresses" class="w-full">

                            <template slot="thead">
                                <vs-th>Timestamp</vs-th>
                                <vs-th>Weight</vs-th>
                                <vs-th>Action</vs-th>
                            </template>

                            <template slot-scope="{data}">
                                <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                                    <vs-td :data="data[indextr].created_at">
                                        {{ getDatetimeStr(data[indextr].created_at) }}
                                    </vs-td>
                                    <vs-td>
                                        {{ getWeightStr(indextr) }}
                                    </vs-td>
                                    <vs-td>
                                        <a class="remove-btn" href="#" @click="remove_progress(data[indextr].id)">Remove</a>
                                    </vs-td>
                                </vs-tr>
                            </template>
                        </vs-table>
                    </div>
                </vx-card>
            </div>
            <div class="vx-col w-1/8 mb-2" />
        </div> 
    </div>
</template>

<style lang="scss">
.remove-btn {
    background: #e6e6e6;
    color: #333;
    padding: 5px 15px;
    display: inline-block;
    margin-bottom: 0;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.6;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
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
import VueApexCharts from 'vue-apexcharts'
import VerticalUserNavMenu from "../../components/VerticalUserNavMenu.vue"

export default {
  components: {
      VueApexCharts,
      VerticalUserNavMenu,
  },
  data() {
      return {
        isMyPlan: false,
        summaryId: null,
        summaryInfo: [],
        kg2lbs: 2.20462,
        lbs2kg: 0.453592,
        current_weight: null,      
        fetchFlag: false,  
      }
  },
  created() {
    this.startPage()    
  },
  mounted() {
    
  },
  computed: {
      isDesktop() {
          return screen.width > 768 ? true : false
      },
      showChart() {
          return this.fetchFlag
      },
      chartoptions() {
        return {
            markers: {
                size: 10,
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            colors: ['#7367F0', '#28C76F', '#EA5455', '#FF9F43', '#1E1E1E'],
            xaxis: {
                type: 'datetime',
                categories: this.fetchFlag ? this.$store.state.keto.chartData[1]['data'] : [],
                labels: {
                    show: false,
                },
            },
            chart: {
                toolbar: {
                    show: false,
                },
            },
            yaxis: {
                decimalsInFloat: 0,
                // title: {
                //     text: "Price ($)",
                //     style: {
                //         color: '#008FFB',
                //         fontSize: '18px',
                //     }
                // },
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
            scales: {
                xAxes: [{
                    display: false // this hides the x-axis
                }],
            }
        }
    },  
    chartdata() {
        return this.fetchFlag ? this.$store.state.keto.chartData[0] : []
    },
    progresses() {
        return this.$store.state.keto.progresses
    },
    curWeight() {
        if(this.$store.state.keto.progresses.length) {
            return this.getWeightStr(0)
        } else {
            return this.getStartingWeight()
        }
    }
  },
  methods: {
      startPage() {
        if(this.$route.params.id == undefined)
            this.$router.push({name: 'page-error-404'})        
        else if(this.$route.params.id.length != 32)
            this.$router.push({name: 'page-error-404'})

        this.summaryId = this.$route.params.id
        this.$store.dispatch("keto/get_summary_info", this.summaryId).then((response) => {
            if(!response.data.success || this.summaryId != response.data.summaryId || !response.data.paid) {
                this.$router.push({name: 'page-error-404'})
            }
            this.summaryInfo    = response.data.userInfo
            this.summaryId      = response.data.summaryId
            let payload = {
                summaryId: this.summaryId
            }
            this.$store.dispatch("keto/get_progress_list", payload).then((response) => {
                if(response.data.success) {
                    this.fetchFlag = true
                } else {
                    console.log('failed')
                }
            })
        })
      },
      getDatetimeStr(datetimestr) {
          return this.$moment(datetimestr).format('lll')
      },
      getWeightStr(index) {
        let unitSystem = parseInt(this.summaryInfo.unit)
        if(unitSystem) {
            return Math.round(parseFloat(this.$store.state.keto.progresses[index]['weight_kg'])) + ' kg'
        } else {
            return Math.round(parseFloat(this.$store.state.keto.progresses[index]['weight_lb'])) + ' lbs'
        }
      },
      getStartingWeight() {
        let unitSystem = parseInt(this.summaryInfo.unit)
        let startWeight = unitSystem == 0 ? this.summaryInfo.weight_lb : this.summaryInfo.weight_kg  

        if(unitSystem) {
            return Math.round(startWeight) + ' kg'
        } else {
            return Math.round(startWeight) + ' lbs'
        }        
      },
      getCurrentWeight() {
          return ''
      },
      getTargetWeight() {
        let unitSystem = parseInt(this.summaryInfo.unit)
        let startWeight = unitSystem == 0 ? this.summaryInfo.target_lb : this.summaryInfo.target_kg

        if(unitSystem) {
            return Math.round(startWeight) + ' kg'
        } else {
            return Math.round(startWeight) + ' lbs'
        }      
      },
      saveWeightEntry() {
          if(this.current_weight == "" || this.current_weight == 0 || this.current_weight === null)
            return

          let current_weight = Math.round(parseFloat(this.current_weight))

          let payload = {
              summaryId: this.summaryId,
              weight: Math.round(parseFloat(current_weight)),
          }
          this.$store.dispatch("keto/save_weight", payload).then((response) => {
              if(response.data.success) {
                  this.startPage()
                  if(this.current_weight) this.current_weight = ""
              } else {
                  console.log('failed')
              }
          })
      },
      remove_progress(value) {
          let payload = {
              summaryId: this.summaryId,
              progressId: value
          }
          this.$store.dispatch("keto/remove_progress", payload).then((response) => {
              if(response.data.success) {
                  this.startPage()
              } else {
                  console.log('failed')
              }
          })
      }
  }
}
</script>
