import unicaenVue from 'unicaen-vue';
import Vuetify from 'vite-plugin-vuetify'
import path from 'path';

/**
 * @see https://vitejs.dev/config/
 *
 * la config transmise ci-dessous est surchargée par UnicaenVue.defineConfig, qui ajoute ses propres éléments
 * puis retourne vite.defineConfig
 */
export default unicaenVue.defineConfig({
    // répertoire où seront placés les fichiers *.vue des composants
    root: 'front',
    build: {
        // Répertoire où seront placés les fichiers issus du build et à ajouter au GIT
        // à mettre en cohérence avec la config côté PHP (unicaen-vue/dist-path)
        outDir: path.resolve(__dirname, 'public/dist'),
    },
    server: {
        // port par défaut utilisé par Node pour communiquer les éléments en "hot-loading"
        // utile uniquement en mode dev, donc
        port: 5133
    },
    plugins: [
        Vuetify(),
    ],
    resolve: {
        alias: {
            // alias pour les imports
            '@': path.resolve(__dirname, 'front'),
        },
        extensions: [
            '.js',
            '.json',
            '.jsx',
            '.mjs',
            '.ts',
            '.tsx',
            '.vue',
          ],
    },
    resolvers: [
        // Liste de resolvers pour faire de l'auto-import

    ],
});
