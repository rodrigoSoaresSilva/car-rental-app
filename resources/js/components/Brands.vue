<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <card-component title="Brand's search">
                    <template v-slot:content>
                        <div class="row g-3 mb-3">
                            <div class="col">
                                <input-container-component
                                title="ID"
                                id="inputID"
                                id-help="idHelp"
                                text-help="Optional. Insert register's ID"
                                >
                                <input
                                    type="number"
                                    class="form-control"
                                    id="inputID"
                                    aria-describedby="idHelp"
                                    placeholder="ID"
                                    v-model="search.id"
                                >
                                </input-container-component>
                            </div>

                            <div class="col">
                                <input-container-component
                                title="Brand's name"
                                id="inputName"
                                id-help="nameHelp"
                                text-help="Optional. Insert brand's Name"
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="inputName"
                                    aria-describedby="nameHelp"
                                    placeholder="Brand's name"
                                    v-model="search.name"
                                >
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm float-end" @click="searchBrand()">Search</button>
                    </template>
                </card-component>

                <card-component title="Brands">
                    <template v-slot:content>
                        <table-component
                            :data="brands.data"
                            :open="true"
                            :update="true"
                            :remove="true"
                            :titles="{
                                id: {title: 'ID', type: 'text'},
                                name: {title: 'Name', type: 'text'},
                                image: {title: 'Logo', type: 'image'}
                            }">
                        </table-component>
                    </template>
                    <template v-slot:footer>
                        <div class="row">
                            <div class="col-10">
                                <pagination-component>
                                    <li v-for="link, key in brands.links" :key="key" :class="link.active ? 'page-item active' : 'page-item'" @click="paginate(link)">
                                        <a class="page-link" v-html="link.label"></a>
                                    </li>
                                </pagination-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalBrand">Add</button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>
        <modal-component id="modalBrand" title="Add Brand">

            <template v-slot:alerts>
                <alert-component type="success" title="Brand created!" :details="detailsBrand" v-if="statusBrandTransaction == 'created'"></alert-component>
                <alert-component type="danger" title="Fail when trying to create Brand!" :details="detailsBrand" v-if="statusBrandTransaction == 'error'"></alert-component>
            </template>

            <template v-slot:content>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <input-container-component
                        title="Brand's name"
                        id="inputNewBrandName"
                        id-help="NewBrandNameHelp"
                        text-help="Insert Brand's name"
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="inputNewBrandName"
                            aria-describedby="newBrandNameHelp"
                            placeholder="Brand's name"
                            v-model="brandName"
                        >
                        </input-container-component>
                    </div>
    
                    <div class="col-12">
                        <input-container-component
                        title="Brand's logo"
                        id="inputLogo"
                        id-help="logoHelp"
                        text-help="Select an image"
                        >
                        <input
                            type="file"
                            class="form-control"
                            id="inputLogo"
                            aria-describedby="logoHelp"
                            placeholder="Brand's logo"
                            @change="uploadImage($event)"
                        >
                        </input-container-component>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="saveBrand()">Save changes</button>
            </template>
        </modal-component>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        data() {
            return {
                urlBase: 'http://127.0.0.1:8000/api/v1/brand',
                urlPagination: '',
                urlFilter: '',
                brandName: '',
                brandLogo: [],
                statusBrandTransaction: '',
                detailsBrand: {},
                brands: {data: []},
                search: { id: '', name: '' },
            }
        },
        computed: {
            token(){
                let cookie = document.cookie.split(';').find(index => {
                    return index.includes('token=');;
                });

                let token = cookie.split('=');

                return 'Bearer ' + token[1];
            },
        },
        methods: {
            getBrands(){
                let url = this.urlBase + '?' + this.urlPagination + this.urlFilter;
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.get(url, config)
                .then(response => {
                    this.brands = response.data.data;
                })
                .catch(errors => {console.log(errors)})
            },
            uploadImage(e){
                this.brandLogo = e.target.files
            },
            saveBrand(){
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                let formData = new FormData();
                formData.append('name', this.brandName);
                formData.append('image', this.brandLogo[0]);

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.statusBrandTransaction = 'created';
                        this.detailsBrand = {
                            message: 'Brand ID: ' + response.data.id
                        }
                    })
                    .catch(errors => {
                        this.statusBrandTransaction = 'error';
                        this.detailsBrand = {
                            data: errors.response.data.errors
                        }
                    });
            },
            paginate(link){
                if(link.url){
                    this.urlPagination = link.url.split('?')[1];
                    this.getBrands();
                }
            },
            searchBrand(){
                let filter = '';

                for(let key in this.search){
                    if(this.search[key]){
                        if(filter != ''){
                            filter += ";";
                        }

                        filter += key + ':like:' + this.search[key];
                    }
                }

                if(filter != ''){
                    this.urlPagination = 'page=1';
                    this.urlFilter = '&filters=' + filter;
                } else {
                    this.urlFilter = '';
                }

                this.getBrands();
            },
        },
        mounted(){
            this.getBrands()
        }
    }
</script>
