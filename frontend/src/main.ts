import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import 'bootstrap/dist/css/bootstrap.css'

const vuetify = createVuetify({
  icons: {
    defaultSet: 'mdi'
  },
  components,
  directives,
})

createApp(App)
.use(router)
.use(vuetify)
.mount('#app')
