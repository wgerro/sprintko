<template>
    <div class="table-responsive">
        
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(cat,index) in category" v-bind:index="index">
                    <td>{{ index + 1}}</td>
                    <td>{{ cat.name }}</td>
                    <td>{{ url + '/' + cat.slug }}</td>
                    <td>{{ cat.description }}</td>
                    <td>
                    <!-- 
                        <button @click="modalPositionPage(page.id, page.name, page.position, url)" class="btn btn-info" data-target="#position" data-toggle="modal"> <i class="fa fa-th-list" aria-hidden="true"></i> </button>
                        <a v-bind:href="url + '/edit/' + page.id" class="btn btn-success"><i class="fa fa-pencil"></i></a> 
                        
                        Trigger the modal with a button
                        <button type="button" class="btn btn-danger" data-toggle="modal" @click="modalDeletePage(page.id,page.name,url)" data-target="#delete" ><i class="fa fa-minus"></i></button>
                         -->
                        <button @click="modalCat(cat.id,cat.name,cat.description,url_main)" type="button" class="btn btn-success" data-target="#edit" data-toggle="modal"><i class="fa fa-pencil"  ></i></button>
                        <button type="button" class="btn btn-danger" data-target="#delete" data-toggle="modal"><i class="fa fa-minus" ></i></button>
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
                category: [],
                id: 0,
                name: 0,
                page: '',
            }
        },
        methods: {
            getCategory: function(){
                $.getJSON('category/json', function(data){
                    this.category = data;
                }.bind(this));
                $('#ukryj').hide();
            },
            modalCat: function(id,name,description,url1){
                this.$parent.modalCat(id,name,description,url1);
            },
            delete: function(index){
                Vue.delete(category, index);
            }
        },
        mounted(){
            this.getCategory();
        },
        props: ['url', 'url_main'],
        
    }
</script>
