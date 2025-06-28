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
                            :open="{visible: true, dataToggle: 'modal', dataTarget: '#modalOpenBrand'}"
                            :update="{visible: true, dataToggle: 'modal', dataTarget: '#modalUpdateBrand'}"
                            :remove="{visible: true, dataToggle: 'modal', dataTarget: '#modalRemoveBrand'}"
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
                                <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalCreateBrand">Add</button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>

        <!-- start modal create brand -->
        <modal-component id="modalCreateBrand" title="Add Brand">

            <template v-slot:alerts>
                <alert-component type="success" title="Brand created!" :details="detailsBrand" v-if="statusBrandTransaction == 'created'"></alert-component>
                <alert-component type="danger" title="Fail when trying to create Brand!" :details="detailsBrand" v-if="statusBrandTransaction == 'error'"></alert-component>
            </template>

            <template v-slot:content>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <input-container-component
                        title="Name"
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
                        title="Logo"
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
        <!-- end modal create brand -->

        <!-- start modal open brand -->
        <modal-component id="modalOpenBrand" title="Brand Details">
            <template v-slot:content>
                <input-container-component title="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component title="Name">
                    <input type="text" class="form-control" :value="$store.state.item.name" disabled>
                </input-container-component>

                <input-container-component title="">
                    <img :src="'storage/'+$store.state.item.image" v-if="$store.state.item.image">
                </input-container-component>

                <input-container-component title="Creation date">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                </input-container-component>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </template>
        </modal-component>
        <!-- end modal open brand -->

        <!-- start modal remove brand -->
        <modal-component id="modalRemoveBrand" title="Remove Brand">
            <template v-slot:alerts>
                <alert-component type="success" title="Operation succeed!" :details="$store.state.transaction" v-if="$store.state.transaction.status == 'success'"></alert-component>
                <alert-component type="danger" title="Operation error!" :details="$store.state.transaction" v-if="$store.state.transaction.status == 'error'"></alert-component>
            </template>
            <template v-slot:content v-if="$store.state.transaction.status != 'success'">
                <input-container-component title="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component title="Name">
                    <input type="text" class="form-control" :value="$store.state.item.name" disabled>
                </input-container-component>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" @click="remove()" v-if="$store.state.transaction.status != 'success'">Remove</button>
            </template>
        </modal-component>
        <!-- end modal remove brand -->

        <!-- start modal update brand -->
        <modal-component id="modalUpdateBrand" title="Edit Brand">

            <template v-slot:alerts>
                <alert-component type="success" title="Operation succeed!" :details="$store.state.transaction" v-if="$store.state.transaction.status == 'success'"></alert-component>
                <alert-component type="danger" title="Operation error!" :details="$store.state.transaction" v-if="$store.state.transaction.status == 'error'"></alert-component>
            </template>

            <template v-slot:content>
                <div class="form-group">
                    <input-container-component title="Name" id="updateName" id-help="updateNameHelp" text-help="Insert Brand's name">
                        <input type="text" class="form-control" id="updateName" aria-describedby="updateNameHelp" placeholder="Brand's name" v-model="$store.state.item.name">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component title="Logo" id="updateImage" id-help="updateImageHelp" text-help="Select an image in PNG format">
                        <input type="file" class="form-control" id="updateImage" aria-describedby="updateImageHelp" placeholder="Select an image" @change="uploadImage($event)">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="update()">Update</button>
            </template>
        </modal-component>
        <!-- end modal update brand -->
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
            remove(){
                let confirmation = confirm('Do you want to remove this brand?');
                
                if(!confirmation) return false;

                let url = this.urlBase + '/' + this.$store.state.item.id;

                let formData = new FormData();
                formData.append('_method', 'delete');

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transaction.status = 'success';
                        this.$store.state.transaction.message = 'Brand removed with success!';

                        this.getBrands();
                    })
                    .catch(errors => {
                        this.$store.state.transaction = {
                            status: 'error',
                            data: errors.response.data.errors,
                        }
                    });
            },
            update(){
                let url = this.urlBase + '/' + this.$store.state.item.id;

                let formData = new FormData();
                formData.append('_method', 'patch');
                formData.append('name', this.$store.state.item.name);

                if (this.brandLogo[0]) formData.append('image', this.brandLogo[0]);

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transaction.status = 'success';
                        this.$store.state.transaction.message = 'Brand updated with success!';

                        updateImage.value = '';
                        this.getBrands();
                    })
                    .catch(errors => {
                        this.$store.state.transaction = {
                            status: 'error',
                            data: errors.response.data.errors,
                        }
                    });
            },
        },
        mounted(){
            this.getBrands()
        }
    }
</script>
