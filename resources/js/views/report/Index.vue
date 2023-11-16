<template>
  <div class="content">
    <div class="container-fluid">
      <breadcrumb :options="['Student Payment Report']">
        <div class="col-sm-6">
          <div class="float-right d-none d-md-block">
            <div class="card-tools">
              <button type="button" class="btn btn-primary btn-sm" @click="exportStudentPaymentReport">
                <i class="fas fa-sync"></i>
                Export
              </button>
            </div>
          </div>
        </div>
      </breadcrumb>

      <div class="row">
        <div class="col-xl-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex">
                    <div class="flex-grow-1">
                      <div class="row">
                        <div class="col-md-2">
                          <div class="form-group">
                            <select name="sessionId" id="sessionId" v-model="sessionId" class="form-control">
                              <option disabled value="">Select Session</option>
                              <option :value="session.session_id" v-for="(session , index) in sessions" :key="index">{{ session.name }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <select name="categoryId" id="categoryId" v-model="categoryId" class="form-control">
                              <option disabled value="">Select Category</option>
                              <option :value="category.id" v-for="(category , index) in categories" :key="index">{{ category.name }}</option>
                            </select>
                          </div>
                        </div>
<!--                        <div class="col-md-2">-->
<!--                          <div class="form-group">-->
<!--                            <multiselect-->
<!--                                v-model="studentId"-->
<!--                                :options="students"-->
<!--                                :multiple="false"-->
<!--                                label="full_name"-->
<!--                                track-by="student_id"-->
<!--                            >-->
<!--                            </multiselect>-->
<!--                          </div>-->
<!--                        </div>-->
<!--                        <div class="col-md-2">-->
<!--                          <div class="form-group">-->
<!--                            <select name="studentId" id="studentId" v-model="studentId" class="form-control">-->
<!--                              <option disabled value="">Select Student</option>-->
<!--                              <option :value="student.student_id" v-for="(student , index) in students" :key="index">{{ student.first_name }} {{ student.last_name }}</option>-->
<!--                            </select>-->
<!--                          </div>-->
<!--                        </div>-->
<!--                        <div class="col-md-2">-->
<!--                          <div class="form-group">-->
<!--                            <input v-model="roll_number" type="text" class="form-control" placeholder="Roll Number">-->
<!--                          </div>-->
<!--                        </div>-->
                        <div class="col-md-2">
                          <div class="form-group">
                            <datepicker v-model="from_date" :format="customFormatter" placeholder="Enter From Date" input-class="form-control"></datepicker>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <datepicker v-model="to_date" :format="customFormatter" placeholder="Enter To Date" input-class="form-control"></datepicker>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <button type="submit" @click="getAllStudentPaymentList" class="btn btn-success"><i class="mdi mdi-filter"></i>Filter</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline table-sm small">
                      <thead>
                      <tr>
                        <th class="text-center">SN</th>
                        <th class="text-center">Student Name</th>
                        <th class="text-center">Student Category</th>
                        <th class="text-center">Roll</th>
                        <th class="text-center">Session</th>
                        <th class="text-center">Currency</th>
                        <th class="text-center">Amount</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr v-for="(bill, i) in student_payment" :key="bill.id" v-if="student_payment.length">
                        <th scope="row">{{ ++i }}</th>
                        <td>{{ bill.name }}</td>
                        <td>{{ bill.student_category }}</td>
                        <td>{{ bill.roll_no }}</td>
                        <td>{{ bill.session }}</td>
                        <td>{{ bill.currency }}</td>
                        <td class="text-right">{{ bill.symbol }}{{ bill.amount }}</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="row">
                    <div class="col-4">
                      <div class="data-count">
                        Show {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} rows
                      </div>
                    </div>
                    <div class="col-8">
                      <pagination
                          v-if="pagination.last_page > 1"
                          :pagination="pagination"
                          :offset="5"
                          @paginate="query === '' ? getAllStudentPaymentList() : searchData()"
                      ></pagination>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <data-export/>
  </div>
</template>

<script>
import {baseurl} from '../../base_url'
import Datepicker from 'vuejs-datepicker';
import moment from "moment";
import {bus} from "../../app";
export default {
  name: "List",
  components: {
    Datepicker
  },
  data() {
    return {
      student_payment: [],
      //students: [],
      sessions: [],
      categories: [],
      pagination: {
        current_page: 1,
        from: 1,
        to: 1,
        total: 1,
      },
      query: "",
      editMode: false,
      isLoading: false,
      studentId: '',
      roll_number: '',
      from_date: '',
      to_date: '',
      sessionId: '',
      categoryId: '',
    }
  },
  watch: {
    query: function(newQ, old) {
      if (newQ === "") {
        this.getAllStudentPaymentList();
      } else {
        this.searchData();
      }
    }
  },
  mounted() {
    document.title = 'Student Payment Report | Bill';
    this.getAllStudentPaymentList();
    //this.getAllStudent();
    this.getAllSession();
    this.getAllCategory();
  },
  methods: {
    getAllStudentPaymentList(){
      let fromdate =  this.from_date ? moment(this.from_date).format('YYYY-MM-DD') : '';
      let todate =  this.to_date ? moment(this.to_date).format('YYYY-MM-DD') : '';

      axios.get(baseurl + 'api/report/student-payment?page='+ this.pagination.current_page
          + "&sessionId=" + this.sessionId
          + "&categoryId=" + this.categoryId
          + "&from_date=" + fromdate
          + "&to_date=" + todate
      ).then((response)=>{
        console.log(response)
        this.student_payment = response.data.data;
        this.pagination = response.data.meta;
      }).catch((error)=>{

      })
    },

    exportStudentPaymentReport(){
      axios.get(baseurl + 'api/report/export-student-payment-report?sessionId='+ this.sessionId
          + "&categoryId=" + this.categoryId
          + "&from_date=" + this.from_date
          + "&to_date=" + this.to_date
      ).then((response)=>{
            console.log(response)
            let dataSets = response.data.data;
            if (dataSets.length > 0) {
              let columns = Object.keys(dataSets[0]);
              columns = columns.filter((item) => item !== 'row_num');
              let rex = /([A-Z])([A-Z])([a-z])|([a-z])([A-Z])/g;
              columns = columns.map((item) => {
                let title = item.replace(rex, '$1$4 $2$3$5')
                return {title, key: item}
              });
              bus.$emit('data-table-import', dataSets, columns, 'Student Payment Report List')
            }
          }).catch((error)=>{
      })
    },

    // getAllStudent(){
    //   axios.get(baseurl + 'api/get-all-student').then((response)=>{
    //     this.students = response.data.students.data;
    //   }).catch((error)=>{
    //
    //   })
    // },
    getAllSession(){
      axios.get(baseurl+'api/get-all-session').then((response)=>{
        console.log(response.data)
        this.sessions = response.data.sessions;
      }).catch((error)=>{

      })
    },
    getAllCategory(){
      axios.get(baseurl+'api/get-all-category').then((response)=>{
        console.log(response.data)
        this.categories = response.data.categories;
      }).catch((error)=>{

      })
    },
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    }
  },
}
</script>

<style scoped>

</style>
