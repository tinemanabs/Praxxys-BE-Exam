<template>
    <div>
        <div v-show="currentStep === 1" class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow">
            <div v-show="hasError1"
                class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50"
                role="alert">
                <span class="font-medium">Error!</span> Please complete the form.
            </div>

            <div class="mb-6">
                <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900">Product
                    Name</label>
                <input v-model="product_name" type="text" id="default-input"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>


            <div class="w-full mx-auto mb-6">
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Select Category</label>
                <select v-model="product_category" id="category"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option v-for="category in categories" :value="category.value" :key="category.value">{{
            category.label }}</option>
                </select>
            </div>

            <div class="w-full mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                <vue-editor v-model="product_description" />
            </div>
        </div>

        <div v-show="currentStep === 2" class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow">
            <div v-show="hasError2"
                class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50"
                role="alert">
                <span class="font-medium">Error!</span> Please upload an image.
            </div>

            <div v-show="saved_images.length != 0">
                <label class="block mb-2 text-sm font-medium text-gray-900" for="multiple_files">Saved images</label>
                <div class="grid grid-cols-1 md:grid-cols-2 mb-6" v-for="productImages in saved_images">
                    <img :src="'/images/products/' + productImages.filename" alt="">
                    <div class="flex justify-center items-center">

                        <button type="button" @click="removeImage(productImages.id)"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                            Remove
                        </button>
                    </div>

                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900" for="multiple_files">Upload
                    multiple files</label>
                <input @change="uploadImage"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                    id="multiple_files" type="file" multiple accept="image/*">
            </div>
        </div>

        <div v-show="currentStep === 3" class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow">
            <div class="mb-6">
                <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900">Date and Time</label>
                <input v-model="product_date_time" type="datetime-local" id="default-input"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
        </div>

        <div class="flex justify-between items-center mt-4">
            <button type="button" v-show="currentStep === 1" @click="cancelBtn"
                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Cancel</button>

            <button type="button" v-show="currentStep === 2 || currentStep === 3" @click="prevStep"
                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Previous</button>

            <button type="button" v-show="currentStep == 1 || currentStep === 2" @click="nextStep"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Next</button>

            <button type="button" v-show="currentStep === 3" @click="submitForm"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Submit</button>
        </div>
    </div>
</template>

<script>
import { VueEditor } from "vue2-editor";
import axios from 'axios';

export default {
    props: ['product'],

    data() {
        return {
            currentStep: 1,
            product_id: '',
            product_name: '',
            product_category: '',
            product_description: '',
            product_images: [],
            saved_images: [],
            product_date_time: '',
            hasError1: false,
            hasError2: false,
            categories: [ 
                { label: 'Category 1', value: 'C1' },
                { label: 'Category 2', value: 'C2' },
                { label: 'Category 3', value: 'C3' },
                { label: 'Category 4', value: 'C4' },
            ]
        }
    },
    mounted() {
        if (this.product) {
            this.product_id = this.product.id;
            this.product_name = this.product.product_name;
            this.product_category = this.product.product_category;
            this.product_description = this.product.product_description;
            this.product_date_time = this.product.product_date_time;
            this.saved_images = this.product.product_images;
        }
    },
    methods: {
        cancelBtn() {
            window.location.replace('/home')
        },
        nextStep() {
            if (this.currentStep == 1) {
                if (this.product_name == '' || this.product_category == '' || this.product_description == '') {
                    this.hasError1 = true;
                } else {
                    this.hasError1 = false;
                    this.currentStep++;
                }
            } else if (this.currentStep == 2) {
                if (this.product_images == '' && this.saved_images.length == 0) {
                    this.hasError2 = true;
                } else {
                    this.hasError2 = false;
                    this.currentStep++;
                }
            }
        },
        prevStep() {
            this.currentStep--;
        },
        uploadImage(e) {
            let images = e.target.files.length;
            for (let i = 0; i < images; i++) {
                this.product_images.push(e.target.files[i])
            }
        },
        removeImage(prodImageId) {
            axios.post(`/api/products/remove-image/${prodImageId}`)
                .then((response) => {
                    console.log(response.data)
                    location.reload()
                })
                .error((error) => {
                    console.log(error)
                })
        },
        submitForm() {
            const formdata = new FormData();

            formdata.append('id', this.product_id)
            formdata.append('product_name', this.product_name)
            formdata.append('product_category', this.product_category)
            formdata.append('product_description', this.product_description)
            formdata.append('product_date_time', this.product_date_time)

            this.product_images.map((image) => (
                formdata.append('product_images[]', image)
            ))

            console.log([...formdata])

            axios.post(`/api/products/update/${this.product_id}`, formdata)
                .then((response) => {
                    console.log(response.data)
                    window.location.replace('/home')
                })
                .catch((error) => {
                    console.log(error)
                })

        }
    }
}
</script>