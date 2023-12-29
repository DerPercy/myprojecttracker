<template>
    <div>
      <h3>New entity</h3>
      <MyForm :schemaurl="this.options.url.entityschema" :formtargeturl="this.options.url.resources"/>
    </div>
    
  </template>
  <script>
  import MyForm from './MyForm.vue'

  export default {
  
    props: ['options'],
    components: {
      MyForm
    },
    data() {
      return { }
    },
    methods: {
    }
  };
  </script>