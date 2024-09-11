import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { aliases, fa } from 'vuetify/iconsets/fa-svg'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { VDateInput } from 'vuetify/labs/VDateInput'

library.add(fas) // Include needed solid icons
library.add(far) // Include needed regular icons

const vuetify = createVuetify({
    components: {
        VDateInput,
    },
    directives,
    icons: {
        defaultSet: 'fa',
        aliases,
        sets: {
            fa,
        },
    },
    defaults: {
        VBtn: {
            color: 'primary',
            // style: 'text-transform: none;'
        },
    }
})

export default vuetify