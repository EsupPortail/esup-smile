<template>
  <div>
    <h2>Gestion gestionnaires/composantes</h2>
    <!-- Onglets de navigation -->
    <nav class="mt-4">
      <div id="nav-tab" class="nav nav-tabs" role="tablist">
        <button class="nav-link active" data-bs-toggle="tab" href="#gestionnaires">Gestionnaires</button>
        <button class="nav-link" data-bs-toggle="tab" href="#composantes">Composantes</button>
      </div>
    </nav>


    <!-- Contenu des onglets -->
    <div class="tab-content">
      <div class="tab-pane fade show active" id="gestionnaires">
        <h2>Attribution des gestionnaires</h2>
        <div class="row">
          <div class="col-3">
            <table class="table table-hover">
              <th>Nom</th>
              <tbody>
              <tr :class="{ 'active': gestionnaireSelected && gestionnaire.id === gestionnaireSelected.id  }"
                  v-for="gestionnaire in gestionnaires"
                  :key="gestionnaire.id"
                  @click="selectGestionnaire(gestionnaire)">
                <td>{{ gestionnaire.displayName }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-3">
            <table class="table table-hover">
              <th>Attribué</th>
              <tbody>
              <tr v-if="gestionnaireSelected.id"
                  v-for="cg in gestionnaireSelected.composanteGroupes"
                  :key="cg.id"
                  @click="removeComposanteGroupe(cg)">
                <td>{{ cg.libelle }} <i class="icon fa fa-minus" aria-hidden="true"></i></td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-3">
            <table class="table table-hover">
              <th>Non Attribué</th>
              <tbody>
              <tr v-for="cg in cgToAdd"
                  :key="cg.id"
                  v-if="gestionnaireSelected.id"
                  @click="addComposanteGroupe(cg)">
                <td>{{ cg.libelle }} <i class="icon fa fa-plus" aria-hidden="true"></i>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="composantes">
        <h2>Liste des Groupes de Composantes</h2>
        <div class="row">
          <div class="col-3">
            <input class="form-control" placeholder="Nom du groupe" type="text" name="" id="" v-model="nameGroupToAdd">
          </div>
          <div class="col-1">
            <button class="btn btn-primary" @click="addGroup">Ajouter</button>
          </div>
          <div class=" col-4">
            <input type="text" v-model="searchCgA" placeholder="Chercher" name="searchCgA" id="searchCgA" class="form-control">
          </div>
          <div class="col-4">
            <input type="text" v-model="searchCgNonA" placeholder="Chercher" name="searchCgNonA" id="searchCgNonA" class="form-control">
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <table class="table table-hover">
              <th>Nom</th>
              <th></th>
              <tbody>
              <tr
                  :class="{ 'active': composanteGroupeSelected && cg.id === composanteGroupeSelected.id  }"
                  v-for="cg in composanteGroupesDefault"
                  :key="cg.id"
              >
                <td @click="selectComposanteGroupe(cg)">{{ cg.libelle }} </td> <td style="width:25px;" @click="deleteGroup(cg)"><i class="icon fa fa-trash" style="color: red!important;" aria-hidden="true"></i></td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-hover">
              <th>Attribué</th>
              <tbody>
              <tr
                  v-if="composanteGroupeSelected"
                  v-for="c in cgSelectedComposantes"
                  :key="c.id"
                  @click="removeComposante(c)">
                <td>{{ c.libelle }} <i class="icon fa fa-minus" aria-hidden="true"></i></td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-hover">
              <th>Non Attribué</th>
              <tbody>
              <tr
                  v-if="composanteGroupeSelected"
                  v-for="c in cToAdd"
                  :key="c.id"
                  @click="addComposante(c)"
              >
                <td>{{ c.libelle }} <i class="icon fa fa-plus" aria-hidden="true"></i></td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        props: {

        },
        data() {
            return {
              composantesDefault: [],
              composanteGroupesDefault: [],
              gestionnaires: [],
              gestionnaireSelected: {
                composanteGroupes: []
              },
              composanteGroupeSelected: {
                composantes: []
              },
              nameGroupToAdd: "",
              searchCgNonA: "",
              searchCgA: ""
            };
        },
        created() {
          this.getComposanteGroupe()
        },
        computed: {
          cgToAdd() {
            if (this.gestionnaireSelected) {
              console.log(this.composanteGroupesDefault)
              return this.composanteGroupesDefault.filter(cg =>
                  !this.gestionnaireSelected.composanteGroupes.some((gCg) => {
                    return gCg.id === cg.id
                  })
              );
            }else {
              return [];
            }
          },
          cToAdd() {
            if (this.composanteGroupeSelected.id) {
              return this.composantesDefault.filter(item1 =>
                  (!this.composanteGroupeSelected.composantes.some(item2 => item2.id === item1.id)) && (item1.libelle.toLowerCase().includes(this.searchCgNonA.toLowerCase()))
              );
            }else {
              return [];
            }
          },
          cgSelectedComposantes() {
              return this.composanteGroupeSelected.composantes.filter(item1 =>
                  item1.libelle.toLowerCase().includes(this.searchCgA.toLowerCase())
              );
          },
        },
        methods: {
          selectGestionnaire(gestionnaire) {
            this.gestionnaireSelected = gestionnaire;
          },
          selectComposanteGroupe(cg) {
            this.composanteGroupeSelected = cg;
          },
          addComposante(c) {
            this.composanteGroupeSelected.composantes.push(c)
            unicaenVue.axios.post(
                unicaenVue.url("configuration/addComposanteToGroup"),
                {composanteGroup: this.composanteGroupeSelected, composante: c}
            ).then(response => {
              this.getComposanteGroupe()
            })
          },
          removeComposante(c) {
            const index = this.composanteGroupeSelected.composantes.findIndex(group => group.id === c.id);
            if (index !== -1) {
              this.composanteGroupeSelected.composantes.splice(index, 1);
            }
            unicaenVue.axios.post(
                unicaenVue.url("configuration/removeComposanteToGroup"),
                {composanteGroup: this.composanteGroupeSelected, composante: c}
            ).then(response => {
              this.getComposanteGroupe()
            })
          },
          addComposanteGroupe(cg) {
            this.gestionnaireSelected.composanteGroupes.push(cg)
            unicaenVue.axios.post(
                unicaenVue.url("configuration/addAttribution"),
                {user: this.gestionnaireSelected, cg: cg}
            ).then(response => {
              if(!response.data.error) {
                this.getComposanteGroupe()
              }else {
                throw response.data
              }
            })
          },
          removeComposanteGroupe(composanteGroup) {
            const index = this.gestionnaireSelected.composanteGroupes.findIndex(cg => cg.id === composanteGroup.id);
            if (index !== -1) {
              this.gestionnaireSelected.composanteGroupes.splice(index, 1);
            }
            unicaenVue.axios.post(
                unicaenVue.url("configuration/removeAttribution"),
                {user: this.gestionnaireSelected, cg: composanteGroup}
            ).then(response => {
              if(!response.data.error) {
                this.getComposanteGroupe()
              }else {
                throw response.data
              }
            })
          },
          getComposanteGroupe() {
            unicaenVue.axios.get(
                unicaenVue.url("configuration/getDataComposanteGroup")
            ).then(response => {
              if(!response.data.error) {
                let data = response.data
                console.log(data)
                this.gestionnaires = data.gestionnaires
                // this.composanteGroupesDefault = data.composanteGroupesDefault
                this.composanteGroupesDefault = Array.isArray(data.composanteGroupesDefault)
                    ? data.composanteGroupesDefault
                    : Object.values(data.composanteGroupesDefault);
                this.composantesDefault = Array.isArray(data.composantesDefault)
                    ? data.composantesDefault
                    : Object.values(data.composantesDefault);
              }else {
                throw response.data
              }
            })
          },
          postAttribution(user, cg) {

          },
          addGroup() {
            if(!this.nameGroupToAdd) {
              return
            }
            unicaenVue.axios.post(
                unicaenVue.url("configuration/addGroup"),
                {name: this.nameGroupToAdd}
            ).then(response => {
              this.getComposanteGroupe()
            })
          },
          deleteGroup(composanteGroup) {
            if(!composanteGroup) {
              return
            }
            unicaenVue.axios.delete(
                unicaenVue.url(`configuration/deleteGroup/${composanteGroup.id}`)
            ).then(response => {
              this.getComposanteGroupe()
            })
          }
        }
    };
</script>


<style scoped>
table tr {
  cursor: pointer;
}
table .active {
  background: #52d13b;
}
table .active tr:hover {
  background: #52d13b!important;
}
.icon {
  float: right!important;
}
</style>