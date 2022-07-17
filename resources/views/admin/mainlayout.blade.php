<!DOCTYPE html>
<html lang="en">
  @include('admin.parts.head')
  <style type="text/css">
    .modal-load {
        display:    none;
        position:   fixed;
        z-index:    10000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('https://i.imgur.com/GCNyjJY.gif') 
                    50% 50% 
                    no-repeat;
    }

    /* When the body has the loading class, we turn
       the scrollbar off with overflow:hidden */
    body.loading .modal-load {
        overflow: hidden;   
    }

    /* Anytime the body has the loading class, our
       modal element will be visible */
    body.loading .modal-load {
        display: block;
    }

    .vcenter {
        display: inline-block;
        vertical-align: middle;
        float: none;
    }

    .vertical-align {
        display: flex;
        align-items: center;
    }

  </style>
<body>
  <!-- BEGIN #loader -->
  <div id="loader" class="app-loader">
    <span class="spinner"></span>
  </div>
  <!-- END #loader -->

  <!-- BEGIN #app -->
  <div id="app" class="app app-header-fixed app-sidebar-fixed ">
    <!-- BEGIN #header -->
      @include('admin.parts.header')
    <!-- END #header -->
  
    <!-- BEGIN #sidebar -->
      @include('admin.parts.sidebar')
    <!-- END #sidebar -->
    
    <!-- BEGIN #content -->
      @yield('content')
    <!-- END #content -->

    <div class="modal-load"><!-- Place at bottom of page --></div>
  
    <!-- BEGIN scroll-top-btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <!-- END scroll-top-btn -->
  </div>
  <!-- END #app -->

  <!-- Script Loader -->
    @include('admin.parts.script-footer')
  <!-- /.script-loader -->

  <script type="text/javascript">

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    function updateTextView(_obj){
      var num = getNumber(_obj.val());
      if(num==0){
        _obj.val('');
      }else{
        _obj.val(numberWithCommas(num));
      }
    }
    function getNumber(_str){
      var arr = _str.split('');
      var out = new Array();
      for(var cnt=0;cnt<arr.length;cnt++){
        if(isNaN(arr[cnt])==false){
          out.push(arr[cnt]);
        }
      }
      return Number(out.join(''));
    }

    function formatDate(dateStr) {

        let str = '';

        if(dateStr != null){
          let split = dateStr.split("-");
          str = split[2] + '/' + split[1] + '/' + split[0];
        }

        return str;

        // const d = new Date(dateStr);
         // + ' ' + d.getHours() + ':' + d.getMinutes().toString().padStart(2, '0')
        // return d.getDate().toString().padStart(2, '0') + '/' + d.getMonth() + 1 + '/' + d.getFullYear();
    }

    $(function(){

      $('.currency').on('keyup',function(){
        updateTextView($(this));
      });

    });
  </script>

  @yield('scriptplus')  

</body>
</html>