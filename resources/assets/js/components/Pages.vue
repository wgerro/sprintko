<template>
    <div class="table-responsive">
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Robots</th>
                    <th>Active</th>
                    <th>Position</th>
                    <th>Category</th>
                    <th>Widgets</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(page,index) in pages" v-bind:index="index">
                    <td>{{ index + 1}}</td>
                    <td>{{ page.name }}</td>
                    <td>{{ url_main + '/' + page.slug }}</td>
                    <td>
                        <span class="label label-success" v-if="page.robots"> <i class="fa fa-check" aria-hidden="true"></i></span>
                        <span class="label label-danger" v-else > <i class="fa fa-times" aria-hidden="true"></i></span>
                    </td>
                    <td>
                        <span class="label label-success" v-if="page.active"> <i class="fa fa-check" aria-hidden="true"></i> </span>
                        <span class="label label-danger" v-else > <i class="fa fa-times" aria-hidden="true"></i></span>
                    </td>
                    <td>{{ page.position }}</td>
                    <td><span v-if="page.category != null">{{ page.category.name }}</span><span v-else="">none</span></td>
                    <td>
                        <span class="label label-success" v-if="page.is_widgets"> <i class="fa fa-check" aria-hidden="true"></i> </span>
                        <span class="label label-danger" v-else ><i class="fa fa-times" aria-hidden="true"></i> </span>
                    </td>
                    <td>
                        <button @click="modalPositionPage(page.id, page.name, page.position, url)" class="btn btn-info" data-target="#position" data-toggle="modal"> <i class="fa fa-th-list" aria-hidden="true"></i> </button>
                        <a v-bind:href="url + '/edit/' + page.id" class="btn btn-success"><i class="fa fa-pencil"></i></a> 
                        
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" @click="modalDeletePage(page.id,page.name,url)" data-target="#delete" ><i class="fa fa-minus"></i></button>
                        

                    </td>
                </tr>                                                      
            </tbody>                             
        </table>
    </div>  
</template>

<script>

    export default {
        
        data: function(){
            return {
                pages: [],
                id: 0,
                name: 0,
                page: '',
            }
        },
        methods: {
            getPages: function(){
                $.getJSON('pages/json', function(data){
                    this.pages = data;
                }.bind(this));
                $('#ukryj').hide();
            },
            modalPositionPage: function(id,name,position,url1){
                this.$parent.modalPosPage(id,name,position,url1);
            },
            modalDeletePage: function(id,name,url){
                
                this.$parent.modalDelPage(id,name,url);
            }
            
        },
        mounted(){
            console.log('adasdasdasdasdasdas');
            this.getPages();
        },
        props: ['url', 'url_main'],
        
    }
</script>
