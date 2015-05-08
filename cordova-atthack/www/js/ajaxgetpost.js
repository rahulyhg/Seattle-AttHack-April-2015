//POST Ajax

function _onFail(error) {
  var message = "Generic fail handler triggered - no specific error handler specified";
  if (typeof error == "string") {
    message = message + " - error message: " + error;
  }
  alert(message);
};

function post_ajax_data(url, encodedata, success)
{
  $.ajax({
    type:"POST",
    url:url,
    data :encodedata,
    processData: false,
    contentType: false,
    success:function(data){
      success.call(this, data);
    },
    error:function(data){
      _onFail(data);
    }
  });
}

function post_ajax_data_original(url, encodedata, success)
{
  $.ajax({
    type:"POST",
    url:url,
    data :encodedata,
    dataType:"json",
    restful:true,
    contentType: 'application/json',
    cache:false,
    timeout:20000,
    async:true,
    beforeSend :function(data) { },
    success:function(data){
      success.call(this, data);
    },
    error:function(data){
      _onFail(data);
    }
  });
}

//GET and DELETE Ajax
function ajax_data(type, url, success)
{
  $.ajax({
    type:type,
    url:url,
    dataType:"json",
    restful:true,
    cache:false,
    timeout:20000,
    async:true,
    beforeSend :function(data) { },
    success:function(data){
      success.call(this, data);
    },
    error:function(data){
      _onFail(data);
    }
  });
}