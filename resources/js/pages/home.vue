<template>
  <div>
    <div class="row">
      <div class="col-md-9">
          <strong>
            My Projects
          </strong>
      </div>

      <div class="col-md-3">
        <button class="button-success" data-toggle="modal" data-target="#exampleModal">
          Create Application
        </button>
      </div>
    </div>

    <hr>
    <div class="mt-3 row">
      <div v-for="application in applications" class="col-md-3 mt-5">
          <card :title="application.application_name">
            <div class="text-center p-3 text-white bg-dark" >
              <router-link :to="{ name: 'cameras',params: {id:application.id}}">
                <fa icon="arrow-right" fixed-width size="3x" />
              </router-link>
            </div>

            <div class="card-footer row">
              <div class="col-md-8">
                <button class="btn btn-warning" @click="updateApplication(application.id,application.application_name)">
                  <fa icon="edit" fixed-width />
                </button>
              </div>
              <div class="col-md-4">
                <button class="btn btn-danger" @click="deleteApplication(application.id)">
                  <fa icon="trash-alt" fixed-width />
                </button>
              </div>
            </div>
          </card>
      </div>


      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{inputAppTitle}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div>
                <div class="form-group">
                  <label for="application_name">Application name </label>
                  <input type="text" class="form-control" :class="inputAppTitle ? 'is-valid':'is-invalid'" v-model="inputAppTitle" id="application_name" aria-describedby="emailHelp" placeholder="Enter Application Name">
                  <div v-if="!inputAppTitle" class="invalid-feedback">
                    Please choose an application title.
                  </div>
                  <div v-else class="valid-feedback">
                      Looks good!
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" @click="createApplication()" data-dismiss="modal" :disabled="!inputAppTitle">Create</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</template>

<script>
import axios from 'axios'
import {db} from '../store/db.js'
import Swal from 'sweetalert2'



export default {
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('home') }
  },
  data(){
    return {
      inputAppTitle:'',
      applications:[],
      cameras:[]
    }
  },

  methods:{
    isThereCameras: async function(id){
      const {data}  = await axios.get(`${db.API_ENDPOINT}/application/${id}/cameras`);
      return data.length;
    },
    updateForm: function(id){
      alert(id);
    },
    fetchApplication: async function (){
      const { data } = await axios.get(`${db.API_ENDPOINT}/application`)
      this.applications = data;
    },
    createApplication: async function () {
      if(this.inputAppTitle == null || this.inputAppTitle === ''){
        return Swal.fire(
          'Application name missing',
          'Fill the input',
          'error'
        )
      }else{
        const data = await axios.post(`${db.API_ENDPOINT}/application/`,{
          title:this.inputAppTitle
        });
        if(data.status === 200){
          await this.fetchApplication();
          return Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Application created!',
            showConfirmButton: false,
            timer: 1500
          })
        }
      }
    },
    deleteApplication: async function (id){
      let data = await axios.delete(`${db.API_ENDPOINT}/application/${id}`);
      await Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          if(data.status === 200) {
            this.applications = this.applications.filter((item) => {
              return item.id !== id
            });
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Application deleted',
              showConfirmButton: false,
              timer: 1500
            })
          }else{
            Swal.fire(
              'Something went wrong!',
              'Your application has not been deleted.',
              'error'
            )
          }
        }
      });
    },
    updateApplication: async function (id,title){
      Swal.fire({
        title: `Update Application: ${title}`,
        input: 'text',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Update',
        showLoaderOnConfirm: true,
        preConfirm: (newTitle) => {
          return axios.post(`${db.API_ENDPOINT}/application/${id}`,{
            title:newTitle,
            _method:'PUT'
          })
            .then(response => {
              if (!response.ok) {
                Swal.fire(
                  'Something went wrong!',
                  'Your application has not been updated.',
                  'error'
                )
              }
              this.fetchApplication();
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Application updated',
                showConfirmButton: false,
                timer: 1500
              })
            })
            .catch(error => {
              Swal.showValidationMessage(
                `Request failed: ${error}`
              )
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        if (result.isConfirmed) {
          this.fetchApplication();
        }
      })
    }
  },
  mounted () {
    this.fetchApplication()
  }


}
</script>

<style scoped>
.button-success{
  margin: 0px;
  padding: 0px 18px;
  border-radius: 17px;
  background-color: rgb(96, 217, 86);
  color: rgb(255, 255, 255);
  fill: rgb(255, 255, 255);
  height: 34px;
  display: inline-block;
  box-shadow: rgba(34, 45, 57, 0.02) 1px 0px 0px inset, rgba(34, 45, 57, 0.02) -1px 0px 0px inset, rgba(34, 45, 57, 0.02) 0px 1px 0px inset, rgba(34, 45, 57, 0.03) 0px -1px 0px inset, rgba(34, 45, 57, 0.02) 0px 0px 0px 1px inset, rgba(25, 64, 22, 0.1) 0px 1px 2px 0px;
  text-shadow: rgba(12, 16, 20, 0.05) 0px 1px 0px;
  font-size: 14px;
  line-height: 34px;
  font-weight: 500;
  appearance: none;
  border: none;
  box-sizing: border-box;
  cursor: pointer;
  outline-style: none;
  text-align: center;
  text-decoration: none;
  user-select: none;
  white-space: nowrap;
  transition: all 300ms cubic-bezier(0.23, 1, 0.32, 1) 0s;
  will-change: transform;
  font-family: Graphik, -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol" !important;
}

.button-success:hover{
  background-color: rgb(68, 197, 83);
  box-shadow: rgba(34, 45, 57, 0.02) 1px 0px 0px inset, rgba(34, 45, 57, 0.02) -1px 0px 0px inset, rgba(34, 45, 57, 0.02) 0px 1px 0px inset, rgba(34, 45, 57, 0.03) 0px -1px 0px inset, rgba(34, 45, 57, 0.02) 0px 0px 0px 1px inset, rgba(25, 64, 22, 0.1) 0px 2px 4px 0px;
  transform: translate3d(0px, -1px, 0px);
}

</style>
