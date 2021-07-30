<template>
    <div class="summary-panel mx-auto w-full lg:w-2/4 max-w-screen-md" id="summary_info">

        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
            </div>
        </div>

        <div class="vx-row">
            <div class="vx-col w-full mb-5">
                <div class="mx-auto text-left mb-10">
                    <h1 class="font-bold text-primary">Get your personalized Keto Diet</h1>
                    <h3 class="font-bold text-dark mt-5">Based on your answers, you will be...</h3>
                </div>
                <div class="vx-row">
                    <div class="vx-col w-full mb-5">
                        <vx-card>                
                            <div class="b-blocks-featured">
                                <div class="b-result b-result--weight">
                                    <div class="b-stats" >
                                        <div class="b-stats--header" v-show="measurement.unit == 1">
                                            <p>{{parseInt(measurement.target_kg) + 2}}</p>
                                            <p>{{parseInt(measurement.target_kg) + 1}}</p>
                                            <p class="e-special">{{parseInt(measurement.target_kg)}} <span>{{getUnitSymbol(measurement.unit)}}</span></p>
                                            <p>{{parseInt(measurement.target_kg) - 1}}</p>
                                            <p>{{parseInt(measurement.target_kg) - 2}}</p>
                                        </div>
                                        <div class="b-stats--header" v-show="measurement.unit == 0">
                                            <p>{{parseInt(measurement.target_lb) + 2}}</p>
                                            <p>{{parseInt(measurement.target_lb) + 1}}</p>
                                            <p class="e-special">{{measurement.target_lb}} <span>{{getUnitSymbol(measurement.unit)}}</span></p>
                                            <p>{{parseInt(measurement.target_lb) - 1}}</p>
                                            <p>{{parseInt(measurement.target_lb) - 2}}</p>
                                        </div>
                                        <div class="b-stats--footer">
                                            <p>
                                                by
                                                <span class="e-month">&nbsp;{{getTargetDatetime() | moment("MMM, YYYY")}}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="b-months" >
                                        <p class="back-url" />
                                        <div class="b-stats--header">
                                            <p>{{getCurrentDatetimeMonth(measurement.created_at)}}</p>
                                            <p>
                                                <b>{{getTargetDatetime() | moment("MMM")}}</b>
                                            </p>
                                        </div>
                                        <div class="b-stats--results">
                                            <div class="b-stats--results--from">
                                                {{ getFromWeight() }}
                                                <span>{{getUnitSymbol(measurement.unit)}}</span>
                                                <p />
                                            </div>
                                            <div class="b-stats--results--to">
                                                {{ getTargetWeight() }}
                                                <span>{{getUnitSymbol(measurement.unit)}}</span>
                                                <p />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </vx-card>
                    </div>
                </div>
                <div class="vx-row">
                    <div class="vx-col w-full sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2 mb-5">
                        <vx-card>                
                            <div class="b-result b-result--text">
                                <div class="b-stats--header">
                                    87 <span>%</span>
                                </div>
                                <div class="b-stats--footer" > 
                                    Similar people
                                    <b>lost</b> more than
                                    <span class="e-special">{{ getDietAmount(measurement.unit) }}</span>
                                    <b>{{getUnitSymbol(measurement.unit)}}</b> on Keto
                                </div>
                            </div>
                        </vx-card>
                    </div>
                    <div class="vx-col w-full sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2 mb-5">
                        <vx-card>                
                            <div class="b-result b-result--firstweek">
                                <div class="b-stats--header">
                                    <div class="b-days">
                                        <div class="b-day">
                                            <span class="e-name">Mon</span>
                                            <span class="e-number">1</span>
                                        </div>
                                        <div class="b-day">
                                            <span class="e-name">Tue</span>
                                            <span class="e-number">2</span>
                                        </div>
                                        <div class="b-day">
                                            <span class="e-name">Web</span>
                                            <span class="e-number">3</span>
                                        </div>
                                        <div class="b-day">
                                            <span class="e-name">Thu</span>
                                            <span class="e-number">4</span>
                                        </div>
                                        <div class="b-day">
                                            <span class="e-name">Fri</span>
                                            <span class="e-number">5</span>
                                        </div>
                                        <div class="b-day">
                                            <span class="e-name">Sat</span>
                                            <span class="e-number">6</span>
                                        </div>
                                        <div class="b-day">
                                            <span class="e-name">Sun</span>
                                            <span class="e-number">7</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="b-stats--footer" >
                                    <div class="e-special">
                                        <span>-3</span> {{getUnitSymbol(measurement.unit)}}
                                    </div>
                                    <p>After first week</p>
                                </div>
                            </div>
                        </vx-card>
                    </div>
                </div>

                <vs-button @click="nextpage" type="relief" size="large" class="mb-6 w-full mt-5" color="primary"><strong>Start diet plan</strong></vs-button>

                <div class="mx-auto text-center mt-20 mb-10">
                    <h1 class="font-bold text-dark">Personal Summary</h1>
                </div>
                <div class="vx-row">
                    <div class="vx-col w-full sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2 mb-5">
                        <vx-card>                
                            <div id="bmi" class="b-result results-box">
                                <div :class="`e-row ` + isSelected(0)">
                                    <span class="e-value"><span class="e-number">{{ getUserBmi() }}</span> BMI</span>
                                    <span class="e-name">Overweight</span>
                                </div>
                                <div :class="`e-row ` + isSelected(1)">
                                    <span class="e-value"><span class="e-number">{{ getUserBmi() }}</span> BMI</span>
                                    <span class="e-name">Normal</span>
                                </div>
                                <div :class="`e-row ` + isSelected(2)">
                                    <span class="e-value"><span class="e-number">{{ getUserBmi() }}</span> BMI</span>
                                    <span class="e-name">Underweight</span>
                                </div>
                            </div>
                        </vx-card>
                    </div>
                    <div class="vx-col w-full sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2 mb-5">
                        <vx-card>                
                            <div id="intake" class="b-result results-box">
                                <div class="e-heading">
                                    Daily calorie intake
                                </div>
                                <div class="e-value">
                                    <div class="daily-norm">
                                        <span>{{ getCalorieStr() }}</span>
                                    </div>
                                </div>
                                <div class="e-measurement">kCal</div>
                                <img src="@assets/images/items/daily-calorie.png" alt="">
                            </div>
                        </vx-card>
                    </div>
                </div>
                <div class="vx-row">
                    <div class="vx-col w-full sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2 mb-5">
                        <vx-card>                
                            <div id="body-parts" class="b-result results-box">
                                <div class="e-heading">
                                Body change estimations
                                </div>
                                <img src="@assets/images/items/body-change-estimations.png" alt="">
                            </div>
                        </vx-card>
                    </div>
                    <div class="vx-col w-full sm:w-full md:w-1/2 lg:w-1/2 xl:w-1/2 mb-5">
                        <vx-card>                
                            <div id="meals" class="results-box">
                                <div class="meal-count" style="max-width: 240px;width: 100%;margin: auto;left: 0;right: 0;">
                                    <span>1000+</span>
                                </div>
                                <img src="@assets/images/items/unique-recipes.png">
                                <p>Unique food variations for you</p>
                            </div>
                        </vx-card>
                    </div>
                </div>

                <vs-button @click="nextpage" type="relief" size="large" class="mb-6 w-full mt-5" color="primary"><strong>Start diet plan</strong></vs-button>

            </div>
            <div class="vx-col w-1/8 mb-2" />
        </div> 
    </div>
