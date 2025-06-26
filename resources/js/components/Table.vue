<template>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th v-for="title, key in titles" :key="key" scope="col">{{ title.title }}</th>
                <th v-if="open || update || remove"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(obj, index) in data" :key="index">
                <td v-for="(value, key) in titles" :key="value.title + '-' + key">
                    <span v-if="value.type !== 'image'">
                        {{ obj[key] }}
                    </span>
                    <span v-else>
                        <img :src="'/storage/' + obj[key]" width="30" height="30" alt="logo">
                    </span>
                </td>
                <td v-if="open || update || remove">
                    <button v-if="open" class="btn btn-outline-success btn-sm">Open</button>
                    <button v-if="update" class="btn btn-outline-primary btn-sm">Edit</button>
                    <button v-if="remove" class="btn btn-outline-danger btn-sm">Remove</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['data', 'titles', 'open', 'update', 'remove']
    }
</script>
