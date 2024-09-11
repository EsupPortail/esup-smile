<template>
    <v-card>
        <v-card-title>
            <h3>Import</h3>
        </v-card-title>
        <v-card-text>
            <v-row>
                <v-col>
                    <v-text-field label="Url de smile-connect" v-model="urlApi" ></v-text-field>
                </v-col>
                <v-col>
                    <v-btn color="primary" @click="parseCatalogue" >Import</v-btn>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
    <v-card>
        <v-card-title>
            <h3>Result</h3>
        </v-card-title>
        <v-card-text>
            <v-row>
                <v-data-table
                    :items="items"
                    item-key="name"
                    :loading="loading"
                >
                    
                </v-data-table>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { ref } from 'vue';

const items = ref([]);
const loading = ref(false);
const urlApi = ref('');

defineProps({
    nCourses: {
        type: Number,
        required: true,
    },
    nComposantes: {
        type: Number,
        required: true,
    },
    nFormations: {
        type: Number,
        required: true,
    },
});

const parseCatalogue = async () => {
    loading.value = true;
    const response = await fetch('/import/parseCatalogue', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({urlApi: urlApi.value}),
    });
    const res = await response.json();
    console.log(res.data)
    items.value = res.data;
    loading.value = false;
};
</script>