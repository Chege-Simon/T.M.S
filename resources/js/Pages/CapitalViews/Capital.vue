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
                <h3 class="card-title col-md-2">All Capitals</h3>
                <div class="col-md-5">
                    <input type="search" v-model="params.search" class="form-control form-control-sm" placeholder="Search...">
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <button class=" btn btn-success" @click="createModel">Register Capital</button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th @click="sort('asset_type')">
                            <span>
                                Asset Type
                                <svg v-if="params.field === 'asset_type' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'asset_type' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th @click="sort('description')">
                            <span>
                                Description
                                <svg v-if="params.field === 'description' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'description' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
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
                        <th @click="sort('amount')">
                            <span>
                                Amount
                                <svg v-if="params.field === 'amount' && params.direction === 'asc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>
                                </svg>

                                <svg v-if="params.field === 'amount' && params.direction === 'desc'" xmlns="http://www.w3.org/2000/svg" style='width:20px' viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"/>
                                </svg>
                            </span>
                        </th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody v-if="capitals">
                    <tr v-for="capital in capitals.data" :key="capital.id" >
                        <td>{{ capital.asset_type }}</td>
                        <td>{{ capital.description }}</td>
                        <td>{{ capital.date }}</td>
                        <td>{{ capital.amount }}</td>
                        <td class="d-flex justify-content-center">
                            <span class="text-primary">
                                <i class="fa fa-wrench fa-fw mx-1" @click="editModal(capital)" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                            </span>
                            |
                            <span class="text-danger">
                                <i class="fa fa-trash fa-fw mx-1" @click="deleteModal(capital)" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
            <pagination class="mt-10" :links="capitals.links"/>
        </div>
    </div>
    <!-- create modal -->
    <div class="modal fade" id="create-model" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Register Capital</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Capital Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="addCapital" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="asset_type">Asset Type</label>
                                <input type="text" class="form-control" id="asset_type" v-model="form.asset_type" placeholder="Enter Asset Type">
                                <div class="text-danger font-italic" v-if="errors.asset_type">{{ errors.asset_type }}</div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" v-model="form.description" placeholder="Enter Description">
                                <div class="text-danger font-italic" v-if="errors.description">{{ errors.description }}</div>
                            </div>
                           <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" v-model="form.date" placeholder="Enter Date">
                                <div class="text-danger font-italic" v-if="errors.date">{{ errors.date }}</div>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount" v-model="form.amount" placeholder="Enter Amount">
                                <div class="text-danger font-italic" v-if="errors.amount">{{ errors.amount }}</div>
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
              <h4 class="modal-title">Edit Capital</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Capital Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="editCapital(editableCapital.id)" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="edit_asset_type">Asset Type</label>
                                <input type="text" class="form-control" id="edit_asset_type" v-model="form.asset_type" placeholder="Enter Asset Type">
                                <div class="text-danger font-italic" v-if="errors.asset_type">{{ errors.asset_type }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_description">Description</label>
                                <input type="text" class="form-control" id="edit_description" v-model="form.description" placeholder="Enter Description">
                                <div class="text-danger font-italic" v-if="errors.description">{{ errors.description }}</div>
                            </div>
                           <div class="form-group">
                                <label for="edit_date">Date</label>
                                <input type="date" class="form-control" id="edit_date" v-model="form.date" placeholder="Enter date">
                                <div class="text-danger font-italic" v-if="errors.date">{{ errors.date }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_amount">Amount</label>
                                    <input type="number" class="form-control" id="edit_amount" v-model="form.amount" placeholder="Enter amount">
                                <div class="text-danger font-italic" v-if="errors.amount">{{ errors.amount }}</div>
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
            capitals: Object,
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
                    asset_type: null,
                    description: null,
                    date: null,
                    amount: null,
                }),
                editableCapital: null,
            }
        },
        methods: {
            deleteCapital(id){
                this.$inertia.delete('/capital/'+id);
            },
            editCapital(id){
                this.$inertia.post('/capital/'+id, this.form);
            },
            addCapital(){
                this.$inertia.post('/capital', this.form);
            },
            fillEditForm(capital){
                this.form.asset_type = capital.asset_type;
                this.form.description = capital.description;
                this.form.date = capital.date;
                this.form.amount = capital.amount;
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
            deleteModal(capital){
                // $('#delete-confirmation').modal('show')
                this.$swal.fire({
                    title: 'Delete: '+capital.name+'\nAre you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.deleteCapital(capital.id);
                    }
                })
            },
            editModal(capital){
                $('#edit-model').modal('show');
                this.editableCapital = capital;
                this.fillEditForm(capital);
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

                    this.$inertia.get(this.route('capital.index'), params, {replace: true, preserveState: true});
                },
                deep: true,
            }
        }
    }
</script>


            