</template>

<style lang="scss">
#meals {
    padding-bottom: 10px;
    .meal-count {
        position: absolute;
        top: 32%;
        width: 120px;
        left: 50%;
        margin-top: -30px;
        margin-left: -60px;
        color: #ff3464;    
    }

    span {
        font-size: 63px;
        @media (min-width:1025px) { font-size: 63px; }        
        @media (max-width:700px) { font-size: 48px; }
        color: #ff3464;
        text-align: center;
        display: block;
        line-height: 36px;
        font-weight: 700;
    }

    img {
        // padding-top: 35px;
        @media (min-width:1600px) { padding-top: 45px; }
        @media (min-width:1025px) { padding-top: 35px; }
        @media (min-width:1025px) { padding-top: 35px; }
        @media (max-width:700px) { padding-top: 15px; }
        // margin-top: -10px;
        max-width: 100px;
        margin: auto;
    }

    p {
        margin-bottom: 30px;
        font-weight: 700;
        margin-top: 55px;
        text-align: center;
        font-size: 22px;
        @media (min-width:1025px) { font-size: 22px; }        
        @media (max-width:700px) { font-size: 18px; }
        max-width: 180px;
        margin: auto;
        line-height: 26px;
        // margin-top: 40px;
        // margin-bottom: 30px;
        padding-bottom: 40px;
        font-weight: 700;
    }
}

