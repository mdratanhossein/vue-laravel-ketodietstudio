/*=========================================================================================
  File Name: moduleCalendarActions.js
  Description: Calendar Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import axios from "../../axios.js"

export default {
  set_gender({ commit }, gender) {
    commit('SET_GENDER', gender)
  },
  search_my_plan({commit}, ip_addr) { 
    return new Promise((resolve, reject) => {
      axios.post("/api/summary/checkMyPlan", {data: ip_addr})
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  set_familiar_index({commit}, index) {
    commit('SET_FAMILIAR_INDEX', index)
  },
  set_meal_preparation_index({commit}, index) {
    commit('SET_MEAL_PREPARATION_INDEX', index)
  },
  set_meat_plan({commit}, products) {
    commit('SET_MEAT_PLAN', products)
  },
  set_meat_products({commit}, products) {
    commit('SET_MEAT_PRODUCTS', products)
  },
  set_physical_active({commit}, version) {
    commit('SET_PHYSICAL_ACTIVE', version)
  },
  set_willing_option({commit}, version) {
    commit('SET_WILLING_OPTION', version)
  },
  set_measurement({commit}, measurement) {
    return new Promise((resolve, reject) => {
      axios.post("/api/summary/new", {data: measurement})
        .then((response) => {
          commit('SET_MEASUREMENT', measurement)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  set_email_addr({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/summary/email", {data: payload})
        .then((response) => {          
          let output = {
            success: response.data.success,
            paid: response.data.paid,
            summaryId: response.data.summaryId
          }
          if(response.data.success) {
            commit('SET_EMAIL_ADDR', payload.email_addr)
          }
          resolve(output)
        })
        .catch((error) => { reject(error) })
    })
  },
  set_submit_datetime({commit}, datetime) {
    commit('SET_SUBMIT_DATETIME', datetime)
  },
  set_summary_id({commit}, summaryId) {
    commit('SET_SUMMARY_ID', summaryId)
  },
  get_summary_info({commit}, summaryId) {
    return new Promise((resolve, reject) => {
      axios.post("/api/summary/get", {summaryId: summaryId})
        .then((response) => {
          if(response.data.summaryId == summaryId) 
            commit('SET_SUMMARY_ID', summaryId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  set_summary_info({commit}, payload) {
    if(payload.data.success) {
      commit('SET_SUMMARY_ID', payload.data.summaryId)
      commit('SET_SUMMARY_INFO', payload.data.userInfo)
    }
  },
  set_payment_info({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/payment/paypal", {data: payload})
        .then((response) => {  
          if(response.data.success) {
            let paymentInfo = {
              paid: true,
              planId: payload.option,
            }
            commit('SET_PAYMENT_INFO', paymentInfo)
          }
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  // set_stripe_payment_info({commit}, payload) {
  //   return new Promise((resolve, reject) => {
  //     axios.post("/api/payment/stripe", {data: payload})
  //       .then((response) => {  
  //         if(response.data.success) {
  //           let paymentInfo = {
  //             paid: true,
  //             planId: payload.option,
  //           }
  //           commit('SET_PAYMENT_INFO', paymentInfo)
  //         }
  //         resolve(response)
  //       })
  //       .catch((error) => { reject(error) })
  //   })
  // },
  search_email_addr({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/summary/search", {data: payload})
        .then((response) => {  
          if(response.data.success) {
            commit('SET_SEARCH_RESULT', response.data.result)
          }
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  update_meal_product({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/update-products", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  update_profile({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/update-profile", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  restart_cycle({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/restart-cycle", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  save_weight({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/save-weight", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  get_progress_list({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/get-progresses", {data: payload})
        .then((response) => { 
          commit('SET_PROGRESS_LIST', response.data.progresses)
          commit('SET_PROGRESS_CHART', response.data.chartData)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  remove_progress({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/remove-progress", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  get_meal_option({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/get-meal-option", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateMealPlan({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/update-meal-plan", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  get_meal_plan({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/get-meal-plan", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  get_meal_info({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/get-meal-info", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  get_replace_item({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/get-replace-item", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  update_meal_item({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/update-meal-item", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  stripe_payment_request({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/payment/stripe", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  get_products({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/get-products", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  get_grocery_list({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/get-grocery-list", {data: payload})
        .then((response) => { 
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  set_firstname({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/summary/firstname", {data: payload})
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  send_email({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/summary/sendmail", {data: payload})
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  update_currDay_meal({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/meal/update-currDay-meal", {data: payload})
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  learn_keto({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/summary/learnketo", {data: payload})
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  view_content({commit}, payload) {
    return new Promise((resolve, reject) => {
      axios.post("/api/summary/viewcontent", {data: payload})
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
}
