<template>

    <div>
        <div class="card border-0 rounded shadow" style="margin-bottom: 15px;">
            <div class="card-body">
                <h4>Edit Project</h4>
                <hr>
                <form @submit.prevent="storeProject">
                    <div class="mb-3">
                        <label class="form-label">NAMA</label>
                        <input type="text" class="form-control" v-model="DtProject.nama" placeholder="Masukkan Nama Project">
                        <div v-if="errors.nama" class="mt-2 alert alert-danger">
                            {{ errors.nama }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">KETERANGAN</label>
                        <textarea class="form-control" v-model="DtProject.keterangan" placeholder="Masukkan keterangan">
                        </textarea>
                        <div v-if="errors.keterangan" class="mt-2 alert alert-danger">
                            {{ errors.keterangan }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-md shadow-sm me-2">UPDATE</button>
                    </div>
                </form>

                
               
        
            </div>
        </div>

        <div class="card border-0 rounded shadow">
            <div class="card-body">
               
                    <div class="mb-3">
                        <label class="form-label">Sub Project</label>
                        <input type="text" class="form-control" v-model="DtProject.subProject" placeholder="Masukkan Nama Subproject">
                        <div v-if="errors.subProject" class="mt-2 alert alert-danger">
                            {{ errors.subProject }}
                        </div>
                    </div>
                   
                    <div class="mb-3">
                        <th scope="col"><button @click.prevent="addSubProject()" class="btn btn-sm btn-danger">ADD SUB Project</button></th>
                    </div>
               
               
                  
                <table class="table"  v-for="(project,index) in DtProject.projects" :key="project.id">
                    <thead>
                        <tr>
                            <th scope="col" colspan="4" style="width: 80%;">{{ project.nama }}</th>
                            <th scope="col"><button @click.prevent="deleteSubProject(`${index}`)" class="btn btn-sm btn-danger">DELETE</button></th>
                            <th scope="col"><button @click.prevent="addDetailProject(`${index}`)"  class="btn btn-sm btn-primary">ADD Detail</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nama</td>
                            <td>StartDate</td>
                            <td>EndDate</td>
                            <td>PIC</td>
                            <td>Status</td>
                            <td></td>
                        </tr>
                        <tr v-for="(detail,index2) in project.details" :key="detail.id">
                            <td><input type="text" class="form-control" v-model="DtProject.projects[index].details[index2].nama" placeholder="Masukkan detail Subproject"></td>
                            <td><input type="date" class="form-control" v-model="DtProject.projects[index].details[index2].StartDate" ></td>
                            <td><input type="date" class="form-control" v-model="DtProject.projects[index].details[index2].EndDate" ></td>
                            <td>
                                <select class="form-control" v-model="DtProject.projects[index].details[index2].pic">
                                    <option v-for="pic in DtProject.pics" :value="pic.id" >{{ pic.nama }}</option>
                                   
                                </select>
                            </td>
                            <td><select class="form-control" v-model="DtProject.projects[index].details[index2].Status">
                                    <option value="Open">Open</option>
                                    <option value="On Progres">On Progres</option>
                                    <option value="Done">Done</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button @click.prevent="deleteDetailProject(`${index}`,`${index2}`)" class="btn btn-sm btn-danger">DELETE</button>
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
            projects: Object,
            errors: Object
        },

        //define Composition Api
        setup(props) {

           
            //state 
            const DtProject = reactive({
                nama: props.projects.nama,
                pics: props.projects.pics,
                subProject:'',
                keterangan: props.projects.keterangan,
                projects:props.projects.project
            })

            //function storeProject
            function storeProject() {
                
                //define variable 
                let nama   = DtProject.nama
                let keterangan = DtProject.keterangan
                let projects = DtProject.projects

                //send data
                Inertia.put(`/projects/${props.projects.id}`, {
                    nama: nama,
                    keterangan: keterangan,
                    projects: projects
                })
             
            }

            function addSubProject(){

                DtProject.projects.push({nama:DtProject.subProject,details:[{nama:'',StartDate:'',EndDate:'',Status:'Open',pic:''}]})
            }

            function deleteSubProject(indexToDelete){
                const  dt = DtProject.projects.splice(indexToDelete,1);
            }

            function addDetailProject(index){
                DtProject.projects[index].details.push({nama:'',StartDate:'',EndDate:'',Status:'Open',pic:''});
            }

            function deleteDetailProject(index,index2){
                const  dt = DtProject.projects[index].details.splice(index2,1);
            }

            return {
                DtProject,
                storeProject,
                addSubProject,
                deleteSubProject,
                deleteDetailProject,
                addDetailProject
            }

        }
    }
</script>
