<template>
    <div class="mx-auto w-full lg:w-2/4 max-w-screen-md">
        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <a @click="$router.go(-1)">
                    <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
                </a>
            </div>
        </div>
        <div class="w-full">
            <div class="mt-10 mb-10 static-title text-center">
                <p>Frequently asked questions</p>
            </div>
            <div class="mt-10 mb-10">
                <faq-item v-for="(item, index) in faqList" :key="index" :question="item.question" :answer="item.answer" />
            </div>
        </div> 
    </div>
</template>

<style lang="scss">
.static-title {
    font-size: 28px;
    font-weight: 700;
}
</style>

<script>
import FaqItem from "../../components/FaqItem.vue"

export default {
  components: {
      FaqItem,
  },
  data() {
      return {
          faqList : [
              {
                  'question': 'How do I access my meal plan?',
                  'answer': 'Right after payment go to the top-right menu, select ‘My meal plan’ and enter your email. You will instantly access your meal plan.'
              },
              {
                  'question': 'So what actually is the Keto Diet?',
                  'answer': 'The Ketogenic, or the Keto Diet, is a very high-fat, very low-carbohydrate diet with moderate consumption of protein. \n' +
                  '75% of your calories on a ketogenic diet come from fat, 20% are from protein, and only 5% of the total calorie intake comes from carbohydrates. Тhrough this macro ratio our body switches its preferred fuel source from carbohydrates to fat, which results in the production of an additional fuel source known as ketones. This unique metabolic state is known as nutritional ketosis.'
              },
              {
                  'question': 'What to do if I’m not happy with the product?',
                  'answer': 'If somehow you don’t find our product is the right one for you, please contact us at hello@ketodietstudio.com. We will help you to find best solution for this case.'
              },
              {
                  'question': 'My diet has too many calories!',
                  'answer': 'Don’t worry about the caloric intake, the meal plan is calculated properly based on your body type. If you reduce too many calories at once, that can cause health problems. It is not about eating less but eating properly. You have the right meal plan! With the keto diet, you will eat fat and burn more fat.'
              },
              {
                  'question': 'What should I drink on a keto diet?',
                  'answer': 'Water is perfect and includes zero carbs. Coffee and tea (without sugar, of course) are good options, as well. A glass of wine is also fine to drink on special occasions.'
              },
              {
                  'question': 'Can I cancel my subscription?',
                  'answer': 'Definitely. Please contact our support team at hello@ketodietstudio.com and we\'ll kindly advise you on how to proceed.'
              }
          ]
      }
  },  
  created() {   
  },
  methods: {
  }
}
</script>
