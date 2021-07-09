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
                <h3 class="card-title col-md-2">All Companies</h3>
                <div class="col-md-5">
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-2">
                    <button class=" btn btn-success" @click="createModel">Register Company</button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Phone Number
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Address
                        </th>
                        <th>
                            Bank account
                        </th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody v-if="companies">
                    <tr v-for="company in companies.data" :key="company.id" >
                        <td>{{ company.name }}</td>
                        <td>{{ company.phone_number }}</td>
                        <td>{{ company.email }}</td>
                        <td>{{ company.address }}</td>
                        <td>{{ company.bank_account }}</td>
                        <td class="d-flex justify-content-center">
                            <span class="text-primary">
                                <i class="fa fa-wrench fa-fw mx-1" @click="editModal(company)" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                            </span>
                            |
                            <span class="text-danger">
                                <i class="fa fa-trash fa-fw mx-1" @click="deleteModal(company)" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
            <pagination class="mt-10" :links="companies.links"/>
        </div>
    </div>
    <!-- create modal -->
    <div class="modal fade" id="create-model" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Company</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Company Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="addCompany" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" v-model="form.name" placeholder="Enter Name">
                                <div class="text-danger font-italic" v-if="errors.name">{{ errors.name }}</div>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" v-model="form.phone_number" placeholder="Enter Phone Number">
                                <div class="text-danger font-italic" v-if="errors.phone_number">{{ errors.phone_number }}</div>
                            </div>
                           <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" v-model="form.email" placeholder="Enter Email">
                                <div class="text-danger font-italic" v-if="errors.email">{{ errors.email }}</div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" v-model="form.address" placeholder="Enter Address">
                                <div class="text-danger font-italic" v-if="errors.address">{{ errors.address }}</div>
                            </div>
                            <div class="form-group">
                                <label for="bank_account">Bank Account</label>
                                <input type="text" class="form-control" id="bank_account" v-model="form.bank_account" placeholder="Enter Bank Account">
                                <div class="text-danger font-italic" v-if="errors.bank_account">{{ errors.bank_account }}</div>
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
              <h4 class="modal-title">Edit Company</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Company Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form @submit.prevent="editCompany(editableCompany.id)" :disabled="form.processing">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="edit_name">Name</label>
                                <input type="text" class="form-control" id="edit_name" v-model="form.name" placeholder="Enter Name">
                                <div class="text-danger font-italic" v-if="errors.name">{{ errors.name }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_phone_number">Phone Number</label>
                                <input type="text" class="form-control" id="edit_phone_number" v-model="form.phone_number" placeholder="Enter Phone NUmber">
                                <div class="text-danger font-italic" v-if="errors.phone_number">{{ errors.phone_number }}</div>
                            </div>
                           <div class="form-group">
                                <label for="edit_email">Email</label>
                                <input type="email" class="form-control" id="edit_email" v-model="form.email" placeholder="Enter Email">
                                <div class="text-danger font-italic" v-if="errors.email">{{ errors.email }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_address">Address</label>
                                <input type="text" class="form-control" id="edit_address" v-model="form.address" placeholder="Enter Address">
                                <div class="text-danger font-italic" v-if="errors.address">{{ errors.address }}</div>
                            </div>
                            <div class="form-group">
                                <label for="edit_bank_account">Bank Account</label>
                                <input type="text" class="form-control" id="edit_bank_account" v-model="form.bank_account" placeholder="Enter Bank Account">
                                <div class="text-danger font-italic" v-if="errors.bank_account">{{ errors.bank_account }}</div>
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
            companies: Object,
            errors:Object,
        },
        data() {
            return {
               form: this.$inertia.form({
                    name: null,
                    phone_number: null,
                    email: null,
                    address: null,
                    bank_account: null,
                }),
                editableCompany: null,
            }
        },
        methods: {
            deleteCompany(id){
                this.$inertia.delete('/my-companies/'+id);
            },
            editCompany(id){
                this.$inertia.post('/my-companies/'+id, this.form);
            },
            addCompany(){
                this.$inertia.post('/my-companies', this.form);
            },
            fillEditForm(company){
                this.form.name = company.name;
                this.form.phone_number = company.phone_number;
                this.form.email = company.email;
                this.form.address = company.address;
                this.form.bank_account = company.bank_account;
            },
            //open modals functions here
            deleteModal(company){
                // $('#delete-confirmation').modal('show')
                this.$swal.fire({
                    title: 'Delete: '+company.name+'\nAre you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        this.deleteCompany(company.id);
                    }
                })
            },
            editModal(company){
                $('#edit-model').modal('show');
                this.editableCompany = company;
                this.fillEditForm(company);
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


            