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
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
@endsection

@section('content')
<div id="app">
<div class="col-xs-12 col-md-12 col-sm-12 panel-ko-fluid" >
    <div class="panel panel-default panel-ko" >
        <div class="panel-heading panel-ko-heading">
			<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
				  <li class="breadcrumb-item active"><span class="label label-success">Mails</span></li>
			</ol>
            
        	<div  class="alert alert-success text-center erorrs" v-if="status == 'is'" style="background: #1B9C01; color:white;">
        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        		<strong><i class="fa fa-check-circle" aria-hidden="true"></i> Success!</strong> @{{ status_desc }}
        	</div>
        	<div  class="alert alert-danger text-center erorrs" v-if="status == 'not'" style="background: #CB0000; color:white; ">
        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        		<strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Warning!</strong> @{{ status_desc }}
        	</div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-md-6 col-sm-12 panel-ko-fluid" >
    <div class="panel panel-default panel-ko" >
    	<div class="panel-heading panel-ko-heading">
            Template GET MAIL
        </div>
        <div class="panel-body">
        	<div class="col-xs-12" style="padding-bottom: 30px;">
	        	<div class="row">
	        		- param : <kbd>$data->email</kbd> < input name="email" > <br>
	        	</div>
        	</div>
        	<form method="POST" id="form-edit-get" action="{{ route('mails-edit',['form'=>'get']) }}" class="form-horizontal" v-on:submit.prevent="edit('get')">
       			{{ csrf_field() }}
       			{{ method_field('PUT') }}
				<!-- Textarea -->
				<div class="form-group">
					<div class="col-md-12 col-xs-12">                     
						<textarea class="form-control" id="content-1" name="get_mail">@{{{ mail.get_mail }}}</textarea>
					</div>
				</div>
				<!-- Button -->
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-floppy-o"></i> SAVE</button>
					</div>
				</div>
			</form>
        	
        	
       	</div>
    </div>
    <div class="panel panel-default panel-ko" >
    	<div class="panel-heading panel-ko-heading">
            Data for mail
        </div>
        <div class="panel-body">
        	<form method="POST" id="form-edit-update-email" action="{{ route('mails-edit',['form'=>'update-email']) }}" class="form-horizontal" v-on:submit.prevent="edit('update-email')">
       			{{ csrf_field() }}
       			{{ method_field('PUT') }}
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">Driver</label>  
				  <div class="col-md-8">
				  <input id="textinput" name="driver" type="text" placeholder="SMTP" class="form-control input-md" value="@{{ mail.driver }}">
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">Host</label>  
				  <div class="col-md-8">
				  <input id="textinput" name="host" type="text" placeholder="mail.example.com" class="form-control input-md" value="@{{ mail.host }}">
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">Port</label>  
				  <div class="col-md-8">
				  <input id="textinput" name="port" type="text" placeholder="587" class="form-control input-md" value="@{{ mail.port }}">
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">User</label>  
				  <div class="col-md-8">
				  <input id="textinput" name="user" type="text" placeholder="user@example.com" class="form-control input-md" value="@{{ mail.user }}">
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">Password</label>  
				  <div class="col-md-8">
				  <input id="textinput" name="pass" type="password" placeholder="" class="form-control input-md" value="@{{ mail.pass}}">
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">Encryption</label>  
				  <div class="col-md-8">
				  <input id="textinput" name="encryption" type="text" placeholder="NULL" class="form-control input-md" value="@{{ mail.encryption }}">
				  </div>
				</div>

				<!-- Button -->
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-floppy-o"></i> SAVE</button>
					</div>
				</div>
			</form>
        </div>
    </div>
</div>

<div class="col-xs-12 col-md-6 col-sm-12 panel-ko-fluid" >
    <div class="panel panel-default panel-ko" >
        <div class="panel-heading panel-ko-heading">
            Template SEND MAIL
        </div>
        <div class="panel-body">
        	<div class="col-xs-12" style="padding-bottom: 30px;">
	        	<div class="row">
	        		- subject : <kbd>$subject</kbd> <br>
	        		- description : <kbd>$description</kbd>
	        	</div>
        	</div>
        	<form method="POST" id="form-edit-send" action="{{ route('mails-edit',['form'=>'send']) }}" class="form-horizontal" v-on:submit.prevent="edit('send')">
       			{{ csrf_field() }}
       			{{ method_field('PUT') }}
				<!-- Textarea -->
				<div class="form-group">
					<div class="col-md-12 col-xs-12">                     
						<textarea class="form-control" id="content-2" name="send_mail">@{{{ mail.send_mail }}}</textarea>
					</div>
				</div>
				<!-- Button -->
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-floppy-o"></i> SAVE</button>
					</div>
				</div>
			</form>
        	
        	
       	</div>
    </div>
    <div class="panel panel-default panel-ko" >
        <div class="panel-heading panel-ko-heading">
            SEND MAIL
        </div>
        <div class="panel-body">
        	<form method="POST" id="form-send" action="{{ route('mails-send') }}" class="form-horizontal" v-on:submit.prevent="send">
       			{{ csrf_field() }}
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="textinput">Email</label>  
				  <div class="col-md-10">
				  <input id="textinput" name="email" type="text" placeholder="email" class="form-control input-md" >
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="textinput">Subject</label>  
				  <div class="col-md-10">
				  <input id="textinput" name="subject" type="text" placeholder="subject" class="form-control input-md" >
				  </div>
				</div>

				<!-- Textarea -->
				<div class="form-group">
					<div class="col-md-12">                     
						<textarea class="form-control" id="content-3" name="description"></textarea>
					</div>
				</div>

				<!-- Button -->
				<div class="form-group">
					<div class="col-md-12 text-center">
						<button id="singlebutton" name="singlebutton" class="btn btn-primary"><i class="fa fa-floppy-o"></i> SAVE</button>
					</div>
				</div>
			</form>
        </div>
    </div>
</div>
</div>
@endsection

@section('js_body')
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.2/vue-resource.js"></script>
<script src="{{asset('js/vue/mails.js')}}"></script>
@endsection