<template>

    <div>
        <div class="card border-0 rounded shadow">
            <div class="card-body">
                <h4>EDIT PIC</h4>
                <hr>
                <form @submit.prevent="updatePic">
                    <div class="mb-3">
                        <label class="form-label">NAMA</label>
                        <input type="text" class="form-control" v-model="pic.nama" placeholder="Masukkan Nama">
                        <div v-if="errors.nama" class="mt-2 alert alert-danger">
                            {{ errors.nama }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" v-model="pic.email" placeholder="Masukkan email">
                        <div v-if="errors.content" class="mt-2 alert alert-danger">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-md shadow-sm me-2">UPDATE</button>
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
            pic: Object,
            errors: Object
        },

        //define Composition Api
        setup(props) {

            //state posts
            const pic = reactive({
                nama: props.pic.nama,
                email: props.pic.email
            })

            //function updatePost
            function updatePic() {
                
                //define variable 
                let nama   = pic.nama
                let email = pic.email

                //send data
                Inertia.put(`/pics/${props.pic.id}`, {
                    nama: nama,
                    email: email
                })
             
            }

            return {
                pic,
                updatePic
            }

        }
    }
</script>