#body-parts {
    .e-heading {
        text-align: center;
        font-size: 23px;
        max-width: 200px;
        margin: auto;
        padding-top: 20px;
        padding-bottom: 15px;
        line-height: 24px;
        font-weight: 700;
    }

    img {
        max-width: 100%;
    }
}
#intake {

    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;

    .e-heading {
        font-weight: 700;
        text-align: center;
        max-width: 80%;
        font-size: 23px;
        padding-top: 15px;
    }

    .e-value {
        font-size: 43px;
        font-weight: 700;
        color: #ff3464;
        line-height: 40px;
    }

    .daily-norm {
        position: relative;
        top: 0;
        font-size: 28px;
        line-height: 43px;
        color: #ff3464;

        span {
            display: block;
            font-weight: 700;
        }
    }

    .e-measurement {
        font-size: 18px;
    }

    img {
        max-width: 250px;
        margin-top: 15px;
        width: 100%;
    }
}

#bmi {
    .e-row {

        height: 33.33333%;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;

        .e-name {
            font-size: 23px;
            font-weight: 700;
            margin-left: auto;
            @media (max-width:700px) { font-size: 18px; }
        }

        .e-value {
            text-transform: uppercase;
            font-size: 23px;
            @media (max-width:700px) { font-size: 18px; }
            color: #ff3464;
            display: none;
        }

        .e-number {
            font-size: 46px;
            @media (max-width:700px) { font-size: 23px; }
            font-weight: 700;
        }
    }

    .is-selected {
        background: rgba(86,70,143,.1);

        .e-value {
            display: block;
        }
    }
}
.button-group {
    text-align: center;
    background: #e4e5e7;
}
#summary_info {
    .vx-card__body {
        min-height: 200px;
        padding: 0px;
    }
}
.b-result--firstweek {    
    min-height: 280px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 100%;
    margin-top: 0;

    .b-stats--footer {
        text-align: center;

        .e-special {
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 33px;
            color: #ff3464;

            span {
                font-size: 90px;
                color: #ff3464;
                font-weight: 700;
            }

            .b-stats--footer p {
                font-size: 23px;
                text-align: center;
                padding-bottom: 10px;
                margin-top: -5px;
            }
        }
    }

    .b-stats--header {
        max-width: 380px;
        padding-top: 10px;
        padding: 20px;
        padding-bottom: 10px;

        .b-days {
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            text-transform: uppercase;
            font-size: 15px;
            color: #dfe0e1;
            min-height: 50px;
            display: flex;

            .b-day:last-child {
                color: rgba(255,45,99,.6);
                .e-number {
                    color: rgba(255,45,99,.6);
                }
            }
            .b-day {
                position: relative;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                -webkit-box-align: center;
                -ms-flex-align: center;
                align-items: center;
                padding-bottom: 8px;
                min-width: 40px;
                display: flex;

                .e-number {
                    color: #000;
                    font-size: 17px;
                }
            }
        }
    }
}

