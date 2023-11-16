<template>
  <div>
    <div class="wrapper-page">
      <div class="card overflow-hidden account-card mx-3">
        <div class="bg-primary p-4 text-white text-center position-relative">
          <h4 class="font-20 m-b-5">Tour Plan For Fertilizer</h4>
          <p class="text-white-50 mb-4">Login Panel.</p>
        </div>
        <div class="account-card-content">
          <ValidationObserver v-slot="{ handleSubmit }">
            <form class="form-horizontal m-t-30" @submit.prevent="handleSubmit(onSubmit)">
              <ValidationProvider name="User ID" mode="eager" rules="required" v-slot="{ errors }">
                <div class="form-group">
                  <label for="EmpCode">Staff ID</label>
                  <input type="text" class="form-control" :class="{'error-border': errors[0]}" id="UserID"
                         v-model="UserID" name="id" placeholder="UserID" autocomplete="off">
                  <span class="error-message"> {{ errors[0] }}</span>
                </div>
              </ValidationProvider>
              <ValidationProvider name="Password" mode="eager" rules="required|min:4" v-slot="{ errors }">
                <div class="form-group">
                  <label for="Password">Password</label>
                  <input type="password" v-model="Password" class="form-control" :class="{'error-border': errors[0]}"
                         id="Password" placeholder="Password" autocomplete>
                  <span class="error-message">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>
              <submit-form name="Log In"/>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {Common} from '../../mixins/common'
import moment from "moment";

export default {
  mixins: [Common],
  data() {
    return {
      UserID: '',
      Password: '',
    }
  },
  computed: {
    now() {
      return moment()
    }
  },
  methods: {
    onSubmit() {
      this.$store.commit('submitButtonLoadingStatus', true);
      this.axiosPostWithoutToken('admin-login', {
        UserID: this.UserID,
        Password: this.Password
      }, (response) => {
        console.log(response)
        localStorage.setItem("token", response.access_token);
        this.successNoti('Successfully logged in.');
        this.$store.commit('submitButtonLoadingStatus', false);
        this.redirect(this.mainOrigin + 'dashboard')
      }, (error) => {
        this.errorNoti(error);
        this.$store.commit('submitButtonLoadingStatus', false);
      })
    }
  }
}
</script>
