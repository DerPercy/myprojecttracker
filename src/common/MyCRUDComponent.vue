<template>
    <div>
      <h3>New entity</h3>
      <MyForm :schemaurl="this.options.url.entityschema" :formtargeturl="this.options.url.resources"/>

      <h3>All entities</h3>
      <MyTable 
        :dataurl="this.options.url.resources" 
        :entityinfourl="this.options.url.entityinfo"
        @entity-action="doAction"
      />

    </div>
    
  </template>
  <script>
  import MyForm from './MyForm.vue'
  import MyTable from './MyTable.vue'

  export default {
  
    props: ['options'],
    components: {
      MyForm,
      MyTable,
    },
    data() {
      return { }
    },
    methods: {
      doAction(type,id) {
        console.log(type)
        console.log(id)
      }
    }
  };
  </script>