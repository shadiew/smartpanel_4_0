"use strict";
var pageOverlay = pageOverlay || (function ($) {
  return {
    show: function (message, options) {
      if (!$('#page-overlay').hasClass('active')) {
        $('#page-overlay').addClass('active');
        $('#page-overlay .page-loading-image').removeClass('d-none');
      }
    },

    hide: function () {
      if ($('#page-overlay').hasClass('active')) {
        $('#page-overlay').removeClass('active');
        $('#page-overlay .page-loading-image').addClass('d-none');
      }
    }
  };

})(jQuery);


var alertMessage = alertMessage || (function ($) {
  var $html = $('<div class="alert alert-icon content d-none" role="alert">' +
    '<i class="fe icon-symbol" aria-hidden="true"></i>' +
    '<span class="message">Message is in here</span>' +
    '</div>');
  return {
    show: function (_message, _type) {
      switch (_type) {
        case 'error':
          var _type = 'alert-warning',
            _icon = 'fe-alert-triangle';
          break;
        case 'success':
          var _type = 'alert-success',
            _icon = 'fe-check';
          break;
        default:
          var _type = 'alert-warning',
            _icon = 'fe-bell';
      }
      $('.alert-message-reponse').html($html);
      $('.alert-message-reponse .content').addClass(_type);
      $('.alert-message-reponse .icon-symbol').addClass(_icon);
      $('.alert-message-reponse .content').removeClass('d-none');
      $('.alert-message-reponse .content .message').html(_message);
    },

    hide: function () {
      $('.alert-message-reponse').html('');
    }
  };

})(jQuery);

// Confirm notice
function confirm_notice(_ms) {
  switch (_ms) {
    case 'deleteItem':
      return confirm(deleteItem);
      break;
    case 'deleteItems':
      return confirm(deleteItems);
      break;
    default:
      return confirm(_ms);
  }
  return confirm(_ms);
}

function is_json(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}

// Reload page
function reloadPage(_url) {
  if (_url) {
    setTimeout(function () { window.location = _url; }, 2500);
  } else {
    setTimeout(function () { location.reload() }, 2500);
  }
}

function notify(_ms, _type) {
  var _text = _ms;
  var _icon = _type;
  if (_type == 'error') {
    _icon = 'warning';
  }
  $.toast({
    text: _text,
    icon: _icon,
    showHideTransition: 'fade',
    allowToastClose: true,
    hideAfter: 3000,
    stack: 5,
    position: 'bottom-center',
    textAlign: 'left',
    loader: true,
    loaderBg: '#0ef1f1',
    beforeShow: function () { },
    afterShown: function () { },
    beforeHide: function () { },
    afterHidden: function () { }
  });
}

