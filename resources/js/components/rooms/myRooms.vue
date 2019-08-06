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

    <h1>My Rooms ({{ myRooms.length }})</h1>
    <table class="table">
      <thead>
        <tr>
          <th>Room Name</th>
          <th>Date</th>
          <th>Controll</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="room,index in myRooms">
          <td scope="row"><router-link :to="{ name: 'chat', params: { room_id: room.id }}">{{ room.name }}</router-link></td>
          <td>{{ room.created_at | moment("from", "now") }}</td>
          <th><button class="btn btn-danger" @click="confirmDeleteRoom(room.id, index)"><li class="fa fa-trash"></li></button></th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      myRooms: [],

      isLoading: false,
      fullPage: true,
      type: "dots",
      loaderColor: "blue",
      loaderHight: 128,
      loaderWidth: 128

    };
  },
  mounted() {
    //console.log("my rooms component mounted.");
  },
  components: {
    Loading
  },
  methods: {
    getMyRooms() {
      this.isLoading = true;

      // GET /someUrl?foo=bar
      this.$http.get("/getMyRooms").then(
        response => {
          this.isLoading = false;
          // success callback
          //console.log(response.body);
          this.myRooms = response.body.data;
        },
        response => {
          // error callback
          console.error(response.body);
          this.isLoading = false;
        }
      );
    },
    onCancel() {
      console.log("User cancelled the loader.");
    },
    deleteRoom(id,index){
      this.isLoading = true;
      // GET /someUrl?foo=bar
      this.$http.get("/deleteMyRoom/" + id).then(
        response => {
            this.isLoading = false;
          // success callback
          //console.log(response.body);
          if(response.body.status == 1){
                this.$swal({
                    title: response.body.message,
                    type: 'success',
                });
                //this.myRooms = response.body.data;
                this.myRooms.splice(index,1);
            }else{
                this.$swal({
                    title: response.body.message,
                    type: 'error',
                });
            }

        },
        response => {
          // error callback
          console.error(response.body);
          this.isLoading = false;
          this.$swal({
                title: 'خطأ فى الاتصال ',
                type: 'error',
            });
        }
      );
    },
    confirmDeleteRoom(id,index){
        this.$swal({
            title: 'هل انت متاكد؟',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم',
            cancelButtonText: 'لا'
            }).then((result) => {
                if (result.value) {
                    this.deleteRoom(id,index)
                }
        })
    }
  },
  created() {
    this.getMyRooms();
  }
};
</script>
