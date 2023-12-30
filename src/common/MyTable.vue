<template>
    <div>
        <h3>My Table</h3>
        <table style="width:100%">
          <tr>
            <th v-for="attr in entityInfo.attributes">
              {{ attr.label }}
            </th>
            <th>
              Edit
            </th>
            <th>
              Delete
            </th>
          </tr>
          <tr v-for="entity in values">
            <td v-for="attr in entityInfo.attributes">
              {{ entity[attr.id] }}
            </td>
            <td>
              ToDo
            </td>
            <td>
              ToDo
            </td>
          </tr>
        </table>
    </div>
</template>
<script>
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import axios from '@nextcloud/axios'


export default {
  props: ['dataurl','entityinfourl'],
  components: {
  },
  data() {
    return { 
      values: [],
      entityInfo: {} 
    }
  },
  async mounted() {
		try {
      const eiResponse = await axios.get(generateUrl(this.entityinfourl))
      this.entityInfo = eiResponse.data
      console.log(this.entityInfo)
			const response = await axios.get(generateUrl(this.dataurl))
      this.values = response.data
      console.log(this.values)
			
		} catch (e) {
			console.error(e)
			//showError(t('notestutorial', 'Could not fetch notes'))
		}
	},
}

</script>