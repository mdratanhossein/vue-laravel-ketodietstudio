/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_GENDER(state, gender) {
    state.gender = gender
  },
  SET_IP_ADDR(state, ip_addr) {
    state.ip_addr = ip_addr
  },
  SET_FAMILIAR_INDEX(state, index) {
    state.familiar = index
  },
  SET_MEAL_PREPARATION_INDEX(state, index) {
    state.mealIndex = index
  },
  SET_MEAT_PLAN(state, products) {
    state.meatPlan = products
  },
  SET_MEAT_PRODUCTS(state, products) {
    state.productPlan = products
  },
  SET_PHYSICAL_ACTIVE(state, index) {
    state.physicalActive = index
  },
  SET_WILLING_OPTION(state, index) {
    state.willingOption = index
  },
  SET_EMAIL_ADDR(state, email_addr) {
    state.email_addr = email_addr
  },
  SET_SUBMIT_DATETIME(state, datetime) {
    state.submitDatetime = datetime
  },
  SET_SUMMARY_ID(state, summaryId) {
    state.summaryId = summaryId
  },
  SET_SUMMARY_INFO(state, summaryInfo) {
    state.summaryInfo = summaryInfo    
  },
  SET_MEASUREMENT(state, measurement) {
    state.measurement.unit = measurement.unit

    if(measurement.unit == 1) {
      state.measurement.age       = measurement.age
      state.measurement.height_cm = measurement.height_cm
      state.measurement.weight_kg = measurement.weight_kg
      state.measurement.target_kg = measurement.target_kg
    } else {
      state.measurement.age       = measurement.age
      state.measurement.height_ft = measurement.height_ft
      state.measurement.height_in = measurement.height_in
      state.measurement.weight_lb = measurement.weight_lb
      state.measurement.target_lb = measurement.target_lb
    }

    state.measurement.datetime = measurement.datetime
  },
  SET_PAYMENT_INFO(state, paymentInfo) {
    state.paid = paymentInfo.paid
    state.planId = paymentInfo.planId
  },
  SET_SEARCH_RESULT(state, result) {
    state.searchResult = result
  },
  SET_PROGRESS_LIST(state, result) {
    state.progresses = result
  },
  SET_PROGRESS_CHART(state, result) {
    state.chartData = result
  },
}
