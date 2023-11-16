<template>
  <div class="content">
    <div class="container-fluid">
      <breadcrumb :options="['Create Management Development Plan']">
        <div class="col-sm-6">
          <div class="float-right d-none d-md-block">
            <div class="card-tools">
              <router-link :to="{name: 'MDPList'}" class="btn btn-primary btn-sm">
                <i class="fas fa-sync"></i>
                Back
              </router-link>
            </div>
          </div>
        </div>
      </breadcrumb>
      <div class="row">
        <div class="col-xl-12">
          <form @submit.prevent="store()" @keydown="form.onKeydown($event)">
            <div class="row">
              <div class="col-md-7">
                <div class="card">
                  <div class="datatable" v-if="!isLoading">
                    <div class="card-body">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <div class="form-group">
                                <label>Appraisal Period</label>
                                <input type="text" name="AppraisalPeriod" readonly v-model="form.AppraisalPeriod" class="form-control" :class="{ 'is-invalid': form.errors.has('AppraisalPeriod') }">
                                <div class="error" v-if="form.errors.has('AppraisalPeriod')" v-html="form.errors.get('AppraisalPeriod')" />
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <div class="form-group">
                                <label>Staff ID</label>
                                <input type="text" name="StaffID" id="StaffID" v-model="form.StaffID" class="form-control" :class="{ 'is-invalid': form.errors.has('StaffID') }" @change="getEmployeeByStaffID">
                                <div class="error" v-if="form.errors.has('StaffID')" v-html="form.errors.get('StaffID')" />
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Employee Name</label>
                              <input type="text" name="EmployeeName" v-model="form.EmployeeName" readonly class="form-control" :class="{ 'is-invalid': form.errors.has('EmployeeName') }">
                              <div class="error" v-if="form.errors.has('EmployeeName')" v-html="form.errors.get('EmployeeName')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Designation</label>
                              <input type="text" name="Designation" readonly v-model="form.Designation" class="form-control" :class="{ 'is-invalid': form.errors.has('Designation') }">
                              <div class="error" v-if="form.errors.has('Designation')" v-html="form.errors.get('Designation')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Department</label>
                              <input type="text" name="Department" readonly v-model="form.Department" class="form-control" :class="{ 'is-invalid': form.errors.has('Department') }">
                              <div class="error" v-if="form.errors.has('Department')" v-html="form.errors.get('Department')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Official Email</label>
                              <input type="text" name="OfficialEmail" v-model="form.OfficialEmail" class="form-control" :class="{ 'is-invalid': form.errors.has('OfficialEmail') }">
                              <div class="error" v-if="form.errors.has('OfficialEmail')" v-html="form.errors.get('OfficialEmail')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Mobile</label>
                              <input type="text" name="Mobile" v-model="form.Mobile" class="form-control" :class="{ 'is-invalid': form.errors.has('Mobile') }">
                              <div class="error" v-if="form.errors.has('Mobile')" v-html="form.errors.get('Mobile')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Date Of Birth</label>
                              <input type="text" name="DateOfBirth" v-model="form.DateOfBirth" readonly class="form-control" :class="{ 'is-invalid': form.errors.has('DateOfBirth') }">
                              <div class="error" v-if="form.errors.has('DateOfBirth')" v-html="form.errors.get('DateOfBirth')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Joining Date</label>
<!--                              <datepicker v-model="form.JoiningDate" :format="customFormatter" readonly placeholder="Enter Date" input-class="form-control"></datepicker>-->
                              <input type="text" name="JoiningDate" v-model="form.JoiningDate" readonly class="form-control" :class="{ 'is-invalid': form.errors.has('JoiningDate') }">
                              <div class="error" v-if="form.errors.has('JoiningDate')" v-html="form.errors.get('JoiningDate')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Current Position</label>
                              <input type="text" name="CurrentPosition" v-model="form.CurrentPosition" readonly class="form-control" :class="{ 'is-invalid': form.errors.has('CurrentPosition') }">
                              <div class="error" v-if="form.errors.has('CurrentPosition')" v-html="form.errors.get('CurrentPosition')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Present Job Started On</label>
                              <datepicker v-model="form.PresentJobStartedOn" :format="customFormatter" input-class="form-control"></datepicker>
