/**
 * Created by yama_gs on 21.10.2016.
 */

/*eslint no-useless-concat: 0, no-undef: 0, no-unused-expressions: 0, complexity: [2, 10], no-use-before-define: 0*/

function throttle(func, ms) {
  var isThrottled = false,
    savedArgs,
    savedThis;

  function wrapper() {
    if (isThrottled) {
      savedArgs = arguments;
      savedThis = this;
      return;
    }
    func.apply(this, arguments);
    isThrottled = true;
    setTimeout(function() {
      isThrottled = false;
      if (savedArgs) {
        wrapper.apply(savedThis, savedArgs);
        savedArgs = savedThis = null;
      }
    }, ms);
  }

  return wrapper;
}

var notify = throttle(function(type, text) {
  return noty({
    type: type,
    text: text,
    timeout: 3000
  });
}, 3500);

function requestApiToken(event) {
  event.stopPropagation();
  event.preventDefault();

  event.target.disabled = true;

  jQuery.ajax({
    url: send_api_token.ajax_url,
    type: 'post',
    data: {
      action: 'send_api_token',
      nonce: send_api_token.nonce,
      return_link_tpl: window.location.toString()
    },
    success: function(response) {
      notify('success', 'AdTechMedia api authorization token request has been sent');
    },
    error: function(response) {
      notify('error', 'Error requesting AdTechMedia api authorization token. Please try again later...');
    },
    complete: function() {
      event.target.disabled = false;
    },
  });

  return false;
}

window.requestApiToken = requestApiToken;

function initModal() {
  // Get the modal.
  var modal = document.getElementById('terms-modal');

  // Get the button that opens the modal.
  var btn = document.getElementById('terms-btn');

  // Get the <span> element that closes the modal.
  var span = document.getElementsByClassName('close')[0];

  // When the user clicks the button, open the modal.
  btn.onclick = function() {
    modal.style.display = 'block';
  };

  // When the user clicks on <span> (x), close the modal.
  span.onclick = function() {
    modal.style.display = 'none';
  };

  // When the user clicks anywhere outside of the modal, close it.
  window.onclick = function(event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  }
}


function addLoader(btn) {
  var icon = btn.find('i');
  btn.addClass('disabled');
  icon.removeClass('mdi mdi-check');
  icon.addClass('fa fa-spinner fa-spin');
}

function removeLoader(btn) {
  var icon = btn.find('i');
  btn.removeClass('disabled');
  icon.removeClass('fa fa-spinner fa-spin');
  icon.addClass('mdi mdi-check');
}

function showSuccess() {
  notify('success', 'AdTechMedia parameters have been saved successfully');
}

function addValidate(form, rules, messages) {
  jQuery.each(rules, function(name, item) {
    jQuery('input[name="' + name + '"]').on('focus', function() {
      var item = jQuery('input[name="' + name + '"]');

      if (jQuery(item).hasClass('invalid')) {
        jQuery(item).removeClass('invalid');
        var label = jQuery(item).parents('.custom-label').find('label');
        if (!label[0]) {
          label = jQuery(item).parents('.custom-input').find('label');
        }
        label.removeClass('invalid');
      }
    });
  });

  return form.validate({
    rules: rules,
    errorClass: 'invalid',
    onclick: false,
    onkeyup: false,
    onfocusout: false,
    showErrors: function(errorMap, errorList) {
      jQuery.each(errorList, function(i, item) {
        if (!jQuery(item.element).hasClass('invalid')) {
          jQuery(item.element).addClass('invalid');
          var label = jQuery(item.element).parents('.custom-label').find('label');
          if (!label[0]) {
            label = jQuery(item.element).parents('.custom-input').find('label');
          }
          label.addClass('invalid');
        }
      });

      var errorsMeassge = '';
      jQuery.each(errorMap, function(i, item) {
        errorsMeassge += '<br>' + item;
      });
      if (errorsMeassge !== '') {
        return notify('error', errorsMeassge);
      }
    },
    messages: messages
  });
}

jQuery.validator.addMethod(
  'regex',
  function(value, element, regexp) {
    var re = new RegExp(regexp);
    return this.optional(element) || re.test(value);
  },
  'Please check your input.'
);

jQuery.validator.addMethod(
  'notEqual',
  function(value, element, param) {
    return this.optional(element) || parseFloat(value) !== param;
  },
  'Please check your input.'
);

function showError(msg = null) {
  msg = msg || 'AdTechMedia parameters failed to save. Please retry or contact plugin support team.';

  notify('error', msg);
}

function getInputsData(inputs) {
  var styles = {};
  jQuery.each(inputs, function (i, input) {
    if (jQuery(input).val() !== '') {
      if (jQuery(input).is(':checkbox')) {
        styles[jQuery(input).attr('name')] = jQuery(input).prop('checked');
      } else {
        styles[jQuery(input).attr('name')] = jQuery(input).val();
      }

    }
  });
  return styles;
}

function checkBtnRegister(checkbox) {
  var button = jQuery('#btn-register');
  if (jQuery(checkbox).prop('checked')) {
    jQuery(button).removeAttr('disabled');
  } else {
    jQuery(button).attr('disabled', 'true');
  }
}

