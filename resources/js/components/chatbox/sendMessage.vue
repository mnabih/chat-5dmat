<template>
  <div>
    <loading
      :active.sync="isLoading"
      :can-cancel="false"
      :on-cancel="onCancel"
      :is-full-page="fullPage"
      :loader="type"
      :color="loaderColor"
      :hight="loaderHight"
      :width="loaderWidth"
    ></loading>

    <div class="bottom_wrapper clearfix">
      <div class="message_input_wrapper">
        <input
          class="message_input"
          v-model="message"
          @keyup.enter="addMessage"
          placeholder="Type your message here..."
        />
      </div>
      <div class="send_message" @click="addMessage">
        <div class="icon"></div>
        <div class="text">Send</div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      isLoading: false,
      fullPage: true,
      type: "dots",
      loaderColor: "blue",
      loaderHight: 128,
      loaderWidth: 128,

      message: ""
    };
  },
  computed: {},
  components: {
    Loading
  },
  mounted() {
    //console.log("send message component mounted.");
  },
  methods: {
    addMessage() {
      if (this.message.trim() == "") {
        return console.log("بطل استهبال");
      } else if (this.message.trim().length < 5) {
        this.$swal({
          title: "يجب ان لا تقل الرسالة عن خمس احرف",
          type: "error"
        });
      } else {
        this.sendMessage();
      }
    },
    sendMessage() {
      this.isLoading = true;
      // POST /someUrl
      this.$http
        .post("/addMessage", {
          message: this.message,
          room_id: this.$route.params.room_id
        })
        .then(
          response => {
            //console.log(response.body.data);
            this.isLoading = false;
            if (response.body.status == 1) {
              this.message = "";

              //this.$root.$emit('new-message', response.body.data)

            } else {
              this.$swal({
                title: response.body.message,
                type: "error"
              });
            }
          },
          response => {
            console.log(response.body);
            // error callback
            this.isLoading = false;
            this.$swal({
              title: "خطأ فى الاتصال ",
              type: "error"
            });
          }
        );
    },
    onCancel() {
      console.log("User cancelled the loader.");
    }
  }
};
</script>
