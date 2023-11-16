<template>
    <div class="content" id="mdp">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="datatable" v-if="!isLoading">
                            <div class="card-body">
                              <div>
                                <img :src="`${mainOrigin}logo/logo.png`" style="height: 60px;" alt="user" class="rounded-circle" />
                                <p style="font-size:15px">Advanced Chemical Industries Limited</p>
                              </div>
                              <div class="first_part">
                                <h3 style="text-align:center">Management Development Plan</h3>
                                <hr>
                                <br>
                                <p style="font-size: 20px">
<!--                                  Appraisal Period <span style="display: inline-block;border-bottom: 1px solid;width: 200px;text-align: center">{{ mdplist.AppraisalPeriod }}</span>-->
                                  Training Period From July <span style="display: inline-block;border-bottom: 1px solid;width: 315px;text-align: center">{{ mdplist.from_period }}</span>
                                  to June <span style="display: inline-block;border-bottom: 1px solid;width: 315px;text-align: center">{{ mdplist.to_period }}</span>
                                </p>
                                <p style="font-size: 20px">
                                  Staff Id <span style="display: inline-block;border-bottom: 1px solid;width: 290px;text-align: center">{{ mdplist.StaffID }}</span>
                                  Name of employee <span style="display: inline-block;border-bottom: 1px solid;width: 390px;text-align: center">{{ mdplist.EmployeeName }}</span>
                                </p>
                                <p style="font-size: 20px">
                                  Designation <span style="display: inline-block;border-bottom: 1px solid;width: 400px;text-align: center">{{ mdplist.Designation }}</span>
                                  Date of birth <span style="display: inline-block;border-bottom: 1px solid;width: 306px;text-align: center">{{ mdplist.DateOfBirth }}</span>
                                </p>
                                <p style="font-size: 20px">
                                  Present Age <span style="display: inline-block;border-bottom: 1px solid;width: 350px;text-align: center">{{ mdplist.Age }}</span>
                                  Date of joining company <span style="display: inline-block;border-bottom: 1px solid;width: 250px;text-align: center">{{ mdplist.JoiningDate }}</span>
                                </p>
                                <p style="font-size: 20px">
                                  Present Job Started <span style="display: inline-block;border-bottom: 1px solid;width: 370px;text-align: center">{{ mdplist.PresentJobStartedOn }}</span>
                                  Qualification <span style="display: inline-block;border-bottom: 1px solid;width: 265px;text-align: center">{{ mdplist.Qualification }}</span>
                                </p>
                              </div>
                              <br>
                              <div class="second_part">
                                <p style="font-weight: bold;font-size: 20px">A. To improve the performance of your present job, list below the areas where you feel that you require additional knowledge or better understanding.</p>
                                <p style="font-size: 20px">Which you will acquire at your personal initiative:</p>

                                <p v-for="(number, i) in row_number" :key="i" style="font-size: 20px">
                                 <span style="display: inline-block;border-bottom: 1px solid;width: 940px;">{{ initiative[i] !== undefined ? initiative[i].Name: '' }}</span>
                                </p>
<!--                              <div v-else>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center" ></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center" ></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center" ></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center" ></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center" ></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center" ></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 700px;text-align: center"></span>-->
<!--                                </p>-->
<!--                              </div>-->
                              </div>
                              <br>
                              <br>
                              <div class="third_part">
                                <p style="font-size: 20px">Which will require in-house or external training that you think should be organized by the Company:</p>
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>-->
<!--                                </p>-->
                                <p v-for="(number, i) in row_number" :key="i" style="font-size: 20px">
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;">{{ training[i] !== undefined ? training[i].TrainingTitle: '' }}</span>
                                </p>
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>-->
<!--                                </p>-->
<!--                                <p>-->
<!--                                  <span style="display: inline-block;border-bottom: 1px solid;width: 700px;text-align: center"></span>-->
<!--                                </p>-->
                              </div>

                              <p>Form No.: TR-003-01/06</p>


