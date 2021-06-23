<template>
    <!-- <app-layout v-bind:form="form" v-bind:data="data"> -->
        <!-- <template #header>
            <h2 class="h4 font-weight-bold">
                Trucks
            </h2>
        </template> -->
    <div v-if="$page.props.flash.error" class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ $page.props.flash.error }}.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    <div class="container">
        <div class="card">
            <div class="card-header row">
                <h3 class="card-title col-md-2">All Trucks</h3>
                <div class="col-md-5">
                    <input type="search" v-model="params.search" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <button class=" btn btn-success" @click="createModel">Register Truck</button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th @click="sort('number_plate')">
                            <span>
                                Number Plate
                                <svg v-if="params.field === 'number_plate' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'number_plate' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sort('manufacturer')">
                            <span>
                                Manufacturer
                                <svg v-if="params.field === 'manufacturer' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'manufacturer' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sort('model')">
                            <span>
                                Model
                                <svg v-if="params.field === 'model' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'model' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th>Color</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody v-if="trucks">
                    <tr v-for="truck in trucks.data" :key="truck.id" >
                        <td>{{ truck.number_plate }}</td>
                        <td>{{ truck.manufacturer }}</td>
                        <td>{{ truck.model }}</td>
                        <td>{{ truck.color }}</td>
                        <td class="d-flex justify-content-center">
                            <span class="text-primary">
                                <i class="fa fa-wrench fa-fw mx-1" @click="editModal(truck)" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                            </span>
                            |
                            <span class="text-danger">
                                <i class="fa fa-trash fa-fw mx-1" @click="deleteModal(truck)" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
            <pagination class="mt-10" :links="trucks.links"/>
        </div>
    </div>
    <!-- create modal -->
    <div class="modal fade" id="create-model" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Register Truck</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Truck Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="addTruck" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="number_plate">Number Plate</label>
                                <input type="text" class="form-control" id="number_plate" v-model="form.number_plate" placeholder="Enter Number plate">
                                <div class="text-danger font-italic" v-if="errors.number_plate">{{ errors.number_plate }}</div>
                            </div>
                            <div class="form-group">
                                <label for="manufacturer">Manufacturer</label>
                                <input type="text" class="form-control" id="manufacturer" v-model="form.manufacturer" placeholder="Enter Manufacturer">
                                <div class="text-danger font-italic" v-if="errors.manufacturer">{{ errors.manufacturer }}</div>
                            </div>
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" id="model" v-model="form.model" placeholder="Enter Model">
                                <div class="text-danger font-italic" v-if="errors.model">{{ errors.model }}</div>
                            </div>
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" id="color" v-model="form.color" placeholder="Enter Color">
                                <div class="text-danger font-italic" v-if="errors.color">{{ errors.color }}</div>
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
              <h4 class="modal-title">Edit Truck</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Truck Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="editTruck(editableTruck.id)" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="number_plate">Number Plate</label>
                                <input type="text" class="form-control" id="number_plate" v-model="form.number_plate" placeholder="Enter Number plate">
                                <div class="text-danger font-italic" v-if="errors.number_plate">{{ errors.number_plate }}</div>
                            </div>
                            <div class="form-group">
                                <label for="manufacturer">Manufacturer</label>
                                <input type="text" class="form-control" id="manufacturer" v-model="form.manufacturer" placeholder="Enter Manufacturer">
                                <div class="text-danger font-italic" v-if="errors.manufacturer">{{ errors.manufacturer }}</div>
                            </div>
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" id="model" v-model="form.model" placeholder="Enter Model">
                                <div class="text-danger font-italic" v-if="errors.model">{{ errors.model }}</div>
                            </div>
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" id="color" v-model="form.color" placeholder="Enter Color">
                                <div class="text-danger font-italic" v-if="errors.color">{{ errors.color }}</div>
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
            trucks: Object,
            errors:Object,
        },
        data() {
            return {
               params: {
                    search: null,
                    field: 'number_plate',
                    direction: 'asc',
               },
               form: this.$inertia.form({
                    number_plate: null,
                    manufacturer: null,
                    model: null,
                    color: null,
                }),
                editableTruck: null,
            }
        },
        methods: {
            deleteTruck(id){
                this.$inertia.delete('/trucks/'+id)
                .then(() => this.successToast("Truck Deleted Successfully!"))
                .catch(() => this.errorToast());
            },
            editTruck(id){
                // this.form.put('/trucks/'+id)
                this.$inertia.post('trucks/'+id, this.form)
                .then(() => this.successToast("Truck Details Edited Successfully!"))
                .catch(() => this.errorToast());
                $('#edit-model').modal('hide');
                this.form.reset();
            },
            addTruck(){
                // this.form.post('/trucks')
                this.$inertia.post('/trucks', this.form)
                .then(() => this.successToast("Truck Registered Successfully!"))
                .catch(() => this.errorToast());
                $('#create-model').modal('hide');
                this.form.reset();
            },
            fillEditForm(truck){
                this.form.number_plate = truck.number_plate;
                this.form.manufacturer = truck.manufacturer;
                this.form.model = truck.model;
                this.form.color = truck.color;
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
            deleteModal(truck){
                // $('#delete-confirmation').modal('show')
                this.$swal.fire({
                    title: 'Delete: '+truck.number_plate+'\nAre you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.deleteTruck(truck.id);
                    }
                })
            },
            editModal(truck){
                $('#edit-model').modal('show');
                this.editableTruck = truck;
                this.fillEditForm(truck);
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
        watch: {
            params: {
                handler() {
                    let params =  this.params;


                    Object.keys(params).forEach(key => {
                        if(params[key] == '') {
                            delete params[key];
                        }
                    });

                    this.$inertia.get(this.route('trucks.index'), params, {replace: true, preserveState: true});
                },
                deep: true,
            }
        }
    }
</script>


            