<!--                              <input type="text" name="PresentJobStartedOn" v-model="form.PresentJobStartedOn" class="form-control" :class="{ 'is-invalid': form.errors.has('PresentJobStartedOn') }">-->
                              <div class="error" v-if="form.errors.has('PresentJobStartedOn')" v-html="form.errors.get('PresentJobStartedOn')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Qualification</label>
                              <input type="text" name="Qualification" v-model="form.Qualification" class="form-control" :class="{ 'is-invalid': form.errors.has('Qualification') }">
                              <div class="error" v-if="form.errors.has('Qualification')" v-html="form.errors.get('Qualification')" />
                            </div>
                          </div>
                        </div>
                        <hr>
                       </div>

                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Supervisor Staff ID</label>
                              <input type="text" name="SuppervisorStaffID" v-model="form.SuppervisorStaffID" class="form-control" :class="{ 'is-invalid': form.errors.has('SuppervisorStaffID') }" @change="getSupervisorByStaffID">
                              <div class="error" v-if="form.errors.has('SuppervisorStaffID')" v-html="form.errors.get('SuppervisorStaffID')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Supervisor Name</label>
                              <input type="text" name="SuppervisorName" readonly v-model="form.SuppervisorName" class="form-control" :class="{ 'is-invalid': form.errors.has('SuppervisorName') }">
                              <div class="error" v-if="form.errors.has('SuppervisorName')" v-html="form.errors.get('SuppervisorName')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Supervisor Designation</label>
                              <input type="text" name="SuppervisorDesignation" readonly v-model="form.SuppervisorDesignation" class="form-control" :class="{ 'is-invalid': form.errors.has('SuppervisorDesignation') }">
                              <div class="error" v-if="form.errors.has('SuppervisorDesignation')" v-html="form.errors.get('SuppervisorDesignation')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Supervisor Email</label>
                              <input type="text" name="SuppervisorEmail" readonly v-model="form.SuppervisorEmail" class="form-control" :class="{ 'is-invalid': form.errors.has('SuppervisorEmail') }">
                              <div class="error" v-if="form.errors.has('SuppervisorEmail')" v-html="form.errors.get('SuppervisorEmail')" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Supervisor Mobile</label>
                              <input type="text" name="SuppervisorMobile" v-model="form.SuppervisorMobile" class="form-control" :class="{ 'is-invalid': form.errors.has('SuppervisorMobile') }">
                              <div class="error" v-if="form.errors.has('SuppervisorMobile')" v-html="form.errors.get('SuppervisorMobile')" />
                            </div>
                          </div>
                        </div>
                        <hr>
                        <p style="font-size: 13px;font-weight:bold;color:#0000B9">A. To improve the performance of your present job, list below the areas where you feel that you require additional knowledge or better understanding.
                          Which you will acquire at your personal initiative:</p>
                        <hr>
                        <h4 style="font-size: 18px">Personal Initiative</h4>
                        <div class="row" v-for="(initiat, index) in form.initiative" :key="index">
                          <div class="col-3 col-md-3">
                            <div class="form-group">
                              <label>Title</label>
                              <input v-model="initiat.Name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('Name') }" name="amount" placeholder="Title" required>
                              <div class="error" v-if="form.errors.has('Name')" v-html="form.errors.get('Name')" />
                            </div>
                          </div>
                          <div class="col-3 col-md-3">
                            <div class="form-group">
                              <label>Type</label>
                              <select v-model="initiat.Type" name="Type" id="catId" class="form-control" :class="{ 'is-invalid': form.errors.has('Type') }">
                                <option value="">Select Type</option>
                                <option value="Knowledge">Knowledge</option>
                                <option value="Skill">Skill</option>
                                <option value="Behavior">Behavior</option>