/*----------  Configure tinymce editor  ----------*/
function plugin_editor(selector, settings) {
  selector = typeof (selector) == 'undefined' ? '.tinymce' : selector;
  var _settings = {
    selector: selector,
    menubar: false,
    theme: "modern",
    branding: false,
    paste_data_images: true,
    relative_urls: false,
    convert_urls: false,
    inline_styles: true,
    verify_html: false,
    cleanup: false,
    autoresize_bottom_margin: 25,
    plugins: [
      "advlist autolink lists link charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | print preview emoticons",
    // file_browser_callback: elFinderBrowser,
  }

  if (typeof (settings) != 'undefined') {
    for (var key in settings) {
      if (key == 'append_plugins') {
        _settings['plugins'].push(settings[key]);
      } else if (key == 'toolbar') {
        _settings['toolbar1'] = _settings['toolbar1'] + " " + settings[key];
      } else {
        _settings[key] = settings[key];
      }
    }
  }
  var editor = tinymce.init(_settings);
  return editor;
}

function elFinderBrowser(field_name, url, type, win) {
  tinymce.activeEditor.windowManager.open({
    file: PATH + 'file_manager/elfinder_init',// use an absolute path!
    title: 'File manager',
    width: 900,
    height: 450,
    resizable: 'yes',
    inline: true
  }, {
    setUrl: function (url) {
      win.document.getElementById(field_name).value = url;
    }
  });
  return false;
}

function sendXMLPostRequest($url, $params) {
  var Url = $url;
  var params = $params;
  var xhr = new XMLHttpRequest();
  xhr.open('POST', Url, true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = processRequest;
  function processRequest(e) {
    console.log(xhr);
    if (xhr.readyState == 4 && xhr.status == 200) {
      var response = JSON.parse(xhr.responseText);
      console.log(response.status);
    }
  }
  xhr.send(params);
}

/*----------  Upload media and return path to input selector  ----------*/
function getPathMediaByelFinderBrowser(_this, default_selector) {
  var _that = _this;
  var _passToElement = typeof (default_selector) == 'undefined' ? _that.siblings('input') : default_selector;
  tinymce.activeEditor.windowManager.open({
    file: PATH + 'file_manager/elfinder_init',
    title: 'File manager',
    width: 900,
    height: 450,
    resizable: 'yes',
    inline: true
  }, {
    setUrl: function (url) {
      _passToElement.val(url);
    }
  });
  return false;
}

/**
 * Call Ajax function with type option
 * @param {selector} element 
 * @param {url} url 
 * @param {option} type 
 */
 function callPostAjax(element, url, data, type, redirect = null) {
  var data_type = (type == 'get-result-html') ? 'html' : 'json';
  $.post(url, data, function (_result) {
    console.log(_result);
    switch (type) {

      case 'sort':
        notifyJS(element, _result.status, _result.message);
        break;

      case 'status':
        notifyJS(element, _result.status, _result.message);
        break;

      case 'delete-item':
        pageOverlay.show();
        if (_result.status == 'success') {
          $(".tr_" + _result.ids).remove();
        }
        setTimeout(function () {
          pageOverlay.hide();
          notify(_result.message, _result.status);
        }, 2000);
        break;

      case 'get-result-html':
        console.log(_result);
        setTimeout(function () {
          pageOverlay.hide();
          $("#result_html").html(_result);
        }, 1000);
        break;

      default:
        setTimeout(function () {
          pageOverlay.hide();
          console.log(_result.status);
          notify(_result.message, _result.status);
          if (_result.status == 'success') {
            if (_result.redirect_url) {
              var redirect = _result.redirect_url;
            } else {
              var redirect = '';
            }
            reloadPage(redirect);
          }
        }, 2000);
        break;
    }
  }, data_type);
}

/**
 * Call Ajax function with type option
 * @param {element} element 
 * @param {className} className 
 * @param {message} message 
 * @param {option} option 
 */
function notifyJS(element, className, message, option) {
  var options = {
    autoHide: true,
    position: '',
    autoHideDelay: 2000,
    className: className,
  };
  if (element === '') {
    options.position = "bottom center";
    $.notify(message, options);
  } else {
    options.position = "top center";
    element.notify(message, options);
  }
}

/**
 * Number format
 * @param {value} input value 
 * @param {toFixed} message 
 */
function preparePrice(value, toFixed = null) {
  var toFixed = 6;
  if (value.countDecimals() > 6) {
    return value.toFixed(toFixed);
  } else {
    return value.toString();
  }
}

Number.prototype.countDecimals = function () {
  if (Math.floor(this.valueOf()) === this.valueOf()) return 0;
  var str = this.toString();
  if (str.indexOf(".") !== -1 && str.indexOf("-") !== -1) {
      return str.split("-")[1] || 0;
  } else if (str.indexOf(".") !== -1) {
      return str.split(".")[1].length || 0;
  }
  return str.split("-")[1] || 0;
}

function Common() {
  var self = this;
  this.init = function () {
    //Callback
    self.Common();
  };
  /**
   * From V3.6 for admin
   */
  this.Common = function () {
    // search area
    var btnSearch = ".search-area button.btn-search",
        btnClear = ".search-area button.btn-clear",
        searchArea = $(".search-area"),
        inputSearchQuery = $(".search-area input[name = query]");

    // Click Search
    $(document).on('click', btnSearch, function () {
      var pathname = window.location.pathname; //Get pathname
      var searchParams = new URLSearchParams(window.location.search);
      var params = ['status'],
        link = '';

      $.each(params, function (key, value) {
        if (searchParams.has(value)) {
          link += value + "=" + searchParams.get(value) + "&"
        }
      });
      var pathlink = pathname + "?" + link + "query=" + inputSearchQuery.val();
      if (searchArea.find('option:selected').length  > 0 ) {
        pathlink = pathlink + "&field=" + searchArea.find('option:selected').val();
      }
      window.location.href = pathlink;
    });

    // Click Btn Clear Option
    $(document).on('click', btnClear, function () {
      var pathname = window.location.pathname; //Get pathname
      window.location.href = pathname
    });
  }
}

Common = new Common();
$(function () {
  Common.init();
});