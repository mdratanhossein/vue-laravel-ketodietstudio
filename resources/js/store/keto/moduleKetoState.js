/*=========================================================================================
  File Name: moduleCalendarState.js
  Description: Calendar Module State
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

export default {
  gender:                 null,     // female, male
  familiar:               null,     // expert, mediate, beginner
  mealIndex:              null,     // 30min, 1hour, more than 1hour
  meatPlan:               [],       // chicken, pork, beef, fish, lamb, veal, vegetarian
  productPlan:            [],       // onions, mushroom, egg, nut, cheese, butter, milk, avocados, seafood
  physicalActive:         null,     // hero, light, newbie,
  willingOption:          null,     // little, mediate, maximum
  measurement: {
    unit:                 null,     // imperial, metric
    age:                  null,     // age    
    height_ft:            null,     // height(ft)
    height_in:            null,     // height(in)
    height_cm:            null,     // height(cm)
    weight_lb:            null,     // weight(lb)
    wegiht_kg:            null,     // weight(kg)
    target_lb:            null,     // target weight(lb)
    target_kg:            null,     // target weight(kg)    
  },  
  summaryId:              null,
  paid:                   null,     // 3month, 2month, 1month
  planId:                 null,
  ip_addr:                null,     // ip address
  email_addr:             null,     // email address
  submitDatetime:         null,     // datetime
  summaryInfo:            null,
  searchResult:           [],
  progresses:             [],
  chartData:              [],
}
