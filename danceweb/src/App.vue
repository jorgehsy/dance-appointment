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
                         </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile @click="$router.replace('/create')">
                         <v-list-tile-action>
                         <v-icon>event</v-icon>
                         </v-list-tile-action>
                         <v-list-tile-content>
                         <v-list-tile-title>Make Appointment</v-list-tile-title>
                         </v-list-tile-content>
                    </v-list-tile>
               </v-list>
          </v-navigation-drawer>
          <v-content>
               <v-container fluid>
                    <router-view></router-view>
               </v-container>
          </v-content>
          <v-footer app></v-footer>
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
