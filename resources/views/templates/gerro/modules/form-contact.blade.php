<!-- FORM CONTACT -->
<div class="form-contact col-xs-12 col-md-12 col-sm-12">
    <h1 class="text-center">Form contact</h1>
    <form class="form-horizontal" method="POST" action="{{ route('send-mail') }}">
    	{{ csrf_field()}}
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textinput">Firstname and lastname</label>  
          <div class="col-md-7">
          <input id="textinput" name="firstname_lastname" type="text" placeholder="firstname and lastname" class="form-control input-md">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textinput">Email</label>  
          <div class="col-md-7">
          <input id="textinput" name="email" type="email" placeholder="email" class="form-control input-md">
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textinput">Subject</label>  
          <div class="col-md-7">
          <input id="textinput" name="subject" type="text" placeholder="subject" class="form-control input-md">
          </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textarea">Description</label>
          <div class="col-md-7">                     
            <textarea class="form-control" id="textarea" name="description"></textarea>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-12 text-center" style="display: flex; justify-content: center;">
            <div class="g-recaptcha" data-sitekey="6LcR5BYUAAAAAFTB8RVaQdKpIGIc80Hs2Zy0VdiZ"></div>
          </div>
        </div>
        <!-- Button -->
        <div class="form-group">
          <div class="col-md-12 text-center">
            <button id="singlebutton" name="singlebutton" class="btn btn-default"><i class="fa fa-envelope-o"></i> Send message</button>
          </div>
        </div>

    </form>

</div>
<!-- END FORM CONTACT -->