<template>
     <v-container fluid grid-list-xl>
          <v-layout row align-content-space-between wrap >
               <v-card v-if="appointments" hover dark raised class="appoinment" v-for="(appointment, index) in appointments" v-bind:key="index"  width="300px" >
                    <v-card-title class="date" >
                         <v-flex>
                              <h3>{{ appointment.dancedate | moment("DD MMMM") }} </h3>
                         </v-flex>
                         <v-chip label small color="light" right text-color="gray" class="day">{{ appointment.dancedate | moment("dddd") }} </v-chip> 
                    </v-card-title>
                    <v-card-text class="luckydancer">
                         <p> Dance scheduled with <span class="dancer">{{ appointment.name }}</span> at 
                         <span class="time"> {{ getTimeFormat(appointment.dancetime) }} </span></p>
                    </v-card-text>
                    <v-card-actions>
                         <v-spacer></v-spacer>
                         <v-btn icon @click="$router.replace('create/'+appointment.id)">
                              <v-icon>edit</v-icon>
                         </v-btn>
                         <v-btn icon @click="dialogDelete(index)">
                              <v-icon>delete</v-icon>
                         </v-btn>
                    </v-card-actions>
               </v-card>
               <v-dialog v-model="dialog" max-width="290">
                    <v-card>
                    <v-card-title class="headline">Are you sure?</v-card-title>
                    <v-card-text>
                         
                    </v-card-text>
                    <v-card-actions>
                         <v-spacer></v-spacer>
                         <v-btn  color="primary" @click="dialog = false"   >
                              CANCEL
                         </v-btn>
                         <v-btn  color="error"  @click="deleteAppointment()"  >
                              DELETE
                         </v-btn>
                    </v-card-actions>
                    </v-card>
               </v-dialog>
               <div v-if="appointments.length == 0">
                    <h1>Want a dance with the Death?</h1>
                    <v-spacer></v-spacer>
                    <v-btn p3 color="primary" @click="$router.replace('create')">Make an Appointment</v-btn>
               </div>
          </v-layout> 
     </v-container>
</template>

<script>
import moment from 'moment';
export default {
     name: "Appointments",
     data (){
          return {
               appointments: [],
               objectPos: null,
               dialog: false
          }
     },
     created(){
          this.fetchAppointments();
     },
     methods:{
          fetchAppointments(){
               fetch("http://api.belike.info/api/appointments", {method: "GET"})
                    .then(data => data.json())
                    .then((data) => {
                         this.appointments = data;
                    })
                    .catch(err => console.log(err));
          },
          dialogDelete(index){
               this.objectPos = index;
               this.dialog = true;
          },
          deleteAppointment(){
               var id = this.appointments[this.objectPos].id;
               fetch("http://api.belike.info/api/appointment/"+id, {method: "DELETE"})
                    .then(() => {
                         this.fetchAppointments();
                         console.log(this.appointments);
                         this.dialog = false;
                    })
                    .catch(err => console.log(err));
          },
          getTimeFormat : function (time){
               return moment(time, "hh:mm:ss").format("hh:mm a");
          }
          
     }
}
</script>

<style scoped>
.appoinment{
     margin: 10px;
}
.luckydancer{
     padding: 30px;
     size: 14pt;
     background: #eee;
     color: black
}
.luckydancer span{
     font-weight: bold;
}
.day{
     font-size: 0.7em;
}
p span{
     font-weight: bold;
}
</style>


