<template>
     <v-container>
          <v-card>
               <v-layout row wrap>
                    <v-flex lg4 xs12>
                         <v-date-picker v-model="picker" ></v-date-picker>
                    </v-flex>
                    <v-flex lg8 xs12 off>
                         <v-layout column >
                              <!-- loop for dancetime taked -->
                              <v-card color="red lighten-4"  lg12 v-for="(schedule, index) in appointments" v-bind:key="index" class="timeCard">
                                   <v-layout>
                                        <v-flex xs2>
                                             <v-card-title text-color="white">{{ schedule.dancetime }}</v-card-title>
                                        </v-flex>
                                        <v-flex xs8>
                                             <v-card-text text-color="white">
                                                  {{ schedule.name }}
                                             </v-card-text>
                                        </v-flex>
                                        <v-flex xs1 >
                                             <v-card-actions >
                                                  <v-btn icon @click="updateDialog(index)"><v-icon>edit</v-icon></v-btn>
                                                  <v-btn icon @click="deleteDialog(index)"><v-icon>delete</v-icon></v-btn>
                                             </v-card-actions>
                                        </v-flex>
                                   </v-layout>
                              </v-card>
                              <!-- loop for available dancetimes -->
                              <v-card color="green lighten-4" hover lg12 v-for="schedule in available" v-bind:key="schedule" class="timeCard">
                                   <v-layout @click="createDialog(schedule)">
                                        <v-flex xs2>
                                             <v-card-title text-color="white">{{ schedule }}</v-card-title>
                                        </v-flex>
                                        <v-flex xs8>
                                             
                                        </v-flex>
                                   </v-layout>
                              </v-card>
                         </v-layout>
                    </v-flex>
               </v-layout>
          </v-card>

    <v-dialog
      v-model="dialog"
      width="500"
    >
      <v-card>
        <v-card-title class="headline grey lighten-2" primary-title >
               <span v-if="!edit">Create Appointment</span>
               <span v-if="edit">Update Appointment</span>
        </v-card-title>

        <v-card-text v-if="schedule">
               <v-form ref="create" v-model="valid" lazy-validation>
                    <v-text-field v-model="name" :counter="30" required label="name" :rules="nameRules"></v-text-field>
                    <v-text-field v-model="email" required label="email" :rules="emailRules"></v-text-field>
                    <p>Creating appointment for dancing on <span>{{ picker }} at {{ dancetime }}.</span> </p>
               </v-form>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn   color="primary"  flat  @click="dialog = false" >
            CANCEL
          </v-btn>
          <v-btn color="green" @click="submit()"  >
            <span v-if="edit">UPDATE</span><span v-else>CREATE</span>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
                   <v-dialog v-model="delDialog" max-width="290">
                    <v-card>
                    <v-card-title class="headline">Are you sure?</v-card-title>
                    <v-card-text >
                    </v-card-text>
                    <v-card-actions>
                         <v-spacer></v-spacer>
                         <v-btn flat color="primary" @click="delDialog = false"   >
                              CANCEL
                         </v-btn>
                         <v-btn  color="error"  @click="deleteAppointment(id)"  >
                              DELETE
                         </v-btn>
                    </v-card-actions>
                    </v-card>
               </v-dialog>
    <v-snackbar
      v-model="snackbar"
      :color="color"
      :timeout="timeout"
    >
      {{ text }}
      <v-btn
        dark
        flat
        @click="snackbar = false"
      >
        Close
      </v-btn>
    </v-snackbar>
     </v-container>
</template>

<script>
import moment from 'moment';
export default {
     name: "Schedule",
     data (){
          return {
               delDialog: false,
               picker: "",
               taked: [],
               available: [],
               appointment: [],
               appointments: [],
               dancetime:"",
               dancedate: "",
               edit: false,
               id: "",
               name: '',
               snackbar: false,
               color: '',
               timeout: 6000,
               text: 'snackbar',
               nameRules: [
               v => !!v || 'Name is required',
               v => (v && v.length <= 30) || 'Name must be less than 10 characters'
               ],
               email: '',
               emailRules: [
               v => !!v || 'E-mail is required',
               v => /.+@.+/.test(v) || 'E-mail must be valid'
               ],
               dialog: false,
               valid: false,
               schedule:["09:00:00","10:00:00","11:00:00","12:00:00","13:00:00","14:00:00","15:00:00","16:00:00"]
          }
     },
     watch:{
          picker (val){
               this.date = this.picker.split('-').join('/');
               this.fetchAppointments();
          }
     },
     methods:{
          fetchAppointments(){
               var api = "http://api.belike.info/api/appointments/" + this.date;
               fetch(api, {method: "GET"})
                    .then(data => data.json())
                    .then((data) => {
                         this.available=[];
                         this.taked=[];
                         this.appointments = data;
                         this.appointments.forEach(element => this.taked.push(element.dancetime));
                         this.available = this.schedule.filter(f => !this.taked.includes(f));
                         // console.log(this.available);
                    })
                    .catch(err => console.log(err));
          },
          updateDialog(index){
               this.edit = true;
               this.name = this.appointments[index].name;
               this.email = this.appointments[index].email;
               this.dancetime = this.appointments[index].dancetime;
               this.dancedate = this.appointments[index].dancedate;
               this.id = this.appointments[index].id;
               this.dialog=true;
          },
          deleteDialog(index){
               this.id = this.appointments[index].id;;
               this.delDialog = true;
          },
          createDialog(val){
               this.dancetime = val;
               this.dancedate = this.picker;
               this.dialog=true;
          },
          submit(){
               if (this.$refs.create.validate()){
                    this.appointment = {
                         "name": this.name,
                         "email": this.email,
                         "dancedate": this.dancedate,
                         "dancetime": this.dancetime
                    };
                    if(!this.edit){
                         this.fetchData("POST");
                    }else{
                         this.fetchData("PUT", this.id);
                    }
               }
          },
          deleteAppointment(id){
               fetch("http://api.belike.info/api/appointment/"+id, {method: "DELETE"})
                    .then(() => {
                         this.fetchAppointments();
                         this.color = "info",
                         this.text = "Appointment DELETED",
                         this.snackbar = true;
                         this.delDialog = false;
                         this.fetchAppointments();
                    })
                    .catch(err => console.log(err));
          },
          fetchData(method, id = ""){
               var apiUrl = "http://api.belike.info/api/appointment" + ((id=="")?'':"/"+id);
               fetch(apiUrl, {
                    body: JSON.stringify(this.appointment),
                    method: method,
                    headers: { "Content-Type":"application/json" }
               })
               .then(data => data.json())
               .then((data) => {
                    console.log(data);
                    if (data.status == 1){
                         this.color = "success",
                         this.text = "Appointment created successfully",
                         this.snackbar = true;
                         this.dialog = false;
                         this.fetchAppointments();
                    }else{
                         this.color = "error",
                         this.text = data.message,
                         this.snackbar = true;
                    }
               })
               .catch((err) => {
                    console.log(err);
                    this.color = "error",
                    this.text = data.message,
                    this.snackbar = true;
               });
          }
     }
}
</script>

<style>
.timeCard{
     margin: 10px;
}
p span{
     font-weight: bold;
}
</style>


