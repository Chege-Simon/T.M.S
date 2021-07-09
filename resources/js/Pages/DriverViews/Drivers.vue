<template>
    <!-- <app-layout v-bind:form="form" v-bind:data="data"> -->
        <!-- <template #header>
            <h2 class="h4 font-weight-bold">
                Trucks
            </h2>
        </template> -->
    <div>
    <div v-if="$page.props.flash.error" class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error! :</strong> {{ $page.props.flash.error }}.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    <div class="container">
        <div class="card">
            <div class="card-header row">
                <h3 class="card-title col-md-2">All Drivers</h3>
                <div class="col-md-5">
                    <input type="search" v-model="params.search" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <button class=" btn btn-success" @click="createModel">Register Driver</button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th @click="sort('name')">
                            <span>
                                Name
                                <svg v-if="params.field === 'name' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'name' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sort('phone_number')">
                            <span>
                                Phone Number
                                <svg v-if="params.field === 'phone_number' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'phone_number' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sort('truck_id')">
                            <span>
                                Assigned Truck
                                <svg v-if="params.field === 'truck_id' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'truck_id' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        
                        <th @click="sort('allowances')">
                            <span>
                                Allowances
                                <svg v-if="params.field === 'allowances' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'allowances' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody v-if="drivers">
                    <tr v-for="driver in drivers.data" :key="driver.id" >
                        <td>{{ driver.name }}</td>
                        <td>{{ driver.phone_number }}</td>
                        <td>{{ driver.truck.number_plate }}</td>
                        <td>Ksh {{ driver.allowances }}</td>
                        <td class="d-flex justify-content-center">
                            <span class="text-primary">
                                <i class="fa fa-wrench fa-fw mx-1" @click="editModal(driver)" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                            </span>
                            |
                            <span class="text-danger">
                                <i class="fa fa-trash fa-fw mx-1" @click="deleteModal(driver)" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
            <pagination class="mt-10" :links="drivers.links"/>
        </div>
    </div>
    <!-- create modal -->
    <div class="modal fade" id="create-model" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Register Driver</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Driver Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="addDriver" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" v-model="form.name" placeholder="Enter Name">
                                <div class="text-danger font-italic" v-if="errors.name">{{ errors.name }}</div>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">phone_number</label>
                                <input type="text" class="form-control" id="phone_number" v-model="form.phone_number" placeholder="Enter Phone Number">
                                <div class="text-danger font-italic" v-if="errors.phone_number">{{ errors.phone_number }}</div>
                            </div>
                            <div class="form-group">
                                <label for="truck_id">Truck</label>
                                <select class="form-control" id="truck_id" v-model="form.truck_id">
                                    <option v-for="truck in trucks" :key="truck.id" :value="truck.id">{{ truck.number_plate }}</option>
                                </select>
                                <div class="text-danger font-italic" v-if="errors.truck_id">{{ errors.truck_id }}</div>
                            </div>
                            <div class="form-group">
                                <label for="allowances">Allowances</label>
                                <input type="number" class="form-control" id="allowances" v-model="form.allowances" placeholder="Enter Allowances">
                                <div class="text-danger font-italic" v-if="errors.allowances">{{ errors.allowances }}</div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer form-group row">
                            <div class="col-sm-10 text-right">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-cog fa-fw"></i> Action</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      
    <!-- edit modal -->
    <div class="modal fade" id="edit-model" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Driver</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Driver Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="editDriver(editableDriver.id)" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="edit_name">Name</label>
                                <input type="text" class="form-control" id="edit_name" v-model="form.name" placeholder="Enter Name">
                                <div class="text-danger font-italic" v-if="errors.name">{{ errors.name }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_phone_number">phone_number</label>
                                <input type="text" class="form-control" id="edit_phone_number" v-model="form.phone_number" placeholder="Enter Phone Number">
                                <div class="text-danger font-italic" v-if="errors.phone_number">{{ errors.phone_number }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_truck_id">Truck</label>
                                <select class="form-control" id="edit_truck_id" v-model="form.truck_id">
                                    <option v-for="truck in trucks" :key="truck.id" :value="truck.id">{{ truck.number_plate }}</option>
                                </select>
                                <div class="text-danger font-italic" v-if="errors.truck_id">{{ errors.truck_id }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_allowances">Allowances</label>
                                <input type="number" class="form-control" id="edit_allowances" v-model="form.allowances" placeholder="Enter Allowances">
                                <div class="text-danger font-italic" v-if="errors.allowances">{{ errors.allowances }}</div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer form-group row">
                            <div class="col-sm-10 text-right">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-cog fa-fw"></i> Action</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    <!-- </app-layout> -->
    </div>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Pagination from '@/Jetstream/Pagination'

    export default {
        components: {
            AppLayout,
            Pagination,
        },layout: AppLayout,
        props:{
            drivers: Object,
            trucks: Object,
            errors:Object,
        },
        data() {
            return {
               params: {
                    search: null,
                    field: 'name',
                    direction: 'asc',
               },
               form: this.$inertia.form({
                    name: null,
                    phone_number: null,
                    truck_id: null,
                    allowances: null,
                }),
                editableDriver: null,
            }
        },
        methods: {
            deleteDriver(id){
                this.$inertia.delete('/drivers/'+id);
            },
            editDriver(id){
                this.$inertia.post('/drivers/'+id, this.form);
            },
            addDriver(){
                this.$inertia.post('/drivers', this.form);
            },
            fillEditForm(driver){
                this.form.name = driver.name;
                this.form.phone_number = driver.phone_number;
                this.form.truck_id = driver.truck_id;
                this.form.allowances = driver.allowances;
            },
            // formClear(){
            //       for(const key in this.form){
            //           this.form[key] = null;
            //       }  
            // },
            sort(field) {
                this.params.field = field;
                this.params.direction = this.params.direction === 'asc' ? 'desc' : 'asc';
            },
            //open modals functions here
            deleteModal(driver){
                // $('#delete-confirmation').modal('show')
                this.$swal.fire({
                    title: 'Delete: '+driver.name+'\nAre you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.deleteDriver(driver.id);
                    }
                })
            },
            editModal(driver){
                $('#edit-model').modal('show');
                this.editableDriver = driver;
                this.fillEditForm(driver);
            },
            createModel(){
                $('#create-model').modal('show');
            },
            //toast options functions
            errorToast(){
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: 'error',
                    title: "Oops... something went wrong!",
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', this.$swal.stopTimer)
                        toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                    }
                })
            },
            successToast(message){
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: message,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', this.$swal.stopTimer)
                        toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                    }
                })
            },
        },
        mounted(){
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
        },
        updated(){
            if(this.$page.props.flash.message){
                this.successToast(this.$page.props.flash.message);
                $('#create-model').modal('hide');
                $('#edit-model').modal('hide');
                this.form.reset();
                this.$page.props.flash.message = null;
            }else if(this.$page.props.flash.error){
                this.errorToast()
            }  
        },
        watch: {
            params: {
                handler() {
                    let params =  this.params;


                    Object.keys(params).forEach(key => {
                        if(params[key] == '') {
                            delete params[key];
                        }
                    });

                    this.$inertia.get(this.route('drivers.index'), params, {replace: true, preserveState: true});
                },
                deep: true,
            }
        }
    }
</script>


            