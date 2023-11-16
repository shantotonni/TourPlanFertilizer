<template>
      <div class="content">
        <div class="container-fluid">
          <div class="page-title-box">
            <div class="row align-items-center">
              <div class="col-sm-6">
                <h4 class="page-title">Dashboard</h4>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active">Welcome to Tour Plan Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-4 col-md-6">
              <div class="card mini-stat bg-primary text-white">
                <div class="card-body" style="padding: 10px">
                  <div class="mb-4">
                    <div class="float-left mini-stat-img mr-4"><img :src="`${mainOrigin}assets/images/services-icon/01.png`" alt=""/></div>
                    <h5 class="font-20 text-center text-uppercase mt-0 text-white-50">On Tour</h5>
                    <h4 class="font-60 text-center ">{{ allData.total_on_tour }} <i class="mdi mdi-arrow-up text-success ml-2"></i>
                    </h4> </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="card mini-stat bg-primary text-white">
                <div class="card-body" style="padding: 10px">
                  <div class="mb-4">
                    <div class="float-left mini-stat-img mr-4"><img :src="`${mainOrigin}assets/images/services-icon/02.png`" alt=""/></div>
                    <h5 class="font-20 text-center text-uppercase mt-0 text-white-50">Tour Activity</h5>
                    <h4 class="font-60 text-center ">{{ allData.total_tour_activity }} <i class="mdi mdi-arrow-up text-success ml-2"></i>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="card mini-stat bg-primary text-white">
                <div class="card-body" style="padding: 10px">
                  <div class="mb-4">
                    <div class="float-left mini-stat-img mr-4"><img :src="`${mainOrigin}assets/images/services-icon/03.png`" alt=""/></div>
                    <h5 class="font-20 text-center text-uppercase mt-0 text-white-50">Tour Complete</h5>
                    <h4 class="font-60 text-center ">{{ allData.total_activity_complete }} <i class="mdi mdi-arrow-up text-success ml-2"></i>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="card mini-stat bg-primary text-white">
                <div class="card-body" style="padding: 10px">
                  <div class="mb-4">
                    <div class="float-left mini-stat-img mr-4"><img :src="`${mainOrigin}assets/images/services-icon/04.png`" alt=""/></div>
                    <h5 class="font-20 text-center text-uppercase mt-0 text-white-50">Channel Visit</h5>
                    <h4 class="font-60 text-center ">{{ allData.total_channel_visit }} <i class="mdi mdi-arrow-up text-success ml-2"></i>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="card mini-stat bg-primary text-white">
                <div class="card-body" style="padding: 10px">
                  <div class="mb-4">
                    <div class="float-left mini-stat-img mr-4"><img :src="`${mainOrigin}assets/images/services-icon/04.png`" alt=""/></div>
                    <h5 class="font-20 text-center text-uppercase mt-0 text-white-50">Farmer Visit</h5>
                    <h4 class="font-60 text-center ">{{ allData.total_farmer_visit }} <i class="mdi mdi-arrow-up text-success ml-2"></i>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-6">
              <div class="card mini-stat bg-primary text-white">
                <div class="card-body" style="padding: 10px">
                  <div class="mb-4">
                    <div class="float-left mini-stat-img mr-4"><img :src="`${mainOrigin}assets/images/services-icon/04.png`" alt=""/></div>
                    <h5 class="font-20 text-center text-uppercase mt-0 text-white-50">Strategic Visit</h5>
                    <h4 class="font-60 text-center ">{{ allData.total_strategic_visit }} <i class="mdi mdi-arrow-up text-success ml-2"></i>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</template>
<script>

import {baseurl} from "../../base_url";

export default {
  name: "Dashboard",
  data() {
    return {
      allData: [],
      labels:[],
      datasets:[
        {
          data: [],
          backgroundColor: "rgba(38, 198, 218, 1)",
          hoverBackgroundColor: "#7E57C2",
          hoverBorderWidth: 0,
        }],
      isLoading : false
    }
  },
  mounted() {
    document.title = 'Dashboard | Tour Plan';
    this.getAllDashboardData();
  },
  methods: {
    getAllDashboardData(){
      axios.get(baseurl + 'api/get-all-dashboard-data'
      ).then((response) => {
        this.allData = response.data.data;
        this.datasets[0].data = response.data.data.value;
        this.isLoading = true;
      }).catch((error)=>{

      })
    },
  }
}
</script>