<!--                                <option :value="category.id" v-for="(category,index) in categories" :key="index">{{category.name}}</option>-->
                              </select>
                              <div class="error" v-if="form.errors.has('Type')" v-html="form.errors.get('Type')" />
                            </div>
                          </div>
                          <div class="col-3 col-md-3">
                            <div class="form-group">
                              <label>Planned Date</label>
                              <datepicker v-model="initiat.Date" :format="customFormatter" placeholder="Enter Date" input-class="form-control"></datepicker>
                              <div class="error" v-if="form.errors.has('Date')" v-html="form.errors.get('Date')" />
                            </div>
                          </div>
                          <div class="col-2" style="padding-top: 30px">
                            <button type="button" class="btn btn-danger btn-sm" @click="deleteFind(index)">x</button>&nbsp;
                            <button type="button" class="btn btn-success btn-sm" @click="addFind">+</button>
                          </div>
                        </div>
                        <hr>
                        <button type="button" class="btn btn-primary float-right" @click="getSuggestiveList()" v-if="dropDown==='NO'" style="width: 230px;height: 45px"> Suggestive List</button>
                        <h4 style="font-size: 18px">Required Training</h4>
                        <p style="font-size: 13px">Which will require in-house or external training that you think should be organized by the Company.</p>
                        <hr>
                        <div class="row" v-for="(train,index2) in form.training" v-if="dropDown">

                          <div class="col-4 col-md-4" v-if="dropDown==='YES'">
                            <div class="form-group">
                              <label>Select Training</label>
                              <select v-model="train.TrainingTitle" name="Type" id="TrainingTitle" class="form-control" :class="{ 'is-invalid': form.errors.has('TrainingTitle') }">
                                <option value="">Select Type</option>
                                <option :value="list.TrainingTitle" v-for="(list,i) in training_list" :key="i">{{list.TrainingTitle}}</option>
                              </select>
                              <div class="error" v-if="form.errors.has('TrainingTitle')" v-html="form.errors.get('TrainingTitle')" />
                            </div>
                          </div>

                          <div class="col-4 col-md-4" v-else>
                            <div class="form-group">
                              <label>Select Training</label>
                              <input v-model="train.TrainingTitle" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('Name') }" name="TrainingTitle" placeholder="Type Or Copy From Suggestive List">
                              <div class="error" v-if="form.errors.has('TrainingTitle')" v-html="form.errors.get('TrainingTitle')" />
                            </div>
                          </div>

                          <div class="col-3 col-md-3">
                            <div class="form-group">
                              <label>Type</label>
                              <select v-model="train.TrainingType" name="TrainingType" id="TrainingType" class="form-control" :class="{ 'is-invalid': form.errors.has('TrainingType') }">
                                <option value="">Select Type</option>
                                <option value="Knowledge">Knowledge</option>
                                <option value="Skill">Skill</option>
                                <option value="Behavior">Behavior</option>
                              </select>
                              <div class="error" v-if="form.errors.has('TrainingType')" v-html="form.errors.get('TrainingType')" />
                            </div>
                          </div>
                          <div class="col-3 col-md-3">
                            <div class="form-group">
                              <label>Planned Date</label>
                              <datepicker v-model="train.TrainingDate" :format="customFormatter" placeholder="Enter Date" input-class="form-control"></datepicker>
                              <div class="error" v-if="form.errors.has('TrainingDate')" v-html="form.errors.get('TrainingDate')" />
                            </div>
                          </div>
