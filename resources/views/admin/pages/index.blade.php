@extends('admin.index')

@section('css')
<style>
.alert{
    display: none;
}
.tabela{
    display: none;
}
.do_ukrycia{
    display: block;
}
.pokaz_tabele{
    display: table-row;
}
</style>
@endsection

@section('content')
	
<div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" id="app">
    <div class="panel panel-default panel-ko">
        <div class="panel-heading panel-ko-heading">
			<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
				  <li class="breadcrumb-item active"><span class="label label-success">Pages</span></li>
			</ol>
            <div>
                <a href="{{ route('pages-create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add page </a>
            </div>
        </div>
        <div class="panel-body">
            <div  class="alert alert-success text-center" v-if="status == 'is'" style="background: #1B9C01; color:white;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong><i class="fa fa-check-circle" aria-hidden="true"></i> Success!</strong> @{{ status_desc }}
                    </div>
                    <div  class="alert alert-danger text-center" v-if="status == 'not'" style="background: #CB0000; color:white; ">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Warning!</strong> @{{ status_desc }}
                    </div>

            <!-- COMPONENT PAGES -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Submenu</th>
                            <th>Robots</th>
                            <th>Active</th>
                            <th>Position</th>
                            <th>Category</th>
                            <th>Widgets</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr id="ukryj">
                        <td colspan="9" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
                    </tr>
                        <input type="hidden" name="url" value="{{ url('/') }}" v-model="url">
                        <input type="hidden" name="url_pages" value="{{ route('pages') }}" v-model="url_pages">
                    
                        <tr class="tabela" v-for="page in pages" track-by="$index">
                            <td>@{{ $index + numery}} </td>
                            <td>@{{ page.name }}</td>
                            <td>@{{ url + '/' + page.slug }}</td>
                            <td>
                                <span v-if="page.sub !== null">
                                    <span class="label label-primary">@{{ page.sub.page.name }}</span>
                                </span>
                                <span v-if="page.sub == null">
                                    <span class="label label-danger">none</span>
                                </span>
                            </td>
                            <td>
                                <span class="label label-success" v-if="page.robots"> <i class="fa fa-check" aria-hidden="true"></i></span>
                                <span class="label label-danger" v-else > <i class="fa fa-times" aria-hidden="true"></i></span>
                            </td>
                            <td>
                                <span class="label label-success" v-if="page.active"> <i class="fa fa-check" aria-hidden="true"></i> </span>
                                <span class="label label-danger" v-else > <i class="fa fa-times" aria-hidden="true"></i></span>
                            </td>
                            <td>@{{ page.position }}</td>
                            <td><span v-if="page.category != null"><span class="label label-primary">@{{ page.category.name }}</span></span><span v-else=""><span class="label label-danger">none</span></span></td>
                            <td>

                                <span class="label label-success" v-if="page.is_widgets == 1"> <i class="fa fa-check" aria-hidden="true"></i> </span>
                                <span class="label label-danger" v-if="page.is_widgets == 0" ><i class="fa fa-times" aria-hidden="true"></i> </span>
                            </td>
                            <td>
                                <button @click="show(page.id, page.name, page.position, page,$index)" type="button" class="btn btn-info" data-toggle="modal" href='#position'><i class="fa fa-list-ol" aria-hidden="true"></i></button>
                                <span v-if="page.module.length > 0">
                                <button @click="show(page.id, page.name, page.position, page,$index)" class="btn btn-warning" data-toggle="modal" href='#modules-position'><i class="fa fa-rocket" aria-hidden="true"></i></button>
                                </span>
                                <a href="{{ url('/admin/pages/edit')}}@{{'/'+page.id}}" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                                <button v-if="page.id != 1" @click="show(page.id, page.name, page.position, page,$index)" type="button" class="btn btn-danger" data-toggle="modal" href='#delete'><i class="fa fa-minus"></i></button>
                            </td>
                        </tr>                                                      
                    </tbody>                             
                </table>
            </div>
            <div class="col-xs-12 text-center" v-if="pages.length > 0">
                <button type="button" class="btn btn-warning @{{ !check_prev_page ? 'disabled':'' }}" @click="getPages(prev_page_url)"><</button>

                <button type="button" class="btn btn-warning @{{ !check_next_page ? 'disabled':'' }}" @click="getPages(next_page_url)">></button>
            </div>  
            <!-- EDIT -->
            <div class="modal fade" id="position">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Edit position: @{{ page_name }}</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form-position" action="{{url('/admin/pages/edit/position')}}@{{'/'+page_id}}" method="POST" class="form-horizontal" role="form" v-on:submit.prevent="editPosition">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}                                    
                                    <div class="form-group text-center">
                                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                                            <input v-model="edit_position" type="text" name="position" id="input" class="form-control" v-bind:value="page_position">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12 text-center">
                                            <button type="submit" class="btn btn-success"  >SAVE</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- EDIT MODULES POSITION-->
            <div class="modal fade" id="modules-position">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Edit modules position: @{{ page_name }}</h4>
                        </div>
                        <div class="modal-body">

                            <form id="form-position-module" action="{{url('/admin/pages/edit/modules-position')}}@{{'/'+page_id}}" method="POST" class="form-horizontal" role="form" v-on:submit.prevent="editModulePosition">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}  
                                    <div class="form-group text-center" v-for="new in page.module">
                                        <label class="col-md-4 control-label" for="textinput">
                                            <span v-if="new.module == 1">Articles</span>
                                            <span v-if="new.module == 2">Media with albums</span>
                                            <span v-if="new.module == 3">Media single</span>
                                            <span v-if="new.module == 4">Cookies</span>
                                            <span v-if="new.module == 5">Form contact</span>
                                        </label>  
                                        <div class="col-md-8">
                                            <input type="text" name="position@{{new.id}}" id="input" class="form-control" v-bind:value="new.position">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-12 text-center">
                                            <button type="submit" class="btn btn-success"  >SAVE</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DELETE -->
            <div class="modal fade" id="delete">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Delete page - @{{ page_name }}</h4>
                        </div>
                        <div class="modal-body text-center">
                            <button type="button" class="btn btn-primary" @click="onDelete(page_id,page)"><i class="fa fa-floppy-o"></i> YES</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection

@section('js_body')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
<script src="{{asset('js/vue/pages.js')}}"></script>
@endsection