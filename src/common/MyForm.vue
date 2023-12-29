<template>
    <div>
        <h3>My Form</h3>
        <FormulateForm 
            v-models="values" 
            :schema="schema" 
            @submit="submitHandler"
        />
    </div>
</template>
<script>

import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import axios from '@nextcloud/axios'


  export default {
    props: ['schemaurl','formtargeturl'],
    data() {
      return { 
        values: {
        },
        schema: [] 
      }
    },
    async mounted() {
		try {
			const response = await axios.get(generateUrl(this.schemaurl))
            this.schema = response.data
            console.log(this.schema)
			
		} catch (e) {
			console.error(e)
			showError(t('notestutorial', 'Could not fetch notes'))
		}
		//this.loading = false
	},

    methods: {
        async submitHandler (data) {
            //await this.$axios.post('/my/api', data)
            //alert(`Thank you, ${data.name}`)
            console.log("submit")
            console.log(data)
            console.log("URL")
            
            console.log(this.formtargeturl)
            this.createNote(data,this.formtargeturl)

        },
        async createNote(data,url) {
			    this.updating = true
			    try {
				    const response = await axios.post(generateUrl(url), data)
            console.log("Request OK")
            console.log(response.data)
				    //const index = this.notes.findIndex((match) => match.id === this.currentNoteId)
				    //this.$set(this.notes, index, response.data)
				    //this.currentNoteId = response.data.id
			    } catch (e) {
				    console.error(e)
				    //showError(t('notestutorial', 'Could not create the note'))
			    }
			    this.updating = false
		    },
    }
  };
  </script>