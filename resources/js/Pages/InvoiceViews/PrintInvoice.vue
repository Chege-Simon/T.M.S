<style media="print" scoped>
    @media all{
        .border{
        border: 1px solid #000 !important;
        }
        .table-bordered th,
        .table-bordered td {
        border: 1px solid #000 !important;
        }
    }
</style>
<template>
<section class="content" id="content">
      <div class="container-fluid">
        <div class="row h6">
          <div class="col-12">
            <div class="invoice p-1 m-1">
                        <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h2>
                        <i class="fas fa-file"></i> Invoice
                        <small class="float-right">Date: {{ format_date(invoice.end) }}</small>
                        </h2>
                    </div>
                <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row border mx-1">
                    <div class="col-4">
                        From
                    <address>
                        <strong>{{ theCompany.name }}</strong><br>
                        {{ theCompany.address }}<br>
                        Phone: {{ theCompany.phone_number }}<br>
                        Email: {{ theCompany.email }}
                    </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        To
                        <address>
                        <strong>{{invoice.client.name}}</strong><br>
                        {{invoice.client.address}}<br>
                        <!-- Phone: {{invoice.client.phone_number}}<br>
                        Email: {{invoice.client.email}} -->
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-2">
                        <b>Invoice #{{invoice.id}}</b><br>
                        <p><b>Terms: </b>{{ invoice.contract.terms }} days</p>
                        <p>Truck Reg. No: <b>{{ invoice.truck.number_plate }}</b></p>
                        <b>Payment Due: </b>{{  due}}<br>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <br>
                <!-- Table row -->
                <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped table-bordered my-0">
                        <thead>
                            <tr>
                                <th>Service Date</th>
                                <th>Record Recipt No.</th>
                                <th>Destination</th>
                                <th>Region</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody v-if="invoice">
                            <tr v-for="record in track_records" :key="record.id" >
                                <td>{{ format_date(record.date) }}</td>
                                <td>{{ record.track_record_receipt_number }}</td>
                                <td>{{ record.destination }}</td>
                                <td>{{ record.region.name }}</td>
                                <td>{{ format_number(record.region.pricing) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div> 
                <div class="row">
                <!-- accepted payments column -->
                <div class="col-8">
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                        <th>TOTAL:</th>
                        <td>{{ format_number(invoice.total) }}</td>
                        </tr>
                    </table>
                    </div>
                </div>
                <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                <div class="col-12">
                    <a @click="print" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                </div>
                </div>
            </div>    
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>  
</template>
<script>
    import Pagination from '@/Jetstream/Pagination'
    import moment from 'moment';
    export default {
        components: {
            Pagination,
        },
        props:{
            invoice: Object,
            track_records: Object,
            companies: Object,
        },
        computed:{
            due(){
                const end = new Date(this.invoice.end);
                // const date = new Date();
                const due = end.setDate(end.getDate() + this.invoice.contract.terms);
                const dueDate = new Date(due);
                return  moment(dueDate , moment.ISO_8601).format('DD-MM-YYYY');
            },
            theCompany(){
                let id = this.invoice.contract.company_id;
                let the_company = null;
                for(const company in this.companies){
                    if(this.companies[company].id == id){
                        the_company = this.companies[company];
                    }
                }
                return the_company;
            }
        },
        methods: { 
            format_number(value){
                // Create our number formatter.
                const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'KSh',

                // These options are needed to round to whole numbers if that's what you want.
                //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });

                return formatter.format(value); /* $2,500.00 */
            },
            format_date(value){
                if (value) {
                    return moment(String(value)).format('DD-MM-YYYY')
                }
            },
            print(){
            // window.addEventListener("load",);
             window.print();
            }
        },
    }
</script>
