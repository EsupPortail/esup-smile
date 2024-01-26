const vues = import.meta.glob('./**/*.vue', {eager: true});

import vueApp from 'unicaen-vue/js/Client/main'


vueApp.init(vues);
