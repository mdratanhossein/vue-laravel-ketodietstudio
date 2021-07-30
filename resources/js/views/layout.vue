<template>
  <div class="layout--main" :class="[layoutTypeClass, navbarClasses, footerClasses, {'no-scroll': isAppPage}]">

    <div id="content-area" :class="[contentAreaClass, {'show-overlay': bodyOverlay}]">

      <div class="content-wrapper">
        <div class="router-view">
          <div class="router-content">
            <div class="content-area__content">
              <!-- <transition :name="routerTransition" mode="out-in"> -->
                <router-view @changeRouteTitle="changeRouteTitle" @setAppClasses="(classesStr) => $emit('setAppClasses', classesStr)" />
              <!-- </transition> -->
            </div>
          </div>
        </div>
      </div>

      <div class="the-footer flex-wrap justify-between" :class="classes">
        <vs-divider class="mt-4 mb-6"></vs-divider>

        <ul class="mt-3 mb-4">
          <li class="mb-2">
            <router-link :to="{name: 'keto-faq'}">
              F.A.Q
            </router-link>
          </li>
          <li class="mb-2">
            <a href="" @click.prevent="showTermPopup">
              Terms and Conditions
            </a>
          </li>
          <li class="mb-2">
            <a href="" @click.prevent="showPrivacyPopup">
              Privacy Policy
            </a>
          </li>
          <li class="mb-2">
            <a href="" @click.prevent="showCookiePopup">
              Cookie Policy
            </a>
          </li>
          <li class="mb-2">
            <a href="" @click.prevent="showRefundPopup">
              Refund Policy
            </a>
          </li>
          <li class="mb-2">
            <router-link :to="{name: 'keto-contact-us'}">
              Contacts
            </router-link>
          </li>
        </ul>

        <span>COPYRIGHT &copy; {{ new Date().getFullYear() }} <a href="https://ketodietstudio.com" target="_blank" rel="nofollow">Keto Diet Studio</a></span>

        <vs-popup class="terms-popup" background-color="rgba(152,152,152,.7)" :background-color-popup="colorx" title="" :active.sync="popupTermActive">
          <div v-html="terms_conditions" />
        </vs-popup>

        <vs-popup class="privacy-popup" background-color="rgba(152,152,152,.7)" :background-color-popup="colorx" title="" :active.sync="popupPrivacyActive">
          <div v-html="privacy_policy" />
        </vs-popup>

        <vs-popup class="cookie-popup" background-color="rgba(152,152,152,.7)" :background-color-popup="colorx" title="" :active.sync="popupCookieActive">
          <div v-html="cookie_policy" />  
        </vs-popup>

        <vs-popup class="refund-popup" background-color="rgba(152,152,152,.7)" :background-color-popup="colorx" title="" :active.sync="popupRefundActive">
          <div v-html="refund_policy" />  
        </vs-popup>

      </div>
      
    </div>
  </div>
</template>

<style lang="scss">
#content-area .content-wrapper {
    min-height: calc(var(--vh, 1vh) * 100 - 3.5rem) !important;
    background-size: cover;
    background-position: right center;
}

h1 {
  margin-bottom: 30px;
}
</style>

<script>
import axios from "../axios.js"

