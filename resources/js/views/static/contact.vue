<template>
    <div class="mx-auto w-full lg:w-2/4 max-w-screen-md contact-us">
        <div class="vx-row">
            <div class="vx-col w-full sm:w-full md:w-full lg:w-full xl:w-2/3 text-left">
                <img class="w-full md:w-2/4" src="@assets/images/logo/logo.png" alt="KetoDietStudio" />
            </div>
        </div>
        <div class="w-full">
            <div class="mt-10 mb-10 static-title text-left">
                <p>CONTACT US</p>
            </div>
            <div class="mt-10 mb-10 contact-form text-left">
                <div class="contact__form-item">
                    <label for="name">Name</label>
                    <span class="wpcf7-form-control-wrap fname"><input type="text" name="fname" value="" size="40" v-model='fname' class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" id="name" aria-required="true" aria-invalid="false" placeholder="Enter your name..."></span>
                </div>
                <div class="contact__form-item">
                    <label for="email">Email Address</label>
                    <span class="wpcf7-form-control-wrap email"><input type="email" name="email" value="" size="40" v-model='email' class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email form-control" id="email" aria-required="true" aria-invalid="false" placeholder="Enter your email address..."></span>
                </div>
                <div class="contact__form-item">
                    <label for="text">Message</label>
                    <span class="wpcf7-form-control-wrap message"><textarea name="message" cols="40" rows="10" v-model='message' class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required form-control w-input" id="message" aria-required="true" aria-invalid="false" placeholder="What can we help with?"></textarea></span>
                </div>
                <button class="btn" @click="submit">Send Message</button>
            </div>
        </div> 
    </div>
</template>

<style lang="scss">
.static-title {
    font-size: 28px;
    font-weight: 700;
}
.contact-form {
    .btn {
        border-radius: 8px;
        background-color: #f86540;
        padding: 12px 40px;
        display: inline-block;
        cursor: pointer;
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
        border: none;
    }
    .contact__form-item {
        padding-bottom: 17px;
        label {
            display: block;
            cursor: pointer;
            font-weight: 400;
            font-size: 12px;
            line-height: 16px;
            color: #161622;
            padding-bottom: 8px;
        }

        .contact__form .btn {
            font-size: 12px;
            width: 100%;
            height: 64px;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .wpcf7-form-control-wrap {
            position: relative;

            input, textarea {
                background: #f5f5f5;
                border: 1px solid #c9c9cf;
                padding: 0 24px;
                height: 56px;
                width: 100%;
                font-weight: 700;
                font-size: 14px;
                line-height: 24px;
                letter-spacing: 1px;
                text-transform: uppercase;
                color: #94949e;                
            }

            textarea {
                height: 168px;
                font-weight: 400;
                text-transform: none;
                padding: 15px 24px;
            }
        }
    }
}
</style>

<script>

export default {
  components: {
  },
  data() {
      return {
          fname: null,
          email: null,
          message: null,
      }
  },  
  created() {   
  },
  methods: {
      submit() {
          let payload = {
              user_name: this.fname,
              user_emailAddr: this.email,
              user_message: this.message,
          }
          this.$store.dispatch("keto/send_email", payload).then((response) => {
                if(response.data.success){
                    alert('Sent your Email successfully!')
                }
                else {
                    alert(response.error)
                }
          })
      }
  }
}
</script>
