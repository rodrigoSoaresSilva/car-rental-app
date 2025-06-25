<template>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th v-for="title, key in titles" :key="key" scope="col">{{ title.title }}</th>
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
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['data', 'titles']
    }
</script>
