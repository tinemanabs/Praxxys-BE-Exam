<template>
    <div>
        <div v-show="currentStep === 1"
            class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="mb-6">
                <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                    Name</label>
                <input type="text" id="default-input"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>


            <div class="w-full mx-auto mb-6">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                    option</label>
                <select id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a country</option>
                    <option value="c1">Category 1</option>
                    <option value="c2">Category 1</option>
                    <option value="c3">Category 1</option>
                    <option value="c4">Category 4</option>
                </select>
            </div>

            <div class="w-full mb-6">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <vue-editor v-model="content" />
            </div>
                

        </div>

        <div v-show="currentStep === 2"
            class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            STEP 2
        </div>

        <div v-show="currentStep === 3"
            class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            STEP 3
        </div>

        <div class="flex justify-between items-center mt-4">
            <button type="button" v-show="currentStep === 2 || currentStep === 3" @click="prevStep"
                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Previous</button>

            <button type="button" v-show="currentStep == 1 || currentStep === 2" @click="nextStep"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Next</button>

            <button type="button" v-show="currentStep === 3" @click="submitForm"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Submit</button>
        </div>
    </div>
</template>

<script>
import { VueEditor } from "vue2-editor";
export default {

    data() {
        return {
            currentStep: 1,
            content: '',
            loading: false
        }
    },
    mounted() {
        console.log("Product Create Mounted")
    },
    methods: {
        nextStep() {
            if(this.currentStep == 1){
                if(this.content == '') {
                    console.log('error')
                } else {
                    this.currentStep++;
                }
            }
        },
        prevStep() {
            this.currentStep--;
        },
        submitForm() {
            console.log('Form Submitted')
        }
    }
}
</script>