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
                <h3 class="card-title col-md-2">All Track Records</h3>
                <div class="col-md-5">
                    <input type="search" v-model="params.search" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <button class=" btn btn-success" @click="createModel">New Record</button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th @click="sort('date')">
                            <span>
                                Date
                                <svg v-if="params.field === 'date' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'date' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sort('truck_number_plate')">
                            <span>
                                Track Number Plate
                                <svg v-if="params.field === 'truck_number_plate' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'truck_number_plate' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sort('region')">
                            <span>
                                Region
                                <svg v-if="params.field === 'region' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'region' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sort('destination')">
                            <span>
                                Destination
                                <svg v-if="params.field === 'destination' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'destination' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sort('customer')">
                            <span>
                                Customer
                                <svg v-if="params.field === 'customer' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'customer' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sort('track_record_receipt_number')">
                            <span>
                                Track Record Receipt Number
                                <svg v-if="params.field === 'track_record_receipt_number' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'track_record_receipt_number' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody v-if="track_records">
                    <tr v-for="track_record in track_records.data" :key="track_record.id" >
                        <td>{{ track_record.date }}</td>
                        <td>{{ track_record.truck_number_plate }}</td>
                        <td>{{ track_record.region }}</td>
                        <td>{{ track_record.destination }}</td>
                        <td>{{ track_record.customer }}</td>
                        <td>{{ track_record.track_record_receipt_number }}</td>
                        <td class="d-flex justify-content-center">
                            <span class="text-primary">
                                <i class="fa fa-wrench fa-fw mx-1" @click="editModal(track_record)" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                            </span>
                            |
                            <span class="text-danger">
                                <i class="fa fa-trash fa-fw mx-1" @click="deleteModal(track_record)" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
            <pagination class="mt-10" :links="track_records.links"/>
        </div>
    </div>
    <!-- create modal -->
    <div class="modal fade" id="create-model" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Register Track Record</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Track Record Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="addTrackRecord" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" class="form-control" id="date" v-model="form.date">
                                <div class="text-danger font-italic" v-if="errors.date">{{ errors.date }}</div>
                            </div>
                            <div class="form-group">
                                <label for="truck_number_plate">Track Number Plate</label>
                                <input type="text" class="form-control" id="truck_number_plate" v-model="form.truck_number_plate" placeholder="Enter Number plate">
                                <div class="text-danger font-italic" v-if="errors.truck_number_plate">{{ errors.truck_number_plate }}</div>
                            </div>
                            <div class="form-group">
                                <label for="region">Region</label>
                                <input type="text" class="form-control" id="region" v-model="form.region" placeholder="Enter Region">
                                <div class="text-danger font-italic" v-if="errors.region">{{ errors.region }}</div>
                            </div>
                            <div class="form-group">
                                <label for="destination">Destination</label>
                                <input type="text" class="form-control" id="destination" v-model="form.destination" placeholder="Enter Destination">
                                <div class="text-danger font-italic" v-if="errors.destination">{{ errors.destination }}</div>
                            </div>
                            <div class="form-group">
                                <label for="customer">Customer</label>
                                <input type="text" class="form-control" id="customer" v-model="form.customer" placeholder="Enter Customer">
                                <div class="text-danger font-italic" v-if="errors.customer">{{ errors.customer }}</div>
                            </div>
                            <div class="form-group">
                                <label for="track_record_receipt_number">Track Record Receipt Number</label>
                                <input type="text" class="form-control" id="track_record_receipt_number" v-model="form.track_record_receipt_number" placeholder="Enter Track Record Receipt Number">
                                <div class="text-danger font-italic" v-if="errors.track_record_receipt_number">{{ errors.track_record_receipt_number }}</div>
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
              <h4 class="modal-title">Edit Track Record</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Track Record Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="editTrackRecord(editableTrackRecord.id)" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" class="form-control" id="date" v-model="form.date">
                                <div class="text-danger font-italic" v-if="errors.date">{{ errors.date }}</div>
                            </div>
                           <div class="form-group">
                                <label for="truck_number_plate">Track Number Plate</label>
                                <input type="text" class="form-control" id="truck_number_plate" v-model="form.truck_number_plate" placeholder="Enter Number plate">
                                <div class="text-danger font-italic" v-if="errors.truck_number_plate">{{ errors.truck_number_plate }}</div>
                            </div>
                            <div class="form-group">
                                <label for="region">Region</label>
                                <input type="text" class="form-control" id="region" v-model="form.region" placeholder="Enter Region">
                                <div class="text-danger font-italic" v-if="errors.region">{{ errors.region }}</div>
                            </div>
                            <div class="form-group">
                                <label for="destination">Destination</label>
                                <input type="text" class="form-control" id="destination" v-model="form.destination" placeholder="Enter Destination">
                                <div class="text-danger font-italic" v-if="errors.destination">{{ errors.destination }}</div>
                            </div>
                            <div class="form-group">
                                <label for="customer">Customer</label>
                                <input type="text" class="form-control" id="customer" v-model="form.customer" placeholder="Enter Customer">
                                <div class="text-danger font-italic" v-if="errors.customer">{{ errors.customer }}</div>
                            </div>
                            <div class="form-group">
                                <label for="track_record_receipt_number">Track Record Receipt Number</label>
                                <input type="text" class="form-control" id="track_record_receipt_number" v-model="form.track_record_receipt_number" placeholder="Enter Track Record Receipt Number">
                                <div class="text-danger font-italic" v-if="errors.track_record_receipt_number">{{ errors.track_record_receipt_number }}</div>
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
            track_records: Object,
            errors:Object,
        },
        data() {
            return {
               params: {
                    search: null,
                    field: 'date',
                    direction: 'asc',
               },
               form: this.$inertia.form({
                    date:null,
                    truck_number_plate: null,
                    region: null,
                    destination: null,
                    customer: null,
                    track_record_receipt_number: null,
                }),
                editableTrackRecord: null,
            }
        },
        methods: {
            deleteTrackRecord(id){
                this.$inertia.delete('/track-record/'+id)
                .then(() => this.successToast("Track Record  Deleted Successfully!"))
                .catch(() => this.errorToast());
            },
            editTrackRecord(id){
                this.$inertia.post('track-record/'+id, this.form)
                .then(() => this.successToast("Track Record  Details Edited Successfully!"))
                .catch(() => this.errorToast());
                $('#edit-model').modal('hide');
                this.form.reset();
            },
            addTrackRecord(){
                this.$inertia.post('/track-record', this.form)
                .then(() => this.successToast("Track Record  Registered Successfully!"))
                .catch(() => this.errorToast());
                $('#create-model').modal('hide');
                this.form.reset();
            },
            fillEditForm(track_record){
                this.form.date = track_record.date;
                this.form.truck_number_plate = track_record.truck_number_plate;
                this.form.region = track_record.region;
                this.form.destination = track_record.destination;
                this.form.customer = track_record.customer;
                this.form.track_record_receipt_number = track_record.track_record_receipt_number;
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
            deleteModal(track_record){
                // $('#delete-confirmation').modal('show')
                this.$swal.fire({
                    title: 'Delete: '+track_record.truck_number_plate+'\nAre you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.deleteTrackRecord(track_record.id);
                    }
                })
            },
            editModal(track_record){
                $('#edit-model').modal('show');
                this.editableTrackRecord = track_record;
                this.fillEditForm(track_record);
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

                    this.$inertia.get(this.route('track-record.index'), params, {replace: true, preserveState: true});
                },
                deep: true,
            }
        }
    }
</script>


            