.b-result--text {
    min-height: 280px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    text-align: center;

    .b-stats--header {
        margin-top: auto;
        font-size: 90px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: flex-end;
        -webkit-box-align: baseline;
        -ms-flex-align: baseline;
        align-items: baseline;
        font-weight: 700;
        color: #ff3464;

        span {
            font-size: 34px;
        }
    }
    .b-stats--footer {
        font-size: 20px;
        max-width: 240px;
        margin: auto;
        line-height: 28px;
        padding-top: 10px;
        margin-top: 15px;
        margin-bottom: 25px;
        font-family: Karla,Montserrat,Arial;

        .e-special {
            color: #ff3464;
            font-size: 27px;
            font-weight: 700;
        }
    }        

}
.b-blocks-featured {
    padding-top: 10px;
    padding-bottom: 0px;
    /* display: -webkit-box; */
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;

    .b-result--weight {
        max-width: 100%;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 0px;
        background: #fff;

        .b-months {
            position: relative;
            background: rgba(255,52,100,.1);
            max-width: 100%;
            margin: 0;
            max-height: none;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            top: 41%;
            font-size: 20px;
            margin: auto;

            p.back-url {
                background-position-x: 50%;
                background-position-y: center;
                background-image: url(/images/elements/b-results-graph.png);
                content: "";
                position: absolute;
                left: 0;
                right: 0;
                width: 100%;
                min-height: 200px;
                background-size: cover;
                bottom: -25px;
            }
            

            .b-stats--header {
                padding-top: 20px;
                max-width: 335px;
                margin: auto;
                display: flex;
                -webkit-box-pack: justify;
                justify-content: space-between;

                p {
                    margin-left: 5%;
                    margin-right: 5%;
                    margin: 0 0 11px;
                }
            }

            .b-stats--results {
                min-height: 230px;
                max-width: 320px;
                margin: auto;
                padding-bottom: 50px;
                display: flex;
                -webkit-box-pack: justify;
                justify-content: space-between;

                .b-stats--results--to {
                    position: relative;
                    margin-bottom: 18px;
                    color: #ff3464;
                    margin-top: auto;
                    margin-right: 2px;
                    display: flex;
                    -webkit-box-orient: vertical;
                    -webkit-box-direction: normal;
                    flex-direction: column;
                    -webkit-box-align: center;
                    align-items: center;
                    font-size: 33px;
                    line-height: 26px;

                    span {
                        font-size: 13px;
                    }

                    p {
                        content: "";
                        position: absolute;
                        left: 0;
                        right: 0;
                        margin: auto;
                        width: 17px;
                        background: #ff3464;
                        height: 17px;
                        border-radius: 20px;
                        top: 70px;
                    }
                }

                .b-stats--results--from {
                    position: relative;
                    left: 10px;
                    // margin-top: 20px;
                    font-size: 23px;
                    margin-left: 0;
                    display: flex;
                    -webkit-box-orient: vertical;
                    -webkit-box-direction: normal;
                    flex-direction: column;
                    -webkit-box-align: center;
                    align-items: center;
                    line-height: 26px;

                    p {
                        content: "";
                        position: absolute;
                        left: 0;
                        right: 0;
                        margin: auto;
                        width: 17px;
                        background: #ff3464;
                        height: 17px;
                        border-radius: 20px;
                        top: 70px;
                    }

                    span {
                        font-size: 13px;
                    }
                }
            }
        }

        .b-stats {
            background: #fff;
            position: relative;
            width: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            min-height: 200px;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            max-height: 212px;
            text-align: center;

            .b-stats--footer {
                margin-bottom: auto;
                padding-top: 10px;
                font-size: 24px;
                font-weight: 700;
            }
            .b-stats--header {
                max-width: 90%;
                width: 100%;
                -webkit-box-pack: center;
                justify-content: center;
                overflow: hidden;
                padding-bottom: 10px;
                padding-top: 15px;
                margin-top: auto;
                margin-bottom: 0;
                align-items: center;
                font-size: 27px;
                font-weight: 700;
                color: #ff3464;
                -webkit-box-align: center;
                display: flex;
                margin: auto;

                p {
                    margin: 0;
                    opacity: .4;
                    margin-left: 5%;
                    margin-right: 5%;                    
                }

                p.e-special {
                    margin-left: 5%;
                    margin-right: 5%;
                    display: -webkit-box;
                    display: flex;
                    -webkit-box-orient: vertical;
                    -webkit-box-direction: normal;
                    flex-direction: column;
                    font-size: 73px;
                    line-height: 73px;
                    opacity: 1;
                    span {
                        font-size: 18px;
                        line-height: 12px;
                        color: #444;
                        font-weight: 300;
                    }
                }
            }
        }
    }

    .b-result {
        width: 100%;
        margin-top: 0;
        min-height: 215px;
    }
}
</style>

