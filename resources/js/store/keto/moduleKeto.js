/*=========================================================================================
  File Name: moduleKeto.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleKetoState.js'
import mutations from './moduleKetoMutations.js'
import actions from './moduleKetoActions.js'
import getters from './moduleKetoGetters.js'

export default {
  // isRegistered: false,
  namespaced: true,
  state: state,
  mutations: mutations,
  actions: actions,
  getters: getters
}