export default {
  props: {
      classes: {
          // type: String,
      },
  },
  data() {
    return {
      disableCustomizer : true,
      disableThemeTour  : true,
      dynamicWatchers   : {},
      footerType        : 'static',
      hideScrollToTop   : true,
      isNavbarDark      : false,
      navbarColor       : '#fff',
      navbarType        : 'floating',
      routerTransition  : 'none',
      routeTitle        : this.$route.meta.pageTitle,

      popupTermActive: false,
      popupPrivacyActive: false,
      popupCookieActive: false,
      popupRefundActive: false,
      colorx: "#ffffff",

      terms_conditions : '',
      privacy_policy : '',
      cookie_policy : '',
      refund_policy : '',
    }
  },
  watch: {
    "$route"() {
      this.routeTitle = this.$route.meta.pageTitle
    },
    isThemeDark(val) {
      const color = this.navbarColor == "#fff" && val ? "#10163a" : "#fff"
      this.updateNavbarColor(color)
    },
    "$store.state.mainLayoutType"(val) {
      this.setNavMenuVisibility(val)
      this.disableThemeTour = true
    }
  },
  computed: {
    bodyOverlay() { return this.$store.state.bodyOverlay },
    contentAreaClass() {
      if(this.mainLayoutType === "vertical") {
        if      (this.verticalNavMenuWidth == "default") return "content-area-reduced"
        else if (this.verticalNavMenuWidth == "reduced") return "content-area-lg"
        else return "content-area-full"
      }
      // else if(this.mainLayoutType === "boxed") return "content-area-reduced"
      else return "content-area-full"
    },
    footerClasses() {
      return {
        'footer-hidden': this.footerType == 'hidden',
        'footer-sticky': this.footerType == 'sticky',
        'footer-static': this.footerType == 'static',
      }
    },
    isAppPage() {
      return this.$route.meta.no_scroll
    },
    isThemeDark()     { return this.$store.state.theme == 'dark' },
    layoutTypeClass() { return `main-${this.mainLayoutType}` },
    mainLayoutType()  { return this.$store.state.mainLayoutType  },
    navbarClasses()   {
      return {
        'navbar-hidden'   : this.navbarType == 'hidden',
        'navbar-sticky'   : this.navbarType == 'sticky',
        'navbar-static'   : this.navbarType == 'static',
        'navbar-floating' : this.navbarType == 'floating',
      }
    },
    verticalNavMenuWidth() { return this.$store.state.verticalNavMenuWidth },
    windowWidth()          { return this.$store.state.windowWidth }
  },
  methods: {
    showTermPopup() {
      axios.get("/tos/terms-and-conditions.html")
        .then((response) => {
          this.terms_conditions = response.data
        })
        .catch((error) => {  })
        this.popupTermActive = true
    },
    showPrivacyPopup() {
      axios.get("/tos/privacy-policy.html")
        .then((response) => {
          this.privacy_policy = response.data
        })
        .catch((error) => {  })
        this.popupPrivacyActive = true
    },
    showCookiePopup() {
      axios.get("/tos/cookie-policy.html")
        .then((response) => {
          this.cookie_policy = response.data
        })
        .catch((error) => {  })
        this.popupCookieActive = true
    },
    showRefundPopup() {
      axios.get("/tos/refund-policy.html")
        .then((response) => {
          this.refund_policy = response.data
        })
        .catch((error) => {  })
        this.popupRefundActive = true
    },

    changeRouteTitle(title) {
      this.routeTitle = title
    },
    updateNavbar(val) {
      if (val == "static") this.updateNavbarColor(this.isThemeDark ? "#10163a" : "#fff")
      this.navbarType = val
    },
    updateNavbarColor(val) {
      this.navbarColor = val
      if (val == "#fff") this.isNavbarDark = false
      else this.isNavbarDark = true
    },
    updateFooter(val) {
      this.footerType = val
    },
    updateRouterTransition(val) {
      this.routerTransition = val
    },
    setNavMenuVisibility(layoutType) {
      if((layoutType === 'horizontal' && this.windowWidth >= 1200) || (layoutType === "vertical" && this.windowWidth < 1200)) {
        // this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', false)
        this.$store.dispatch('updateVerticalNavMenuWidth', 'no-nav-menu')
      }
      else {
        // this.$store.commit('TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE', true)
      }
    },
    toggleHideScrollToTop(val) {
      this.hideScrollToTop = val
    }
  },
  created() {
    const color = this.navbarColor == "#fff" && this.isThemeDark ? "#10163a" : this.navbarColor
    this.updateNavbarColor(color)
    this.setNavMenuVisibility(this.$store.state.mainLayoutType)

    // Dynamic Watchers for tour
    // Reason: Once tour is disabled it is not required to enable it.
    // So, watcher is required for just disabling it.
    this.dynamicWatchers.windowWidth = this.$watch("$store.state.windowWidth", (val) => {
      if(val < 1200) {
        this.disableThemeTour = true
        this.dynamicWatchers.windowWidth()
      }
    })

    this.dynamicWatchers.verticalNavMenuWidth = this.$watch("$store.state.verticalNavMenuWidth", () => {
      this.disableThemeTour = true
      this.dynamicWatchers.verticalNavMenuWidth()
    })

    this.dynamicWatchers.rtl = this.$watch("$vs.rtl", () => {
      this.disableThemeTour = true
      this.dynamicWatchers.rtl()
    })
  },
  beforeDestroy() {
    Object.keys(this.dynamicWatchers).map(i => {
      this.dynamicWatchers[i]()
      delete this.dynamicWatchers[i]
    })
  }
}

</script>