<script>
export default {
  data() {
      return {
        btn_colorx: '#ffffff',
        summaryId: null,
        summaryInfo: [],
        paymentInfo: null,
        bmiClass: -1,
        isFetched: false,
        monthNames: ["January", "February", "March", "April", "May","June","July", "August", "September", "October", "November","December"]
      }
  },
  computed: {
      measurement() {
        //   return this.$store.state.keto.summaryInfo
          return this.summaryInfo
      }
  },
  created() {    
    // check router variable
    if(this.$route.params.id == undefined)
        this.$router.push({name: 'page-error-404'})
    else if(this.$route.params.id.length != 32)
        this.$router.push({name: 'page-error-404'})

    // set the summary id 
    this.summaryId = this.$route.params.id

    // get the user information
    this.$store.dispatch("keto/get_summary_info", this.summaryId).then((response) => {
        this.paymentInfo = response.data.paymentInfo
        if(!response.data.success || this.summaryId != response.data.summaryId) {
            // if failed, redirect to 404 page
            this.$router.push({name: 'page-error-404'})
        } else {
            //  save information
            this.summaryInfo = response.data.userInfo
            this.isFetched = true

            // set the bmi value of the user
            let bmiVal = parseFloat(this.summaryInfo.bmi)
            if(bmiVal <= 18.5)  {
                this.bmiClass = 2
            } else if(bmiVal > 18.5 && bmiVal <= 24.9) {
                this.bmiClass = 1
            } else if(bmiVal > 25) {
                this.bmiClass = 0
            }

            // this.$cookies.set('summaryId', this.summaryId)
            // this.$store.dispatch("keto/set_summary_info", response).then((res) => {
                
            // })
        }
    })
  },
  beforeRouteEnter(to, from, next) {
    next()
  },
  methods: {
      getDietAmount(val) {
          if(val) return 4
          else return 20
      },
      getCalorieStr() {
          if(!this.isFetched) return ''
          let calorie = (Math.floor(parseFloat(this.summaryInfo.calorie) / 10) * 10)
          return (calorie - 75) + '-' + (calorie + 75) 
      },
      getUserBmi() {
        if(this.isFetched)
            return this.summaryInfo.bmi
        else
            return ''
      },
      isSelected(val) {
        if(!this.isFetched) {
            return ''
        }

        if(this.bmiClass == val) return 'is-selected'
        else return ''
      },
      getFromWeight() {
        if(parseInt(this.summaryInfo.unit))
            return this.summaryInfo.weight_kg
        else
            return this.summaryInfo.weight_lb
      },
      getTargetWeight() {
        if(parseInt(this.summaryInfo.unit)) {
            return this.summaryInfo.target_kg
        } else {
            return this.summaryInfo.target_lb
        }
      },
      getUnitSymbol(unit) {
          return parseInt(unit) == 0 ? 'lb' : 'kg'
      },
      getCurrentDatetimeMonth(datetime) {
          if(datetime == undefined) return
        var date = new Date(datetime.split(' ')[0])
          return this.$moment(date).format('MMM')
      },
      getTargetDatetime() {
        let datetime = this.summaryInfo.created_at
        if(datetime == undefined) return ''

        // calculate the duration for the user's diet plan
        let monthVal = 0
        if(parseInt(this.summaryInfo.unit)) {
            monthVal = Math.floor(Math.abs(parseFloat(this.summaryInfo.weight_kg) - parseFloat(this.summaryInfo.target_kg)) / 4.0) + 1
        } else {
            monthVal = Math.floor(Math.abs(parseFloat(this.summaryInfo.weight_lb) - parseFloat(this.summaryInfo.target_lb)) / 8.81849) + 1
        }

        // add the duration to the start datetime
        let currDate = this.$moment(datetime)
        let targetDate = currDate.add(monthVal, 'months')
        return targetDate
      },
      selectProduct(product) {
          
      },
      nextpage() {
        if(this.paymentInfo) {
            this.$router.push({name: 'keto-user-profile', params: { id: this.summaryId }})
        } else {
            this.$router.push({name: 'keto-email', params: { id: this.summaryId }})
        }
      },
  }
}
</script>
