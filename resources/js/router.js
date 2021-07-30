import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    scrollBehavior () {
        return { x: 0, y: 0 }
    },
    routes: [

        {
    // =============================================================================
        // Keto LAYOUT ROUTES
        // =============================================================================
        path: '',
        component: () => import('./views/layout.vue'),
        children: [
    // =============================================================================
    // Theme Routes
    // =============================================================================
                {
                    path: '/',
                    name: 'keto-main',
                    component: () => import('./views/index.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/quiz/step1',
                    name: 'keto-quiz-step1',
                    component: () => import('./views/steps-1-familiar.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/quiz/step2',
                    name: 'keto-quiz-step2',
                    component: () => import('./views/steps-2-whatisketo.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/quiz/step3',
                    name: 'keto-quiz-step3',
                    component: () => import('./views/steps-3-mealpreparation.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/quiz/step4',
                    name: 'keto-quiz-step4',
                    component: () => import('./views/steps-4-meat.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/quiz/step5',
                    name: 'keto-quiz-step5',
                    component: () => import('./views/steps-5-products.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/quiz/step6',
                    name: 'keto-quiz-step6',
                    component: () => import('./views/steps-6-physicalactive.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/quiz/step7',
                    name: 'keto-quiz-step7',
                    component: () => import('./views/steps-7-willingoption.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/quiz/step8',
                    name: 'keto-quiz-step8',
                    component: () => import('./views/steps-8-dietmeasurement.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/quiz/step9/:id',
                    name: 'keto-quiz-step9',
                    component: () => import('./views/steps-9-username.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/summary/:id',
                    name: 'keto-summary',
                    component: () => import('./views/steps-10-summary.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/email/:id',
                    name: 'keto-email',
                    component: () => import('./views/steps-11-email.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/subscribe/:id',
                    name: 'keto-subscribe',
                    component: () => import('./views/subscribe.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/success/:id',
                    name: 'keto-success-payment',
                    component: () => import('./views/successPayment.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/myplan',
                    name: 'keto-myplan',
                    component: () => import('./views/login.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/plan/:id',
                    redirect: '/plan/profile/:id'
                },
                {
                    path: '/plan/meal/:id',
                    name: 'keto-user-plan',
                    component: () => import('./views/user/UserMealPlan.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/plan/index/:id',
                    name: 'keto-user-index',
                    component: () => import('./views/user/UserIndex.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/plan/progress/:id',
                    name: 'keto-user-progress',
                    component: () => import('./views/user/UserProgress.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/plan/profile/:id',
                    name: 'keto-user-profile',
                    component: () => import('./views/user/UserProfile.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/learnketo',
                    name: 'keto-user-learnketo',
                    component: () => import('./views/user/UserLearnKeto.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/viewcontent/:id',
                    name: 'keto-user-viewcontent',
                    component: () => import('./views/user/UserViewContent.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/plan/groceries/:id',
                    name: 'keto-user-groceries',
                    component: () => import('./views/user/UserGroceries.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
                {
                    path: '/frequently-asked-questions',
                    name: 'keto-faq',
                    component: () => import('./views/static/faq.vue'),
                    meta: {
                        rule: 'editor',
                    }
                },
            ]
        },
        {
            path: '',
            component: () => import('./views/layout.vue'),
            children: [
                    {
                        path: '/contact-us',
                        name: 'keto-contact-us',
                        component: () => import('./views/static/contact.vue'),
                        meta: {
                            rule: 'editor',
                        }
                    },
                ]
            },
    ],
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
    if (appLoading) {
        appLoading.style.display = "none";
    }
})

router.beforeEach((to, from, next) => {
    // If auth required, check login. If login fails redirect to login page
    // if(to.meta.adminAuth) {
    //     if (!auth.isAdminAuthenticated()) {
    //     //   console.log('Auth failed')
    //       router.push({ path: '/admin-login', query: { to: to.path } })
    //       return next(false)
    //     } else {
    //     //   console.log('Auth success')
    //         return next()
    //     }
    // } else {
    //     return next()
    // }

    return next()

//     firebase.auth().onAuthStateChanged(() => {

//         // get firebase current user
//         const firebaseCurrentUser = firebase.auth().currentUser

//         // if (
//         //     to.path === "/pages/login" ||
//         //     to.path === "/pages/forgot-password" ||
//         //     to.path === "/pages/error-404" ||
//         //     to.path === "/pages/error-500" ||
//         //     to.path === "/pages/register" ||
//         //     to.path === "/callback" ||
//         //     to.path === "/pages/comingsoon" ||
//         //     (auth.isAuthenticated() || firebaseCurrentUser)
//         // ) {
//         //     return next();
//         // }

//         // If auth required, check login. If login fails redirect to login page
//         if(to.meta.authRequired) {
//           if (!(auth.isAuthenticated() || firebaseCurrentUser)) {
//             router.push({ path: '/pages/login', query: { to: to.path } })
//           }
//         }

//         return next()
//         // Specify the current path as the customState parameter, meaning it
//         // will be returned to the application after auth
//         // auth.login({ target: to.path });

//     });

});

export default router
