<template>
    <div class="content" id="mdp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="datatable" v-if="!isLoading">
                            <div class="card-body margin_p">
                              <div class="first_part">
                                <h3 style="text-align:center">ACI Limited</h3>
                                <p style="text-align:center;font-size: 18px;font-weight: bold;margin-left: 190px;">Management Staff Action Plan and Performance Appraisal Form
                                  <span style="font-weight: normal;border: 1px solid;padding: 15px;margin-left: 20px">Private & Confidential</span>
                                </p>
                                <hr>
                                <p style="font-size: 18px">
                                  Name of employee <span style="display: inline-block;border-bottom: 1px solid;width: 300px;text-align: center">{{ action_plan.EmployeeName }}</span>
                                  Position <span style="display: inline-block;border-bottom: 1px solid;width: 270px;text-align: center">{{ action_plan.Designation }}</span>
                                  Staff Id <span style="display: inline-block;border-bottom: 1px solid;width: 100px;text-align: center">{{ action_plan.StaffID }}</span>
                                </p>
                                <p style="font-size: 18px">
                                  Name of Supervisor <span style="display: inline-block;border-bottom: 1px solid;width: 290px;text-align: center">{{ action_plan.SuppervisorName }}</span>
                                  Position <span style="display: inline-block;border-bottom: 1px solid;width: 270px;text-align: center">{{ action_plan.SuppervisorDesignation }}</span>
                                  Staff Id <span style="display: inline-block;border-bottom: 1px solid;width: 100px;text-align: center">{{ action_plan.SuppervisorStaffID }}</span>
                                </p>
                              </div>

                              <div class="first_part" style="margin-top: 9px">
                                <p style="font-size: 18px">
                                  Agreed Action Plan for the Period : {{ action_plan.ActionPlanPeriod }}
                                </p>
                                <table class="table table-bordered" style="border: 1px solid #000000 !important">
                                  <thead>
                                    <tr style="background: white;color: black">
                                      <th class="text-center" rowspan="2" style="vertical-align: middle;">Task/Objective (70% Quantitative;  30% Qualitative)</th>
                                      <th class="text-center" rowspan="2" style="vertical-align: middle;">Target Date Of Completion</th>
                                      <th class="text-center" rowspan="2" style="vertical-align: middle;">Criterion Of Measurement</th>
                                      <th class="text-center" colspan="2"> Level of Achievement*</th>
                                    </tr>
                                    <tr style="background: white;color: black">
                                      <th class="text-center"> Rating by Employee</th>
                                      <th class="text-center"> Rating by Supervisor</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(item, i) in task" :key="item.ID" v-if="task.length">
                                      <td class="text-left" style="width: 50%;">{{i+1}}. {{ item.TaskName }}</td>
                                      <td class="text-center">{{ customFormatter(item.TargetDateOfCompletion) }}</td>
                                      <td class="text-center" >{{ item.CriterionOfMeasurement }}</td>
                                      <td style="background: #c1c1c1"></td>
                                      <td style="background: #c1c1c1"></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <p style="font-size: 18px">(You may insert new rows if it is required)</p>
                              </div>

                              <div class="third_part">
                                <div style="display: flex">
                                    <div class="col-md-3" style="text-align: left">
                                      <p>Signature of Employee</p>
                                      <input type="text">
                                    </div>
                                  <div class="col-md-3">
                                    <p>Signature of Supervisor</p>
                                    <input type="text">
                                  </div>
                                  <div class="col-md-3">
                                    <p>Signature of Employee</p>
                                    <input type="text">
                                  </div>
                                  <div class="col-md-3">
                                    <p>Signature of Supervisor</p>
                                    <input type="text">
                                  </div>
                                </div>
                              </div>
                              <br>
                              <div class="third_part" style="margin-top: 10px;">
                                <div style="display: flex">
                                  <div class="col-md-3" style="text-align: left">
                                    <p>Preparation Date of Action Plan</p>
                                  </div>
                                  <div class="col-md-3">
                                    <input type="text" style="height: 40px">
                                  </div>
                                  <div class="col-md-3">
                                    <p>Date of Appraisal Interview</p>
                                  </div>
                                  <div class="col-md-3">
                                    <input type="text" style="height: 40px">
                                  </div>
                                </div>
                              </div>
                              <div>
                                <p>*Rating Scale</p>
                                <table class="table table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline table-sm small">
                                  <thead>
                                  <tr style="background: white;color: black">
                                    <th class="text-center" style="vertical-align: middle;">Outstanding</th>
                                    <th class="text-center" colspan="2" style="vertical-align: middle;">Very Good</th>
                                    <th class="text-center" colspan="2" style="vertical-align: middle;">Good</th>
                                    <th class="text-center" colspan="2" style="vertical-align: middle;">Satisfactory</th>
                                    <th class="text-center" colspan="2" style="vertical-align: middle;">Tolerable</th>
                                    <th class="text-center" style="vertical-align: middle;">Poor</th>
                                  </tr>
                                  <tr style="background: white;color: black">
                                    <th class="text-center"> 9</th>

                                    <th class="text-center"> 8</th>
                                    <th class="text-center"> 7</th>

                                    <th class="text-center"> 6</th>
                                    <th class="text-center"> 5</th>

                                    <th class="text-center"> 4</th>
                                    <th class="text-center"> 3</th>

                                    <th class="text-center"> 2</th>
                                    <th class="text-center"> 1</th>

                                    <th class="text-center"> 0</th>
                                  </tr>
                                  </thead>
                                </table>
                              </div>
                              <div class="fourth_part">
                                <div style="display: flex">
                                  <div class="col-md-3">
                                    <p>Average Rating <input type="text" style="margin-left: 20px"></p>
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
import printJS from 'print-this'
import moment from "moment";
export default {
    name: "List",
    data() {
        return {
          action_plan: [],
          task: [],
          isMessage : false,
          query: "",
          editMode: false,
          isLoading: false,
        }
    },
  created() {
    axios.get(baseurl + `api/action_plane_print/${this.$route.params.ID}`).then((response)=>{
      console.log(response)
      this.action_plan = response.data.data
      this.task = response.data.data.finds

      // setTimeout(function(){
      //   window.print()
      // },1000)
      $('#mdp').printThis({
        importCSS: true,
        loadCSS: baseurl+"css/app.css",
      });

    });
  },
    methods: {
      customFormatter(date) {
        return moment(date).format('MMMM YYYY');
      },
    },
}
</script>
<style scoped>
.table thead th {
  vertical-align: middle;
}
#mdp {
  font-family: 'Nunito', sans-serif;
  color: #000000;
}
table tr th,table tr td {
  color: #000000 !important;
}
.table-bordered {
  border: 1px solid #000000 !important;
}
.table-bordered td, .table-bordered th {
  border: 1px solid #000000 !important;
}
.margin_p p{
  margin: 0;
  font-size: 18px;
}
.margin_p .table>tbody>tr>td, .table>tfoot>tr>td, .table>thead>tr>td {
  /* padding: 15px 12px; */
}
</style>

