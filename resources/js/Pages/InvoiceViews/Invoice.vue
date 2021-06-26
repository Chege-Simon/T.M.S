<template>
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info no-print">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>
            <div class="invoice p-3 mb-3">
                        <!-- title row -->
                <div class="row">
                <div class="col-12">
                    <h4>
                    <i class="fas fa-file"></i> Invoice
                    <small class="float-right">Date: {{ format_date(invoice.end) }}</small>
                    </h4>
                </div>
                <!-- /.col -->
                </div>
                <br>
                <br>
                <!-- info row -->
                <div class="row invoice-info border">
                <div class="col-sm-4 invoice-col">
                    From
                  <address>
                    <strong>Francis Chege Njenga</strong><br>
                    1462-0232, RUIRU<br>
                    Phone: 0722626879<br>
                    Email: fchege2015ios@gmail.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                    <strong>{{invoice.client.name}}</strong><br>
                    {{invoice.client.address}}<br>
                    Phone: {{invoice.client.phone_number}}<br>
                    Email: {{invoice.client.email}}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Invoice #{{invoice.id}}</b><br>
                    <b>Payment Due:</b> 2/22/2014<br>
                    <br>
                    <p>Truck Reg. No: <b>{{ invoice.truck.number_plate }}</b></p>
                </div>
                <!-- /.col -->
                </div>
                <!-- /.row -->
                <hr>
                <!-- Table row -->
                <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped table-bordered">
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
                <br>
                <br>
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
                        <td>KES {{ invoice.total }}</td>
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
    import AppLayout from '@/Layouts/AppLayout'
    import Pagination from '@/Jetstream/Pagination'
    import moment from 'moment';
    export default {
        components: {
            AppLayout,
            Pagination,
        },layout: AppLayout,
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
            window.addEventListener("load", window.print());
            }
        },
    }
</script>