<!--                          <div class="col-2" style="padding-top: 30px">-->
<!--                            <button type="button" class="btn btn-danger btn-sm" @click="Training_deleteFind(index2)">x</button>&nbsp;-->
<!--                            <button type="button" class="btn btn-success btn-sm" @click="Training_addFind">+</button>-->
<!--                          </div>-->
                        </div>

                        <hr>

                        <div class="row">
                          <p style="font-size: 13px;font-weight: bold;color:#0000B9"> B. For development to take future responsibilities
                            Other than those mentioned in A, list below two areas of personal development/training that you would like to see
                            happen in your case in the coming years and explain how those trainings will help the company
                          </p>
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col-6 col-md-6">
                                <div class="form-group">
                                  <label>Training One</label>
                                  <input v-model="form.AreaOne" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('AreaOne') }" style="height: 90px" name="AreaOne" placeholder="Title" required>
                                  <div class="error" v-if="form.errors.has('AreaOneName')" v-html="form.errors.get('AreaOneName')" />
                                </div>
                              </div>
                              <div class="col-6 col-md-6">
                                <div class="form-group">
                                  <label>Training Two</label>
                                  <input v-model="form.AreaTwo" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('AreaTwo') }" style="height: 90px" name="AreaTwo" placeholder="Title" required>
                                  <div class="error" v-if="form.errors.has('AreaTwo')" v-html="form.errors.get('AreaTwo')" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="card">
                  <div class="datatable" v-if="!isLoading">
                    <div class="card-body">
                      <div class="col-md-12">
                        <p>Last Five Years Training History</p>
                        <table class="table table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline table-sm small">
                          <thead>
                            <tr>
                              <th>Organized By</th>
                              <th>Training Category</th>
                              <th>Training Name</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(training, i) in training_history" :key="i" v-if="training_history.length">
                                <td>{{ training.Organized_By }}</td>
                                <td>{{ training.Tranning_Category }}</td>
                                <td>{{ training.Tranning_Name }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
<!--    modal-->

    <div class="modal fade bs-example-modal-lg" id="suggestiveModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title mt-0" id="myLargeModalLabel">Suggestive Learning Offering List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="modalHide()">×</button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline table-sm small">
              <thead>
              <tr>
                <th>Learning Topic</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(suggestive, i) in suggestive_list" :key="i" v-if="suggestive_list.length">
                <td>{{ suggestive.TrainingTitle }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

  </div>
</template>

<script>
import {baseurl} from '../../base_url'
import Datepicker from 'vuejs-datepicker';
import moment from "moment";
import {Common} from "../../mixins/common";
// Basic Use - Covers most scenarios
import { VueEditor } from "vue2-editor";
export default {
  name: "List",
  mixins: [Common],
  components: {
    Datepicker,
    VueEditor
  },
  data() {
    return {
      training_history: [],
      training_list: [],
      employee: [],
      supervisor: [],
      suggestive_list: [],
      form: new Form({
        ID :'',
        AppraisalPeriod :'2023-2024',
        StaffID :'',
        EmployeeName :'',
        Designation :'',
        Department: '',
        OfficialEmail:'',
        Mobile:'',
        DateOfBirth:'',
        JoiningDate:'',
        CurrentPosition:'',
        PresentJobStartedOn:'',
        Qualification:'',
        SuppervisorStaffID:'',
        SuppervisorName:'',
        SuppervisorDesignation:'',
        SuppervisorEmail:'',
        SuppervisorMobile:'',
        AreaOne:'',
        AreaTwo:'',
        initiative: [{ Name: '' , Type: '', Date: ''}],
        training: [
            { TrainingTitle: '' , TrainingType: '', TrainingDate: ''},
            { TrainingTitle: '' , TrainingType: '', TrainingDate: ''},
            { TrainingTitle: '' , TrainingType: '', TrainingDate: ''},
            { TrainingTitle: '' , TrainingType: '', TrainingDate: ''},
            { TrainingTitle: '' , TrainingType: '', TrainingDate: ''},
        ],
        //area: [{ AreaOneName: '', AreaTwoName: ''}],
      }),
      isLoading: false,
      dropDown:''
    }
  },
  mounted() {
    document.title = 'MDP Create | MDP';
    //this.getAllEmployeeTrainingList()
  },
  created() {
    this.getUserData()
    //this.getData()
  },
  methods: {
    store(){
      this.form.busy = true;
      this.form.post(baseurl + "api/mdp/store").then(response => {
        console.log(response)
        if (response.data.status === 'error'){
          this.errorNoti(response.data.message);
        }else {
          this.redirect(this.mainOrigin + 'mdp-list')
          this.successNoti(response.data.message);
        }
      }).catch(e => {
        this.isLoading = false;
      });
    },
    getEmployeeByStaffID(){
      axios.post(baseurl +'api/get-employee-by-employee-code/', {
        EmpCode: this.form.StaffID,
      }).then((response)=>{
        console.log(response)
        this.training_history = response.data.training_history;
        this.form.EmployeeName = response.data.employee.EmployeeName;
        this.form.Designation = response.data.employee.Designation;
        this.form.Department = response.data.employee.Department;
        this.form.OfficialEmail = response.data.employee.OfficialEmail;
        this.form.Mobile = response.data.employee.Mobile;
        this.form.DateOfBirth = response.data.employee.DateOfBirth;
        this.form.JoiningDate = response.data.employee.JoiningDate;
        this.form.CurrentPosition = response.data.employee.CurrentPosition;
        this.form.PresentJobStartedOn = response.data.employee.PresentJobStartedOn;
        this.form.Qualification = response.data.employee.Qualification;
        this.form.StaffID = response.data.employee.StaffID;
        this.dropDown = response.data.dropDown;
        this.training_list = response.data.training_list;
      }).catch((error)=>{

      })
    },
    getSupervisorByStaffID(){
      axios.post(baseurl +'api/get-supervisor-by-employee-code/', {
        EmpCode: this.form.StaffID,
        SuperVisorEmpCode: this.form.SuppervisorStaffID,
      }).then((response)=>{
        console.log(response)
        if (response.data.status === 'error'){
          this.errorNoti(response.data.message);
        }else {
          this.form.SuppervisorName = response.data.employee.SuppervisorName;
          this.form.SuppervisorDesignation = response.data.employee.SuppervisorDesignation;
          this.form.SuppervisorEmail = response.data.employee.SuppervisorEmail;
          this.form.SuppervisorMobile = response.data.employee.SuppervisorMobile;
          this.form.SuppervisorStaffID = response.data.employee.SuppervisorStaffID;
        }
      }).catch((error)=>{

      })
    },
    getAllEmployeeTrainingList(){
      axios.get(baseurl+'api/get-all-employee-training-list').then((response)=>{
        this.training_list = response.data.training_list;
      }).catch((error)=>{

      })
    },
    getSuggestiveList(){
      axios.get(baseurl+'api/get-level-wise-suggestive-list/' + this.form.StaffID).then((response)=>{
        this.suggestive_list = response.data.suggestive_list;
        $("#suggestiveModal").modal("show");
      }).catch((error)=>{

      })
    },
    getData() {
      axios.get(baseurl+'api/get-agree-business-user').then((response)=>{
        console.log(response)
        this.dropDown = response.data.dropDown
      }).catch((error)=>{

      })
    },
    getUserData() {
      this.axiosPost('me', {}, (response) => {
        this.image = `${this.mainOrigin}assets/images/avatar.png`;
        this.$store.commit('me', response);
        console.log(response)
        if(response.payload.Type ==='employee'){
          this.form.StaffID = response.payload.EmpCode;
          this.getEmployeeByStaffID()
          $('#StaffID').attr('readonly', true);
        }
      }, (error) => {
        this.errorNoti(error);
      });
    },
    modalHide(){
      $("#suggestiveModal").modal("hide");
    },
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    },
    //for initiative
    addFind: function () {
      this.form.initiative.push({ Name: '' , Type: '', Date: ''});
    },
    deleteFind: function (index) {
      this.form.initiative.splice(index, 1);
    },
    //for training
    Training_addFind: function () {
      this.form.training.push({ TrainingTitle: '' , TrainingType: '', TrainingDate: ''});
    },
    Training_deleteFind: function (index2) {
      this.form.training.splice(index2, 1);
    },
    // //for Area_one
    // AreaaddFind: function () {
    //   this.form.area.push({ AreaOneName: '', AreaTwoName: ''});
    // },
    // AreadeleteFind: function (index2) {
    //   this.form.area.splice(index2, 1);
    // },
  },
}
</script>

<style scoped>
.side_note label{
  font-size: 11px!important;
  margin-bottom: 0;
}
.side_note .form-control {
  height: 25px!important;
}
.side_note .form-group {
  margin-bottom: 0;
}
.form-group label{
  font-size:12px!important
}
.form-control {
  font-size: 12px!important;
}
</style>
