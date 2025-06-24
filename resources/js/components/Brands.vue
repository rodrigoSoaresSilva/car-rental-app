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
                                >
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <button type="submit" class="btn btn-primary btn-sm float-end">Search</button>
                    </template>
                </card-component>

                <card-component title="Brands">
                    <template v-slot:content>
                        <table-component></table-component>
                    </template>
                    <template v-slot:footer>
                        <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalBrand">Add</button>
                    </template>
                </card-component>
            </div>
        </div>
        <modal-component id="modalBrand" title="Add Brand">
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
                            type="number"
                            class="form-control"
                            id="inputNewBrandName"
                            aria-describedby="newBrandNameHelp"
                            placeholder="Brand's name"
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
                        >
                        </input-container-component>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </template>
        </modal-component>
    </div>
</template>

<script>
    
</script>
