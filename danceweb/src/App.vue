<template>
     <v-app>
          <v-toolbar app>
               <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
               <v-toolbar-title>Dance with Death</v-toolbar-title>
               <v-spacer></v-spacer>
               <!-- <v-toolbar-items class="hidden-sm-and-down">
                    <v-btn flat><router-link :to="make-appointment"> Make an Appointment</router-link></v-btn>
               </v-toolbar-items> -->
          </v-toolbar>
          <v-navigation-drawer v-model="drawer" fixed app>
               <v-list two-line>
                    <v-list-tile @click="$router.replace('/')">
                         <v-list-tile-action>
                         <v-icon>home</v-icon>
                         </v-list-tile-action>
                         <v-list-tile-content>
                         <v-list-tile-title>Home</v-list-tile-title>
                         <v-list-tile-title class="subtitle">for Asimovers</v-list-tile-title>
                         </v-list-tile-content>
                    </v-list-tile>
                    
        <v-divider></v-divider>
                    <v-list-tile @click="$router.replace('/lab')">
                         <v-list-tile-action>
                         <v-icon>dashboard</v-icon>
                         </v-list-tile-action>
                         <v-list-tile-content>
                         <v-list-tile-title>Playground</v-list-tile-title>
                         <v-list-tile-title class="subtitle">Just for fun</v-list-tile-title>
                         </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile @click="$router.replace('/create')">
                         <v-list-tile-action>
                         <v-icon>event</v-icon>
                         </v-list-tile-action>
                         <v-list-tile-content>
                         <v-list-tile-title>Make Appointment</v-list-tile-title>
                         <v-list-tile-title class="subtitle">Get a date!</v-list-tile-title>
                         </v-list-tile-content>
                    </v-list-tile>
               </v-list>
          </v-navigation-drawer>
          <v-content>
               <v-container fluid>
                    <router-view></router-view>
               </v-container>
          </v-content>
            <v-footer app dark height="auto">
    <v-card class="flex" flat til >
      <v-card-actions class="grey darken-3 justify-center">
        <strong>Code Challenge for Asimov Consultores by Jorge Simoes</strong>
        <v-spacer></v-spacer>
        <a href="https://github.com/jorgehsy/dance-appointment"><v-icon small>code</v-icon>  view source code  </a>
      </v-card-actions>
    </v-card>
  </v-footer>
     </v-app>
</template>

<script>
export default {
     name: "App",
     data() {
          return {
               drawer: null
          };
     }
};
</script>
<style>
.subtitle{
     font-size: 8pt;
     color: gray;
     font-weight: 400
}
a{
     text-decoration: none;
     color: white;
}
</style>

