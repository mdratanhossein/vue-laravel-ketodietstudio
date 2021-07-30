<template>
    <div class="user-vertical-nav-menu">
        <div class="navbar-wrapper">
            <div class="container">
                <div class="helper menu-helper" @click="isMenuActive = true">
                    <feather-icon icon="AlignJustifyIcon" class="inline-block mr-2" svgClasses="w-8 h-6" />
                </div>

                <div class="mobile-logo">
                    <router-link :to="{path: `/plan/meal/` + summaryId}">
                        <img src="@assets/images/logo/logo.png" alt="KetoDietStudio">
                    </router-link>
                </div>
            </div>
        </div>                 
        <div class="b-menu-inner" v-show="isMenuActive">
            <div class="b-menu-wrapper">
                <div class="b-menu-close" @click="isMenuActive = false">
                    <img src="@assets/images/icons/icon-arrow.png" alt="Close">
                </div>
                <div class="b-menu-header">
                    <strong>NAVIGATION</strong>
                    <div class="client-data">
                        {{ getEmail }}
                    </div>
                </div>
                <div class="b-menu-content">
                    <router-link :to="{path: `/plan/meal/` + summaryId}" :class="getActive(0)">
                        Meals
                    </router-link>
                    <router-link :to="{path: `/plan/progress/` + summaryId}" :class="getActive(1)">
                        My progress
                    </router-link>
                    <router-link :to="{path: `/plan/profile/` + summaryId}" :class="getActive(2)">
                        My profile
                    </router-link>
                </div>
                <div class="b-menu-logo">
                    <img src="@assets/images/logo/logo.png" alt="Logo">
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
.user-vertical-nav-menu {
    display: block;
    top: 0;
    bottom: 0;
    z-index: 1000!important;
    background: hsla(0,0%,100%,.6);
    padding-top: 100px;
    padding-left: 10px;
    opacity: 1;
    width: 100%;

    .navbar-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        background: #fff;
        z-index: 999;
        width: 100%;
        -webkit-box-shadow: 0 4px 11px 4px rgba(86,70,143,.3);
        box-shadow: 0 4px 11px 4px rgba(86,70,143,.3);
        height: 60px;

        .container {
            min-height: 50px;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;

            .helper {
                position: absolute;
                cursor: pointer;
                z-index: 999;
                left: 15px;
                top: 15px;
                cursor: pointer;
            }

            .mobile-logo {
                text-align: center;

                img {
                    max-height: 35px;
                    height: 35px;
                    margin-top: 10px;
                }
            }
        }
    }    

    .b-menu-inner {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 1000!important;
        background: hsla(0,0%,100%,.6);
        opacity: 1;
        width: 100%;

        .b-menu-wrapper {
            width: 85%;
            background: #fff;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-shadow: 4px 4px 10px rgba(66,17,103,.22);
            box-shadow: 4px 4px 10px rgba(66,17,103,.22);

            .b-menu-close {
                position: absolute;
                top: 15px;
                right: 15px;                
                cursor: pointer;

                img {
                    width: 30px;
                }
            }

            .b-menu-header {
                padding: 15px;
                padding-top: 60px;
            }

            .b-menu-content {
                margin-top: 30px;
                border-top: 1px solid #56468f;

                a {
                    padding: 15px;
                    display: block;
                    border-bottom: 1px solid #56468f;
                    color: #56468f;
                }

                .active {
                    font-weight: 700;
                    text-decoration: none;
                    color: #fff;
                    background: #56468f;
                }
            }

            .b-menu-logo {
                position: absolute;
                text-align: center;
                bottom: 60px;

                img {
                    max-width: 50%;
                    opacity: .3;
                }
            }
        }
    }

}

</style>

<script>
export default {
    props: {
    },
    data() {
        return {
            isFetched: false,
            isMenuActive: false,
            summaryId: null,
            sumamryInfo: null,
        }
    },    
    methods: {
        getActive(val) {
            if(this.$route.name == 'keto-user-plan' && val == 0)
                return 'active'
            else if(this.$route.name == 'keto-user-progress' && val == 1)
                return 'active'
            else if(this.$route.name == 'keto-user-profile' && val == 2)
                return 'active'
            else 
                return ''
        }
    },
    computed: {
        getEmail() {
            if(this.isFetched) 
                return this.summaryInfo.email
            else
                return ''
        }
    },
    watch: {
    },
    created() {
        if(this.$route.params.id == undefined)
            this.$router.push({name: 'page-error-404'})        
        else if(this.$route.params.id.length != 32)
            this.$router.push({name: 'page-error-404'})

        this.summaryId = this.$route.params.id
        this.$store.dispatch("keto/get_summary_info", this.summaryId).then((response) => {
            if(!response.data.success || this.summaryId != response.data.summaryId || !response.data.paid) {
                this.$router.push({name: 'page-error-404'})
            }
            this.summaryInfo    = response.data.userInfo            
            this.summaryId      = response.data.summaryId
            this.isFetched      = true
        })
    }
}
</script>