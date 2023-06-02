<template>
    <div>
        <input v-model="searchTerm" placeholder="Buscar lugar" @input="searchPlaces" />
        <ul class="text-white" v-if="filteredPlaces.length">
            <li v-for="place in filteredPlaces" :key="place.alpha2Code" @click="selectPlace(place)">
                {{ place.name }} ({{ place.iataCode }})
            </li>
        </ul>
        <p class="text-white" v-else>No se encontraron lugares</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            searchTerm: '',
            places: [],
            filteredPlaces: [],
        };
    },
    mounted() {
        this.fetchPlaces();
    },
    methods: {
        fetchPlaces() {
            axios
                .get('https://restcountries.com/v2/all') // Obtener información básica del país desde REST Countries API
                .then(response => {
                    this.places = response.data.map(country => {
                        return {
                            name: country.name,
                            alpha2Code: country.alpha2Code,
                            iataCode: '', // Dejar el código IATA inicialmente vacío
                        };
                    });
                    this.fetchIataCodes(); // Obtener los códigos IATA para cada país
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchIataCodes() {
            axios
                .get('https://api.example.com/iata-codes') // Reemplaza la URL con la URL de la fuente de datos de códigos IATA
                .then(response => {
                    const iataCodes = response.data;
                    // Actualizar los códigos IATA en la lista de lugares
                    this.places.forEach(place => {
                        const iataCode = iataCodes.find(code => code.country === place.name);
                        if (iataCode) {
                            place.iataCode = iataCode.code;
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        },
        searchPlaces() {
            this.filteredPlaces = this.places.filter(place =>
                place.name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                place.iataCode.toLowerCase() === this.searchTerm.toLowerCase()
            );
        },
        selectPlace(place) {
            console.log(place.iataCode);
        },
    },
};
</script>
