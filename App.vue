<template>
    <div id="app">
      <Login />
      <HelloWorld />
    </div>
  </template>
  
  <script>
  import HelloWorld from "./components/HelloWorld.vue";
  import Login from "/src/components/Login.vue";
  
  export default {
    name: "App",
    components: {
      Login,
    },
  };
  </script>