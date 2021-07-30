<template>
    <div class="w-full mx-auto">
        <div v-if="isDesktop" class="tabs-nav inner">
            <div class="tabs-wrapper">
                <router-link :to="{path: `/learnketo`}" class="tabs-logo">
                    <img class="w-64" src="@assets/images/logo/logo.png" alt="KetoDietStudio">
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
                            <h1 class="learn-title">{{ item.title }}</h1>
                            <img :src="getArticleImage(item)" class="w-4/5 md:2/4 mt-10 mb-5 mx-auto" alt="article">
                            <div v-html="item.content" class="w-full mx-auto text-left"/>
                        </div>
                    </div>
                    <vs-button @click="back" type="relief" size="medium" class="mt-5 w-full mx-auto" color="primary"><strong>Back</strong></vs-button>
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
 .learn-title {
    font-size: 15pt;
    font-weight: bold;
    word-break: break-word;    
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
          article_id : '',
          summaryId : ''
      }
  },
  beforeRouteEnter(to, from, next) {
      if(from.name != 'keto-user-learnketo') {
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
          this.article_id = this.$route.params.art_id

          this.$store.dispatch("keto/view_content", this.article_id).then((response) => {
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
      back() {
          this.$router.push({name: 'keto-user-learnketo', params: {id : this.summaryId}})
      }
  },
}
</script>
