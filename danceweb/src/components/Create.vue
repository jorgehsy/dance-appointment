<template>
<v-container fluid grid-list-xl>
     <v-form ref="form" v-model="valid" lazy-validation>
          <v-layout row wrap align-content-space-between>
               <v-flex xs4>
                    <v-text-field
                         v-model="appointment.name"
                         :rules="nameRules"
                         :counter="30"
                         label="Name"
                         required
                    ></v-text-field>
                    <v-text-field
                         v-model="appointment.email"
                         :rules="emailRules"
                         label="E-mail"
                         required
                    ></v-text-field>
                    <v-btn :disabled="!valid" @click="submit">
                         Create Appointment
                    </v-btn>
                    <v-alert :value="alertDate" type="warning" transition="scale-transition">
                         You must pick a date and a time for the dance.
                    </v-alert>
                    <v-alert :value="alertWarning" type="warning" transition="scale-transition">
                         {{ alertMessage }}
                    </v-alert>
                    <v-alert :value="alertError" type="error" transition="scale-transition">
                         Sorry... there was an error with the comunication. Please try again.
                    </v-alert>
               </v-flex>
               <v-flex xs6>
                    <v-date-picker first-day-of-week="0" v-model="appointment.dancedate" :landscape="landscape" ></v-date-picker>
                    <v-time-picker :allowed-hours="allowedHours" v-model="appointment.dancetime" :landscape="landscape"></v-time-picker>
               </v-flex>
          </v-layout>
     </v-form>
     <v-dialog v-model="dialog" max-width="400" >
          <v-card >
               <v-card-title class="headline" >Appointment Created!</v-card-title>
               <v-card-text v-if="appointment.dancedate" class="dialog" >
                    <p>Congratz <span>{{ appointment.name }}</span>! you will have a Dance with the Death on <span>{{ appointment.dancedate | moment("DD MMMM") }}</span> at <span>{{ getTimeFormat(appointment.dancetime) }}</span>.</p>
               </v-card-text>
               <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" flat="flat" @click="dialog = false" >
                         Create Other
                    </v-btn>
                    <v-btn  color="green darken-1" flat="flat" @click="$router.replace('/')">
                         Take me Home
                    </v-btn>
               </v-card-actions>
          </v-card>
    </v-dialog>
</v-container>
</template>

<script>
import axios from 'vue-cli-plugin-axios';
import moment from 'moment';
export default {
     name: "create",
     data (){
           return {
               dialog: false,
               valid: false,
               nameRules: [
                    v => !!v || 'Name is required',
                    v => (v && v.length <= 30) || 'Name must be less than 30 characters'
               ],
               emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid'
               ],
               appointment: {
                    dancedate: null,
                    dancetime: null,
                    name: '',
                    email: '',
               },
               landscape: true,
               alertDate: false,
               alertError: false,
               alertWarning: false,
               alertMessage: "",
          }
     },
     methods:{
          submit () {
               if ((this.$refs.form.validate()) && (this.appointment.dancedate && this.appointment.dancetime)){
                    // console.log(this.appointment);
                    fetch('http://api.belike.info/api/appointment', {
                         body: JSON.stringify(this.appointment),
                         method: "POST",
                         headers: { "Content-Type":"application/json" }
                    })
                    .then(data => data.json())
                    .then((data) => {
                         console.log(data);
                         if (data.status == 1){
                              this.dialog = true;
                         }else{
                              this.alertWarning = true;
                              this.alertMessage = data.message;
                              self = this;
                              setTimeout(function(){self.alertWarning=false}, 5000);
                         }
                    })
                    .catch((err) => {
                         console.log(err);
                         this.alertError = true;
                         var self = this;
                         setTimeout(function(){this.alertError=false}, 5000);
                    })
               }else{
                    this.alertDate = true;
                    var self = this;
                    setTimeout(function(){this.alertDate=false}, 3000);
               }
          },
          getTimeFormat : function (time){
               return moment(time, "hh:mm:ss").format("hh:mm a");
          },
          allowedHours: v => v > 8 || v < 6,
     }
}
</script>

<style>
.dialog span{
     font-weight: bold;
}
.headline{
     background: lightgreen;
}
</style>
