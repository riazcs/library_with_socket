<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Carted item list</div>
                    <div class="card-body">
                        I'm an example component.
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

          }
        }
    }
</script>
