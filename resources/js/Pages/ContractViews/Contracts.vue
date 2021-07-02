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
                <h3 class="card-title col-md-2">All Contracts</h3>
                <div class="col-md-5">
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <button class=" btn btn-success" @click="createModel">Register Contract</button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Description
                        </th>
                        <th>
                            Company
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Period
                        </th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody v-if="contracts">
                    <tr v-for="contract in contracts.data" :key="contract.id" >
                        <td>{{ contract.name }}</td>
                        <td>{{ contract.description }}</td>
                        <td>{{ contract.company.name }}</td>
                        <td>{{ contract.date }}</td>
                        <td>{{ contract.period }}</td>
                        <td class="d-flex justify-content-center">
                            <span class="text-primary">
                                <i class="fa fa-wrench fa-fw mx-1" @click="editModal(contract)" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                            </span>
                            |
                            <span class="text-danger">
                                <i class="fa fa-trash fa-fw mx-1" @click="deleteModal(contract)" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
            <pagination class="mt-10" :links="contracts.links"/>
        </div>
    </div>
    <!-- create modal -->
    <div class="modal fade" id="create-model" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Contract</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Contract Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="addContract" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" v-model="form.name" placeholder="Enter Name">
                                <div class="text-danger font-italic" v-if="errors.name">{{ errors.name }}</div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" v-model="form.description" placeholder="Enter Description">
                                <div class="text-danger font-italic" v-if="errors.description">{{ errors.description }}</div>
                            </div>
                           <div class="form-group">
                                <label for="company_id">Company</label>
                                <select class="form-control" id="company_id" v-model="form.company_id">
                                    <option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }} -- {{ company.address }}</option>
                                </select>
                                <div class="text-danger font-italic" v-if="errors.company_id">{{ errors.company_id }}</div>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" v-model="form.date">
                                <div class="text-danger font-italic" v-if="errors.date">{{ errors.date }}</div>
                            </div>
                            <div class="form-group">
                                <label for="period">Period</label>
                                <input type="text" class="form-control" id="period" v-model="form.period" placeholder="Enter Period">
                                <div class="text-danger font-italic" v-if="errors.period">{{ errors.period }}</div>
                            </div>
                            <div class="form-group">
                                <label for="terms">Terms</label>
                                <input type="number" class="form-control" id="terms" v-model="form.terms" placeholder="Enter Terms">
                                <div class="text-danger font-italic" v-if="errors.terms">{{ errors.terms }}</div>
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
              <h4 class="modal-title">Edit Contract</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Contract Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="editContract(editableContract.id)" :disabled="form.processing">
                       <div class="card-body">
                            <div class="form-group">
                                <label for="edit_name">Name</label>
                                <input type="text" class="form-control" id="edit_name" v-model="form.name" placeholder="Enter Name">
                                <div class="text-danger font-italic" v-if="errors.name">{{ errors.name }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_description">Description</label>
                                <input type="text" class="form-control" id="edit_description" v-model="form.description" placeholder="Enter Description">
                                <div class="text-danger font-italic" v-if="errors.description">{{ errors.description }}</div>
                            </div>
                           <div class="form-group">
                                <label for="edit_company_id">Company</label>
                                <select class="form-control" id="edit_company_id" v-model="form.company_id">
                                    <option v-for="company in companies" :key="company.id" :value="company.id">{{ company.name }} -- {{ company.address }}</option>
                                </select>
                                <div class="text-danger font-italic" v-if="errors.company_id">{{ errors.company_id }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_date">Date</label>
                                <input type="date" class="form-control" id="edit_date" v-model="form.date">
                                <div class="text-danger font-italic" v-if="errors.date">{{ errors.date }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_period">Period</label>
                                <input type="text" class="form-control" id="edit_period" v-model="form.period" placeholder="Enter Period">
                                <div class="text-danger font-italic" v-if="errors.period">{{ errors.period }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_terms">Terms</label>
                                <input type="number" class="form-control" id="edit_terms" v-model="form.terms" placeholder="Enter Terms">
                                <div class="text-danger font-italic" v-if="errors.terms">{{ errors.terms }}</div>
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
            contracts: Object,
            companies: Object,
            errors:Object,
        },
        data() {
            return {
               form: this.$inertia.form({
                    name: null,
                    description: null,
                    company_id: null,
                    date: null,
                    period: null,
                    terms: null,
                }),
                the_company:null,
                editableContract: null,
            }
        },
        methods: {
            deleteContract(id){
                this.$inertia.delete('/contracts/'+id);
            },
            editContract(id){
                this.$inertia.post('/contracts/'+id, this.form);
            },
            addContract(){
                this.$inertia.post('/contracts', this.form);
            },
            fillEditForm(contract){
                this.form.name = contract.name;
                this.form.description = contract.description;
                this.form.company_id = contract.company_id;
                this.form.date = contract.date;
                this.form.period = contract.period;
                this.form.terms = contract.terms;
            },
            //open modals functions here
            deleteModal(contract){
                // $('#delete-confirmation').modal('show')
                this.$swal.fire({
                    title: 'Delete: '+contract.name+'\nAre you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.deleteContract(contract.id);
                    }
                })
            },
            editModal(contract){
                $('#edit-model').modal('show');
                this.editableContract = contract;
                this.fillEditForm(contract);
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
    }
</script>


            