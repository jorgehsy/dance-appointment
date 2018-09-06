<template>
     <v-container >
          <Appointments />
     </v-container>
</template>

<script>
import Appointments from "@/components/Appointments.vue";
export default {
     name: "laboratory",
     components: {
          Appointments
     }  
}
</script>


<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>

