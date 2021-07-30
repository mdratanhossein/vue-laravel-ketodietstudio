<template>
    <div class="w-full mx-auto">
        <div v-if="isDesktop" class="tabs-nav inner">
            <div class="tabs-wrapper">
                <router-link :to="{path: `/plan/index/` + this.summaryId}" class="tabs-logo">
                    <img class="w-64" src="@assets/images/logo/logo.png" alt="KetoDietStudio">
                </router-link>           
                <router-link :to="{path: `/plan/profile/` + summaryId}" class="profile-tab tab-item ">
                    <img src="@assets/images/icons/icon-profile.svg"> My profile
                </router-link>
                <router-link :to="{path: `/plan/progress/` + summaryId}" class="meals-tab tab-item ">
                    <img src="@assets/images/icons/icon-progress.svg"> My progress
                </router-link>
                <router-link :to="{path: `/plan/meal/` + summaryId}" class="meals-tab tab-item active">
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
                    <div class="vx-row">
                        <div class="vx-col w-full text-center" v-for="(item, index) in article_data" :key="index">
                            <img :src="getArticleImage(item)" @click="next(item.id)" class="w-4/5 md:2/4 mt-10 mb-5 mx-auto article_image" alt="article">
                            <p class="title">{{ item.title }}</p>
                            <vs-divider class="mt-10 my-6 md:my-12 mx-auto vs-divider"></vs-divider>
                        </div>
                        <vs-button @click="back" type="relief" size="medium" class="mt-5 w-3/4 mx-auto" color="primary"><strong>Back</strong></vs-button>
                    </div>
                </vx-card>
            </div>
        </div> 
    </div>
</template>

<style lang="scss">
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
.article-photo {
    max-width: 100px;
    @media (max-width:700px) { width: 60px !important; }
    float: center;
    margin: 10px;
    text-align: -webkit-center;
}
.vs-divider {
    width: 100%;
    border-top: 1px solid rgb(177, 177, 177);
}
.article_image {
    cursor: pointer;
}
.title {
    font-size: 15pt;
    font-weight: bold;
    word-break: break-word;
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
          article_data : [],
          summaryId : ''
      }
  },
  beforeRouteEnter(to, from, next) {
      if(from.name != 'keto-user-index' && from.name != 'keto-user-viewcontent') {
          next({
              name: 'keto-main',
          })
      } else {
          next()
      }
  },
  created() {
      this.initPage()
  },
  computed: {
    isDesktop() {
          return screen.width > 768 ? true : false
      },
  },
  methods: {   
      initPage() {
          this.summaryId = this.$route.params.id

          this.$store.dispatch("keto/learn_keto", this.summaryId).then((response) => {
            if(response.data.success) {
                this.article_data = response.data.article_data
            } else {
                alert(response.data.error)
            }     
          })   
      },
      getArticleImage(image) {
          return image.image_url.replace('http://localhost/', '/')
      },
      next(article_id) {
          this.$router.push({name: 'keto-user-viewcontent', params: {id : this.summaryId, art_id : article_id}})
      },
      back() {
          this.$router.push({name: 'keto-user-index', params: {id : this.summaryId}})
      }
  },
}
</script>
