<template>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>User <b>Management</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>					
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Created</th>						
                        <th>E-mail</th>
                        <th>ID-Position</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <td>{{ user.id }}</td>
                        <td><a href="#"  data-bs-toggle="modal" data-bs-target="#showModal" v-on:click="showUser(user.id)"><img v-bind:src=" user.photo ? user.photo : '/avatars/no-avatar.jpg'" class="avatar" alt="Avatar"> {{ user.name }}</a></td>
                        <td>{{ new Date(user.registration_timestamp * 1000).toISOString().slice(0, 10) }}</td>
                        <td>{{ user.email }}</td>                        
                        <td>{{ user.position_id }}-{{ user.position }}</td>
                        <td>{{ user.phone }}</td>
                        <td>
                            <a href="#" class="settings" title="Settings" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>
                            <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="clearfix">
                <div class="hint-text">Showing <b>{{ count }}</b> out of <b>{{ total_users }}</b> entries</div>
                <ul class="pagination">
                    <li class="page-item"  v-bind:class="{'disabled': links.prev_url === null}" ><a v-bind:href="links['prev_url'] ? '?page=' + (current_page-1) : '#' " >Previous</a></li>
                    <li class="page-item" v-for="page in parseInt(total_pages)" :key="page"  v-bind:class="{'active': page == current_page}" >
                        <a v-bind:href="'?page='+ page" class="page-link"> {{ page }}</a>
                    </li>
                    <li class="page-item" v-bind:class="{'disabled': links.next_url === null}" ><a v-bind:href="links['next_url'] ? '?page=' + (current_page+1) : '#' " class="page-link">Next</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>     

   <!-- Modal -->
   <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showModalLabel">User info #ID {{ user.id }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container d-flex justify-content-center">
              <div class="card mt-5 px-4 pt-4 pb-2">
                  <div class="media p-2"> <img v-bind:src=" user.photo ? user.photo : '/avatars/' + 'no-avatar.jpg'" class="mr-1 align-self-start">
                      <div class="media-body">
                          <div class="d-flex flex-row justify-content-between">
                              <h6 class="mt-2 mb-0">{{ user.name }}</h6>
                          </div>
                          <p class="text-muted">{{ user.registration_timestamp ? new Date(user.registration_timestamp * 1000).toISOString().slice(0, 10) : ''  }}</p>
                      </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                           <p class="mb-0">Position</p>
                        </div>
                        <div class="col-sm-12">
                           <p class="text-muted mb-0">{{ user.position }}</p>
                        </div>
                     </div>
                     <hr>
                      <div class="row">
                         <div class="col-sm-8">
                            <p class="mb-0">Email</p>
                         </div>
                         <div class="col-sm-12">
                            <p class="text-muted mb-0">{{ user.email }}</p>
                         </div>
                      </div>
                      <hr>
                      <div class="row">
                         <div class="col-sm-8">
                            <p class="mb-0">Phone</p>
                         </div>
                         <div class="col-sm-12">
                            <p class="text-muted mb-0">{{ user.phone }}</p>
                         </div>
                      </div>
                   </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
    export default {
        data: function () {
            return {
                users: [],
                user: [],
                current_page: 0,
                total_pages: 0,
                total_users: 0,
                count: 6,
                links: []
            }
        }, 

        mounted() {
            this.loadUsers();
        },

        methods: {
            showUser: function (id) {
                console.log(id);
                axios.get('/api/users/'+ id)
                .then((response) => {
                    this.user = response.data.user;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadUsers: function () {
                let uri = window.location.search.substring(1); 
                let params = new URLSearchParams(uri);

                axios.get('/api/users',{
                params: {
                    'page': params.get("page"),
                    'count': params.get("count")
                }
            } )
                .then((response) => {
                    this.users = response.data.users;
                    this.current_page = response.data.page;
                    this.total_pages = response.data.total_pages;
                    this.total_users = response.data.total_users;
                    this.count = response.data.count;
                    this.links = response.data.links;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>