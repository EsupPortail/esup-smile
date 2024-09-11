<template>
  <div class="container mt-4">
    <h2 class="headTitle">{{ stringTranslation['inscription'] }}</h2>
    <v-form v-model="valid">
      <v-row>
        <v-col cols="6">
          <h3 class="titleBlue">1. {{ stringTranslation['mobilite'] }}</h3>
          <v-radio-group
              v-model="form.mobilite.value"
              :rules="rules.required"
          >
            <v-radio
                v-for="mobilite in mobilites"
                :key="mobilite.id"
                :label="mobilite.libelle"
                :value="mobilite.id"
            ></v-radio>
          </v-radio-group>
          <v-select
              v-model="form.monthArrival"
              :items="months"
              :label="stringTranslation['MonthArrival']"
              :rules="[m => !!m || 'Champ requis.']"
          ></v-select>
          <h3 class="titleBlue">3. {{ stringTranslation['filesToUpload'] }}</h3>
          <v-table>
            <thead>
            <tr>
              <th class="text-left">
                Name
              </th>
              <th class="text-left">
                File
              </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="td in typedocumentsToShow"
                :key="td.id"
            >
              <td>{{ td.libelle }}</td>
              <td>{{  }}</td>
            </tr>
            </tbody>
          </v-table>
        </v-col>
        <v-col>
          <h3 class="titleBlue">2. {{ stringTranslation['checkInformation'] }}</h3>
          <v-row>
            <v-col cols="6">
              <v-text-field
                  v-model="form.firstName"
                  :label="stringTranslation['Firstname']"
                  :rules="rules.required"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                  v-model="form.lastName"
                  :label="stringTranslation['Lastname']"
                  :rules="rules.required"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-text-field
                  v-model="form.esi"
                  label="ESI"
                  :rules="rules.required"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-text-field
                  v-model="form.email"
                  label="Email"
                  :rules="[e => !!e || 'Champ requis.', e => /.+@.+\..+/.test(e) || 'Email invalide']"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-date-input
                  v-model="form.birthdate"
                  :label="stringTranslation['Birthdate']"
              ></v-date-input>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-text-field
                  v-model="form.city"
                  :label="stringTranslation['City']"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-text-field
                  v-model="form.postcode"
                  :label="stringTranslation['Postcode']"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-text-field
                  v-model="form.numStreet"
                  label="N°"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-text-field
                  v-model="form.street"
                  :label="stringTranslation['Street']"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-text-field
                  v-model="form.emailReferent"
                  :label="stringTranslation['emailReferent']"
                  :rules="[e => !!e || 'Champ requis.', e => /.+@.+\..+/.test(e) || 'Email invalide']"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-autocomplete
                  v-model="form.etablissement"
                  :items="etablissements"
                  :label="stringTranslation['Etablissement']"
                  :hint="`${(form.etablissement) ? form.etablissement.paysCode : ''}`"
                  item-title="libelle"
                  item-value="id"
                  persistent-hint
                  return-object
              ></v-autocomplete>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-checkbox
                  v-model="form.firstMobility"
                  :label="stringTranslation['firstMobility']"
                  :rules="[v => !!v || 'Champ requis.']"
              ></v-checkbox>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="6">
          <v-btn
              color="primary"
              type="submit"

          >
            Valider
          </v-btn>
        </v-col>
      </v-row>
    </v-form>
    <v-alert>
      {{ typeDocuments }} {{ form.mobilite }}
    </v-alert>
  </div>
</template>

<script setup>
import {reactive, ref, toRef, computed, toRefs} from 'vue';

const props = defineProps({
  mobilites: {
    type: Object,
    required: true
  },
  etablissements: {
    type: Object,
    required: true
  },
  inscription: {
    type: Object,
    required: true
  },
  stringTranslation: {
    type: Object,
    required: true
  },
  typeDocuments: {
    type: Object,
    required: true
  }
})

const months = ref([
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
])
let valid = ref(false);
let form = reactive({
  mobilite: props.inscription.mobilite,
  monthArrival: props.inscription.montharrival,
  firstName: props.inscription.firstname,
  lastName: props.inscription.lastname,
  email: props.inscription.email,
  esi: props.inscription.esi,
  username: props.inscription.username,
  birthdate: props.inscription.birthdate,
  city: props.inscription.city,
  postcode: props.inscription.postcode,
  street: props.inscription.street,
  numStreet: props.inscription.numstreet,
  emailReferent: props.inscription.mailreferent,
  firstMobility: props.inscription.firstmobility,
});
form = toRefs(form);
let rules = ref({
  required: [value => !!value || 'Champ requis.']
});

const typedocumentsToShow = computed(() => {
  return props.typeDocuments.filter((td) => {
    let mobilites =  td.mobilites.filter((m) => {
      return m === form.mobilite.value
    })
    return mobilites.length > 0
  })
})
defineExpose({
  typedocumentsToShow
})

</script>
