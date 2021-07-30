<template>
    <div class="accordion-item box-item-10 bg-white">
        <div class="js-accordion-toggle accordion-header box-relative" :style="`background-color:` + getCurrColor()" @click="clickQuestion">
            <div class="accordion-title">{{ question }}</div>
            <span class="img-wrapper svg-wrapper toggle">
                <feather-icon icon='ChevronDownIcon' svgClasses='h-8 w-8' class='ml-1' v-show="!isOpen" />
                <feather-icon icon='ChevronUpIcon' svgClasses='h-8 w-8' class='ml-1' v-show="isOpen" />
            </span>
        </div>
        <div class="js-accordion-content accordion-content" v-show="isOpen">
            <p>{{ answer }}</p>
        </div>
    </div>
</template>

<style lang="scss">

.accordion-item {
    margin-bottom: 1rem;
    overflow: hidden;
    width: 100%;
    background-color: #fff;
    box-shadow: 0 4px 14px 0 rgba(0, 0, 0, 0.15);
    position: relative;
    border-radius: 0.625rem;

    .accordion-header {
        line-height: 1.5rem;
        min-height: 3.5rem;
        -webkit-user-select: none;
        padding: 1.5rem 4rem 1.2rem 1.5rem;
        line-height: 1.75rem;
        -webkit-transition: background-color 0.25s;
        transition: background-color 0.25s;
        -webkit-box-align: center;
        align-items: center;
        cursor: pointer;
    }
    .accordion-title {
        cursor: pointer;
        text-align: left;
        color: #292929;
        font-family: IBMPlexSans, Montserrat, sans-serif;
        font-size: 16px;
        font-size: 1rem;
        line-height: 1.3;
        font-weight: 700;
    }
    .toggle {
        width: 1.3125rem;
        height: 0.625rem;
        position: absolute;
        right: 1.125rem;
        top: 1.625rem;
        flex-shrink: 0;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        display: flex;
    }

    .accordion-content {
        font-size: 16px;
        font-size: 1rem;
        line-height: 1.8;
        padding: 1.5rem 2.5rem;
        text-align: left;
    }
}
</style>

<script>
export default {
    props: {
        question: String,
        answer: String,
    },
    methods: {
        getCurrColor() {
            if(this.isOpen) return '#F8D6D8'
            else return '#fff'
        },
        clickQuestion() {
            this.isOpen = !this.isOpen
        }
    },
    data() {
        return {
            isOpen: false,
        }
    },
    computed: {
    },
    watch: {
    },
    created() {
    }
}
</script>