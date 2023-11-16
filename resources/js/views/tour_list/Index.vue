<template>
  <div class="content">
    <div class="container-fluid">
      <breadcrumb :options="['Monthly Tour Plan ']"/>
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="datatable" v-if="!isLoading">
              <div class="card-body">
                <div class="d-flex">
                  <div class="flex-grow-1">
                    <div class="row">

                    </div>
                  </div>
                  <div class="card-tools">
                    <button type="button" class="btn btn-info btn-sm" @click="getAllMonthlyPlanList('Y')">
                      <i class="mdi mdi-file-excel"></i>
                      Export
                    </button>
                  </div>
                </div>
                <div class="table-responsive">
                  <table
                      class="table table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline table-sm small">
                    <thead style = 'color:black'>
                    <tr style = 'background-color :skyblue'>
                      <th>SN</th>
                      <th>Name</th>
                      <th>Tour Complete</th>
                      <th>Activity Complete</th>
                      <th>Channel Visit</th>
                      <th>Farmer Visit</th>
                      <th>Strategic</th>
                      <th >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(plan, i) in tour_plans" :key="plan.ID" v-if="tour_plans.length">
                      <th class="text-center">{{ ++i }}</th>
                      <td>{{ plan.UserName }}</td>
                      <td>{{plan.TourComplete  }}</td>
                      <td class="text-right">{{ plan.Percentage }}%</td>
                      <td class="text-right">{{ plan.ChanelVisit }}</td>
                      <td class="text-right">{{ plan.FarmerVisit }}</td>
                      <td class="text-right">{{ plan.StrategicVisit }}</td>
                      <td class="text-center">
                        <router-link :to="`monthly-plan-list/${plan.UserId}`" class="btn btn-info btn-sm"><i
                            class="mdi mdi-square-show-outline"></i> Show
                        </router-link>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                  <br>

                </div>
              </div>
            </div>
            <div v-else>
              <skeleton-loader :row="14"/>
            </div>
            <data-export/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {baseurl} from '../../base_url'
import {Common} from "../../mixins/common";
import {bus} from "../../app";
import moment from "moment/moment";

export default {
  name: "List",
  mixins: [Common],
  data() {
    return {
      tour_plans: [],
      pagination: {
        current_page: 1
      },
      isMessage: false,
      query: '',
      editMode: false,
      isLoading: false,
      filename: 'tour-details-' + moment().format('yyyy-MM-DD')
    }
  },
  watch: {
    query: function (newQ, old) {
      if (newQ === "") {
        this.getAllMonthlyPlanList('N');
      } else {
        this.searchData();
      }
    }
  },
  mounted() {
    document.title = 'Monthly Plan List | Tour Plan';
    this.getAllMonthlyPlanList('N');
  },
  methods: {
    getAllMonthlyPlanList(ex) {
      axios.get(baseurl + 'api/monthly-plan-list?page='+ this.pagination.current_page
          + "&query=" + this.query
      ).then((response) => {
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
    searchData(){
      axios.get("/api/search/monthly-plan-list/" + this.query ).then(response => {
        this.tour_plans = response.data.data;
      }).catch(e => {
        this.isLoading = false;
      });
    },
    reload() {
      this.query = "";
      this.getAllMonthlyPlanList('N');
    },

    exportMDPList(){
      axios.get(baseurl + 'api/export-mdp-list')
          .then((response)=>{
            let dataSets = response.data.data;
            if (dataSets.length > 0) {
              let columns = Object.keys(dataSets[0]);
              columns = columns.filter((item) => item !== 'row_num');
              let rex = /([A-Z])([A-Z])([a-z])|([a-z])([A-Z])/g;
              columns = columns.map((item) => {
                let title = item.replace(rex, '$1$4 $2$3$5')
                return {title, key: item}
              });
              bus.$emit('data-table-import', dataSets, columns, 'MDP Export')
            }
          }).catch((error)=>{
        console.log(error)
      })
    },

  },
}
</script>

<style lang="scss" scoped>
.document-upload-modal {
  .delete {
    color: red;
    position: absolute;
    right: 25px;
    display: none;
    top: 10px;
  }

  .title:hover .delete {
    display: block
  }
}
</style>
