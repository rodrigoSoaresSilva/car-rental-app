<template>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th v-for="title, key in titles" :key="key" scope="col">{{ title.title }}</th>
                <th v-if="open.visible || update.visible || remove.visible"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(obj, index) in data" :key="index">
                <td v-for="(value, key) in titles" :key="value.title + '-' + key">
                    <span v-if="value.type == 'text'">
                        {{ obj[key] }}
                    </span>
                    <span v-if="value.type == 'date'">
                        {{ formatDateTime(obj[key]) }}
                    </span>
                    <span v-if="value.type == 'image'">
                        <img :src="'/storage/' + obj[key]" width="30" height="30" alt="logo">
                    </span>
                </td>
                <td v-if="open.visible || update.visible || remove.visible">
                    <button v-if="open.visible" class="btn btn-outline-success btn-sm" :data-bs-toggle="open.dataToggle" :data-bs-target="open.dataTarget" @click="setStore(obj)">Open</button>
                    <button v-if="update.visible" class="btn btn-outline-primary btn-sm" :data-bs-toggle="update.dataToggle" :data-bs-target="update.dataTarget" @click="setStore(obj)">Edit</button>
                    <button v-if="remove.visible" class="btn btn-outline-danger btn-sm" :data-bs-toggle="remove.dataToggle" :data-bs-target="remove.dataTarget" @click="setStore(obj)">Remove</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script setup>
    import { formatDateTime } from '@/utils/date';
</script>

<script>
    export default {
        props: ['data', 'titles', 'open', 'update', 'remove'],
        methods: {
            setStore(obj) {
                this.$store.state.transaction.status = '';
                this.$store.state.transaction.message = '';
                this.$store.state.transaction.data = '';
                this.$store.state.item = obj;
            }
        }
    }
</script>
