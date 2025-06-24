<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Brand's search</div>

                    <div class="card-body">
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
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm float-end">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    
</script>
