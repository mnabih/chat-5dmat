<template>
  <div class>
    <div class="row">
      <div class="col-md-4">
        <router-link to="/all" class="btn btn-primary">All rooms</router-link>
      </div>
      <div class="col-md-4">
        <router-link to="/my" class="btn btn-primary">My rooms</router-link>
      </div>
    </div>
    <br />

    <div class="chat_window">
      <div class="top_menu">
        <div class="title">{{ roomName }} - Chat Room - {{ roomUsers }}</div>
      </div>

      <all-messages :messages="messages"></all-messages>
      <send-message></send-message>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      messages: [],
      channel: "",
      roomName: "",
      roomUsers:""
    };
  },
  mounted() {
    //console.log("chat box component mounted.");
    this.roomName = this.$route.params.room_name;

    // this.$root.$on('new-message',( data) => {
    //     console.log(data);
    //     this.messages.push(data);
    // });
  },
  methods: {
    listenToPusher(channelName, eventName,action) {

      // toast setting
      const Toast = this.$swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        
      })

      this.channel = this.$pusher.subscribe(channelName);
      this.channel.bind(eventName, data => {
        //console.log('chat box pusher ',data);
          if(action == 'newMsg'){
              this.messages.push(data);
          }else if(action == 'countUsers'){
              this.roomUsers = data.length;
              // for old room update after user go out
              this.$root.$emit('room_users', data);
          }else if(action == 'userLeft'){
              Toast.fire({
              title: data.name + " left room " + this.roomName,
              type: "success"
            });
          }else if(action == 'userJoin'){
            
            Toast.fire({
              title: data.name + " joined room " + this.roomName ,
              type: "success"
            })
              
          }

      });
    },
    getRoomUsers(){
        this.$http
        .get("/room/users/" + this.$route.params.room_id)
        .then(
          response => {
            //console.log('room users from chat box',response.body.data);
            if (response.body.status == 1) {
              // get room users for count inside room name
              this.roomUsers = response.body.data.length;
              // get room users for user list component
              this.$root.$emit('room_users', response.body.data)

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
            this.$swal({
              title: "خطأ فى الاتصال ",
              type: "error"
            });
          }
        );
    },
    // add this user to this room then update room users count
    addUserToRoom(){
        this.$http
        .get("/add/user/" + this.$route.params.room_id)
        .then(
          response => {
            //console.log(response.body.data);
            if (response.body.status == 1) {
              // update room users after new login
              this.getRoomUsers();

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
            this.$swal({
              title: "خطأ فى الاتصال ",
              type: "error"
            });
          }
        );
    },
    leaving(){
      window.addEventListener("beforeunload", function (e) {
        console.log(888888);
        var confirmationMessage = "\o/";

        (e || window.event).returnValue = confirmationMessage;     //Gecko + IE
        return confirmationMessage;                                //Webkit, Safari, Chrome etc.
      });
    }

  },
  created() {
    this.leaving();
    // listen to new messages
    this.listenToPusher(
      "room_" + this.$route.params.room_id,
      "new_message",
      'newMsg'
    );

    // add this user to this room then get room users
    this.addUserToRoom();

    // listen to all users data after join or left rooms
    this.listenToPusher(
      "roomUsers_" + this.$route.params.room_id,
      "room_users",
      'countUsers'
    );

    // listen to left user
    this.listenToPusher(
      "userleft_" + this.$route.params.room_id,
      "user_left",
      'userLeft'
    );

    // listen to join user
    this.listenToPusher(
      "userjoin_" + this.$route.params.room_id,
      "user_join",
      'userJoin'
    );
  },
  ready(){

  },

};
</script>
