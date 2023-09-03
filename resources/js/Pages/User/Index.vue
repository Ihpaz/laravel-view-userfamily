<template>
    <div class="mt-5">
        <!-- flash message -->
        <div v-if="$page.props.flash.message" class="alert alert-success" role="alert">
            {{ $page.props.flash.message }}
        </div>
        <!-- flash message -->
        <div class="mb-3">
            <inertia-link href="/users/create" class="btn btn-md btn-primary">TAMBAH DATA</inertia-link>
        </div>
        <div class="card border-0 rounded shadow-sm">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Nationality</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.ID">
                            <td>{{ user.Cst_name }}</td>
                            <td>{{ user.Nationality.Nationality_name }}</td>
                            <td>{{ user.Cst_dob_date }}</td>
                            <td>{{ user.Cst_email }}</td>
                            <td>{{ user.Cst_phoneNum }}</td>
                            <td class="text-center">
                                <inertia-link :href="`/users/${user.ID}/edit`" class="btn btn-sm btn-primary me-2">EDIT</inertia-link>
                                <button @click.prevent="deleteUser(`${user.ID}`)" class="btn btn-sm btn-danger">DELETE</button>
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
            users: Array // <- nama props yang dibuat di controller saat parsing data
        },

       
        //define Composition Api
        setup() {
           
            //method deletePost
            function deleteUser(id) {
                
                Inertia.delete(`/users/${id}`)

            }

            return {
                deleteUser
            }

        }
    }
</script>

<style>

</style>