<template>
    <div class="row">
        <div class="col-md-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fa fa-line-chart mr-1"></i>
                  Profit and Loss Report
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
                      <th colspan="3">Profit and Loss Statement of: {{ thisYear }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                      <th>INCOME</th>
                      <td></td>
                      <th>{{ format_number(income) }}</th>
                    </tr>
                    <tr>
                      <th>>>Services rendered</th>
                      <td>{{ format_number(income) }}</td>
                      <td></td>
                    </tr>
                    <tr>
                        <th>EXPENSES</th>
                        <td></td>
                        <th>{{ format_number(totalExpenses) }}</th>
                    </tr>
                    <tr v-for="(expense,key) in expenses" :key="key">
                        <th>>>{{ key }}</th>
                        <td>{{ format_number(expense) }}</td>
                        <td></td>
                    </tr>
                    <tr></tr>
                    <tr>
                      <th>NET PROFIT</th>
                      <td></td>
                      <th>{{ format_number(PorL)}}</th>
                    </tr>
                </tbody>
                </table>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-7">
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
                <table class="table table-bordered table-responsive" style="height: 400px;max-height: 400px;overflow-y: scroll;">
                <thead>
                    <tr>
                      <th colspan="4">Ledger of: {{ thisYear }}</th>
                    </tr>
                    <tr>
                      <th>Date</th>
                      <th>Details</th>
                      <th>Debit</th>
                      <th>Credit</th>
                    </tr>
                </thead>
                <tbody v-for="(record,key) in records" :key="key">
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
        </div>
    </div>

</template>
<script>
import AppLayout from '@/Layouts/AppLayout'
import moment from 'moment';
export default {
    components: {
        AppLayout,
    },layout: AppLayout,
    props:{
        track_records: Object,
        bills: Object,
        capitals: Object,
        invoices: Object,
    },
    data(){
      return{
        // balance: 0,
      }
    },
    computed:{
      thisYear(){
        return new Date().getFullYear();
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
          const allInvoices = this.invoices;
          let income = 0;
          for(let invoice in allInvoices){
            income += allInvoices[invoice].total;
          }
          return income;
        },
        PorL(){
          return this.income - this.totalExpenses;
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
        },
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
    mounted(){
      // this.getRecords();
    }
  }
</script>