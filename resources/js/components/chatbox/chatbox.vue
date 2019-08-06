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
        <div class="title">Chat</div>
      </div>

      <all-messages></all-messages>
      <send-message></send-message>

    </div>


  </div>
</template>

<script>
export default {
  mounted() {
    //console.log("chat box component mounted.");
  }
};
</script>
