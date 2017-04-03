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
    <div class="panel panel-default panel-ko" >
        <div class="panel-heading panel-ko-heading">
			<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
				  <li class="breadcrumb-item active"><span class="label label-success">Comments</span></li>
			</ol>
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
                            <th>Autor</th>
                            <th>Post</th>
                            <th>Nickname</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Active</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="ukryj">
                            <td colspan="7" class="text-center" style="font-size:20px;"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading...</td>
                        </tr>
                        <input type="hidden" name="url" value="{{ url('/') }}" v-model="url">
                        <input type="hidden" name="url_pages" value="{{ route('comments') }}" v-model="url_com">
                        <tr class="tabela" v-for="com in comments" track-by="$index">
                            <td> @{{ numery + $index  }} </td>
                            <td> 
                                <span v-if="com.user_id != null">
                                    <span class="label label-primary">@{{ com.user.name }}</span>
                                </span>
                                <span v-if="com.user_id == null">
                                    <span class="label label-default">Anonim</span>
                                </span>
                            </td>
                            <td> <span class="label label-danger">@{{ com.post.subject }}</span></td>
                            <td> @{{ com.nickname }} </td>
                            <td> @{{ com.subject }} </td>
                            <td> @{{ com.description }} </td>
                            <td> 
                            <span class="label label-success" v-if="com.active"> <i class="fa fa-check" aria-hidden="true"></i> </span>
                                <span class="label label-danger" v-if="!com.active" ><i class="fa fa-times" aria-hidden="true"></i> </span>
                            </td>
                            <td> @{{ com.created_at }} </td>
                            <td> 
                            <button @click="show(com,$index)" type="button" class="btn btn-success" data-toggle="modal" href='#position' ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                            <button @click="show(com,$index)" type="button" class="btn btn-danger" data-toggle="modal" href='#delete'><i class="fa fa-minus"></i></button>
                            
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- paginate -->
            <div class="col-xs-12 text-center" v-if="comments.length > 0">
                <button type="button" class="btn btn-warning @{{ !check_prev_page ? 'disabled':'' }}" @click="getComments(prev_page_url)"><</button>

                <button type="button" class="btn btn-warning @{{ !check_next_page ? 'disabled':'' }}" @click="getComments(next_page_url)">></button>
            </div>
            <!-- EDIT POSITION-->
            <div class="modal fade" id="position">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Edit comment nr: @{{ index + 1 }}</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form-edit" action="{{url('/admin/comments/edit/')}}@{{'/'+comment.id}}" method="POST" class="form-horizontal" role="form" v-on:submit.prevent="edit">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}                                    
                                    <!-- Select Basic -->
                                    <div class="form-group">
                                      <label class="col-md-2 control-label" for="selectbasic">Active</label>
                                      <div class="col-md-10">
                                        <select id="selectbasic" name="active" class="form-control" >
                                          <option value="0" v-bind:selected="comment.active == false">NO</option>
                                          <option value="1" v-bind:selected="comment.active == true">YES</option>
                                        </select>
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
                            <h4 class="modal-title">Delete comment nr: @{{ index + 1 }}</h4>
                        </div>
                        <div class="modal-body text-center">
                            <button type="button" class="btn btn-primary" @click="onDelete(comment.id,comment)"><i class="fa fa-floppy-o"></i> YES</button>
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
<script src="{{asset('js/vue/comments.js')}}"></script>
@endsection