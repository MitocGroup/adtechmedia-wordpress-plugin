/**
 * Created by yama_gs on 21.10.2016.
 */

/*eslint no-useless-concat:0*/

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
        timeout: 3000,
    });
}, 3500);

/*global send_api_token*/
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
            return_link_tpl: window.location.toString(),
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

function showError() {
    notify(
        'error',
        'AdTechMedia parameters failed to save. Please retry or contact plugin support team.'
    );
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
                  revenueMethod: jQuery('select[name="revenue_method"]').val()
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
      jQuery.each(country.find(':selected').data('methods'), function(key, value) {
          method.append(jQuery('<option></option>')
              .attr('value', value).text(value));
      });
  });
  jQuery('#content-config button').bind('click', function(e) {
      var btn = jQuery(this);

      var valid = addValidate(jQuery('#content-config'), {
          price: {
              required: true,
              digits: true,
              min: 1
          },
          payment_pledged: {
              required: true,
              digits: true
          },
          content_offset: {
              required: true,
              digits: true,
              min: 1
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
  
  const tplManager = atmTplManager(isLocalhost ? 'dev' : 'prod');
  const runtime = tplManager.rendition().render('#template-editor');

  runtime.showSettings = true;
  tplManager.client.bindLoader(runtime);
  tplManager.generalSettings = appearanceSettings;

  tplManager
    .authorizeAndSetup(apiKey, propertyId)
    .then(exists => {        
      return exists 
        ? tplManager.fetch() 
        : tplManager.createDefaults(
          propertyId, themeId, platformId,
          themeVersion, platformVersion
        );
    })
    .then(() => tplManager.syncConfig(runtime))
    .then(() => {
      document.getElementById('save-templates-config')
        .addEventListener('click', e => {
          var btn = jQuery(e.target);
          addLoader(btn);
          tplManager.waitConfig(runtime)
            .then(() => tplManager.updateAll())
            .then(() => {
              jQuery.ajax({
                url: save_template.ajax_url,
                type: 'post',
                data: {
                  action: 'save_template',
                  nonce: save_template.nonce,
                  appearanceSettings: JSON.stringify(tplManager.generalSettings),
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
            });
        });
    });
});
