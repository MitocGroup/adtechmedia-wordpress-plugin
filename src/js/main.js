/**
 * Created by yama_gs on 21.10.2016.
 */

function getCSSFields(inputs) {
  var styles = {};

  jQuery.each(inputs, function (i, input) {
    if (jQuery(input).val() !== '') {
      styles[jQuery(input).data('template-css')] = jQuery(input).val();
    }
  });
  return styles;
}

function getInputsData(inputs){
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

function getPositionFields() {
  var inputs = jQuery('[data-template="position"] input');

  return getInputsData(inputs);
}

function getOverallStylingFields() {
  var styles = {},
    inputs = jQuery('[data-template="overall-styling"] input');
  jQuery.each(inputs, function (i, input) {
    if (jQuery(input).val() !== '') {
      styles[jQuery(input).attr('data-template-css')] = jQuery(input).val();
    }
  });
  return styles;
}

function getOverallStyling() {
  var css = '',
    stylesData = getOverallStylingFields();
  if (stylesData.hasOwnProperty('background-color')) {
    css += '.atm-base-modal {background-color: ' + stylesData['background-color'] + ';}' +
      '.atm-targeted-modal .atm-head-modal ' +
      '.atm-modal-heading {background-color: ' + stylesData['background-color'] + ';}';
  }
  jQuery.each(['border', 'box-shadow'], function (i, key) {
    if (stylesData.hasOwnProperty(key)) {
      css += '.atm-targeted-modal{'+key+': ' + stylesData[key] + ';}';
    }
  });
  if (stylesData.hasOwnProperty('footer-background-color')) {
    css += '.atm-base-modal .atm-footer{background-color: ' + stylesData['footer-background-color'] + ';}';
  }
  if (stylesData.hasOwnProperty('footer-border')) {
    css += '.atm-base-modal .atm-footer{border: ' + stylesData['footer-border'] + ';}';
  }
  if (stylesData.hasOwnProperty('font-family')) {
    css += '.atm-targeted-container .mood-block-info,' +
      '.atm-targeted-modal,' +
      '.atm-targeted-modal .atm-head-modal .atm-modal-body p,' +
      '.atm-unlock-line .unlock-btn {font-family: ' + stylesData['font-family'] + ';}';
  }
  return css;
}
function applayOverallStyling(css) {
  var style = jQuery('#overall-template-styling');
  style.html(css);
}
function fillOverallStylesFields() {
  /*global templateOverallStylesInputs*/
  var inputs = jQuery('[data-template="overall-styling"] input');
  jQuery.each(inputs, function (i, input) {
    var key = jQuery(input).attr('data-template-css');
    if (templateOverallStylesInputs.hasOwnProperty(key)) {
      jQuery(input).val(templateOverallStylesInputs[key])
    }
  });
}
function fillPositionFields() {
  /*global templatePositionInputs*/
  var inputs = jQuery('[data-template="position"] input');
  jQuery.each(inputs, function (i, input) {
    var key = jQuery(input).attr('name');
    if (templatePositionInputs.hasOwnProperty(key)) {
      if (jQuery(input).is(':checkbox')) {
        //styles[jQuery(input).attr('name')] = jQuery(input).prop('checked');
        jQuery(input).prop('checked', templatePositionInputs[key]);
      } else {
        jQuery(input).val(templatePositionInputs[key])
      }
    }
  });
  if (!jQuery('#checkbox-sticky').prop('checked')) {
    jQuery('.disable-if-sticky input').attr('disabled', 'disabled');
  } else {
    jQuery('.disable-if-sticky input').removeAttr('disabled');
  }
}
function fillCSSFields(key, inputValues, inputFields) {
  if (inputValues.hasOwnProperty(key)) {
    jQuery.each(inputValues[key], function (name, value) {
      inputFields[key].inputs.filter('[data-template-css="' + name + '"]').val(value);
    });
  }
}
function inputsToObject(inputs) {
  var res = {};
  jQuery.each(inputs, function (key, value) {
    res[key] = value.input.val();
  });
  return res;
}
function styleInputsToObject(inputs) {
  var res = {};
  jQuery.each(inputs, function (key, value) {
    res[key] = getCSSFields(value.inputs);
  });
  return res;
}
function getDatatemplate(value) {
  if ('auth' == value){
    value = 'pledge';
  }
  return '[data-template="' + value + '"]';
}

function initModal() {
  // Get the modal.
  var modal = document.getElementById('terms-modal');

  // Get the button that opens the modal.
  var btn = document.getElementById('terms-btn');

  // Get the <span> element that closes the modal.
  var span = document.getElementsByClassName('close')[0];

  // When the user clicks the button, open the modal.
  btn.onclick = function () {
    modal.style.display = 'block';
  };

  // When the user clicks on <span> (x), close the modal.
  span.onclick = function () {
    modal.style.display = 'none';
  };

  // When the user clicks anywhere outside of the modal, close it.
  window.onclick = function (event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  }
}

jQuery(document).ready(function () {
  /*global atmTpl, templateInputs, templateStyleInputs, save_template, noty*/
  atmTpl.default.config({revenueMethod: 'micropayments'});
  var atmTemplating = atmTpl.default;

  //atmTpl.config({revenueMethod: 'advertising'});
  fillPositionFields();
  fillOverallStylesFields();
  var templates = [
    {
      name : 'pledge',
      component : 'pledgeComponent',
      dataTab : 'pledge',
      collapsed : '#render-pledge-collapsed',
      expanded : '#render-pledge-expanded',
      sections : [
        {
          dataTab : 'salutation',
          options : [{
            name : 'body-welcome',
            inputName : 'welcome',
            type : 'expanded'
          }]
        }, {
          dataTab : 'message',
          options : [{
            name : 'body-msg-mp',
            inputName : 'message-expanded',
            type : 'expanded'
          }, {
            name : 'heading-headline',
            inputName : 'message-collapsed',
            type : 'collapsed'
          }]
        }
      ]
    },
    {
      name : 'auth',
      component : 'authComponent',
      dataTab : 'auth',
      collapsed : '#render-pledge-collapsed',
      expanded : '#render-pledge-expanded',
      sections : [
        {
          dataTab : 'user',
          otherComponent: 'authComponent',
          options : [{
            name : 'logged-headline',
            inputName : 'user-logged',
            type : 'collapsed'
          }, {
            name : 'used-headline',
            inputName : 'user-used',
            type : 'expanded'
          }]
        }
      ]
    },
    {
      name : 'pay',
      component : 'payComponent',
      dataTab : 'pay',
      collapsed : '#render-pay-collapsed',
      expanded : '#render-pay-expanded',
      sections : [
        {
          dataTab : 'salutation',
          options : [{
            name : 'body-salutation',
            inputName : 'salutation',
            type : 'expanded'
          }]
        }, {
          dataTab : 'message',
          options : [{
            name : 'body-msg-mp',
            inputName : 'message-expanded',
            type : 'expanded'
          }, {
            name : 'heading-headline-setup',
            inputName : 'message-collapsed',
            type : 'collapsed'
          }]
        }
      ]
    },
    {
      name : 'refund',
      component : 'refundComponent',
      dataTab : 'refund',
      collapsed : '#render-refund-collapsed',
      expanded : '#render-refund-expanded',
      sections : [
        {
          dataTab : 'mood-ok',
          options : [{
            name : 'body-feeling-ok',
            inputName : 'body-feeling-ok',
            type : 'expanded'
          }]
        }, {
          dataTab : 'mood',
          options : [{
            name : 'body-feeling',
            inputName : 'body-feeling',
            type : 'expanded'
          }]
        }, {
          dataTab : 'mood-happy',
          options : [{
            name : 'body-feeling-happy',
            inputName : 'body-feeling-happy',
            type : 'expanded'
          }]
        }, {
          dataTab : 'mood-not-happy',
          options : [{
            name : 'body-feeling-not-happy',
            inputName : 'body-feeling-not-happy',
            type : 'expanded'
          }]
        }, {
          dataTab : 'message',
          options : [{
            name : 'body-msg',
            inputName : 'message-expanded',
            type : 'expanded'
          }, {
            name : 'heading-headline',
            inputName : 'message-collapsed',
            type : 'collapsed'
          }]
        }, {
          dataTab : 'share',
          options : [{
            name : 'body-share-experience',
            inputName : 'body-share-experience',
            type : 'expanded'
          }]
        }
      ]
    }
  ];

  (function ($) {
    // read available template stories
    //atmTpl.default.config({revenueMethod: 'advertising'});
    var stories = atmTemplating.stories();
    console.log(stories);
    var views = {};
    var inputs = {};
    var options = {};
    var styling = {};
    var styleInputs = {};

    function toggleTemplates() {
      var sender = jQuery(jQuery(this.$el).parents('[data-view]')[0]),
        viewKey = sender.attr('data-view-key'),
        type = sender.attr('data-view'),
        typeOther = 'expanded',
        small = true,
        senderParent = sender.parent(),
        senderParentExpaned = senderParent.find('[data-view-text="expanded"]'),
        senderParentCollapsed = senderParent.find('[data-view-text="collapsed"]');
      if (type === 'expanded') {
        typeOther = 'collapsed';
        small = false;
      }
      senderParent.find('[data-view="' + typeOther + '"]').attr('data-view', type);
      sender.attr('data-view', typeOther);
      views[viewKey][typeOther]._watchers['showModalBody'].forEach(unwatch => unwatch());
      delete views[viewKey][typeOther]._watchers['showModalBody'];
      views[viewKey][typeOther].small(small);
      views[viewKey][typeOther].watch('showModalBody', toggleTemplates);
      var tmp = views[viewKey]['expanded'];
      views[viewKey]['expanded'] = views[viewKey]['collapsed'];
      views[viewKey]['collapsed'] = tmp;

      tmp = senderParentExpaned.html();
      senderParentExpaned.html(senderParentCollapsed.html());
      senderParentCollapsed.html(tmp);
    }

    jQuery.each(templates, function (i, template) {
      var tab = jQuery(getDatatemplate(template.dataTab));
      options[template.component] = {};
      styling[template.component] = {};
      var viewKey = template.dataTab;
      views[viewKey] = {};
      jQuery.each(template.sections, function (j, section) {
        var sectionTab = tab.find(getDatatemplate(section.dataTab));
        var styleInputsKey = viewKey + section.dataTab + 'style';
        styleInputs[styleInputsKey] = {
          inputs : sectionTab.find(getDatatemplate('style') + ' input, ' + getDatatemplate('style') + ' select')
        };
        jQuery.each(section.options, function (j, option) {
          var inputsKey = viewKey + section.dataTab + option.type;
          inputs[inputsKey] = {
            input : sectionTab.find('input[name="' + option.inputName + '"]'),
            optionName : option.name,
            type : option.type
          };
          if (templateInputs.hasOwnProperty(inputsKey)) {
            inputs[inputsKey].input.val(templateInputs[inputsKey]);
            options[template.component][option.name] = templateInputs[inputsKey];
            styling[template.component][option.name] = templateStyleInputs[styleInputsKey];
          }

        });
        fillCSSFields(styleInputsKey, templateStyleInputs, styleInputs);
      });
      views[viewKey]['component'] = template.component;
      if ('auth' == viewKey){
        viewKey = 'pledge';
        atmTemplating.updateTemplate(template.component, options[template.component], styling[template.component]);
        views[viewKey].expanded.redraw();
        views[viewKey].collapsed.redraw();
      } else {
        views[viewKey]['expanded'] = atmTemplating.render(template.name, template.expanded);
        views[viewKey]['expanded'].small(false);
        views[viewKey]['collapsed'] = atmTemplating.render(template.name, template.collapsed);
        jQuery(template.expanded).attr('data-view-key', viewKey);
        jQuery(template.collapsed).attr('data-view-key', viewKey);
        atmTemplating.updateTemplate(template.component, options[template.component], styling[template.component]);
        views[viewKey].expanded.redraw();
        views[viewKey].collapsed.redraw();
        views[viewKey].expanded.watch('showModalBody', toggleTemplates);
        views[viewKey].collapsed.watch('showModalBody', toggleTemplates);
      }
    });

    var throttledSync = jQuery.throttle(200, function (e) {
      var viewKey = jQuery(jQuery(this).parents('[data-template]')[2]).data('template');
      var redrawViewKey = viewKey;
      var tabKey = jQuery(jQuery(this).parents('[data-template]')[1]).data('template');
      if ('user' == tabKey) {
        viewKey = 'auth';
      }
      var inputKey = viewKey + tabKey;


      jQuery.each(['expanded', 'collapsed'], function (i, type) {
        //console.log(type);

        if (inputs.hasOwnProperty(inputKey + type)) {
          options[views[viewKey].component][inputs[inputKey + type].optionName] = inputs[inputKey + type].input.val();
          styling[views[viewKey].component][inputs[inputKey + type].optionName] =
            getCSSFields(styleInputs[inputKey + 'style'].inputs);

        }
      });
      // update template
      atmTemplating.updateTemplate(
        views[viewKey].component,
        options[views[viewKey].component],
        styling[views[viewKey].component]
      );

      // redraw the view
      views[redrawViewKey].expanded.redraw();
      views[redrawViewKey].collapsed.redraw();
      views[redrawViewKey].expanded.watch('showModalBody', toggleTemplates);
      views[redrawViewKey].collapsed.watch('showModalBody', toggleTemplates);
    });

    var $form = $('section.views-tabs');
    var $inputs = $form.find('input');
    var $selects = $form.find('select');
    var $colorInputs = $form.find('input[type="color"]');
    var triggered=false;
    function synch(field,dataType,additionalType,eventName){
      synchFromTo(field,dataType,additionalType,eventName,'user-pay','user',true);
      synchFromTo(field,dataType,additionalType,eventName,'user','user-pay',false);
    }


    function synchFromTo(field,dataType,additionalType,eventName,from,to,trigger){
      jQuery('[data-template="'+from+'"] '+field+'['+dataType+']'+additionalType).bind(eventName, function () {

        var input = jQuery(jQuery('[data-template="'+to+'"] '+field+additionalType+'['+dataType+'="'+jQuery(this).attr(dataType)+'"]')[0]);
        input.val(jQuery(this).val());
          triggered=true;
        if (trigger) {
          input.trigger(eventName);
        }else{
          setTimeout(function(){
          views['pay'].expanded.redraw();
          views['pay'].collapsed.redraw();
          },100);
        }
      });
    }
    synch('input','name','','keyup');
    synch('input','data-template-css','','keyup');
    synch('select','data-template-css','','change');
    synch('input','data-template-css','[type="color"]','change');
    $inputs.bind('keyup', throttledSync);
    $colorInputs.bind('change', throttledSync);
    $selects.bind('change', throttledSync);

    var overallSync = jQuery.throttle(200, function () {
      applayOverallStyling(getOverallStyling());
    });
    jQuery('[data-template="overall-styling"] input').bind('keyup', overallSync);
    jQuery('[data-template="overall-styling"] input[type="color"]').bind('change', overallSync);

    function addLoader(btn){
      var icon = btn.find('i');
      btn.addClass('disabled');
      icon.removeClass('mdi mdi-check');
      icon.addClass('fa fa-spinner fa-spin');
    }

    function removeLoader(btn){
      var icon = btn.find('i');
      btn.removeClass('disabled');
      icon.removeClass('fa fa-spinner fa-spin');
      icon.addClass('mdi mdi-check');
    }
    function showSuccess(){
      noty({
        type: 'success',
        text: 'AdTechMedia parameters have been saved successfully',
        timeout: 2000
      });
    }
    function showError(){
      noty({
        type: 'error',
        text: 'AdTechMedia parameters failed to save. Please retry or contact plugin support team.',
        timeout: 2000
      });
    }
    jQuery('.save-templates').bind('click', function (e) {
      var btn = jQuery(this);
      var viewKey = jQuery(btn.parents('[data-template]')[0]).data('template');
      //console.log(viewKey);
      if (viewKey === 'position') {
        viewKey = 'pledge';
      }
      addLoader(btn);
      jQuery.ajax({
        url : save_template.ajax_url,
        type : 'post',
        data : {
          action : 'save_template',
          nonce : save_template.nonce,
          inputs : JSON.stringify(inputsToObject(inputs)),
          styleInputs : JSON.stringify(styleInputsToObject(styleInputs)),
          position : JSON.stringify(getPositionFields()),
          overallStyles : getOverallStyling(),
          overallStylesInputs : JSON.stringify(getOverallStylingFields()),
          component : views[viewKey].component,
          template : atmTemplating.templateRendition(views[viewKey].component).render(
            options[views[viewKey].component],
            styling[views[viewKey].component]
          )
        },
        success : function (response) {
          removeLoader(btn);
          showSuccess();
        },
        error : function (response) {
          removeLoader(btn);
          showError();
        }
      });
      addLoader(btn);
      viewKey = 'auth';
      jQuery.ajax({
        url : save_template.ajax_url,
        type : 'post',
        data : {
          action : 'save_template',
          nonce : save_template.nonce,
          inputs : JSON.stringify(inputsToObject(inputs)),
          styleInputs : JSON.stringify(styleInputsToObject(styleInputs)),
          position : JSON.stringify(getPositionFields()),
          overallStyles : getOverallStyling(),
          overallStylesInputs : JSON.stringify(getOverallStylingFields()),
          component : views[viewKey].component,
          template : atmTemplating.templateRendition(views[viewKey].component).render(
            options[views[viewKey].component],
            styling[views[viewKey].component]
          )
        },
        success : function (response) {
          removeLoader(btn);
          showSuccess();
        },
        error : function (response) {
          removeLoader(btn);
          showError();
        }
      });
    });

    jQuery('#save-revenue-model').bind('click', function (e) {
      var btn = jQuery(this);
      addLoader(btn);
      jQuery.ajax({
        url : save_template.ajax_url,
        type : 'post',
        data : {
          action : 'save_template',
          nonce : save_template.nonce,
          revenueMethod : jQuery('select[name="revenue_method"]').val()
        },
        success : function (response) {
          removeLoader(btn);
          showSuccess();
        },
        error : function (response) {
          removeLoader(btn);
          showError();
        }
      });
    });
    jQuery('#country').bind('change', function (e) {
      var country = jQuery(this),
        method = jQuery('#revenue_method');
      method.empty();
      $.each(country.find(':selected').data('methods'), function(key,value) {
        method.append($('<option></option>')
          .attr('value', value).text(value));
      });
    });
    jQuery('#content-config button').bind('click', function (e) {
      var btn = jQuery(this);
      addLoader(btn);
      jQuery.ajax({
        url : save_template.ajax_url,
        type : 'post',
        data : {
          action : 'save_template',
          nonce : save_template.nonce,
          contentConfig : JSON.stringify(getInputsData(
            jQuery('#content-config .content input,#content-config .content select')
          ))
        },
        success : function (response) {
          removeLoader(btn);
          showSuccess();
        },
        error : function (response) {
          removeLoader(btn);
          showError();
        }
      });
 
    });

  })(jQuery);



  jQuery('#checkbox-sticky').on('change', function () {
    if (!jQuery(this).prop('checked')) {
      jQuery('.disable-if-sticky input').attr('disabled', 'disabled');
    } else {
      jQuery('.disable-if-sticky input').removeAttr('disabled');
    }
  });

  jQuery('#terms').on('change', function () {
    var button = jQuery('#btn-register');
    if (jQuery(this).prop('checked')) {
      jQuery(button).removeAttr('disabled');
    } else {
      jQuery(button).attr('disabled', 'true');
    }
  });

  initModal();

  jQuery('#modal-content').load('https://crossorigin.me/https://www.adtechmedia.io/terms/dialog.html');

  function firstSynch(){
    jQuery('[data-template="user"] input[name]').trigger('keyup');
    jQuery('[data-template="user"] input[data-template-css]').trigger('keyup');
    jQuery('[data-template="user"] select[data-template-css]').trigger('change');
    jQuery('[data-template="user"] input[type="color"][data-template-css]').trigger('change');
  };
  firstSynch();
});
