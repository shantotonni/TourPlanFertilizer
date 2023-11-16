<template>
    <div class="content">
        <div class="container-fluid">
            <breadcrumb :options="['Management Development Plan']"/>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="datatable" v-if="!isLoading">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <div class="row">
                                            <div class="col-md-2" v-if="personal===null">
                                                <input v-model="query" type="text" class="form-control" placeholder="Search">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-tools">
<!--                                      <router-link :to="{name: 'MDPCreate'}" class="btn btn-success btn-sm" style="color: white">-->
<!--                                        <i class="fas fa-plus"></i>-->
<!--                                        Add Management Development Plan-->
<!--                                      </router-link>-->
<!--                                        <button type="button" class="btn btn-primary btn-sm" @click="exportGenerator">-->
<!--                                            <i class="mdi mdi-database-export"></i>-->
<!--                                            Export-->
<!--                                        </button>-->
                                        <button type="button" class="btn btn-info btn-sm" @click="exportMDPList" v-if="personal===null">
                                            <i class="fas fa-sync"></i>
                                            Export
                                        </button>
                                      <button type="button" class="btn btn-primary btn-sm" @click="reload">
                                            <i class="fas fa-sync"></i>
                                            Reload
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline table-sm small">
                                        <thead>
                                          <tr>
                                              <th>SN</th>
                                              <th>Staff ID</th>
                                              <th>Employee Name</th>
                                              <th>Designation</th>
                                              <th>Department</th>
                                              <th>Official Email</th>
                                              <th>Mobile</th>
                                              <th>Appraisal Period</th>
                                              <th class="text-center">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr v-for="(mdp, i) in mdplist" :key="mdp.ID" v-if="mdplist.length">
                                              <th>{{ ++i }}</th>
                                              <td>{{ mdp.StaffID }}</td>
                                              <td>{{ mdp.EmployeeName }}</td>
                                              <td>{{ mdp.Designation }}</td>
                                              <td>{{ mdp.Department }}</td>
                                              <td>{{ mdp.OfficialEmail }}</td>
                                              <td>{{ mdp.Mobile }}</td>
                                              <td>{{ mdp.AppraisalPeriod }}</td>
                                              <td class="text-center">
<!--                                                <router-link :to="`mdp-edit/${mdp.ID}`" class="btn btn-info btn-sm"><i class="mdi mdi-square-edit-outline"></i> Edit</router-link>-->
                                                <router-link :to="`mdp-print/${mdp.ID}`" class="btn btn-info btn-sm"><i class="mdi mdi-printer"></i> MDP</router-link>
                                                <router-link :to="`mdp-print_two/${mdp.ID}`" class="btn btn-info btn-sm"><i class="mdi mdi-printer"></i> PTC</router-link>
                                                <button @click="destroy(mdp.ID)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                              </td>
                                          </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <pagination
                                        v-if="pagination.last_page > 1"
                                        :pagination="pagination"
                                        :offset="5"
                                        @paginate="query === '' ? getAllMDPList() : searchData()"
                                    ></pagination>
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
export default {
    name: "List",
  mixins: [Common],
    data() {
        return {
          mdplist: [],
          personal: {},
            pagination: {
                current_page: 1
            },
            isMessage : false,
            query: "",
            editMode: false,
            isLoading: false,
        }
    },
    watch: {
        query: function(newQ, old) {
            if (newQ === "") {
                this.getAllMDPList();
            } else {
                this.searchData();
            }
        }
    },
    mounted() {
        document.title = 'MDP List | MDP';
        this.getAllMDPList();
        this.getData();
    },
    methods: {
      getAllMDPList(){
            axios.get(baseurl + 'api/mdp/list?page='+ this.pagination.current_page).then((response)=>{
                this.mdplist = response.data.data;
                this.pagination = response.data.meta;
            }).catch((error)=>{

            })
        },
        searchData(){
            axios.get(baseurl + "api/search/mdp/list/" + this.query + "?page=" + this.pagination.current_page).then(response => {
                this.mdplist = response.data.data;
                this.pagination = response.data.meta;
            }).catch(e => {
                this.isLoading = false;
            });
        },
      getData() {
        this.axiosPost('me', {}, (response) => {
          this.$store.commit('me', response);
          this.personal = response.personal
        }, (error) => {
          this.errorNoti(error);
        });
      },
        reload(){
            this.getAllMDPList();
            this.query = "";
            // this.$toaster.success('Data Successfully Refresh');
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
        destroy(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(baseurl + 'api/mdp/delete/'+ id).then((response)=>{
                        this.getAllMDPList();
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    })
                }
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
