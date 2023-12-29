/**
 * SPDX-FileCopyrightText: 2018 John Molakvoæ <skjnldsv@protonmail.com>
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { generateFilePath } from '@nextcloud/router'

import Vue from 'vue'
import App from './App'
const VueFormulate = require('@braid/vue-formulate')
Vue.use(VueFormulate.default)


// eslint-disable-next-line
__webpack_public_path__ = generateFilePath(appName, '', 'js/')
//Vue.use(Vueform, vueformConfig)
Vue.mixin({ methods: { t, n } })

export default new Vue({
	el: '#content',
	render: h => h(App),
})