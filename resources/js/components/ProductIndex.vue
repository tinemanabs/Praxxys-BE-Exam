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

        <div class="flex justify-between mb-4">
            <div>
                <select v-model="selectedCategory" id="category"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2">
                    <option value="">All Categories</option>
                    <option v-for="category in categories" :value="category">{{ category }}</option>
                </select>
            </div>

            <div class="max-w-lg">
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" v-model="searchKeyword" id="default-search"
                        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search" />
                </div>
            </div>
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
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        v-for="value in displayedProducts">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ value.product_name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ value.product_category }}
                        </td>
                        <td class="px-6 py-4" v-html="value.product_description">
                        </td>
                        <td class="px-6 py-4">
                            {{ value.product_date_time }}
                        </td>
                        <td class="px-6 py-4">
                            <button @click="editProduct(value.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                            <button @click="deleteProduct(value.id)"
                                class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination controls -->

        <div class="flex justify-between items-center mt-4">
            <buttton v-if="currentPage > 1" @click="prevPage"
                class="flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 5H1m0 0 4 4M1 5l4-4" />
                </svg>
                Previous
            </buttton>
            <span>Page {{ currentPage }}</span>

            <buttton v-if="hasNextPage" @click="nextPage"
                class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                Next
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </buttton>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            searchKeyword: '',
            selectedCategory: '',
            products: [],
            categories: ['c1', 'c2', 'c3', 'c4'], // Example categories
            currentPage: 1,
            itemsPerPage: 10, // Number of products per page
        }
    },
    methods: {
        redirectCreate() {
            window.location.replace('/products/create')
        },

        fetchProducts() {
            axios.get('/api/products/all')
                .then((response) => {
                    console.log(response.data.products)
                    this.products = response.data.products
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.hasNextPage) {
                this.currentPage++;
            }
        },
        editProduct(productId) {
            window.location.replace(`/products/${productId}`)
        },
        deleteProduct(productId) {
            axios.post(`/api/products/delete/${productId}`)
                .then((response) => {
                    location.reload();
                })
        }
    },
    computed: {
        // Check if there are more pages after the current one
        hasNextPage() {
            return this.currentPage * this.itemsPerPage < this.products.length;
        },
        // Calculate the index of the first product to display on the current page
        startIndex() {
            return (this.currentPage - 1) * this.itemsPerPage;
        },
        // Calculate the index of the last product to display on the current page
        endIndex() {
            return this.currentPage * this.itemsPerPage;
        },
        // Slice the products array to display only the products for the current page
        displayedProducts() {
            let filtered = this.filteredProducts;

            // Paginate the filtered products
            filtered = filtered.slice(this.startIndex, this.endIndex);

            return filtered;
        },
        filteredProducts() {
            let filtered = this.products;

            if (this.searchKeyword) {
                const keyword = this.searchKeyword.toLowerCase();
                filtered = filtered.filter(product => (
                    product.product_name.toLowerCase().includes(keyword) ||
                    product.product_description.toLowerCase().includes(keyword)
                ))
            }

            if (this.selectedCategory) {
                filtered = filtered.filter(product => (
                    product.product_category == this.selectedCategory
                ))
            }

            return filtered;
        }
    },
    mounted() {
        this.fetchProducts();
        console.log("Component mounted.");
    },
};
</script>
