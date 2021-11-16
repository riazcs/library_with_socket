<template>
    <div>
        
<div class="container pt-5 mt-5"> 
   <div class="text-right">
     <router-link to="/checklist">
     <button class="btn btn-primary">Cart ({{totalItems}})</button>                     
      </router-link>
   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
   </div>
<div class="productcont" v-for="(book,index) in books" :key="index">
        <div class="product">
            <h3 class="productname">{{book.name}}</h3>
            <p>By {{book.written_by}}</p>
            <p class="price">Borrow fee: ${{book.borrow_fee}}</p>
            <p class="del-price">Delivery fee: ${{book.delivery_fee}}</p>
            <button class="addtocart" @click="borrow(book.id)" :disabled="book.is_borrow==1 || btn=='Booked'">{{book.is_borrow==1?'Booked':btn}}</button>
        </div>
        
        </div>
        
</div>
    </div>
</template>

<script>
import * as $ from "jquery";
import * as bootstrap from "bootstrap";
    export default {
      name: 'BorrowBook',
    components: {
        // ExampleComponent,
    },
        data() {
            return {
              wSocket: new WebSocket(this.$wsUrl),
                totalItems:'',
                books:[],
                btn:'Borrow now',
            }
        },
        mounted(){
           this.get_books();
           this.wSocket.addEventListener('open', function (event) {
            });
            this.wSocket.addEventListener('message', function (event) {
            });

            this.wSocket.onmessage = function(event) {
                console.log(event);
                var decoded = JSON.parse(event.data);
                if(decoded.response=='borrowBook'){
                    this.btn='Booked';
                } 
            }
            this.wSocket.onopen = function(event) {
                this.send(JSON.stringify({
                    action: 'subscribe',
                    room: 'book-'+this.books.id
                }));
            }

        },
        methods: {
          get_books(){
           axios({ method: "GET", url: "/api/products"}).then(
            result => {
              this.books = result.data.product;
              this.totalItems = result.data.booked;
            },
            error => {
              console.error(error);
            }
           );
        
          },
          borrow(id){
            this.totalItems = 1;
            axios.post("/api/book-now", {
            book_id : id,
          })
          .then(res => {
            console.log(res.data.result);
            if(res.data.result == "success"){ 
                this.btn="Booked";
                // this.wSocket.send(JSON.stringify({
                //                 action: 'borrowBook',
                //                 room: 'book-'+id
                //             }));
              }else{                    
              }
          })
          .catch(err => {                                                    
                console.log(err);
          });
          },

          get_booked_item(){
             axios({ method: "GET", url: "/api/booked-list"}).then(
            result => {
              this.booked_items = result.data.product;
            $('#myModal').modal('show');
            },
            error => {
              console.error(error);
            }
      );

          }
        }
    }
</script>

<style lang="scss" scoped>
// .container {
//   max-width: 800px; 
//   margin: 1em auto; 
//   background:#FFF; 
//   padding:30px;
//   border-radius:5px;
// }
// .productcont {
//   display: flex; 
// }
// .product {
//   padding:1em; 
//   border:1px solid #E0E4CC; 
//   margin-right:1em; 
//   border-radius:5px;
// }
// .cart-container {
//   border:1px solid #E0E4CC;
//   border-radius:5px;
//   margin-top:1em;
//   padding:1em;
// }
// button, input[type="submit"] { 
//     border:1px solid #FA6900; 
//     color:#fff; 
//     background: #F38630; 
//     padding:0.6em 1em;
//     font-size:1em; 
//     line-height:1; 
//     border-radius: 1.2em;
//     transition: color 0.2s ease-in-out, background 0.2s ease-in-out, border-color 0.2s ease-in-out;
// }
// button:hover, button:focus, button:active, input[type="submit"]:hover, input[type="submit"]:focus, input[type="submit"]:active {
//     background: #A7DBD8;
//     border-color:#69D2E7;
//     color:#000;
//     cursor: pointer;
// }
// table {
//   margin-bottom:1em;
//   border-collapse:collapse;
// }
// table td, table th {
//   text-align:left;
//   padding:0.25em 1em;
//   border-bottom:1px solid #E0E4CC;
// }
// #carttotals {
//   margin-right:0;
//   margin-left:auto;
// }
// .cart-buttons {
//   width:auto;
//   margin-right:0;
//   margin-left:auto;
//   display:flex;
//   justify-content:flex-end;
//   padding:1em 0;
// }
// #emptycart {
//   margin-right:1em;
// }
// table td:nth-last-child(1) {
//   text-align:right;
// }
// .message {
//   border-width: 1px 0px;
//   border-style:solid;
//   border-color:#A7DBD8;
//   color:#679996;
//   padding:0.5em 0;
//   margin:1em 0;
// }
</style>