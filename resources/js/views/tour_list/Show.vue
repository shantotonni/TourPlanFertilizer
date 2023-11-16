<template>
  <div class="content">
    <div class="container-fluid">
      <breadcrumb :options="['Tour Details']">
        <div class="col-sm-6">
          <div class="float-right d-none d-md-block">
            <div class="card-tools">
              <router-link :to="{name: 'MonthlyPlan'}" class="btn btn-primary btn-sm">
                <i class="fas fa-sync"></i>
                Back
              </router-link>
            </div>
          </div>
        </div>
      </breadcrumb>
      <div class="row">
        <div class="col-xl-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="d-flex">
                  <div class="flex-grow-1">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <input v-model="query" @keyup="getDetails('N')" type="text" class="form-control"
                                 placeholder="Search">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <datepicker v-model="from_date" :format="customFormatter" placeholder="Enter From Date"
                                      input-class="form-control"></datepicker>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <datepicker v-model="to_date" :format="customFormatter" placeholder="Enter To Date"
                                      input-class="form-control"></datepicker>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <button type="submit" @click="getDetails('N')" class="btn btn-success"><i class="mdi mdi-filter"></i>Filter
                        </button>
                      </div>
                      <div class="col-md-1">
                        <button type="submit" @click="getDetails('Y')" class="btn btn-success"><i class="mdi mdi-file-excel"></i>Export
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table
                      class="table table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline table-sm small">
                    <thead style='color:black'>
                    <tr style='background-color :skyblue'>
                      <th>SN</th>
                      <th>Employee ID</th>
                      <th>Employee Name</th>
                      <th>Designation</th>
                      <th>Destination</th>
                      <th>Action Type</th>
                      <th>Objective</th>
                      <th>Outcome</th>
                      <th>Image</th>
                      <th>Lat</th>
                      <th>Lon</th>
                      <th>PlanDate</th>
                      <th>PlanExecutionDate</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(plan, i) in tour_plans" :key="plan.ID" v-if="tour_plans.length">
                      <th class="text-center">{{ ++i }}</th>
                      <td class="text-right">{{ plan.UserId }}</td>
                      <td>{{ plan.UserName }}</td>
                      <td>{{ plan.UserDesignation }}</td>
                      <td>{{ plan.Destination }}</td>
                      <td>{{ plan.ActionName }}</td>
                      <td>{{ plan.Objective }}</td>
                      <td>{{ plan.Outcome }}</td>
                      <td class="text-center">
                        <img v-if="plan.Image" height="40" width="40" :src="tableImage(plan.Image)" alt="">
                      </td>
                      <td class="text-right">{{ plan.Lat }}</td>
                      <td class="text-right">{{ plan.Lon }}</td>
                      <td class="text-right">{{ plan.PlanDate }}</td>
                      <td class="text-right">{{ plan.PlanExecutionDate }}</td>
                    </tr>
                    </tbody>
                  </table>
                  <br>
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
import {Common} from "../../mixins/common";
// Basic Use - Covers most scenarios
import {VueEditor} from "vue2-editor";
import {bus} from "../../app";

export default {
  name: "List",
  components: {
    Datepicker

  },
  mixins: [Common],
  data() {
    return {
      tour_plans: [],
      pagination: {
        current_page: 1
      },
      isMessage: false,
      from_date: '',
      to_date: '',
      query: "",
      editMode: false,
      isLoading: false,
      filename: 'tour-details-'+this.$route.params.ID+'-' + moment().format('yyyy-MM-DD')
    }
  },
  mounted() {
    document.title = 'Action Details | Tour Plan';
    this.getDetails('N');
  },
  methods: {
    getDetails(ex) {
      axios.post(baseurl + `api/monthly-plan-list/${this.$route.params.ID}`, {
        from_date: this.from_date,
        to_date: this.to_date,
        search: this.query,
        export: ex
      }).then((response) => {
        if (ex === 'Y') {
          let dataSets = response.data.tour_plans;
          if (dataSets.length > 0) {
            let columns = Object.keys(dataSets[0]);
            columns = columns.filter((item) => item !== 'row_num');
            let rex = /([A-Z])([A-Z])([a-z])|([a-z])([A-Z])/g;
            columns = columns.map((item) => {
              let title = item.replace(rex, '$1$4 $2$3$5')
              return {title, key: item}
            });
            console.log(dataSets,columns,this.filename)
            bus.$emit('data-table-import', dataSets, columns, this.filename)
          }
        } else {
          this.tour_plans = response.data.tour_plans;
        }
      }).catch((error) => {

      })
    },
    reload() {
      this.query = "";
      this.getDetails('N');
      this.$toaster.success('Data Successfully Refresh');
    },
    changeImage(event) {
      let file = event.target.files[0];
      let reader = new FileReader();
      reader.onload = event => {
        this.form.Image = event.target.result;
      };
      reader.readAsDataURL(file);
    },
    showImage() {
      let img = this.form.Image;
      if (img.length > 100) {
        return this.form.Image;
      } else {
        return window.location.origin + "/TourPlanFertilizer/uploads/" + this.form.Image;
      }
    },
    tableImage(image) {
      return window.location.origin + "/TourPlanFertilizer/uploads/" + image;
    },
    customFormatter(date) {
      return moment(date).format('YYYY-MM-DD');
    }

  },
}
</script>

<style scoped>
.side_note label {
  font-size: 11px !important;
  margin-bottom: 0;
}

.side_note .form-control {
  height: 25px !important;
}

.side_note .form-group {
  margin-bottom: 0;
}

.form-group label {
  font-size: 12px !important
}

.form-control {
  font-size: 12px !important;
}
</style>
