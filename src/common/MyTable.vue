<template>
    <div>
        <h3>My Table</h3>
        <table style="width:100%">
          <tr>
            <th v-for="attr in entityInfo.attributes">
              {{ attr.label }}
            </th>
            <th>
              Actions
            </th>
          </tr>
          <tr v-for="entity in values">
            <td v-for="attr in entityInfo.attributes">
              {{ entity[attr.id] }}
            </td>
            <td>
              <NcActions>
                <NcActionButton @click="$emit('entity-action', 'edit',entity.id)">
			            <template #icon>
				            <Pencil :size="20" />
			            </template>
			            Edit
		            </NcActionButton>
                <NcActionButton @click="$emit('entity-action', 'delete',entity.id)">
			            <template #icon>
				            <Delete :size="20" />
			            </template>
			            Delete
		            </NcActionButton>

              </NcActions>
            </td>
          </tr>
        </table>
    </div>
</template>
<script>
import { generateUrl } from '@nextcloud/router'
import { showError, showSuccess } from '@nextcloud/dialogs'
import axios from '@nextcloud/axios'

import NcActions from '@nextcloud/vue/dist/Components/NcActions'
import NcActionButton from '@nextcloud/vue/dist/Components/NcActionButton'
import Delete from 'vue-material-design-icons/Delete'
import Pencil from 'vue-material-design-icons/Pencil'


export default {
  props: ['dataurl','entityinfourl'],
  components: {
    NcActions,
    NcActionButton,
    Delete,
    Pencil,
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
  methods: {
		showMessage(msg) {
			alert(msg)
		},
	},
}

</script>