<!--                              <div class="third_part">-->
<!--                                <h4 style="font-width: bold;">Training & Development Policy</h4>-->
<!--                                <p>-->
<!--                                  Issued by: Ms. Sheema Abed Rahman, GM, CS-->
<!--                                  <br>-->
<!--                                 <span style="text-align: center;margin-left: 80px"> 30 June 2005</span>-->
<!--                                </p>-->
<!--                              </div>-->
                              <br>
                              <br>
                              <div class="fourth_part">
                                <p style="font-weight: bold;font-size: 20px">B. For development to take future responsibilities</p>
                                <p style="font-size: 18px">Other than those mentioned in A, list below two areas of personal development/training that you would like
                                  to see happen in your case in the coming years and explain how those trainings will help the company.</p>

<!--                                1. <p v-for="(number, i) in row_number" :key="i" v-if="Area.length">-->
<!--                                 <span style="display: inline-block;border-bottom: 1px solid;width: 940px;">{{ Area[i] !== undefined ? Area[i].AreaOneName: '' }}</span>-->
<!--                                </p>-->
                                1. <p style="font-size: 20px">
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;">{{ mdplist.AreaOne }}</span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 700px;text-align: center"></span>
                                </p>
                              </div>
                              <br>
                              <div class="fifth_part">
<!--                                <p>-->
<!--                                  2. <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>-->
<!--                                </p>-->
<!--                                2. <p v-for="(number, i) in row_number" :key="i" v-if="Area.length">-->
<!--                                <span style="display: inline-block;border-bottom: 1px solid;width: 940px;">{{ Area[i] !== undefined ? Area[i].AreaTwoName: '' }}</span>-->
<!--                              </p>-->
                                2.<p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;font-size: 20px">{{ mdplist.AreaTwo }}</span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 700px;text-align: center"></span>
                                </p>
                              </div>
                              <br>
                              <div class="six_part">
                                <p style="font-size: 20px">
                                  Signature of employee <span style="display: inline-block;border-bottom: 1px solid;width: 300px;text-align: center"></span>
                                </p>
                                <p style="font-size: 20px">
                                  Date <span style="display: inline-block;border-bottom: 1px solid;width: 400px;text-align: center"></span>
                                </p>
                              </div>
                              <br>
                              <div class="fourth_part">
                                <p style="font-size: 20px">Remarks and recommendations of superior</p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 940px;text-align: center"></span>
                                </p>
                                <p>
                                  <span style="display: inline-block;border-bottom: 1px solid;width: 400px;text-align: center"></span>
                                </p>
                              </div>
                              <br>
                              <div class="six_part">
                                <p style="font-size: 20px">
                                  Signature <span style="display: inline-block;border-bottom: 1px solid;width: 300px;text-align: center"></span>
                                </p>
                                <p style="font-size: 20px">
                                  Date <span style="display: inline-block;border-bottom: 1px solid;width: 400px;text-align: center"></span>
                                </p>
                              </div>
<!--                              <div class="third_part">-->
<!--                                <h4 style="font-width: bold;">Training & Development Policy</h4>-->
<!--                                <p>-->
<!--                                  Issued by: Ms. Sheema Abed Rahman, GM, CS-->
<!--                                  <br>-->
<!--                                  <span style="text-align: center;margin-left: 80px"> 30 June 2005</span>-->
<!--                                </p>-->
<!--                              </div>-->
                              <p style="padding-top: 70px">Form No.: TR-003-01/06</p>
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
export default {
    name: "List",
    data() {
        return {
          mdplist: [],
          initiative: [],
          training: [],
          Area: [],
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
          row_number: [
            {number: 0},
            {number: 1},
            {number: 2},
            {number: 3},
            {number: 4},
            {number: 5},
            {number: 6},
          ],
        }
    },
  created() {
    axios.get(baseurl + `api/mdp/print/${this.$route.params.ID}`).then((response)=>{
      console.log(response.data.data)
      this.mdplist = response.data.data
      this.initiative = response.data.data.initiative
      this.training = response.data.data.training
      this.Area = response.data.data.area
      // setTimeout(function(){
      //   window.print()
      // },1000)
      $('#mdp').printThis({
        importCSS: true,
        loadCSS: "path/to/new/CSS/file",
      });

    });
  },

    methods: {
      //
    },
}
</script>
<style scoped>

</style>

