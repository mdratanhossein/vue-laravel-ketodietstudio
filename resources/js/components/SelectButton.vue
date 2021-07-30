<template>
    <div :class="{active: isActive, withIcon: isIcon, 'select-button': true}" @click="callback($event)">
        <div class="icon" v-if="isIcon">
            <i :class="query" :style="{ backgroundImage: 'url(' + require('@assets/images/elements/icons.png') + ')' }" />
        </div>
        <slot></slot>
        <div class="status"></div>
        <div class="status-icon">{{ curStatusIcon }}</div>
    </div>
</template>

<style lang="scss">
.select-button {
    // @media (max-width:700px) { width: 100% !important; }
    // @media (min-width:1025px) { width: 60% !important; }
    // @media (min-width:1200px) { width: 50% !important; }
    // @media (min-width:1600px) { width: 40% !important; }
    border-radius: 9px;
    background-color: #fff;
    -webkit-box-shadow: 0 4px 11px -7px rgba(0,0,0,.2);
    box-shadow: 0 4px 11px -7px rgba(0,0,0,.2);
    opacity: .7;
    cursor: pointer;
    position: relative;
    padding: 20px;
    color: #444;
    font-family: Karla,Montserrat;
    padding-right: 40px;
    font-size: 15px;
    letter-spacing: .51px;
    line-height: 18px;
    margin-bottom: 15px;
}


.select-button.withIcon.active {
    .icon {
        i {
            -webkit-filter: grayscale(0) !important;
            filter: grayscale(0) !important;
            opacity: 1 !important;
        }
    }
}

.select-button.active .status {
    background-color: #56468f;
}

.select-button .status-icon {
    color: #fff;
    z-index: 2;
    font-size: 24px;
    font-weight: 600;
    text-align: center;
    position: absolute;
    right: 10px;
    top: 50%;
    margin-top: -10px;
}

.select-button .status {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
    border-radius: 9px 0 0 9px;
    background-color: #c3c3c3;
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    width: 30px;
    z-index: 1;
}

.select-button.active .status-icon {
    position: absolute;
    right: 8px;
    top: 50%;
    margin-top: -12px;
}

.select-button.withIcon {
    padding-left: 65px;

    .icon {
        max-height: 32px;
        position: absolute;
        top: 50%;
        background-size: contain;
        left: 10px;
        margin-top: -16px;
        height: 40px;
        text-align: center;
        width: 40px;

        i {
            max-width: 100%;
            max-height: 100%;
            -webkit-filter: grayscale(100%);
            filter: grayscale(100%);
            opacity: .43;
        }
    }
}

.select-button.active {
    -webkit-box-shadow: 0 4px 11px -2px rgba(86,70,143,.3);
    box-shadow: 0 4px 11px -2px rgba(86,70,143,.3);
    color: #ff3464;
    opacity: 1;
}


.chicken {
    background-position: -2px -1064px;
    width: 37px;
    height: 32px;
}

.avocado, .back, .beef, .butter, .capers, .cheese, .chicken, .coconut, .egg, .eggs, .female, .fish, .forward-female, .forward-male, .goat-cheese, .ham, .icons, .lamb, .male, .milk, .mushroom, .mushrooms, .nuts, .olives, .onions, .pork, .seafood, .veal {
    display: inline-block;
    overflow: hidden;
    text-indent: -9999px;
    text-align: left;
}
</style>

<script>
export default {
    props: {
        isIcon: Boolean,
        query: String,
        state: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        curStatusIcon() {
            return this.isActive ? "+" : "-"
        },
    },
    methods: {
        callback: function(e) {
            this.isActive = !this.isActive
            this.$emit('click', e);
        },
        setActive(payload) {
            let product_plan = payload.data
            if(product_plan.includes(this.query))
                this.isActive = true
        }
    },
    mounted() {
        this.$root.$on("userProfileMealProducts", (payload) => {
            this.setActive(payload)
        })
    },
    data() {
        return {
            isActive: false,
        }
    }
}
</script>