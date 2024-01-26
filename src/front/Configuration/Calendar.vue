<template>
  <div class="container mt-4">
    <h2>Calendrier - Ouverture des inscriptions</h2>
    <div class="row mt-2">
      <div class="col">
        <h3>Année
          <span class="pointer" @click="changeYear('previous')">
            <i class="fa-solid fa-arrow-left"></i>
          </span>
          {{yearSelectedLibelle}}
          <span class="pointer" @click="changeYear('next')">
            <i class="fa-solid fa-arrow-right"></i>
          </span>
       </h3>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNewPeriod">Nouvelle période</button>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col">
        <table class="table table-bordered tablePeriods">
          <thead>
            <tr>
              <th scope="col">Date de début</th>
              <th scope="col">Date de fin</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="period in currentPeriods" :key="period.id">
              <td>{{formatDate(period.startDate)}}</td>
              <td>{{formatDate(period.endDate)}}</td>
              <td>
                <span @click="selectPeriod(period)" class="pointer" data-bs-toggle="modal" data-bs-target="#modalUpdatePeriod">
                  <i class="fa-2x fa-solid fa-pen-to-square"></i>
                </span>
                <span @click="selectPeriod(period)" class="pointer" data-bs-toggle="modal" data-bs-target="#modalDeletePeriod">
                  <i class="fa-2x fa-solid fa-trash-can red"></i>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal fade" id="modalUpdatePeriod" tabindex="-1" aria-labelledby="modalUpdatePeriod" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier la période</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col" v-if="selectedPeriod">
                <form method="POST" action="calendarUpdate">
                  <div class="form-control">
                    <label for="startDateUpdate" class="form-label">Date de début</label>
                    <input v-model="selectedPeriod.startDate" class="form-control form-control-lg" name="startDateUpdate" id="startDateUpdate" type="date">
                  </div>
                  <div class="form-control">
                    <label for="endDateUpdate" class="form-label">Date de fin</label>
                    <input v-model="selectedPeriod.endDate" class="form-control form-control-lg" name="endDateUpdate" id="endDateUpdate" type="date">
                  </div>
                  <div class="form-control">
                    <input type="hidden" name="periodId" :value="selectedPeriod.id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="m-1 btn btn-primary">Modifier</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalNewPeriod" tabindex="-1" aria-labelledby="modalNewPeriod" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalNewPeriodLabel">Nouvelle période</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col">
                <form method="POST" action="calendarNew">
                  <div class="form-control">
                    <label for="startDateNew" class="form-label">Date de début</label>
                    <input class="form-control form-control-lg" name="startDateNew" id="startDateNew" type="date">
                  </div>
                  <div class="form-control">
                    <label for="endDateNew" class="form-label">Date de fin</label>
                    <input class="form-control form-control-lg" name="endDateNew" id="endDateNew" type="date">
                  </div>
                  <div class="form-control" v-if="currentCalendar">
                    <input type="hidden" name="calendarId" :value="currentCalendar.id">
                    <input type="hidden" name="calendarYear" :value="currentCalendar.year">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="m-1 btn btn-primary">Ajouter</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalDeletePeriod" tabindex="-1" aria-labelledby="modalDeletePeriod" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Supprimer la période d'ouverture</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" v-if="selectedPeriod">
            <div class="row">
              <div class="col">
                Voulez-vous vraiment supprimer la période ?
              </div>
            </div>
            <div class="row">
              <form method="POST" action="calendarDelete">
                <div class="form-control">
                  <input type="hidden" name="periodId" :value="selectedPeriod.id">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="m-1 btn btn-danger">Supprimer</button>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    calendars: {
      type: Array
    }
  },
  data() {
    return {
      yearSelected: new Date().getFullYear(),
      selectedPeriod: null
    };
  },
  created() {
    console.log(this.calendars)
  },
  computed: {
    yearSelectedLibelle() {
      return this.getCurrentYearLibelle();
    },
    currentPeriods() {
      let calendar = this.currentCalendar
      return calendar.periods;
    },
    currentCalendar() {
      let calendar = this.calendars.find(calendar => calendar.year === this.yearSelected);
      if(!calendar) {
        calendar = {
          id: null,
          periods: [],
          year: this.yearSelected
        }
      }
      return calendar
    }
  },
  methods: {
    getCurrentYearLibelle() {
      let currentYear = this.yearSelected
      let libelle = currentYear + "/" + (currentYear + 1);
      return libelle;
    },
    changeYear(direction) {
      let currentYear = this.yearSelected
      if (direction === "previous") {
        currentYear--;
      } else {
        currentYear++;
      }
      this.yearSelected = currentYear;
    },
    selectPeriod(period) {
      this.selectedPeriod = period;
    },
    formatDate(dateString) {
      let date = new Date(dateString)
      return date.toLocaleDateString('fr-FR');
    }
  }
};
</script>
<style>
.pointer {
  cursor: pointer;
}
.tablePeriods tr{
  cursor: default;
}
.red {
  color: red;
}
</style>