<template>
    <div>
      <h3>New entity</h3>
      <MyForm :schemaurl="this.options.url.entityschema" :formtargeturl="this.options.url.resources"/>
      <div v-if="this.editEntity != null">
        <h3>Edit entity</h3>
        <MyForm 
          :schemaurl="this.options.url.entityschema" 
          :formtargeturl="this.options.url.resources+'/'+this.editEntityId" 
          :prefillvalues="this.editEntity"
          method="PUT"
        />
      </div>
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
  import axios from '@nextcloud/axios'
  import { generateUrl } from '@nextcloud/router'

  export default {
  
    props: ['options'],
    components: {
      MyForm,
      MyTable,
    },
    data() {
      return { 
        editEntity: null
      }
    },
    methods: {
      async doAction(type,id) {
        if(type == "delete"){

        }else if (type == "edit"){
          //this.editEntityId = id;
          const response = await axios.get(generateUrl(this.options.url.resources+'/'+id))
          console.info(response.data)
          this.editEntity = response.data
        }else{
          console.error("Invalid type:"+type)
        }
        //console.log(id)
      }
    }
  };
  </script>