<template>
     <v-container >
          <Schedule />
     </v-container>
</template>

<script>
import Schedule from "@/components/Schedule.vue";

export default {
  name: "home",
  components: {
    Schedule
  }
};
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
