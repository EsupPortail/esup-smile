<template>
  <div class="container mt-4">
    <h2>Inscription</h2>
    <form @submit.prevent="submitForm">
      <div class="row">
        <!-- Champs de formulaire -->
        <div class="col-md-6 mb-3">
          <label for="nom" class="form-label">Nom</label>
          <input type="text" class="form-control" id="nom" v-model="form.nom">
        </div>
        <div class="col-md-6 mb-3">
          <label for="prenom" class="form-label">Prénom</label>
          <input type="text" class="form-control" id="prenom" v-model="form.prenom">
        </div>
        <!-- Ajoutez ici les autres champs nécessaires -->
        <div class="col-md-6 mb-3">
          <label for="etablissement" class="form-label">Établissement universitaire</label>
          <select id="etablissement" class="form-select" v-model="form.etablissement">
            <option disabled value="">Veuillez sélectionner un établissement</option>
            <option v-for="etablissement in etablissements" :key="etablissement.id" :value="etablissement.id">
              {{ etablissement.libelle }}
            </option>
          </select>
        </div>

        <!-- Choix de mobilité et upload de documents -->
        <div class="mb-3">
          <label class="form-label">Type de mobilité</label>
          <div v-for="mobilite in mobilites" :key="mobilite.id" class="form-check">
            <input type="radio" class="form-check-input" :id="mobilite.id" :value="mobilite.id" v-model="form.mobilite">
            <label class="form-check-label" :for="mobilite.id">{{ mobilite.nom }}</label>
            <div v-if="form.mobilite === mobilite.id">
              <input type="file" @change="handleFileUpload($event, mobilite.id)">
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    defaultNom: String,
    defaultPrenom: String
  },
  data() {
    return {
      form: {
        nom: this.defaultNom,
        prenom: this.defaultPrenom,
        // ... autres champs du formulaire
        mobilite: '',
        // ... autres champs
      },
      etablissements: [],
      mobilites: [],
      uploadedFiles: {}
    };
  },
  created() {
    this.fetchEtablissements();
    this.fetchMobilites();
  },
  methods: {
    fetchEtablissements() {
      unicaenVue.axios.get('/inscription/etablissements')
          .then(response => {
            this.etablissements = response.data;
          })
          .catch(error => {
            console.error("Erreur lors du chargement des établissements:", error);
          });
    },
    fetchMobilites() {
      unicaenVue.axios.get('/inscription/mobilites')
          .then(response => {
            this.mobilites = response.data;
          })
          .catch(error => {
            console.error("Erreur lors du chargement des types de mobilité:", error);
          });
    },
    submitForm() {
      // Ici, vous devez gérer l'envoi des données du formulaire ainsi que des fichiers uploadés.
      console.log("Formulaire envoyé", this.form);
      // Ajoutez la logique d'envoi ici
    },
    handleFileUpload(event, mobiliteId) {
      this.uploadedFiles[mobiliteId] = event.target.files[0];
      // Gérez l'upload de ce fichier selon votre logique backend
    }
  }
};
</script>
