<template>
<div>
    <ul class="messages" v-chat-scroll>
        <li class="message left appeared" v-for="(message,index) in messages" :key="index">
          <div class="avatar" >
              <div class="userName">{{ message.user.name }}</div>
              <b></b>
          </div>
          <div class="text_wrapper">
            <div class="text row">
                <p class="text">{{ message.text }}</p>
                <small class="small time">{{ message.created_at }}</small>
            </div>
          </div>
        </li>

      </ul>
</div>
</template>
<script>
    export default{
        props:['messages'],
        data(){
            return{

            }
        },
        mounted() {
            //console.log("all messages component mounted.");
        },

    }
</script>
<style>
    .small{
        font-size: 10px;
    }
    .userName{
        margin: 30%;
        font-weight: bolder;
        font-size: 12px;
    }
    .time{
        float: right;
        padding-left: 10%;
    }
    .text{
        float: left;
    }
</style>
