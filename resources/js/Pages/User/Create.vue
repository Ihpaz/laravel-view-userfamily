<template>

    <div>
        <div class="card border-0 rounded shadow" style="margin-bottom: 15px;">
            <div class="card-body">
                <h4>Create User</h4>
                <hr>
                <form @submit.prevent="storeUser">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" v-model="DtUser.Cst_name" placeholder="Masukkan Nama">
                        <div v-if="errors.Cst_name" class="mt-2 alert alert-danger">
                            {{ errors.Cst_name }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nationality</label>
                        <select class="form-control" v-model="DtUser.Nationality_id">
                            <option v-for="nationality in DtUser.nationalities" :value="nationality.ID" >{{ nationality.Nationality_name }}</option>  
                        </select>
                        <div v-if="errors.Nationality_id" class="mt-2 alert alert-danger">
                            {{ errors.Nationality_id }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" v-model="DtUser.Cst_dob_date" >
                        <div v-if="errors.Cst_dob_date" class="mt-2 alert alert-danger">
                            {{ errors.Cst_dob_date }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" v-model="DtUser.Cst_email" placeholder="Masukkan Email">
                        <div v-if="errors.nama" class="mt-2 alert alert-danger">
                            {{ errors.Cst_email }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" v-model="DtUser.Cst_phoneNum" placeholder="Masukkan No Telp">
                        <div v-if="errors.nama" class="mt-2 alert alert-danger">
                            {{ errors.Cst_phoneNum }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-md shadow-sm me-2">SIMPAN</button>
                    </div>
                </form>
        
            </div>
        </div>

        <div class="card border-0 rounded shadow">
            <div class="card-body">
                
                   
                    <div class="mb-3">
                        <th scope="col"><button @click.prevent="addFamily()" class="btn btn-sm btn-danger">Tambah Keluarga</button></th>
                    </div>
               
               
                    <div v-if="errors.FamilyList" class="mt-2 alert alert-danger">
                            {{ errors.FamilyList }}
                        </div>
                <table class="table"  v-for="(family,index) in DtUser.FamilyList" :key="family.id">
                    <thead>
                        <tr>
                           <th>Nama</th>
                           <th>Tanggal Lahir</th>
                           <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control" v-model="DtUser.FamilyList[index].Fl_name" placeholder="Masukkan detail Subproject"></td>
                            <td><input type="date" class="form-control" v-model="DtUser.FamilyList[index].Fl_dob_date" ></td>
                            <td class="text-center">
                                <button @click.prevent="deleteFamily(`${index}`)" class="btn btn-sm btn-danger">DELETE</button>
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

    import { reactive } from 'vue'
    import { Inertia } from '@inertiajs/inertia'

    export default {

        //layout
        layout: LayoutApp,

        //props
        props: {
            users: Object,
            errors: Object
        },

        //define Composition Api
        setup(props) {

           
            //state 
            const DtUser = reactive({
                nationalities: props.users.nationalities,
                Cst_name: props.users.Cst_name,
                Cst_email: props.users.Cst_email,
                Cst_dob_date: props.users.Cst_dob_date,
                Cst_phoneNum: props.users.Cst_phoneNum,
                Nationality_id: props.users.Nationality_id,
                FamilyList:[]
            })

            //function storeProject
            function storeUser() {
                
                //define variable 
                let Cst_name   = DtUser.Cst_name
                let Cst_email = DtUser.Cst_email
                let Cst_dob_date = DtUser.Cst_dob_date
                let Cst_phoneNum = DtUser.Cst_phoneNum
                let Nationality_id = DtUser.Nationality_id
                let FamilyList = DtUser.FamilyList

                //send data
                Inertia.post('/users/', {
                    Cst_name: Cst_name,
                    Cst_email: Cst_email,
                    Cst_dob_date: Cst_dob_date,
                    Cst_phoneNum:Cst_phoneNum,
                    Nationality_id:Nationality_id,
                    FamilyList:FamilyList
                })
             
            }

            function addFamily(){

                DtUser.FamilyList.push({Fl_name:'',Fl_dob_date:''})
            }

            function deleteFamily(indexToDelete){
                const  dt = DtUser.FamilyList.splice(indexToDelete,1);
            }

          


            return {
                DtUser,
                addFamily,
                deleteFamily,
                storeUser
               
            }

        }
    }
</script>
