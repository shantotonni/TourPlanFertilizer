<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="datatable" v-if="!isLoading">
                            <div class="card-body">
                              <div style="text-align: center">
                                <img :src="`${mainOrigin}logo/logo.png`" style="height: 60px;" alt="user" class="rounded-circle" />
                                <h3>Personal Training Commitment 2023-2024</h3>
                              </div>
                              <div class="first_part">
                                <table class="table table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline table-sm small">
                                  <thead>
                                    <tr style="background: white;color: black">
                                      <th class="text-center">Staff ID</th>
                                      <th class="text-center">Employee Name</th>
                                      <th class="text-center">Designation</th>
                                      <th class="text-center">Joining Date</th>
                                      <th class="text-center">Present Job Starte On</th>
                                      <th class="text-center">Mobile</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td class="text-center">{{ mdplist.StaffID }}</td>
                                      <td class="text-center">{{ mdplist.EmployeeName }}</td>
                                      <td class="text-center">{{ mdplist.Designation }}</td>
                                      <td class="text-center">{{ mdplist.JoiningDate }}</td>
                                      <td class="text-center">{{ mdplist.PresentJobStartedOn }}</td>
                                      <td class="text-center">{{ mdplist.Mobile }}</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>

                              <br>

                              <div class="first_part">
<!--                                <p>Training Received so far: List Attached</p>-->
                                <table class="table table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline table-sm small">
                                  <thead>
                                    <tr style="background: white;color: black">
                                      <th>Area of Performance Improvement</th>
                                      <th>Required Training/Learning Topic</th>
                                      <th>Program Type</th>
                                      <th>Planned Month</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>In-house or External Training By the Company for Delivering Present Job Responsibility</td>
                                      <td><p v-for="(train, i) in training" :key="i" v-if="training.length">{{ train.TrainingTitle }}</p></td>
                                      <td><p v-for="(train, i) in training" :key="i" v-if="training.length">{{ train.TrainingType }}</p></td>
                                      <td><p v-for="(train, i) in training" :key="i" v-if="training.length">{{ customFormatter(train.TrainingDate) }}</p></td>
                                    </tr>
                                    <tr>
                                      <td>Personal Development / Training to Deliver Future Job Responsibilities</td>
                                      <td>
                                        <p>{{ mdplist.AreaOne }}</p>
                                        <p>{{ mdplist.AreaTwo }}</p>
                                      </td>
                                      <td><p v-for="(init, i) in initiative" :key="i" v-if="initiative.length">{{ init.Type }}</p></td>
                                      <td style="width: 8%"><p v-for="(init, i) in initiative" :key="i" v-if="initiative.length">{{ customFormatter(init.Date) }}</p></td>
                                    </tr>
                                    <tr>
                                      <td>Knowledge and skill will be Acquire at personal Initiative</td>
                                      <td><p v-for="(init, i) in initiative" :key="i" v-if="initiative.length">{{ init.Name }}</p></td>
                                      <td></td>
                                      <td></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                              <hr>
                              <br>
                              <div class="first_part">
                               <div style="display: flex">
                                 <div style="width: 33%">
                                   <p>
                                     <span style="display: inline-block;border-top: 1px solid;width: 160px;text-align: center"></span>
                                   </p>
                                   <p>Signature of the Incumbent</p>
                                   <p>Form No: TR-00301/06</p>
                                 </div>
                                 <div style="text-align: center;width: 33%">
                                   <p>
                                     <span style="display: inline-block;border-top: 1px solid;width: 200px;text-align: center"></span>
                                   </p>
                                   <p>Signature of the Supervisor</p>
                                 </div>
                                 <div style="text-align: center;width: 33%">
                                   <p>
                                     <span style="display: inline-block;border-top: 1px solid;width: 200px;text-align: center"></span>
                                   </p>
                                   <p>Signature of the Department Head</p>
                                 </div>
                               </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {baseurl} from '../../base_url'
import moment from "moment/moment";

export default {
    name: "List",
    data() {
        return {
          mdplist: [],
          initiative: [],
          training: [],
          area: [],
            pagination: {
                current_page: 1
            },
            isMessage : false,
            query: "",
            editMode: false,
            isLoading: false,
            form: new Form({
                id:'',
                generator_name:'',
                unique_generator_code: '',
                generator_model: '',
                brand_id:'',
                rating: '',
                generator_serial: '',
                engine_brand: '',
                engine_serial: '',
            }),
        }
    },
  created() {
    axios.get(baseurl + `api/mdp/print/${this.$route.params.ID}`).then((response)=>{
      console.log(response)
      this.mdplist = response.data.data
      this.training = response.data.data.training
      this.initiative = response.data.data.initiative
      this.area = response.data.data.area

      setTimeout(function(){
        window.print()
      },2000)
    });
  },

    methods: {
      customFormatter(date) {
        return moment(date).format('YYYY-MM-DD');
      },
    },
}
</script>

<style scoped>
 @media print{@page {size: landscape}}
 p{
   margin:0
 }
</style>
