<template>
  <div class="content">
    <div class="container-fluid">
      <breadcrumb :options="['Profile']">
      </breadcrumb>
      <!-- end row -->
        <div class="col-12 col-md-12">
          <div class="card">
            <div class="card-body">
              <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile" role="tab"
                                        aria-selected="false"><span class="d-block d-sm-none"><i
                    class="far fa-user"></i></span> <span class="d-none d-sm-block">Change Password</span></a></li>
              </ul><!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane p-3" id="profile" role="tabpanel">
                  <ValidationObserver v-slot="{ handleSubmit }">
                    <form class="form-horizontal" @submit.prevent="handleSubmit(onSubmit2)">
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <ValidationProvider name="Old Password" mode="eager" rules="required" v-slot="{ errors }">
                            <div class="form-group">
                              <label for="old-pass">Old Password</label>
                              <input type="password" class="form-control" :class="{'error-border': errors[0]}"
                                     id="old-pass"
                                     v-model="oldPass" name="old-pass" placeholder="Old Password">
                              <span class="error-message"> {{ errors[0] }}</span>
                            </div>
                          </ValidationProvider>
                        </div>
                        <div class="col-12 col-md-6">
                          <ValidationProvider name="Password" mode="eager" vid="password" rules="required|min:6"
                                              v-slot="{ errors }">
                            <div class="form-group">
                              <label for="password">Password</label>
                              <input type="password" class="form-control" :class="{'error-border': errors[0]}"
                                     id="password"
                                     v-model="newPass" name="new-pass" placeholder="Password">
                              <span class="error-message"> {{ errors[0] }}</span>
                            </div>
                          </ValidationProvider>
                        </div>
                        <div class="col-12 col-md-6">
                          <ValidationProvider name="Confirm  Password" mode="eager"
                                              rules="required|confirmed:password"
                                              v-slot="{ errors }">
                            <div class="form-group">
                              <label for="re-enter">Confirm Password</label>
                              <input type="password" class="form-control" :class="{'error-border': errors[0]}"
                                     id="re-enter"
                                     v-model="checkPass" name="re-enter" placeholder="Confirm Password">
                              <span class="error-message"> {{ errors[0] }}</span>
                            </div>
                          </ValidationProvider>
                        </div>
                      </div>
                      <submit-form style="float:left" name="Save"/>
                    </form>
                  </ValidationObserver>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- container-fluid -->
</template>
<script>
import {Common} from "../../mixins/common";
import imageCompressor from 'vue-image-compressor';

const Compress = require('compress.js')
export default {
  components: {imageCompressor},
  mixins: [Common],
  data() {
    return {
      profile: {},
      oldPass: '',
      newPass: '',
      checkPass: '',
      isLoading: true
    }
  },
  created() {
    this.getData();
  },
  methods: {
    onSubmit2() {
      this.$store.commit('submitButtonLoadingStatus', true);
      this.axiosPost('change-password', {
        oldPass: this.oldPass,
        newPass: this.newPass,
      }, (response) => {
        this.successNoti(response.message);
        this.logout();
        this.$store.commit('submitButtonLoadingStatus', false);
      }, (error) => {
        this.errorNoti(error);
        this.$store.commit('submitButtonLoadingStatus', false);
      })
    },
    logout() {
      this.axiosPost("logout", {}, (response) => {
            localStorage.setItem("token", "");
            this.$router.push(this.mainOrigin + "login");
            this.successNoti(response.message)
          },
          (error) => {
            this.errorNoti(error);
          }
      );

    },
    onSubmit() {
      this.$store.commit('submitButtonLoadingStatus', true);
      this.axiosPost('change-profile', {
        email: this.email,
        name: this.name,
        mobile: this.mobile,
        image: this.image,
        isImageChange: this.isImageChange,
      }, (response) => {
        this.successNoti(response.message);
        this.getData();
        this.$store.commit('submitButtonLoadingStatus', false);
      }, (error) => {
        this.errorNoti(error);
        this.$store.commit('submitButtonLoadingStatus', false);
      })
    },
    async attachment(event) {
      const compressor = new window.Compress();
      const files = [...event.target.files];
      if (event.target.files && event.target.files[0]) {
        this.uploadText = event.target.files[0].name;
        const results = await compressor.compress(files, {
          size: 4,
          quality: 0.80,
        });
        const output = results[0];
        this.image = output.prefix + output.data
        this.isImageChange = true;
      }
    },
    getData() {
      this.axiosPost('me', {}, (response) => {
        console.log(response)
        this.profile = response;
        this.name = this.profile.UserName;
        this.email = this.profile.Email;
        this.mobile = this.profile.Phone;
        this.image = `${this.mainOrigin}uploads/${this.profile.Avatar}`;
        this.isImageChange = false;
        this.isLoading = false;
      }, (error) => {
        this.errorNoti(error);
      });
    }
  }
}
</script>
