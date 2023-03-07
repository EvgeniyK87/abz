<template>

<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Create User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="token" class="form-label">One-time Token </label> 
            <a href="#" class="pull-right" v-on:click="loadToken">Generate new token</a>
            <input type="text" class="form-control text-truncate" id="token"  v-model="token">
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" v-model="name">
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" class="form-control" id="phone" placeholder="Enter phone" v-model="phone">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" v-model="email">
          </div>
          <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input class="form-control" type="file" id="photo" v-on:change="uploadPhoto">
          </div>
          <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <select class="form-select" id="position" v-model="position_id">
              <option selected disabled>Choose position</option>
              <option v-for="position in positions" v-bind:value="position.id" >{{ position.name }}</option>
            </select>
          </div>
        </form>
        <div id="result" class="alert alert-danger d-none" role="alert" >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" v-on:click="createUser" >Create user</button>
      </div>
    </div>
  </div>
</div>

</template>

<script>
    export default {
        data: function () {
            return {
                positions: [],
                token: "",
                name: "",
                phone: "",
                email: "",
                photo: "",
                position_id: ""
            }
        }, 

        mounted() {
            this.loadPositions();
            this.loadToken();
        },
        methods: {
            loadPositions: function () {
                axios.get('/api/positions')
                .then((response) => {
                    this.positions = response.data.positions;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadToken: function () {
              axios.get('/api/token')
                .then((response) => {
                    this.token = response.data.token;
                    console.log(this.token);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            uploadPhoto(event) {
              this.photo = event.target.files[0];;
            },
            createUser() {

              let request = new FormData();
              request.append('photo', this.photo);
              request.append('name', this.name);
              request.append('email', this.email);
              request.append('phone', this.phone);
              request.append('position_id', this.position_id);

              console.log(request);

                axios
                  .post('/api/users', 
                    request, 
                    {
                    headers: {
                      Authorization: "Bearer " + this.token,
                      "Content-Type": "multipart/form-data"
                    }
                  })
                  .then( (response) => {
                    this.success = 1;
                    this.message = response.message;
                     $("#result").removeClass("d-none").removeClass("alert-danger").addClass("alert-success").text( "ID #" + response.data.user_id + ' ' + response.data.message);
                  })
                  .catch(function (error) {

                    if (error.response) {
                        // Request made and server responded

                        $("#result").removeClass("d-none").removeClass("alert-success").text(error.response.data.message);

                        $.each(error.response.data.fails, function( field, message ) {
                          $("#result").append( "<div><b>"+ field +"</b>: "+ message +"</div>" )
                        });

                        console.log(error.response.data.message);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                      } else if (error.request) {
                        // The request was made but no response was received
                        console.log(error.request);
                      } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log('Error', error.message);
                      }
                });
              }
        }
    }
</script>