jQuery().ready(function() {
  jQuery('#save-revenue-model').bind('click', function(e) {
    var btn = jQuery(this);
    var form = jQuery('#save-revenue-model').parents('form');
    var valid = addValidate(jQuery(form), {
      email: {
        required: true,
        email: true
      }
    }, {
      email: {
        required: 'The field \'Email address\' is required.',
        email: 'Your email address must be in the format of name@domain.com.'
      }
    });
    if (valid.form()) {
      addLoader(btn);
      jQuery.ajax({
        url: save_template.ajax_url,
        type: 'post',
        data: {
          action: 'save_template',
          nonce: save_template.nonce,
          revenueMethod: jQuery('select[name="revenue_method"]').val(),
          country: jQuery('select[name="country"]').val(),
          currency: jQuery('#price_currency').val()
        },
        success: function(response) {
          removeLoader(btn);
          showSuccess();
        },
        error: function(response) {
          removeLoader(btn);
          showError();
        }
      });
    }
  });
  jQuery('#country').bind('change', function(e) {
    var country = jQuery(this);
    var method = jQuery('#revenue_method');
    method.empty();
    var currency = jQuery('#price_currency');
    currency.empty();
    jQuery.each(country.find(':selected').data('methods'), function(key, value) {
      method.append(jQuery('<option></option>')
        .attr('value', value).text(value));
    });
    jQuery.each(country.find(':selected').data('currency'), function(key, value) {
      currency.append(jQuery('<option></option>')
        .attr('value', value).text(value));
    });
  });

  $price = jQuery('#price');
  $price.keypress(function(event) {
    var $this = jQuery(this);
    var text = $this.val();

    if ((event.which !== 46 || text.indexOf('.') !== -1)
        && ((event.which < 48 || event.which > 57)
        && (event.which !== 0 && event.which !== 8))) {
      event.preventDefault();
    }
    if (parseInt(text) > 9999999) {
      event.preventDefault();
    }
    if ((text.split('.')[0].length === 0) && ((event.which === 46) || (event.which === 47))) {
      $this.val('0.');
      event.preventDefault();
    }
    if ((event.which === 46) && (text.indexOf('.') === -1)) {
      setTimeout(function() {
        if ($this.val().substring(text.indexOf('.')).length > 3) {
          $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
        }
      }, 1);
    }
    if ((text.indexOf('.') !== -1) &&
            (text.substring(text.indexOf('.')).length > 2) &&
            (event.which !== 0 && event.which !== 8) &&
            (jQuery(this)[0].selectionStart >= text.length - 2)) {
      event.preventDefault();
    }
  });

  $price.bind('paste', function(e) {
    var text = e.originalEvent.clipboardData.getData('Text');
    if (jQuery.isNumeric(text)) {
      if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
        e.preventDefault();
        jQuery(this).val(text.substring(0, text.indexOf('.') + 3));
      }
    }
    else {
      e.preventDefault();
    }
  });

  $pristine = jQuery('#payment_pledged, #content_offset');
  $pristine.keyup(function(event) {
    var $this = jQuery(this);
    var text = $this.val();
    if (text.length > 7) { event.preventDefault(); }
    if ((text.indexOf('.') !== -1) || (text.length > 7)) {
      $this.val($this.val().replace('.','').substring(0,7));
      event.preventDefault();
    }
  });

  jQuery('#content-config button').bind('click', function(e) {
    var btn = jQuery(this);

    var valid = addValidate(jQuery('#content-config'), {
      price: {
        required: true,
        regex: '^([0-9]{1,7})?(\.|,)?([0-9]{1,2})$',
        notEqual: 0
      },
      payment_pledged: {
        required: true,
        digits: true
      },
      content_offset: {
        required: true,
        digits: true,
        min: 0
      },
      ads_video: {
        required: false,
        url: true
      }
    }, {
      price: {
        required: 'The field \'Content pricing\' is required.',
        digits: 'The field \'Content pricing\' must be a number.'
      },
      payment_pledged: {
        required: 'The field \'Content paywall\' is required.',
        digits: 'The field \'Content paywall\' must be a number.'
      },
      content_offset: {
        required: 'The field \'Content preview\' is required.',
        digits: 'The field \'Content preview\' must be a number.'
      },
      ads_video: {
        required: false,
        url: 'The field \'Content preview\' must be a valid url.'
      }
    });
    if (valid.form()) {
      addLoader(btn);
      addLoader(saveTemplatesBtn);
      jQuery.ajax({
        url: save_template.ajax_url,
        type: 'post',
        data: {
          action: 'save_template',
          nonce: save_template.nonce,
          contentConfig: JSON.stringify(getInputsData(
            jQuery('#content-config .content input,#content-config .content select')
          ))
        },
        success: function(response) {
          removeLoader(btn);
          removeLoader(saveTemplatesBtn);
          showSuccess();
        },
        error: function(response) {
          removeLoader(btn);
          showError();
        }
      });
    }
  });
  
  var terms = jQuery('#terms');

  terms.on('change', function() {
    checkBtnRegister(this);
  });

  jQuery.get(window.termsUrl).done(function(data) {
    jQuery('#modal-content').append(data);
  }).fail(function() {
    var str = '<a href="' + window.termsUrl + '"' + ' target="_blank">' + window.termsUrl + '</a>';
    jQuery('#modal-content').append(str);
  });
  
  checkBtnRegister(terms);
  initModal();

  if (!apiKey) { return false }

  var atmEnv = 'prod';

  if (isLocalhost) {
    atmEnv = 'test';
  } else if (isStage) {
    atmEnv = 'stage';
  }

  const brEngine = atmBr(atmEnv);
  const brRendition = brEngine.authorize(apiKey).render('#br-manager').defaultSchema();

  brEngine.sync(propertyId, brRendition)
    .then(save => {
      brRendition.emitter.on('update', () => {
        setTimeout(() => {
          save()
            .catch(error => {
              showError('Error saving Business Rules. Please retry or contact plugin support team.');
            });
        }, 100);
      });
    })
    .catch(error => {
      showError('Error synchronizing Business Rules. Please reload the page or contact plugin support team.');
    });
  
  const saveTemplatesBtn = jQuery('#save-templates-config');
  const tplManager = atmTplManager(atmEnv);
  const runtime = tplManager.rendition().render('#template-editor');

  function applyOverallStyles(appearanceSettings, showNotify = false) {
    if (!appearanceSettings) { return; }
    var overallHtml = '';
    var $overallTemplate = jQuery('#overall-template-api');
    overallHtml = '.atm-base-modal { background-color: '+appearanceSettings.model.body.backgroundColor+'}\n'+
        '.atm-targeted-modal .atm-head-modal .atm-modal-heading { background-color: '+
        appearanceSettings.model.body.backgroundColor+'}\n' +
        '.atm-targeted-modal { position: relative; border: '+
        appearanceSettings.model.body.border+'; box-shadow: '+appearanceSettings.model.body.boxShadow+'}\n'+
        '.atm-base-modal .atm-footer  { background-color: '+
        appearanceSettings.model.footer.backgroundColor+'; border: '+
        appearanceSettings.model.body.backgroundColor+'}\n'+
        '.atm-targeted-container .mood-block-info,.atm-targeted-modal,.atm-targeted-modal .atm-head-modal '+
        '.atm-modal-body p,.atm-unlock-line .unlock-btn  { font-family: '+
        appearanceSettings.model.footer.fontFamily+'}';

    $overallTemplate.html( overallHtml );

    jQuery.ajax({
      url: save_template.ajax_url,
      type: 'post',
      data: {
        action: 'save_template',
        nonce: save_template.nonce,
        appearanceSettings: JSON.stringify(tplManager.generalSettings)
      },
      success: function () {
        if (showNotify) { removeLoader(saveTemplatesBtn); }
      },
      error: function(response) {
        showError();
      }
    });
  }

  runtime.showSettings = true;
  tplManager.client.bindLoader(runtime);
  tplManager.generalSettings = appearanceSettings;

  tplManager
    .authorizeAndSetup(apiKey, propertyId)
    .then(function(exists) {
      let result;
      if (exists) {
        result = tplManager.fetch();
      } else {
        result = tplManager.createDefaults(propertyId, themeId, platformId, themeVersion, platformVersion);
      }
      return result;
    })
    .then(function() {
      return tplManager.syncConfig(runtime);
    })
    .then(function() {
      function syncTemplates(notify) {
        addLoader(saveTemplatesBtn);
        tplManager.waitConfig(runtime)
          .then(function() {
            return tplManager.updateAll();
          })
          .then(function() {
            applyOverallStyles(tplManager.generalSettings, true);
          })
          .catch(function(error) {
            removeLoader(saveTemplatesBtn);
            showError('Error saving Templates Configuration. Please retry or contact plugin support team.');
          });
      }
      
      saveTemplatesBtn.on('click', function() {
        if (jQuery(this).hasClass('disabled')) { return; }
        syncTemplates(true);
      });

      if (forceSaveTemplates) {
        syncTemplates();
      }

      applyOverallStyles(tplManager.generalSettings);
    });
});

jQuery().ready(function() {
  var url = window.location.href;
  var apiToken = (/atm-token/gi.test(url)) 
    ? url.match(/atm-token=([^&]+)/)[1]
    : '';
  
  if (apiToken) {
    jQuery('.atm-missing-key-msg').addClass('preloader');
    jQuery('.atm-missing-key-msg *').css('opacity', 0);
    jQuery.ajax({
      url: ajaxurl,
      type: 'post',
      data: {
        action: 'key_from_token',
        atm_token: apiToken
      },
      success: function(response) {
        if (response.length > 0) {
          window.location = url.replace(/\&atm-token=([^&]+)/, '');
        }
      },
      error: function(response) {
        notify('error', 'Error requesting AdTechMedia api authorization token. Please try again later...');
      }
    });
  }
  if (updatedAppearance === 0) {
    jQuery.ajax({
      url: ajaxurl,
      type: 'post',
      data: {
        action: 'update_appearance'
      }
    });
  }
});
