<template>
    <div class="mt-5">
        <!-- flash message -->
        <div v-if="$page.props.flash.message" class="alert alert-success" role="alert">
            {{ $page.props.flash.message }}
        </div>
        <!-- flash message -->
        <div class="mb-3">
            <inertia-link href="/pics/create" class="btn btn-md btn-primary">TAMBAH DATA</inertia-link>
        </div>
        <div class="card border-0 rounded shadow-sm">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NAMA</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pic in pics" :key="pic.id">
                            <td>{{ pic.nama }}</td>
                            <td>{{ pic.email }}</td>
                            <td class="text-center">
                                <inertia-link :href="`/pics/${pic.id}/edit`" class="btn btn-sm btn-primary me-2">EDIT</inertia-link>
                                <button @click.prevent="deletePic(`${pic.id}`)" class="btn btn-sm btn-danger">DELETE</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutApp from '../../Layouts/App.vue'

    import { Inertia } from '@inertiajs/inertia'

    export default {

        //layout
        layout: LayoutApp,

        //props
        props: {
            pics: Array // <- nama props yang dibuat di controller saat parsing data
        },

        //define Composition Api
        setup() {

            //method deletePost
            function deletePic(id) {
                
                Inertia.delete(`/pics/${id}`)

            }

            return {
                deletePic
            }

        }
    }
</script>

<style>

</style>