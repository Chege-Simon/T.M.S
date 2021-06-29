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
                <div class="row border">
                    <div class="col-sm-4">
                        From
                    <address>
                        <strong>Francis Chege Njenga</strong><br>
                        1462-0232, RUIRU<br>
                        Phone: 0722626879<br>
                        Email: fchege2015ios@gmail.com
                    </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        To
                        <address>
                        <strong>{{invoice.client.name}}</strong><br>
                        {{invoice.client.address}}<br>
                        Phone: {{invoice.client.phone_number}}<br>
                        Email: {{invoice.client.email}}
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2">
                        <b>Invoice #{{invoice.id}}</b><br>
                        <p><b>Terms: </b>{{ invoice.contract.terms }} days</p>
                        <p>Truck Reg. No: <b>{{ invoice.truck.number_plate }}</b></p>
                        <b>Payment Due:</b> 2/22/2014<br>
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
                                <td>{{ record.region.pricing }}</td>
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
                        <td>KSh {{ invoice.total }}</td>
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
        },
        methods: { 
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
