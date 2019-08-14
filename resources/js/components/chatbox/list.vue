<template>
	<div class="container">
		<h3>online</h3>
		<ul>
			<li v-for="roomuser in roomUsers">{{roomuser.user.name}}</li>
		</ul>
	</div>
</template>
<script>
    export default{
        data(){
            return{
            	roomUsers:[],
            }
        },
        mounted() {
            //console.log("list component mounted.");
            this.$root.$on('room_users',( data) => {
		        //console.log('list component',data);
		        this.roomUsers = data;
		    });
        },
        created(){
        	
        },

    }
</script>