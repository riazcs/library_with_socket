<template>
  <div id="app">
                     <BorrowBook/>
         <router-view />
    <!-- <vue-progress-bar></vue-progress-bar> -->
  </div>
</template>
<script src="https://unpkg.com/vue-meta/dist/vue-meta.min.js"></script>
<script>
import Vue from "vue";
// import VueProgressBar from "vue-progressbar";
import BorrowBook from '../components/BorrowBook.vue';
const options = {
  color: "#4e73df",
  failedColor: "#874b4b",
  thickness: "5px",
  transition: {
    speed: "0.5s",
    termination: 300
  },
  autoRevert: true,
  location: "top",
  inverse: false
};
// Vue.use(VueProgressBar, options);
export default {
    name: "App",
    components: {
        BorrowBook,
    },
};
</script>