
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'jquery-ui/ui/widgets/autocomplete.js';
import 'jquery-ui/ui/widgets/sortable.js';
import 'jquery-steps/build/jquery.steps.min.js';
import 'formBuilder/dist/form-builder.min.js';
import 'formBuilder/dist/form-render.min.js';
import 'jquery-validation/dist/jquery.validate.min.js';

// TinyMCE
import 'tinymce/tinymce.min.js';

// Date Range picker
import 'daterangepicker/daterangepicker.js';

// TableSaw
import 'tablesaw/dist/stackonly/tablesaw.stackonly.js';
import 'tablesaw/dist/tablesaw-init.js';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

//CHECK TERMS ACCEPTANCE BUTTON TO ENABLE SUBMIT BUTTON
function checkTerms() {
    if ( $('.terms-acceptance').is(":checked") ) {
        $('.terms-button').removeAttr("disabled");
    } else {
        $('.terms-button').attr("disabled", "disabled");
    }
}
$(document).ready(function() {
    checkTerms();
});
$('.terms-acceptance').on('click', function() {
    checkTerms();
});
//END - CHECK TERMS ACCEPTANCE BUTTON

$(function (){
// REFERRALS
	// Check if phone number is already referred
	$('#referral-create-form input[name="phone"]').blur(function (){
		if ($(this).val()) {
			$.get('/referral/check-duplicate', {
				phone: $(this).val()
			}, function (data){
				if (data.phone) {
					$('.bfh-phone').addClass('duplicate-referral');
				} else {
					$('.bfh-phone').removeClass('duplicate-referral');
				}
			});
		}
	});
	// Check if email address is already referred
	$('#referral-create-form input[name="email"]').blur(function (){
		if ($(this).val()) {
			$.get('/referral/check-duplicate', {
				email: $(this).val()
			}, function (data){
				if (data.email) {
					$('.referral-email').addClass('duplicate-referral');
				} else {
					$('.referral-email').removeClass('duplicate-referral');
				}
			});
		}
	});

	// Check duplicate before submitting form
	$('#referral-create-form').submit(function (){
		if ($('.duplicate-referral').length) {
			$('#incentful-modal').modal('show');
			return false;
		}
	});
	// Prepare modal
	$('.create-referral #incentful-modal .modal-body').html('<p>The referral you are trying to submit is already on the system.</p>');
	$('.create-referral #incentful-modal .btn.submit').on('click', function (){
		$('.referral-email').removeClass('duplicate-referral');
		$('.bfh-phone').removeClass('duplicate-referral');
		$('#referral-create-form').submit();
	});
	$('.create-referral #incentful-modal .btn.cancel').on('click', function (){
		location.href = '/';
	});

	var phone_p = $('.phone-placeholder');
	processPhone(phone_p);
	phone_p.on('focus', function (){
		$(this).hide();
		$('.bfh-phone').removeClass('hidden').focus().on('blur', function (){
			processPhone(phone_p);
		});
	});
	function processPhone(phone_p){
		if ($('.bfh-phone').val() == '(' || !$('.bfh-phone').val()) {
			phone_p.show();
			$('.bfh-phone').addClass('hidden').focus();
		} else {
			phone_p.hide();
			$('.bfh-phone').removeClass('hidden');
		}
	}

	$('.referral-status .dropdown-menu li a').on('click', function (){
		var _this = $(this);

		// Save current selected status for dynamic adjustments of referral tally.
		var currentStatus = $(this).closest('.referral-status').find('.form-control').text(); 

		if (currentStatus == _this.text()) {
			return false;
		}

		// Change status of referral
		var data;
		data = {
			id: $(this).closest('td').data('id'),
			status: $(this).data('status')
		};
		function statusCallback(callbackData){
         	_this.closest('td').find('.form-control').text(_this.text());
   			var approvalCnt = $('.pending-approval .rh-count span');
   			var rewardCnt = $('.pending-reward .rh-count span');
         	switch (_this.text()) {
         		case ('Submitted'):
         			approvalCnt.text(parseInt(approvalCnt.text()) + 1);
         			if (currentStatus == "Approved") {
         			rewardCnt.text(parseInt(rewardCnt.text()) - 1);
         			}
         			break;
         		case ('Approved'):
         			rewardCnt.text(parseInt(rewardCnt.text()) + 1);
         			if (currentStatus == "Submitted") {
         				approvalCnt.text(parseInt(approvalCnt.text()) - 1);
         			}
         			break;
         		default:         			
         			if (currentStatus == "Submitted") {
         				approvalCnt.text(parseInt(approvalCnt.text()) - 1);
         			}
         			if (currentStatus == "Approved") {
         			rewardCnt.text(parseInt(rewardCnt.text()) - 1);
         			}
         	}
		}

		// Prepare admin note
       	if (_this.text() == "Denied") {
       		var referrals_modal = $('.referrals-wrapper #incentful-modal');
       		referrals_modal.find('.modal-title').text('Note for Denying Referral');
       		referrals_modal.find('.modal-body').html('<textarea class="referrals modal-textarea"></textarea>');
			referrals_modal.modal('show');
			referrals_modal.on('shown.bs.modal',function (){
				var options = {
					selector: '.modal-textarea',
					menubar: false,
					statusbar: false
				}
				tinymceHelper(options, false);
			});
			$('.referrals-wrapper #incentful-modal .btn.submit').on('click', function (){
				tinymceHelper(null, true);
				data.note = $('.referrals.modal-textarea').val();
				ajaxHelper("referral/update", data, "POST", statusCallback);
				referrals_modal.modal('hide');
			});
			$('.referrals-wrapper #incentful-modal .btn.cancel').on('click', function (){
				referrals_modal.modal('hide');
			});
       	} else {
			ajaxHelper("referral/update", data, "POST", statusCallback);
       	}
	});
// END - REFERRALS

// NOTIFICATIONS
	$('button.mark-read').on('click', function (){
		var notification = $(this).closest('.notifications');
		var _this = $(this);
		// Mark as read notifications by id
        $.ajax({
            type: "POST",
			 beforeSend: function(request) {
			   request.setRequestHeader("X-CSRF-TOKEN", notification.data('token'));
			 },
            url: "/user/" + notification.data('id') + "/notification/" + $(this).data('nid'),
            success: function( data ) {
            	if (data == "success") {
            		_this.closest('.alert').remove()
            	}
            }
        });
	});
// END - NOTIFICATIONS

// GET MEMBERS
	// Retrieve all members
    $( "input[name='member']" ).autocomplete({
    	source: function (request, response){
    		$.ajax({
    			url: '/members/1'
    		}).done(function (data){
    			response($.map( data, function(id, name) {
    				return {id: id, value: name};
             		}));
    		});
    	},
    	select: function (e, ui){
    		$('#member-id').val(ui.item.id);
    	}
    });
// END - GET MEMBERS

// ADJUST HEIGHT
	adjustMainBodyHeight();
	$( window ).resize(function() {
		adjustMainBodyHeight();
	});
	function adjustMainBodyHeight(){
		var height = $('.panel-body').height() > $('.col-sidebar').height() ? $('.panel-body').height() : $('.col-sidebar').height();
		height = height > $('body').height() ? height : $('body').height();
		$('.logged-in .main-content').height(height);
	}
// END - ADJUST HEIGHT

// JQUERY FORMBUILDER
	  let fields = [
	    {
	      label: 'Email',
	      attrs: {
	        type: 'email',
	        subtype: 'email',
	        className: 'form-control'
	      },
	      icon: '<i class="fa fa-envelope-o"></i>'
	    }
	  ];

	  let templates = {
	    email: function(fieldData) {
	      return {
	        field: '<input type="email" name="email" />',
	        onRender: function() {
	          //$(document.getElementById(fieldData.name)).rateYo({rating: 3.6});
	        }
	      };
	    }
	  };

	  let inputSets = [{
	        label: 'Address',
	        name: 'address', // optional
	        showHeader: false, // optional
	        fields: [
	        	{
		          type: 'text',
		          label: 'Address',
		          className: 'form-control'
		        }, {
		          type: 'text',
		          label: 'Line 2',
		          className: 'form-control',
		        }, {
		          type: 'text',
		          label: 'City:',
		          className: 'form-control'
	        	}, {
		          type: 'select',
		          label: 'State',
		          className: 'form-control',
		          values: [{
		            label: 'Alabama',
		            value: 'al'
		          }, {
		            label: 'Wyoming',
		            value: 'wy',
		            selected: false
		          }]
		        }, {
		          type: 'number',
		          label: 'Zip',
		          className: 'form-control'
		        }
	        ]}, {
	        label: 'User Agreement',
	        fields: [{
	          type: 'header',
	          subtype: 'h3',
	          label: 'Terms & Conditions',
	          className: 'header'
	        }, {
	          type: 'paragraph',
	          label: 'I understand that the receipt of the $100.00 Cash Reward is dependent on my referral\'s AC installation Status. I am only entitled for a Referral Reward if/when this referral\'s AC Unit has been installed by All Year Cooling and Heating, Inc. View our full terms and conditions. ',
	        }, {
	          type: 'checkbox',
	          label: 'Do you agree to the terms and conditions?',
	        }]
	      }];

	  var typeUserDisabledAttrs = {
	    autocomplete: ['access']
	  };

	  var typeUserAttrs = {
	    text: {
	      className: {
	        label: 'Class',
	        options: {
	          'red form-control': 'Red',
	          'green form-control': 'Green',
	          'blue form-control': 'Blue'
	        },
	        style: 'border: 1px solid red'
	      }
	    }
	  };

	  // test disabledAttrs
	  let disabledAttrs = ['placeholder'];

	  const fbOptions = {
	    subtypes: {
	      text: ['datetime-local']
	    },
      	disableFields: ['autocomplete', 'starRating', 'hidden', 'file', 'date'],
		defaultFields: [{
			className: "form-control",
			label: "First Name",
			placeholder: "Enter your first name",
			name: "first-name",
			required: true,
			type: "text"
		},{
			className: "form-control",
			label: "Last Name",
			placeholder: "Enter your last name",
			name: "last-name",
			required: true,
			type: "text"
		},{
			className: "form-control",
			label: "Phone",
			placeholder: "Enter your phone number",
			name: "phone",
			required: true,
			type: "text"
		},{
			className: "form-control",
			label: "Address",
			placeholder: "Enter your address",
			name: "address",
			required: true,
			type: "text"
		},{
			className: "form-control",
			label: "Line 2",
			placeholder: "Enter your address line 2",
			name: "address2",
			required: true,
			type: "text"
		},{
			className: "form-control",
			label: "City",
			placeholder: "Enter your City",
			name: "city",
			required: true,
			type: "text"
		},{
			className: "form-control",
			label: "Zip",
			placeholder: "Enter your Zip",
			name: "zip",
			required: true,
			type: "text"
		}],
	    roles: {},
	    onSave: function(e, formData) {
	      toggleEdit();
	      $('.render-wrap').formRender({
	        formData,
	        templates
	      });
	      window.sessionStorage.setItem('formData', JSON.stringify(formData));
	    },
	    stickyControls: {
	      enable: true
	    },
	    sortableControls: true,
	    fields,
	    templates,
	    inputSets,
	    typeUserDisabledAttrs,
	    typeUserAttrs,
	    // disabledAttrs
	  };
	  let formData = window.sessionStorage.getItem('formData');
	  let editing = true;

	  if (formData) {
	    fbOptions.formData = JSON.parse(formData);
	  }

	  function toggleEdit() {
	    document.body.classList.toggle('form-rendered', editing);
	    return editing = !editing;
	  }

	  const setFormData = '[{"type":"text","label":"Full Name","subtype":"text","className":"form-control","name":"text-1476748004559"},{"type":"select","label":"Occupation","className":"form-control","name":"select-1476748006618","values":[{"label":"Street Sweeper","value":"option-1","selected":true},{"label":"Moth Man","value":"option-2"},{"label":"Chemist","value":"option-3"}]},{"type":"textarea","label":"Short Bio","rows":"5","className":"form-control","name":"textarea-1476748007461"}]';

	  const formBuilder = $('.build-wrap').formBuilder(fbOptions);
	  const fbPromise = formBuilder.promise;

	  fbPromise.then(function(fb) {
	    let apiBtns = {
	      showData: fb.actions.showData,
	      clearFields: fb.actions.clearFields,
	      getData: () => console.log(fb.actions.getData()),
	      setData: () => fb.actions.setData(setFormData),
	      addField: () => {
	        let field = {
	            type: 'text',
	            class: 'form-control',
	            label: 'Text Field added at: ' + new Date().getTime()
	          };
	        fb.actions.addField(field);
	      },
	      removeField: () => fb.actions.removeField(),
	      testSubmit: () => {
	        console.log(document.forms[0].checkValidity());
	        // document.forms[0].submit()
	      },
	      resetDemo: () => {
	        window.sessionStorage.removeItem('formData');
	        location.reload();
	      }
	    };
	    
	    // Apply saved form from db
		if ($('.raw-form-json').text()) {
			formBuilder.actions.setData($('.raw-form-json').text());
		}
		$('.frmb').show();

		// Lock name fields
		$('.frmb .text-field').each(function (){
			var label = $(this).find('label.field-label').text();
			if (label == "First Name" || label == "Last Name" || label == "Email") {
				$(this).closest('.text-field').find('.field-actions').addClass('hidden');
			}
		});
	  });	  

	  //document.getElementById('edit-form').onclick = function() {
	    //toggleEdit();
	  //};

// END - JQUERY FORMBUILDER

// JQUERY STEPS
	var form = $("#register-form-multistep");
	var multiStepRegistration = [
		'We need some basic information about you to get started.',
		'Tell Us About Your Company',
		'What information do you need to follow up with a referral?<span class="subtext">This is the information your referral club members will enter when submitting a referral.</span>',
		'How will you reward your members for their qualifying referrals?',
		'Please review the information you have entered.'
	];
	form.closest('.register-main').find('.top-content').text(multiStepRegistration[0]);
	/*form.validate({
		errorPlacement: function errorPlacement(error, element) { element.after(error); },
		rules: {
			confirm: {
				equalTo: "#password"
			}
		}
	});*/
	var setFormGen = 0;
	form.children("div").steps({
		headerTag: "h3",
		bodyTag: "section",
		transitionEffect: "slideLeft",
		onInit: function ()
		{
			$('#register-form-multistep').show();
			// Process label of multi step form
			var text = form.find('.steps').hide().clone().appendTo($('.form-multistep-number')).show();
			$('.steps').find('a').each(function (){
				$(this).contents().filter(function (){
					return this.nodeType == 3;
				}).wrap('<span class="step-label"></span>');
			}).find('.number').text(function (){
				$(this).text($(this).text().replace('.', ''));
			});
			$('.actions').addClass('col-md-12');
		},
		onStepChanging: function (event, currentIndex, newIndex)
		{
			//form.validate().settings.ignore = ":disabled,:hidden";
			form.find('.actions').find('li').click(function (){
				$('.form-multistep-number li.current').removeClass('current');
				$('.form-multistep-number li').eq($('.steps').find('li.current').index()).addClass('current');
				stepsContentHeight();
			});
			stepsContentHeight();
			if (newIndex == 2 && !setFormGen) {
		  		$('#register-form-multistep #steps-uid-0-p-2').html($('.form-generator'));
		  		setFormGen = 1;
			}
			form.closest('.register-main').find('.top-content').html(multiStepRegistration[newIndex]);
			return true;//form.valid();
		},
		onFinishing: function (event, currentIndex)
		{
			//form.validate().settings.ignore = ":disabled";
			return true; //form.valid();
		},
		onFinished: function (event, currentIndex)
		{
			alert("Submitted!");
			console.log(event);
		},
		labels: {
			previous: 'Back',
			finish: 'Submit'
		}
	});
	stepsContentHeight();
	$( window ).resize(function() {
		stepsContentHeight();
	});
	function stepsContentHeight(){
		$('.wizard .content').css('min-height', $('.wizard .content section.current .form-group-wrapper').height() + 25);
	} 
// END JQUERY STEPS

// COMMON
	$('.check-all').on('click', function (){
		$('.checkbox-group').prop('checked', this.checked);
	});
	
	// Init bootstrap tooltip
	$('[data-toggle="tooltip"]').tooltip();
	$('.tooltip-q').on('click', function (){
		$(this).tooltip('show');
	});

	// TinyMCE helper
	function tinymceHelper(options, save) {
		if (save) {
			tinymce.triggerSave();
		} else {
			tinymce.init(options);
		}
	}

	// Ajax helper
	function ajaxHelper(url, data, method, callback) {
		$.ajax({
			url: url,
			data: data,
			type: method,
			beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').prop('content'));},
			success: function(data) { 
				callback(data);
			}
        });
	}

	// Get base64 of file uploaded
	function readImage(input, callback) {
	    if (input.files && input.files[0]) {
	    	var url = window.URL || window.webkitURL;
	        var image = new Image();

	        image.onload = function (e) {
	           callback(input, this.src, false);
	        }

	        image.onerror = function (e) {
	           callback(input, this.src, true);
	        }

			image.src = url.createObjectURL(input.files[0]);
	    }
	}

// END COMMON

// SIDEBAR
	$('.menu-marker').on('click', function (){
		var target_menu = $(this).parent().next();
		var plus = $(this).parent().find('.fa-plus');
		var minus = $(this).parent().find('.fa-minus');
		if (target_menu.is(':visible')) {minus.removeClass('fa-minus').addClass('fa-plus');}
		else {plus.removeClass('fa-plus').addClass('fa-minus');}
		return;
	});

// END SIDEBAR

// JQUERY DATERANGEPICKER
	var currentDate = new Date();
	var dayFrom = currentDate.getDate() - 30;
	var day = currentDate.getDate();
	var month = currentDate.getMonth() + 1;
	var year = currentDate.getFullYear();
	
	var dateRange = [];
	if ($('input[name="daterange"]').val()) {
		dateRange = $('input[name="daterange"]').val().split('|');
	} else {
		dateRange[0] = dateRange[1] = month + '/' + day	 + '/' + year
	}
	$('input[name="daterange"]').daterangepicker({
		drops: 'down',
	    startDate: dateRange[0],
	    endDate: dateRange[1],
	}).on('apply.daterangepicker', function(ev, picker) {
      window.location.href = "/referrals?daterange=" + picker.startDate.format('MM/DD/YYYY') + "|" + picker.endDate.format('MM/DD/YYYY') + $(this).data('query');
  	});

// END JQUERY DATERANGEPICKER

// FILTER REFERRALS BY STATUS
	$('.filter-by .dropdown-menu li a').click(function(){
		window.location.href = "/referrals?status=" + $(this).data('id') + $(this).data('query');
	});
// END FILTER REFERRALS BY STATUS

// SEARCH REFERRALS
	var query = $('input[name="q"]');
	$('.btn-search').on('click', function (){
		window.location.href = query.data('url') + '?q=' + query.val() + query.data('query');
	});
	query.keydown(function (e){		 
	    if(e.keyCode == 13){
	        $('.btn-search').trigger('click');
	    }
	});
// SEARCH REFERRALS

// CREATE COMPANY
	function processLogo (input, data, error){
		if (error) { 
	        alert('Please upload a valid logo image.');
			$('.submit-company').removeClass('disabled').removeAttr('disabled');
	    	$('.upload-label').text('Upload Company Logo');
	    	$('.logo-preview img').prop('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7').parent().addClass('hidden');	    	
		    $('.logo-blob').val('');
		    $('.logo-blob-name').val('');
	    	return false;
		}
		var filename = input.files[0].name;
	    $('.upload-label').text('Filename: ' + filename);
	    $('.logo-preview img').prop('src', data).parent().removeClass('hidden');
	    $('.logo-blob').val(data);
	    $('.logo-blob-name').val(filename);
		$('.submit-company').removeClass('disabled').removeAttr('disabled');
	}
	$("#logo-upload").change(function(){
		$('.submit-company').addClass('disabled').prop('disabled', 'disabled');
	    $('.upload-label').text('Processing...');
		readImage(this, processLogo);
	});	

	// Update logo
	function updateLogo (input, data, error){
		if (!error) {
			$('.company-logo img').prop('src', data);
			$('#company-update-logo').submit();
		} else {
			$('.processing').addClass('hidden');
			$('.company-logo img').css('opacity', 1);			
		}
	}
	$('.logo-input').on('change', function (){
		$('.processing').removeClass('hidden');
		$('.company-logo img').css('opacity', .5);
	}).closest('.company-logo').find('.ajax-logo').on('click', function (){	
		$('.logo-input').trigger('click');
	});
// END CREATE COMPANY

// MESSAGES
	var options = {
		selector: 'textarea[name="message"]',
		menubar: false,
		statusbar: false
	}
	tinymceHelper(options, false);
// END MESSAGES

// CONTACT
	$('#contact-form').on('click', function (){
		tinymceHelper(null, true);
	});
// END CONTACT

// MANAGE ACCOUNT
	var uploadLabel;
	function processProfile (input, data, error){
		if (error) { 
	        alert('Please upload a valid profile image.');
	    	$('.upload-label').text(uploadLabel);	    	
	    	$('.profile-preview img').prop('src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7').parent().addClass('hidden');	    	
		    $('.profile-blob').val('');
		    $('.profile-blob-name').val('');
	    	return false;
		}
		var filename = input.files[0].name;
	    $('.profile-preview img').prop('src', data).parent().removeClass('hidden');
	    $('.upload-label').text('Filename: ' + filename);
	    $('.profile-blob').val(data);
	    $('.profile-blob-name').val(filename);
		$('.submit-profile').removeClass('disabled').removeAttr('disabled');
	}
	$("input[name='profile']").change(function(){
		$('.submit-profile').addClass('disabled').prop('disabled', 'disabled');
		uploadLabel = $('.upload-label').text();
	    $('.upload-label').text('Processing...');
		readImage(this, processProfile);
	});	
// END MANAGE ACCOUNT

// REFERRAL PROGRAM SETTINGS
	function formBuilderCallback(data) {
	    location.reload();
	}
	$('.submit-custom-form').on('click', function (){
    	var formBuilderData = formBuilder.actions.getData('json');
    	var formGenerator = $('.form-generator');
    	if (formBuilderData != "[]") {
	    	$(this).addClass('disabled');
	    	$(this).button('loading');
			var data = {
				company_id: formGenerator.data('company-id'),
				raw_form_json: formBuilderData,
				form_name: ($('input[name="template_name"]').val() != '') ? $('input[name="template_name"]').val() : 'Referral form template'
			};
			ajaxHelper("/program-options/referral-program-settings", data, "POST", formBuilderCallback);
    	}
		/* var fbRender = document.getElementById('fb-rerender'),
		  formData = formBuilder.actions.getData("json");
		  var formRenderOpts = {
		    formData,
		    dataType: 'json'
		  };
		  $(fbRender).formRender(formRenderOpts);
		  
		*/
	});
	$('.clear-all-trigger').on('click', function (){
		$('.clear-all').click();
	});
// END REFERRAL PROGRAM SETTINGS


});