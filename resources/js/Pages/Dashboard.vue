<template>
    <app-layout>
        <template #header>
            <h2 class="h4 font-weight-bold">
                Dashboard
            </h2>
        </template>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ PorL?PorL:null }}<sup style="font-size: 20px">%</sup></h3>

                <p>Profit/Loss this Month</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer" style="height:3em">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ track_records.length }}</h3>

                <p>Trips Current Month</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/track-record" class="small-box-footer" style="height:3em">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ trucks.length }}</h3>

                <p>Truck Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="/trucks" class="small-box-footer" style="height:3em">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ clients.length }}</h3>

                <p>Client Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="/clients" class="small-box-footer" style="height:3em">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fa fa-files-o mr-1"></i>
                  Ledger
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                      <th colspan="4">Ledger of: {{ when }}</th>
                    </tr>
                    <tr>
                      <th>Date</th>
                      <th>Details</th>
                      <th>Debit</th>
                      <th>Credit</th>
                    </tr>
                </thead>
                <tbody v-for="(record,key) in records" :key="key" style="height: 400px;overflow-y: scroll;">
                      <tr v-for="transaction in record" :key="transaction">
                        <th>{{  key }}</th>
                        <td >{{  transaction.details }}</td>
                        <td>{{  format_number(transaction.type === 'debit' ? transaction.cash : null) }}</td>
                        <td >{{  format_number(transaction.type === 'credit' ? transaction.cash : null) }}</td>
                        <!-- <td >{{  transaction.type === 'debit' ? balance -= transaction.cash : balance += transaction.cash }}</td> -->
                      </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Balance</th>
                    <td></td>
                    <td>{{ format_number(balance < 0 ? balance: null) }}</td>
                    <td>{{ format_number(balance > 0 ? balance: null) }}</td>
                  </tr>
                </tfoot>
                </table>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import { Inertia } from '@inertiajs/inertia'
    export default {
        components: {
            AppLayout,
        },
        props:{
            trucks: Object,
            clients: Object,
            track_records: Object,
            bills: Object,
            capitals: Object,
            invoices: Object,
        },
        computed:{ 
          when(){
            let date = new Date().getMonth();
            let when = '';
            switch (date) {
              case 0:
                when = 'Jan'
                break; 
              case 1:
                when = 'Feb'
                break;
              case 2:
                when = 'Mar'
                break; 
              case 3:
                when = 'Apr'
                break;
              case 4:
                when = 'May'
                break; 
              case 5:
                when = 'Jun'
                break; 
              case 6:
                when = 'Jul'
                break; 
              case 7:
                when = 'Aug'
                break; 
              case 8:
                when = 'Sep'
                break; 
              case 9:
                when = 'Oct'
                break; 
              case 10:
                when = 'Nov'
                break;
              case 11:
                when = 'Dec'
                break;
            
              default:
                break;
            }
            when = when + " " + new Date().getFullYear();
            return when;
          },
          expenses(){
          let expenses = new Set();
          let dict =  {};
          const the_bills = this.bills;
          for(let bill in the_bills){
              expenses.add(the_bills[bill].expense.account);
          }
          
          for(let key of expenses){
              dict[key] = 0;
          }
          for(let key of expenses){
              for(const bill in the_bills){
                  if(key == the_bills[bill].expense.account){
                      let hold = dict[key];
                      hold+=the_bills[bill].amount
                      dict[key] = hold;
                  }
              }
          }
          return dict;
          },
          totalExpenses(){
            let total = 0;
            const dict = this.expenses;
              for(let key in dict){
                  total += dict[key];
            }
            return total;
          },
          income(){
              const records = this.track_records;
              let income = 0;
              for(let record in records){
                income += records[record].region.pricing;
              }
              return income;
          },
          PorL(){
            return (this.income - this.totalExpenses) / this.income * 100;
          },
        records(){
            const track_records = this.track_records;
            const bills = this.bills;
            const capitals = this.capitals;
            let tracking = {};
            for(let record in track_records){
            let transaction = [];
                let day = track_records[record].date;
                let data = {
                  'details': track_records[record].client.name+": "+track_records[record].truck.number_plate+" -- "+track_records[record].destination+" @ "+track_records[record].region.name, 
                  'cash': track_records[record].region.pricing,
                  'type': 'credit'
                };
                if(tracking.hasOwnProperty(day)){
                    tracking[day].forEach((value)=>{
                      transaction.push(value);
                    });
                    transaction.push(data);
                    tracking[day] = transaction;
                }else{
                    transaction.push(data);
                    tracking[day] = transaction;
                }
            }
            for(let bill in bills){
            let transaction = [];
              let data = {
                'details': bills[bill].expense.expense_type+" for "+bills[bill].truck.number_plate, 
                'cash': bills[bill].amount,
                'type': 'debit'
              };
              if(tracking.hasOwnProperty(bills[bill].date)){
                  tracking[bills[bill].date].forEach((value)=>{
                    transaction.push(value);
                  });
                  transaction.push(data);
                  tracking[bills[bill].date] = transaction;
              }else{
                  transaction.push(data);
                  tracking[bills[bill].date] = transaction;
              }
            }
            for(let capital in capitals){
              let transaction = [];
              let data = {
                'details': capitals[capital].asset_type+": "+capitals[capital].description, 
                'cash': capitals[capital].amount,
                  'type': 'credit'
              };
              if(tracking.hasOwnProperty(capitals[capital].date)){
                  tracking[capitals[capital].date].forEach((value)=>{
                    transaction.push(value);
                  });
                  transaction.push(data);
                  tracking[capitals[capital].date] = transaction;
              }else{
                  transaction.push(data);
                  tracking[capitals[capital].date] = transaction;
              }
            }
            const ordered = Object.keys(tracking).sort().reduce(
              (obj, key) => { 
                obj[key] = tracking[key]; 
                return obj;
              }, {}
            );
            return ordered;
        },
        balance(){
          let records = this.records;
          let balance = 0;
          for(let record in records){
            for(let transaction in records[record]){
                let trans = records[record][transaction];
              if(trans.type === 'credit'){
                balance += trans.cash;
              }else{
                balance -= trans.cash;
              }
            }
          }
          // console.log(balance);
          return balance;
        }
        },
        methods:{
             format_number(value){
              if(typeof(value) !== 'number'){
                return null;
              }
              // Create our number formatter.
              const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'KSh',

                // These options are needed to round to whole numbers if that's what you want.
                //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
              });

              return formatter.format(value); /* $2,500.00 */
            }
        },
        mounted(){;
        }
    }
</script>
