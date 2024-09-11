<template>
  <div class="row mt-2">
    <div class="col">
      <h2>Courses</h2>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-2">
      <select class="form-select" name="searchComposante" id="searchComposante" v-model="filterComposante">
        <option value="" selected>Composante</option>
        <template v-for="composante in composantes">
          <option :value="composante.id">{{ composante.libelle }}</option>
        </template>
      </select>
    </div>
    <div class="col-2">
      <input class="form-control" type="text" name="searchText" id="searchText" v-model="filterText" placeholder="Chercher Code ou Titre">
    </div>
    <div class="col-1">
      <input class="form-control" type="number" name="searchEcts" id="searchEcts" v-model="filterEcts" placeholder="ECTS">
    </div>
    <div class="col-2">
      <select class="form-select" name="searchLangue" id="searchLangue" v-model="filterLangue">
        <option value="" selected>Langues</option>
        <template v-for="langue in langues">
          <option :value="langue">{{ langue }}</option>
        </template>
      </select>
    </div>
    <div class="col-2">
      <select class="form-select" name="searchSemester" id="searchSemester" v-model="filterSemester">
        <option value="" selected>S1/S2</option>
        <option value="s1">S1</option>
        <option value="s2">S2</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-bordered" style="position: relative;" :style="{opacity: (loading) ? '0.5' : 1}">
        <thead>
        <tr>
          <th>Composante</th>
          <th>Code</th>
          <th>Title</th>
          <th>ECTS</th>
          <th>Langage</th>
          <th>S1</th>
          <th>S2</th>
          <template v-for="mobilite in mobilites">
            <th>{{ mobilite.libelle }}</th>
          </template>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="c in filteredCourses">
          <td>{{ c.composanteLibelle }}</td>
          <td>{{ c.codeElp }}</td>
          <td>{{ c.libelle }}</td>
          <td>{{ c.ects }}</td>
          <td>{{ c.langueEnseignement }}</td>
          <td>
            <div class="form-check form-switch">
              <input class="form-check-input checkS2" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                     v-model="c.s1" true-value="1" false-value="" @change="toggleSemester(c)"
              />
            </div>
          </td>
          <td>
            <div class="form-check form-switch">
              <input class="form-check-input checkS2" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                     v-model="c.s2" true-value="1" false-value="" @change="toggleSemester(c)"
              />
            </div>
          </td>
          <td>

          </td>
        </tr>
        </tbody>
        <svg v-if="loading" style="position: absolute; top: 100px;left: 40%;" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="64px" height="64px" viewBox="0 0 128 128" xml:space="preserve"><g><path d="M64 9.75A54.25 54.25 0 0 0 9.75 64H0a64 64 0 0 1 128 0h-9.75A54.25 54.25 0 0 0 64 9.75z" fill="#039dc1"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1800ms" repeatCount="indefinite"></animateTransform></g></svg>
      </table>
      <span>{{courses.length}} results</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "MonTest",
  props: {
    monId: {required: true, type: Number}
  },
  data()
  {
    return {
      contacts: [],
      courses: [],
      composantes: [],
      mobilites: [],
      langues: [],
      loading: false,
      filterSemester: '',
      filterComposante: '',
      filterText: '',
      filterEcts: '',
      filterLangue: '',
      pageSize: 30,
    };
  },
  async mounted() {
    await this.getData();
  },
  computed: {
    filteredCourses() {
      let n = 0
      console.log(this.filterComposante, this.filterSemester)
      let courses = this.courses.filter((c) => {
        let valid = true
        if(n >= this.pageSize) {
          return false
        }

        if(this.filterComposanteRes(c) &&
            this.filterSemesterRes(c) &&
            this.filterTextRes(c) &&
            this.filterEctsRes(c) &&
            this.filterLanguesRes(c)
        ) {
          valid = true
        }else {
          valid = false
        }

        if(valid) {
          n++
        }
        return valid
      })
      return courses
    }
  },
  methods: {
    toggleSemester(c) {
      console.log(c.s1, c.s2)
    },
    filterSemesterRes(c) {
      if(this.filterSemester) {
        if(this.filterSemester === "s1" && c.s1 === "1") {
          return true
        }else return this.filterSemester === "s2" && c.s2 === "1";
      }
      return true
    },
    filterComposanteRes(c) {
      if(this.filterComposante) {
        if(c.composanteId === this.filterComposante) {
          return true
        }else {
          return false
        }
      }
      return true
    },
    filterTextRes(c) {
      if(this.filterText) {
        let isCode = c.codeElp.indexOf(this.filterText) !== -1;
        let isLibelle = c.libelle.indexOf(this.filterText) !== -1;
        if(isCode || isLibelle) {
          return true
        }else {
          return false
        }
      }
      return true
    },
    filterEctsRes(c) {
      if(this.filterEcts) {
        if(parseInt(c.ects) === this.filterEcts) {
          return true
        }else {
          return false
        }
      }
      return true
    },
    filterLanguesRes(c) {
      if(this.filterLangue) {
        if(c.langueEnseignement === this.filterLangue) {
          return true
        }else {
          return false
        }
      }
      return true
    },
    getData() {
      this.loading = true

      unicaenVue.axios.get(
          unicaenVue.url("formations/test-data/:monId", {monId: this.monId})
      ).then(response => {

        if(!response.data.error) {
          console.log(response)
          this.courses = response.data.courses;
          this.composantes = response.data.composantes;
          this.langues = response.data.langues;
          this.mobilites = response.data.mobilites;
        }else {
          throw response.data
        }
      })
      .catch(error => {
        console.log("Error");
        console.log(error);
      }).finally(() => {
        console.log('finally')
        this.loading = false
      });
    }
  }
}

</script>

<style scoped>

</style>
