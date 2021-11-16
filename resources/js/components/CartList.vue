<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Carted item list</div>
                    <div class="card-body">
                        <div class="table-responsive">          
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Book Name</th>
                                    <th>Written By</th>
                                    <th>Borrow Charge</th>
                                    <th>Delivery Charge</th>
                                    <th>Total Charge</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(book,index) in booked_items" :key="index">
                                    <td>{{book.name}}</td>
                                    <td>{{book.written_by}}</td>
                                    <td>{{book.borrow_fee}}</td>
                                    <td>{{book.delivery_fee}}</td>
                                    <td>{{book.borrow_fee + book.delivery_fee}}</td>
                                    <td><button class="btn btn-sm btn-secondary" @click="order_now(book.id)"> Order Now</button></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                booked_items:[]
            }
        },
        mounted() {
            this.get_booked_item();
        },
        methods:{
            
          get_booked_item(){
             axios({ method: "GET", url: "/api/booked-list"}).then(
            result => {
              this.booked_items = result.data.product;
            },
            error => {
              console.error(error);
            }
      );

          },

          order_now(id){
            this.totalItems = 1;
            axios.post("/api/give-order", {
            book_id : id,
          })
          .then(res => {
            console.log(res.data.result);
            if(res.data.result == "success"){ 
              }else{                    
              }
          })
          .catch(err => {                                                    
                console.log(err);
          });
          },
        }
    }
</script>
