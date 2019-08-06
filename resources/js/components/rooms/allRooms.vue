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

    <h1>All Rooms ({{ allRooms.length }})</h1>
    <table class="table">
      <thead>
        <tr>
          <th>Room Name</th>
          <th>User Name</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="room in allRooms">
          <td scope="row"><router-link :to="{ name: 'chat', params: { room_id: room.id }}">{{ room.name }}</router-link></td>
          <td>{{ room.user.name }}</td>
          <td>{{ room.created_at | moment("from", "now") }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      allRooms: [],

      isLoading: false,
      fullPage: true,
      type: "dots",
      loaderColor: "blue",
      loaderHight: 128,
      loaderWidth: 128

    };
  },
  mounted() {
    //console.log("all rooms component mounted.");
  },
  components: {
    Loading
  },
  methods: {
    getAllRooms() {
      this.isLoading = true;

      // GET /someUrl?foo=bar
      this.$http.get("/getAllRooms").then(
        response => {
            this.isLoading = false;
          // success callback
          //console.log(response.body);
          this.allRooms = response.body.data;
        },
        response => {
          // error callback
          //console.error(response.body);
          this.isLoading = false;
        }
      );
    },
    onCancel() {
      console.log("User cancelled the loader.");
    }
  },
  created() {
    this.getAllRooms();
  }
};
</script>
