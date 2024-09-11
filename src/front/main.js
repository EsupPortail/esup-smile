const vues = import.meta.glob('./**/*.vue', {eager: true});

import vueApp from 'unicaen-vue/js/Client/main'
// Vuetify
import vuetify from './plugins/vuetify'
import pinia from './plugins/pinia'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const options = {
    beforeMount: (app) => {
        app.component('font-awesome-icon', FontAwesomeIcon)
        app.use(vuetify)
        app.use(pinia)
    },
}

vueApp.init(vues, options);