<template>
    <div :class="{'meal-plan': true}" v-show="true">
        <img :src="getMealPhoto" class="meal-photo" alt="meal">
        <div class="meal-data">
            <div class="meal-time mt-3">
                {{ getMealTime() }}
            </div>
            <div class="meal-title">
                <span class="mt-10"  @click="viewRecipe">{{ getTrimDesc() }}</span>
                <br>
                <!-- <button @click="updateRecipe" class="mt-5 replace-recipe" data-meal="99155850">
                    Replace recipe
                </button> -->
            </div>
            <div class="arrow-icon" v-show="!showOnly">
                <img @click="updateRecipe" class="refresh-recipe w-6 h-6" src="/images/icons/refresh.svg" alt="Open">
                <img @click="viewRecipe" class="view-recipe w-4 h-6" src="/images/icons/forward-male.svg" alt="Open">
            </div>
        </div>
        <vs-popup class="recipe-popup-view" background-color="rgba(152,152,152,.7)" :background-color-popup="colorx" title="" :active.sync="popupActive">
            <div class="vx-row">
                <div class="vx-col w-full text-center">
                    <img :src="getMealPhoto" class="popup-meal-photo" alt="meal">
                </div>
            </div>
            <div class="vx-row">
                <div class="vx-col w-full text-left">
                    <p class="popup-meal-title mt-5 mb-5">{{ title }} </p>
                </div>
            </div>
            <div class="vx-row">
                <div class="vx-col w-1/2 text-left">
                    <p class="popup-meal-energy mt-5 mb-5">{{ energy }} kcal</p>
                </div>
                <div class="vx-col w-1/2 text-left">
                    <p class="popup-meal-prepare mt-5 mb-5">{{ total_time }}</p>
                </div>
            </div>
            <div class="vx-row">
                <div class="vx-col w-full text-left">
                    <p class="popup-meal-ingredients-desc mt-5 mb-5">Essential recipe ingredients</p>
                </div>
            </div>
            <div class="vx-row">
                <div class="vx-col w-full sm:w-full md:w-full lg:w-3/5 xl:w-3/5 text-left">
                    <!-- <p class="popup-meal-ingredients mt-5 mb-5">{{ ingredients }}</p> -->
                    <p class="popup-meal-ingredients mt-2 mb-2" v-for="(item, index) in ingredients" :key="index">
                        <strong>{{ getIngredient(item.pivot) }}</strong> {{ item.name }}
                    </p>
                </div>
                <div class="vx-col w-full sm:w-full md:w-full lg:w-2/5 xl:w-2/5 text-left">
                    <div class="w-full">
                        <p class="popup-meal-nutrients-desc mt-5 mb-5">Nutrients</p>
                    </div>
                    <div class="w-full">
                        <!-- <p class="popup-meal-nutrients mt-5 mb-5">{{ nutrients }}</p> -->
                        <p class="popup-meal-nutrients mt-2 mb-2" v-for="(item, index) in nutrients" :key="index">
                            <strong>{{ item.pivot.weight }} grams </strong> of {{ item.name }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="vx-row">
                <div class="w-full">
                    <p :class="{active: isActive[index], 'popup-meal-steps':true, 'mt-2':true, 'mb-2':true}" v-for="(item, index) in steps" :key="index">
                        <!-- <input type="checkbox" id="todo" name="todo" value="todo" @click="checkStep(index)"> -->
                        <vs-checkbox v-model="isActive[index]">
                           step {{ index + 1 }}
                        </vs-checkbox>                       
                        {{ item.content }}
                    </p>
                </div>
                <div class="vx-col w-full text-left">
                    <p class="popup-meal-recipe mt-5 mb-5">{{ content }}</p>
                </div>
            </div>
            <div class="vx-row">
                <div class="vx-col w-full text-left">
                    <!--<vs-button :click="printRecipe" type="relief" size="large" class="mt-10 mb-6 w-full" color="primary"><strong>Get my plan</strong></vs-button>                        -->
                </div>
            </div>
        </vs-popup>       
    </div>
</template>

<style lang="scss">
.recipe-popup-view {
    .popup-meal-photo {
        max-width: 100%;
    }
    .popup-meal-title {
        color: #ff3464;
        font-family: Karla,Montserrat;
        font-size: 18px;
        font-weight: 700;
        letter-spacing: .47px;
        line-height: 22px;
    }
    .popup-meal-energy {
        color: #56468f;
        font-family: Karla,Montserrat;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .47px;
        line-height: 16px;
    }
    .popup-meal-ingredients-desc {
        color: #555;
        font-family: Karla,Montserrat;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .47px;
        line-height: 16px;
    }
    .popup-meal-nutrients-desc {
        color: #555;
        font-family: Karla,Montserrat;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .47px;
        line-height: 16px;
    }
    .popup-meal-steps {
        margin-left: 10pt;       
    }
    .active {
        color: red;
    }
}
.meal-data {
    padding-top: 20px;
}
.meal-plan {
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
.meal-photo {
    max-width: 100px;
    @media (max-width:700px) { max-width: 80px !important; }
    float: left;
    margin: 10px;
    cursor: pointer;
}
.meal-time {
    color: #ff3464;
    font-family: Karla,Montserrat;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .41px;
    line-height: 15px;
    cursor: pointer;
}
.meal-title {
    opacity: .9;
    color: #444;
    font-family: Karla,Montserrat;
    font-size: 18px;
    @media (max-width:700px) { font-size: 14px !important; }
    font-weight: 600;
    letter-spacing: .37px;
    line-height: 16px;
    margin-top: 15px;
    @media (max-width:700px) { margin-top: 5px !important; }
    cursor: pointer;
}
.replace-recipe {
    background-color: #56468f!important;
    border-color: #312363!important;
    margin-top: 5px;
    padding: 3px 10px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
    color: #fff;
    cursor: pointer;
}
.arrow-icon {
    position: absolute;
    right: 0;
    text-align: center;
    top: 0;
    width: 34px;
    line-height: 130px;
    height: 100%;
    border-left: 1px solid #f6f6f6;
    display: flex;
    flex-direction: column;
    // cursor: pointer;

    .refresh-recipe {
        top: 16px;
        left: 6px;
    }

    .view-recipe {
        bottom: 16px;
        left: 12px;
    }

    img {
        position: absolute;
        cursor: pointer;
    }
}
</style>

<script>
export default {
    props: {
        mealInfo: Object,
        showOnly: Boolean,
    },
    computed: {
        getMealPhoto() {
            return this.mealInfo.image_url.replace('http://localhost/', '/')
            // return '/images/food-placeholder.png'
        },
    },
    methods: {    
        getIngredient(item) {
            if(item.type_metric != "") {
                return item.count_metric + " " + item.type_metric + "s"
            } else if(item.type_imperial != "") {
                return item.count_imperial + " " + item.type_imperial + "s"
            }
        },
        viewRecipe() {
            let payload = {
                id: this.mealInfo.id
            }
            this.$store.dispatch("keto/get_meal_info", payload).then((response) => {
                if(response.data.success) {
                    
                    this.title          = response.data.meal_info.title
                    this.imgFile        = response.data.meal_info.image_url
                    this.meal_type      = response.data.meal_info.meal_type
                    this.total_time     = response.data.meal_info.prep
                    this.energy         = response.data.meal_info.energy
                    this.ingredients    = response.data.meal_info.ingredients
                    this.nutrients      = response.data.meal_info.nutrients
                    this.content        = response.data.meal_info.content
                    this.steps          = response.data.meal_info.steps
                    this.status = true

                    this.popupActive = true

                    for(var i=0; i<this.steps.length; i++) {
                        this.isActive[i] = false
                    }
                }
            })            
        },
        updateRecipe() {
            this.$root.$emit("replace_recipe_item", {
                time: this.mealInfo.meal_type
            }) 
        },
        getTrimDesc() {
            let maxLen = screen.width > 768 ? 20 : 16
            let val = this.mealInfo.title

            if(val.length > maxLen)
                return val.substr(0, maxLen)
            else    
                return val
        },
        getMealTime() {
            let num = parseInt(this.mealInfo.meal_type)
            if(num == 0) 
                return 'Breakfast'
            else if(num == 1)
                return 'Morning snack'
            else if(num == 2)
                return 'Lunch'
            else if(num == 3)
                return 'Evening snack'
            else if(num == 4)
                return 'Dinner'
        },
    },
    data() {
        return {
            status: false,
            colorx: "#ffffff", //"#def1d1",
            popupActive: false,
            title: null,
            imgFile: null,
            meal_type: null,
            total_time: null,
            energy: null,
            ingredients: null,
            nutrients: null,
            content: null,
            steps: null,
            isActive: [],
        }
    },
}
</script>