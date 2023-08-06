<template>

    <div>
        <div class="card border-0 rounded shadow">
            <div class="card-body">
                <h4>TAMBAH PIC</h4>
                <hr>
                <form @submit.prevent="storePic">
                    <div class="mb-3">
                        <label class="form-label">NAMA</label>
                        <input type="text" class="form-control" v-model="pic.nama" placeholder="Masukkan Nama PIC">
                        <div v-if="errors.nama" class="mt-2 alert alert-danger">
                            {{ errors.nama }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">EMAIL</label>
                        <input type="text" class="form-control" v-model="pic.email" placeholder="Masukkan email PIC">
                        <div v-if="errors.email" class="mt-2 alert alert-danger">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-md shadow-sm me-2">SIMPAN</button>
                        <button type="reset" class="btn btn-warning btn-md shadow-sm">RESET</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script>
    //import layout
    import LayoutApp from '../../Layouts/App.vue'

    import { reactive } from 'vue'
    import { Inertia } from '@inertiajs/inertia'

    export default {

        //layout
        layout: LayoutApp,

        //props
        props: {
            errors: Object
        },

        //define Composition Api
        setup() {

            //state posts
            const pic = reactive({
                nama: '',
                email: ''
            })

            //function storePost
            function storePic() {
                
                //define variable 
                let nama   = pic.nama
                let email = pic.email

                //send data
                Inertia.post('/pics/', {
                    nama: nama,
                    email: email
                })
             
            }

            return {
                pic,
                storePic
            }

        }
    }
</script>
