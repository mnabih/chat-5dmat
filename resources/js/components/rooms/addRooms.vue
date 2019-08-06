<template>
  <div class="vld-parent">
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

    <h1>Add New Room</h1>
    <div class="form-group">
      <label for="name">Room Name</label>
      <input
        type="text"
        name="name"
        id="name"
        class="form-control"
        v-model="roomName"
        placeholder=""
        aria-describedby="helpId"
      />
    </div>
    <button
      type="submit"
      @click.prevent="addNewRoom"
      @input="btnSubmitStatus"
      v-bind:disabled="btnSubmit"
      class="btn btn-primary"
    >Submit</button>
  </div>
</template>

<script>
import { log } from 'util';
export default {
  data() {
    return {
      roomName: "",

      btnSubmit: true,

      isLoading: false,
      fullPage: true,
      type: "dots",
      loaderColor: "blue",
      loaderHight: 128,
      loaderWidth: 128
    };
  },computed:{
      btnSubmitStatus(){
          if(this.roomName.trim() == ""){
              return this.btnSubmit=true;
          }else if (this.roomName.trim().length < 5){
              return this.btnSubmit=true;
          }else{
              return this.btnSubmit=false;
          }
      },
  },
  mounted() {
    //console.log("add rooms component mounted.");
  },
  components: {
    Loading
  },
  methods: {
    addNewRoom() {
        this.isLoading = true;
        // POST /someUrl
        this.$http.post('/addRoom', {name: this.roomName}).then(response => {
            console.log(response.body);
            this.isLoading = false;
            if(response.body.status == 1){
                this.roomName = '';
                this.btnSubmit = true;
                this.$swal({
                    title: response.body.message,
                    type: 'success',
                });
            }else{
                this.$swal({
                    title: response.body.message,
                    type: 'error',
                });
            }

        }, response => {
            console.log(response.body);
            // error callback
            this.isLoading = false;
            this.$swal({
                title: 'خطأ فى الاتصال ',
                type: 'error',
            });
        });


    },
    onCancel() {
      console.log("User cancelled the loader.");
    }
  }
};
</script>
