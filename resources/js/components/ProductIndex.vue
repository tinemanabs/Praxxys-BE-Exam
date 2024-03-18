<template>
    <div>
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-2xl font-bold dark:text-white">Products List</h4>
            <button v-on:click="redirectCreate" type="button"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center inline-flex items-center me-2">
                <svg class="w-5 h-5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14m-7 7V5" />
                </svg>
                Create
            </button>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Data and Time
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="value in products">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ value.product_name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ value.product_description }}
                        </td>
                        <td class="px-6 py-4">
                            {{ value.product_category }}
                        </td>
                        <td class="px-6 py-4">
                            {{ value.product_date_time }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            products: []
        }
    },
    methods: {
        redirectCreate() {
            window.location.replace('/products/create')
        }
    },
    created() {
        axios.get('/api/products/all')
            .then((response) => {
                console.log(response.data.products)
                this.products = response.data.products
            })
            .catch((error) => {
                console.log(error)
            })
    },
    mounted() {
        console.log("Component mounted.");
    },
};
</script>
