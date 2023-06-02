<template>
    <div v-if="active" class="fixed top-0 right-0 w-full h-full bg-[#202124] ">
        <div class="flex p-3 bg-white dark:bg-[#202124] border-b border-gray-400">
            <button class="mr-3" @click="active = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="m-3" width="30" height="30" fill="#fff" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
            </button>
            <input ref="myInput" type="text" v-model="country" @input="searchAirports" class=" text-[20px] block w-full text-white dark:bg-[#202124] focus:outline-none" :placeholder="placeholder">
        </div>
        <div class="overflow-y-auto h-full">
            <button  v-for="airport in airports" :key="airport.code" @click="selectAirport(airport)" class="w-full p-3 flex align-content-center hover:bg-gray-700">
                <div class="mr-3">
                    <svg class="m-3" width="20" height="20" fill="#fff" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
                </div>
                <div class="text-white text-[18px] text-left">
                    <div class="flex">
                        <div class="mr-2">{{ airport.name }}</div> <div>({{ airport.code }})</div>
                    </div>
                    <div class="text-[12px] text-gray-400">
                        {{ airport.countryName }}
                    </div>
                </div>
            </button>
        </div>

    </div>

    <div v-else >
        <div class="p-3 bg-white border border-gray-200 rounded-lg shadow dark:bg-[#202124] dark:border-gray-400 ">
            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-[#202124] dark:border-gray-400 ">
                <div class="flex p-2">
                    <div class="w-full">
                        <input type="text" v-model="selectedCountry[0]" @click="searchOpen(0)"  class="rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="¿Desde dónde?" required>
                    </div>
                    <button class="ml-3 mr-3">
                        <svg width="20" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M438.6 150.6c12.5-12.5 12.5-32.8 0-45.3l-96-96c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.7 96 32 96C14.3 96 0 110.3 0 128s14.3 32 32 32l306.7 0-41.4 41.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l96-96zm-333.3 352c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 416 416 416c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0 41.4-41.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-96 96c-12.5 12.5-12.5 32.8 0 45.3l96 96z"/></svg>
                    </button>
                    <div class="w-full">
                        <input type="text" v-model="selectedCountry[1]"  @click="searchOpen(1)" class="rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="¿A dónde quieres ir?" required>
                    </div>
                </div>
                <div class="flex p-2">
                    <div class="w-full mr-3">
                        <input type="date" v-model="departureDate" class=" rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="¿Desde dónde?" required>
                    </div>
                    <div class="w-full">
                        <input type="date" v-model="returnDate"  class="rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="¿A dónde quieres ir?" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-center mb-2">
            <button v-if="code.length == 2" @click="login()" type="button" class="flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <svg width="20" fill="#fff" class="mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                Explorar
            </button>
            <div v-else type="button" class="flex text-white hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-blue-800">
                <svg width="20" fill="#fff" class="mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                Explorar
            </div>
        </div>
        <div>
            <div v-if="error">{{ error }}</div>
            <div  v-if="flightOffers.data && flightOffers.data.length > 0">
                <div class="mb-4 text-1 flex leading-none tracking-tight text-gray-800 dark:text-white">
                    Viaje desde <div class="font-bold text-white ml-2 mr-2">{{ selectedCountry[0] }}</div> hasta  <div class="font-bold text-white ml-2 mr-2">{{ selectedCountry[1] }}</div>
                </div>

                <div v-for="offer in flightOffers.data" :key="offer.id" class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-[#202124] dark:border-gray-400 mb-3">
                    <div class="text-white text-1">
                        <div v-if="isLoading">Cargando...</div>
                        <div v-else>
                          <span v-if="searchAirlineData[offer.validatingAirlineCodes[0]]">
                            {{ searchAirlineData[offer.validatingAirlineCodes[0]] }}
                          </span>
                                                <span v-else>
                            {{ getAirlineName(offer.validatingAirlineCodes[0]) }}
                          </span>
                        </div>
                        
                    </div>
                    <div class="flex justify-end">
                        <div class="text-1 leading-none tracking-tight text-gray-900 dark:text-white">
                            {{ currencyCode + ' ' + offer.price.total }}
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-center mb-2">
                    <button type="button"  class="flex text-sm px-5 py-2.5 mr-2 mb-2 text-white bg-white border border-gray-200 rounded-lg shadow dark:bg-[#202124] dark:border-gray-400">Ver Más </button>
                </div>
            </div>
            <div v-else>
                <div v-if="loading == true" class="flex justify-center w-full py-3.5">
                    <svg class="animate-spin mr-3" fill="#fff" width="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H464c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0s-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3s163.8-62.5 226.3 0L386.3 160z"/></svg>
                </div>
                <div  class="text-white text-center" v-else-if="flightOffers.data && flightOffers.data.length == 0">
                    No se encontraron resultados
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            country: null,
            airports: [],
            selectedCountry: [],
            active : false,
            code : [
                'SDQ',
                'JFK'
            ],
            index : 0,
            isLoading: false,
            placeholder : null,
            searchAirlineData: {},
            options : 0,
            accessToken: '',
            originLocationCode: 'SDQ',
            destinationLocationCode: 'JFK',
            departureDate: '2023-07-07',
            returnDate: '2023-07-11',
            adults: 2,
            max: 10,
            currencyCode: 'DOP',
            flightOffers: {},
            error: null,
            locations: {},
            loading : false
        };
    },
    mounted() {

    },
    methods: {
        formatFlightDuration(duration) {
            if (isNaN(duration)) {
                return 'No disponible';
            }

            const hours = Math.floor(duration / 60);
            const minutes = duration % 60;

            if (hours === 0) {
                return `${minutes} min`;
            } else if (minutes === 0) {
                return `${hours} h`;
            } else {
                return `${hours} h ${minutes} min`;
            }
        },
        async getAirlineName(code) {
            if (this.searchAirlineData[code]) {
                return this.searchAirlineData[code];
            } else {
                try {
                    this.isLoading = true;
                    const response = await axios.get('http://appflights.test/api/airline', {
                        params: {
                            code: code
                        }
                    });
                    const name = response.data.Airline;
                    this.searchAirlineData[code] = name;
                    this.isLoading = false;
                    return name;
                } catch (error) {
                    console.log(error);
                    this.isLoading = false;
                    return 'Error al obtener el nombre de la aerolínea';
                }
            }
        },
        searchAirline(code) {
            return new Promise((resolve, reject) => {
                axios.get('http://appflights.test/api/airline', {
                    params: {
                        code: code
                    }
                })
                    .then(response => {
                        resolve(response.data.Airline);
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error);
                    });
            });
        },
        searchAirports() {
            axios.get('http://appflights.test/api/airports', {
                params: {
                    country: this.country
                }
            })
                .then(response => {
                    this.airports = response.data;
                    this.selectedCountry[this.index] = null;
                })
                .catch(error => {
                    console.log(error);
                });

            if (this.country !== '') {
                this.selectedCountry[this.index] = this.country;
            }
        },
        selectAirport(value) {
            this.selectedCountry[this.index] = value.name;
            this.code[this.index] = value.code;
            this.active = false;
        },
        searchOpen (index){
            this.active = true;
            const placeholders = [
                '¿Desde dónde?',
                '¿A dónde quieres ir?'
            ];
            this.country = '';
            this.placeholder = placeholders[index];
            this.index = index;
            setTimeout(() => {
                this.$refs.myInput && this.$refs.myInput.focus();
            }, 200);
        },
        login() {
            this.loading = true;
            this.flightOffers = {};
            const clientId = 'FGnAfp2G2IAnhr1KHtY10GSzOQusd9VZ';
            const clientSecret = 'MOF6wQxBlkXHWxob';
            const url = 'https://test.api.amadeus.com/v1/security/oauth2/token';

            const params = new URLSearchParams();
            params.append('grant_type', 'client_credentials');
            params.append('client_id', clientId);
            params.append('client_secret', clientSecret);

            axios.post(url, params)
                .then(response => {
                    this.accessToken = response.data.access_token;
                    this.getFlightOffers();
                })
                .catch(error => {
                    this.error = error.message;
                });
        },
        getFlightOffers() {
            const url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
            const params = {
                originLocationCode: this.code[0],
                destinationLocationCode: this.code[1],
                departureDate: this.departureDate,
                returnDate: this.returnDate,
                adults: this.adults,
                max: this.max,
                currencyCode: this.currencyCode,
            };

            axios
                .get(url, {
                    headers: {
                        Authorization: `Bearer ${this.accessToken}`,
                    },
                    params: params,
                })
                .then((response) => {
                    this.flightOffers = response.data;
                    this.loading = false;
                })
                .catch((error) => {
                    this.error = error.message;
                });
        },
        getCityName(iataCode) {
            return this.locations[iataCode]?.cityCode || iataCode;
        },
        formatDate(date) {
            const formattedDate = new Date(date);
            return formattedDate.toLocaleDateString();
        },
    }
};
</script>
