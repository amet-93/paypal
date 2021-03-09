@extends('ThemePage.layout.home_dashboard_layout')
@section('content')
<!-- Main content -->
<section class="content-header">
  <?php 
    $url = str_replace('/'.basename(request()->path()).'','',Request::path());
    $final_url = str_replace('admin/','',$url);
    $extend = explode('-',$final_url);
    $route_url = explode('/',Request::path());
    $user_url =  explode('-',basename(request()->path()));
  ?>
  <h1>Generate Code</h1>
  <ol class="breadcrumb">
    <li><a href="{{in_array('user', $route_url) == true?url('user'):url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>{{in_array('user', $route_url) == true?'User':'Dashboard'}}</a></li>
    @if(is_numeric(basename(request()->path())) == true)
      <li class="active"> 
        @if(!empty($extend[1]))
          @for($j= 0; $j < count($extend); $j++)
            {{ucwords($extend[$j].' ')}}
          @endfor
        @else
          {{ucwords($final_url)}}
        @endif
      </li>
    @elseif(in_array('user', $route_url))
       @if(!empty($user_url[1]))
        <li class="active">
          @for($k= 0; $k < count($user_url); $k++)
            {{ucwords($user_url[$k].' ')}}
          @endfor
        </li>
      @else
        <li class="active">{{ucwords(str_replace('user/','',Request::path()))}}</li>
      @endif
    @else
      <li class="active">{{ucwords(str_replace('admin/','',Request::path()))}}</li>
    @endif
  </ol>
</section>
<section class="content" style="float: none;">
  @if($data != '')
    <a href="{{url('user/certification-level-dashboard')}}"><h3>Certification 
	purchase and approval is required before certification image code can be 
	generated</h3></a>
  @else
    <textarea class="form-control" rows="10">
      <script type="text/javascript">
        let class_name = "demo";
        let imwidth= '200px';

        //don't change anything below
        let mc = document.getElementsByClassName(class_name);
        if(mc.length > 0){
          let img_content="{{URL::to('/')}}/api/user/getimg/{{$mixed}}";
          for (let i = 0; i < mc.length; i++) {
            let mi = document.createElement('img');
            mi.src = img_content;
            mi.alt = "BCC";
            mi.style.width = imwidth;
            let ma = document.createElement('a');
            ma.href="{{URL::to('/')}}/user/certification-detail/{{$mixed}}?referrer="+location.hostname+"";
            mc[i].appendChild(ma);
            ma.appendChild(mi);
          }
        }
      </script>
    </textarea>
    <div>
      &nbsp;
      To add the certification image to your web site, please follow these steps:
      <ul>
        <li>Add a div with class "demo" at place where BCC Certified image is to be displayed.</li>
        <li>For example:  &nbsp;<code>&lt;div class="demo"&gt;&lt;/div&gt;</code></li>
        <li>Get the code you need from your dashboard in the Generate Code section.</li>
        <li>Place this code before body (&lt;/body&gt;) close tag of your site code.</li>
        <li>Refresh the page and check the image position.</li>
        <li>Click on the image and make sure it links to the page with the certification information</li>
        <li>If you have any problems, please contact us at support@bizcybercert.us</li>
      </ul>
      <!-- <span>To add certification Image on site follow these steps:<br>
      <ul>
          <li> Add a div with class <b>"demo"</b>  at place where BCC Certified image to be shown.<br>
              <b>e.g. &nbsp;<code>&lt;div class="demo"&gt;&lt;/div&gt;</code></b>
          </li>
          <li> Get your generate code from your<a href="//bizcybercert.us/dashboard/user/generatecode" class="dashboard"> Dashbaord </a> </li>
          <li>Place the code  in footer of your code</li>
      </ul>
        </span> -->
  </div>
  @endif 
</section>

<section class="content hide" style="float: none;">
<form class="form-horizontal" id="img2b64">
  <h2>Input</h2>
  <div class="form-group">
    <label class="col-sm-2 control-label">Convert Card Type:</label>
    <div class="col-sm-10">
      <select class="form-control" name="convertType">
        <option value="bronze" selected>BRONZE LEVEL</option>
        <option value="gold">GOLD LEVEL</option>
        <option value="platinum">PLATINUM LEVEL</option>
        <option value="silver">SILVER LEVEL</option>
      </select>
    </div>
  </div>
  <!--<div class="form-group">
    <label class="col-sm-2 control-label">URL:</label>
    <div class="col-sm-10">
      <input type="url" name="url" class="form-control" placeholder="Insert an IMAGE-URL" value="http://upload.wikimedia.org/wikipedia/commons/4/4a/Logo_2013_Google.png" required />
    </div>
  </div>-->
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-default">
    </div>
  </div>
</form>

<div class="output form-horizontal" style="min-height: 250px;">
  <hr>
  <h2>Output</h2>
  <div>
    <strong class="col-sm-2 text-right">Converted via:</strong>
    <div class="col-sm-10">
      <span class="convertType"></span>
    </div>
  </div>
  <div>
    <strong class="col-sm-2 text-right">Size:</strong>
    <div class="col-sm-10">
      <span class="size"></span>
    </div>
  </div>
  <div>
    <strong class="col-sm-2 text-right">Text:</strong>
    <div class="col-sm-10">
      <textarea class="form-control textbox"></textarea>
    </div>
  </div>
  <div>
    <strong class="col-sm-2 text-right">Link:</strong>
    <div class="col-sm-10">
      <a href="#" class="link"></a>
    </div>
  </div>
  <div>
    <strong class="col-sm-2 text-right">Image:</strong>
    <div class="col-sm-10">
      <img class="img">
    </div>
  </div>
</div>
</body>
<script src="{{url('public/assets/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script>
function loadContent(){
  
}
function convertImgToDataURLviaCanvas(url, callback, outputFormat) {
  let img = new Image();
  img.crossOrigin = 'Anonymous';
  img.onload = function() {
    let canvas = document.createElement('CANVAS');
    let ctx = canvas.getContext('2d');
    let dataURL;
    canvas.height = this.height;
    canvas.width = this.width;
    ctx.drawImage(this, 0, 0);
    dataURL = canvas.toDataURL(outputFormat);
    callback(dataURL);
    canvas = null;
  };
  img.src = url;
}

function convertFileToDataURLviaFileReader(url, callback) {
  let xhr = new XMLHttpRequest();
  xhr.onload = function() {
    let reader = new FileReader();
    reader.onloadend = function() {
      callback(reader.result);
    }
    reader.readAsDataURL(xhr.response);
  };
  xhr.open('GET', url);
  xhr.responseType = 'blob';
  xhr.send();
}

$('#img2b64').submit(function(event) {
  let imageUrl = 'https://bizcybercert.us/images/cart_img/'+$(this).find('[name=convertType]').val()+'.png';
  //alert(imageUrl); 
  let convertType = $(this).find('[name=convertType]').val();
  //alert(convertType);
  let convertFunction = convertType === 'FileReader' ?
    convertFileToDataURLviaFileReader :
    convertImgToDataURLviaCanvas;

  convertFunction(imageUrl, function(base64Img) {
    $('.output')
      .find('.textbox')
      .val(base64Img)
      .end()
      .find('.link')
      .attr('href', base64Img)
      .text(base64Img)
      .end()
      .find('.img')
      .attr('src', base64Img)
      .end()
      .find('.size')
      .text(base64Img.length)
      .end()
      .find('.convertType')
      .text(convertType)
      .end()
      .show()
  });

  event.preventDefault();
});
</script>
</section>
@endsection