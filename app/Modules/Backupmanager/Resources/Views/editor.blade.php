<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
<title>Script Editor -> {{$script->filename}}</title>
<style type="text/css" media="screen">
  .alert-ng {
    color: #31708f;
    background-color: #d9edf7;
    border-color: #bce8f1;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
  }

    #editor {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
{!! Html::style('css/bootstrap.min.css') !!}
</head>
<body>

<div id="editor">{{ $script['scriptBody']['script'] }}</div>

<script src="{{URL::asset('js/jQuery-2.1.4.min.js')}}"></script>
<script src="{{URL::asset('js/ace/ace.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-notify.min.js')}}"></script>
<script>
var notify_settings = {
    // settings
    type: 'ng',
    delay: 250,
    animate: {
      enter: 'animated fadeInDown',
      exit: 'animated fadeOutUp'
    },
    template: '<div data-notify="container" class="col-xs-11 col-sm-2 alert alert-{0}" role="alert">' +
      '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
      '<span data-notify="icon"></span> ' +
      '<span data-notify="title">{1}</span> ' +
      '<span data-notify="message">{2}</span>' +
      '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
      '</div>' +
      '<a href="{3}" target="{4}" data-notify="url"></a>' +
    '</div>'
  }

  var editor = ace.edit("editor");

  editor.commands.addCommand({
    name: 'saveFile',
    bindKey: {
      win: 'Ctrl-S',
      mac: 'Command-S',
      sender: 'editor|cli'
    },
    exec: function(env, args, request) {
      $.ajax({
        url: "{{ URL::route('admin.backupmanager.editor.save') }}",
        type: "POST",
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
          'script': editor.getSession().getValue(),
          'id':     "{{$script->id}}"
        },
        success: function(response){
          if(response.success) {
            $.notify({message: 'File Saved.'},notify_settings);
          }
        },
        error: function(data){
          $.notify({message: 'There was an error saving.'},notify_settings);
        }
      });
    }
  });
  editor.setTheme("ace/theme/cobalt");
  editor.getSession().setMode("ace/mode/sh");
</script>
</body>
</html>
