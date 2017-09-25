
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
import 'spectrum-colorpicker/spectrum.js';

// TinyMCE
import 'tinymce/tinymce.min.js';
import 'tinymce/plugins/image/index.js';
import 'tinymce/plugins/link/index.js';

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
	if (phone_p.length) {
	processPhone(phone_p);
		phone_p.on('focus', function (){
			$(this).hide();
			$('.bfh-phone').removeClass('hidden').focus().on('blur', function (){
				processPhone(phone_p);
			});
		});
	}
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
		var referralProcessing = true;
		var removeStatuDropdown = false;

		// Add spinner to referral status
		_this.closest('.referral-status').find('.fa').removeClass('fa-angle-down').addClass('fa-spinner fa-pulse fa-fw');

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
   			
         	// Update referral counter
   			var approvalCnt = $('.pending-approval .rh-count span a');
   			var rewardCnt = $('.pending-reward .rh-count span a');
   			approvalCnt.text(callbackData.approval.length);
   			rewardCnt.text(callbackData.reward.length);

         	referralProcessing = false;
         	if (removeStatuDropdown) {
				_this.closest('.referral-status').find('.fa').removeClass('fa-angle-down fa-spinner fa-pulse fa-fw').addClass('fa-lock');
         		_this.closest('.referral-status').find('.dropdown-menu').remove();
         	} else {
				_this.closest('.referral-status').find('.fa').removeClass('fa-spinner fa-pulse fa-fw').addClass('fa-angle-down');
         	}
		}

		// Prepare admin note
       	var referrals_modal = $('.referrals-wrapper #incentful-modal');
       	if (_this.data('status') == 4) {
       		referrals_modal.find('.modal-title').text('Note for Denying Referral');
       		referrals_modal.find('.modal-body').html('<textarea class="referrals modal-textarea"></textarea>');
			referrals_modal.modal('show');
			referrals_modal.on('shown.bs.modal',function (){
				var options = {
					selector: '.modal-textarea',
					menubar: false,
					statusbar: false,
			plugins: 'link image'
				}
				tinymceHelper(options, false);
			});
			$('.referrals-wrapper #incentful-modal .btn.submit').on('click', function (){
				if (referralProcessing) {
					tinymceHelper(null, true);
					data.note = $('.referrals.modal-textarea').val();
					ajaxHelper("/referral/update", data, "POST", statusCallback);
					referrals_modal.modal('hide');
				}
			});
			$('.referrals-wrapper #incentful-modal .btn.cancel').on('click', function (){
				referrals_modal.modal('hide');
			});
       	} else if (_this.data('status') == 3) {
       		referrals_modal.find('.modal-title').text('Reward Sent Notification');
       		referrals_modal.find('.modal-body').html('Please take note that the referral status cannot be changed after being set as "Reward Sent"');
			referrals_modal.modal('show');
			$('.referrals-wrapper #incentful-modal .btn.submit').on('click', function (){				
				if (referralProcessing) {
					tinymceHelper(null, true);
					ajaxHelper("/referral/update", data, "POST", statusCallback);
					referrals_modal.modal('hide');
				}
			});
			$('.referrals-wrapper #incentful-modal .btn.cancel').on('click', function (){
				referrals_modal.modal('hide');
			});
			removeStatuDropdown = true;
       	}
       	else {
			if (referralProcessing) {
				ajaxHelper("/referral/update", data, "POST", statusCallback);
			}
       	}
	});
 	$('.current-referral-status').each(function (){
 		if ($(this).data('status') == 3) {$(this).addClass('disabled');}
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

// NOTIFICATION EMAILS
	$('.table-notification-emails input[type="checkbox"]').change(function (){
		if ($(this).is(':checked')) {
			$(this).closest('td').find('.status').text('Inactive');
		} else {
			$(this).closest('td').find('.status').text('Active');
		}
	});
// END - NOTIFICATIONS EMAILS

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

    // Change role
	var $membersModal = $('.members-wrapper #incentful-modal');
	var url;
	$('.change-role').click(function (){
		var role_id = $(this).data('role-id');
   		$membersModal.find('.modal-title').text('Change User Role');
   		$membersModal.find('.modal-body').text($(this).data('name') + '\'s current role is "' + $(this).data('role-name') + '".');
   		$('.member-roles').find('select[name="member-roles"] option[value="' + $(this).data('role-id') + '"]').attr('selected', true);
   		$membersModal.find('.modal-body').append($('.member-roles').html());
   		$membersModal.find('.modal-footer').find('.submit').unbind();
   		$membersModal.find('.modal-footer').find('.cancel').unbind();
   		$membersModal.find('.modal-footer').find('.submit').addClass('btn-primary').text('Apply').on('click', function (){
			ajaxHelper(url, {role_id: role_id, role_id_new: $('.modal-body').find('select[name="member-roles"]').val()}, "POST", function (data){
		    	location.reload();
			});
		});;
   		$membersModal.find('.modal-footer').find('.cancel').addClass('btn-danger').text('Cancel').on('click', function (){
			$membersModal.modal('hide');
		});
		$membersModal.modal('show');
		url = $(this).data('url');
	});

    // Delete user
	$('.delete-user').click(function (){
   		$membersModal.find('.modal-title').text('Delete User Confirmation');
   		$membersModal.find('.modal-body').text('Are you sure you want to delete user ' + $(this).data('name') + '?');
   		$membersModal.find('.modal-footer').find('.submit').unbind();
   		$membersModal.find('.modal-footer').find('.cancel').unbind();
   		$membersModal.find('.modal-footer').find('.submit').addClass('btn-primary').text('Yes').on('click', function (){
			ajaxHelper(url, [], "POST", function (data){
		    	location.reload();
			});
		});
   		$membersModal.find('.modal-footer').find('.cancel').addClass('btn-danger').text('No').on('click', function (){
			$membersModal.modal('hide');
		});
		$membersModal.modal('show');
		url = $(this).data('url');
	});

	// Change password
	$('.change-password').click(function (){
   		$membersModal.find('.modal-title').text('Change Password Confirmation');
   		$membersModal.find('.modal-body').html('<div><span>Enter new password for ' + $(this).data('name') + ':</span></div><div><input type="password" class="form-control" name="user_new_password"></div>');
   		$membersModal.find('.modal-body').append('<div>&nbsp;</div>');
   		$membersModal.find('.modal-body').append('<div><span>Re-enter new password: </span></div><input type="password" class="form-control" name="user_new_password_confirmation">');
   		$membersModal.find('.modal-footer').find('.submit').unbind();
   		$membersModal.find('.modal-footer').find('.cancel').unbind();
   		$membersModal.find('.modal-footer').find('.submit').addClass('btn-primary').text('Change Password').on('click', function (){
   			// Verify that the new passwords match.
   			var newPass = $('input[name=user_new_password]');
   			var newPassConf = $('input[name=user_new_password_confirmation]');
   			if (!newPass.val() && !newPassConf.val()) {
				alert('Please enter a new password');
   			} else if (newPass.val() != newPassConf.val()) {
				alert('The new passwords did not match');
			} else if (newPass.val().length < 6 || newPassConf.val().length < 6) {
				alert('Please enter at least six(6) characters for the password.');
			} else {
				ajaxHelper(url, {user_new_password: newPass.val(), user_new_password_confirmation: newPassConf.val()}, "POST", function (data){
			    	location.reload();
				});
			}
			return;
		});
   		$membersModal.find('.modal-footer').find('.cancel').addClass('btn-danger').text('Cancel').on('click', function (){
			$membersModal.modal('hide');
		});
		$membersModal.modal('show');
		url = $(this).data('url');
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

	  // Setup custom fields
	
	  let fields = [
	    {
	      label: 'Email',
	      attrs: {
	        type: 'text',
	        subtype: 'email',
	      },
		  placeholder: "Enter your Friend's email",
	      subtype: 'email',
	      icon: '<i class="fa fa-envelope-o"></i>'
	    }, {
	      label: 'Phone',
	      attrs: {
	        type: 'text',
	      },
		  className: 'form-control phone-field',
		  placeholder: "Enter your Friend's phone number",
	      icon: '<i class="fa fa-phone"></i>'
	    }
	  ];
	  let templates = {
	  };

	  // Add fields of address set
	  let addressSetArr = [{
			type: 'text',
			label: 'Address',
			placeholder: 'Enter your Friend\'s address',
			className: 'form-control address-group',
			required: true,
			name: 'address'
		}, {
			type: 'text',
			label: 'Line 2',
			placeholder: 'Enter your Friend\'s address line 2',
			className: 'form-control address-group',
			required: false,
			name: 'address2'
		}, {
			type: 'text',
			label: 'City',
			placeholder: 'Enter your Friend\'s city',
			className: 'form-control address-group',
			required: true,
			name: 'city'
		}, {
			type: 'select',
			label: 'State',
			className: 'form-control address-group',
			values: [{value: 'al', label: 'AL'}, {value: 'ak', label: 'AK'}, {value: 'az', label: 'AZ'}, {value: 'ar', label: 'AR'}, {value: 'ca', label: 'CA'}, {value: 'co', label: 'CO'}, {value: 'ct', label: 'CT'}, {value: 'de', label: 'DE'}, {value: 'fl', label: 'FL', selected: true}, {value: 'ga', label: 'GA'}, {value: 'hi', label: 'HI'}, {value: 'id', label: 'ID'}, {value: 'il', label: 'IL'}, {value: 'in', label: 'IN'}, {value: 'ia', label: 'IA'}, {value: 'ks', label: 'KS'}, {value: 'ky', label: 'KY'}, {value: 'la', label: 'LA'}, {value: 'me', label: 'ME'}, {value: 'md', label: 'MD'}, {value: 'ma', label: 'MA'}, {value: 'mi', label: 'MI'}, {value: 'mn', label: 'MN'}, {value: 'ms', label: 'MS'}, {value: 'mo', label: 'MO'}, {value: 'mt', label: 'MT'}, {value: 'ne', label: 'NE'}, {value: 'nv', label: 'NV'}, {value: 'nh', label: 'NH'}, {value: 'nj', label: 'NJ'}, {value: 'nm', label: 'NM'}, {value: 'ny', label: 'NY'}, {value: 'nc', label: 'NC'}, {value: 'nd', label: 'ND'}, {value: 'oh', label: 'OH'}, {value: 'ok', label: 'OK'}, {value: 'or', label: 'OR'}, {value: 'pa', label: 'PA'}, {value: 'ri', label: 'RI'}, {value: 'sc', label: 'SC'}, {value: 'sd', label: 'SD'}, {value: 'tn', label: 'TN'}, {value: 'tx', label: 'TX'}, {value: 'ut', label: 'UT'}, {value: 'vt', label: 'VT'}, {value: 'va', label: 'VA'}, {value: 'wa', label: 'WA'}, {value: 'wv', label: 'WV'}, {value: 'wi', label: 'WI'}, {value: 'wy', label: 'WY'}],
			required: true,
			name: 'state'
		}, {
			type: 'text',
			label: 'Zip',
			placeholder: 'Enter your Friend\'s zip',
			className: 'form-control address-group',
			required: true,
			name: 'zip'
		}]
		let addressSet = {
		      label: 'Address',
		      name: 'address', // optional
		      showHeader: false, // optional
		      fields: addressSetArr
		 }

	  // Init input sets
	  let inputSets = [addressSet, {
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

		// Setup basic and complete fields template
		var defaultFieldsBasic = [{
			className: "form-control",
			label: "First Name",
			placeholder: "Enter your Friend's first name",
			name: "first_name",
			required: true,
			type: "text"
		},{
			className: "form-control",
			label: "Last Name",
			placeholder: "Enter your Friend's last name",
			name: "last_name",
			required: true,
			type: "text"
		},{
			className: "form-control",
			label: "Email",
			placeholder: "Enter your Friend's email",
			name: "email",
			required: true,
			type: "text",
	        subtype: 'email'
		},{
			className: "form-control phone-custom",
			label: "Phone",
			placeholder: "Enter your Friend's phone number",
			name: "phone",
			required: true,
			type: "text"
		}]
		var defaultFieldsComplete = defaultFieldsBasic.slice(0);
		$.each(addressSetArr, function (){
			defaultFieldsComplete.push($(this)[0]);
		});
		var templateObj = {
			defaultFieldsBasic: defaultFieldsBasic,
			defaultFieldsComplete: defaultFieldsComplete
		}

	  var typeUserDisabledAttrs = {
	    autocomplete: ['access']
	  };

	  let disabledAttrs = ['placeholder'];

	  const fbOptions = {
	    subtypes: {
	      text: ['datetime-local']
	    },
      	disableFields: ['autocomplete', 'starRating', 'hidden', 'file', 'date'],
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
	    typeUserDisabledAttrs
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

	  const formBuilder = $('.build-wrap').formBuilder(fbOptions);
	  const fbPromise = formBuilder.promise;

	  // Trigger after form generator has loaded
	  fbPromise.then(function(fb) {	    
	    // Display saved form from db
		if ($('.raw-form-json').text()) {
			formBuilder.actions.setData($('.raw-form-json').text());
		}
		$('.frmb').show();

    	if (formBuilder.actions.getData && formBuilder.actions.getData('json') == '[]') {
			formBuilder.actions.setData(JSON.stringify(defaultFieldsComplete));		
    	}

		// Lock name fields
		$('.frmb .text-field').each(function (){
			var label = $(this).find('label.field-label').text();
			if (label == "First Name" || label == "Last Name" || label == "Email" || label == "Phone") {
				$(this).closest('.text-field').find('.field-actions').addClass('hidden');
			}
		});

		// Process template dropdown change
		$('select[name="referral_template"]').change(function (){
			if ($(this).val()) {
				formBuilder.actions.setData(JSON.stringify(templateObj[$(this).val()]));	
			}
		});

		// Override form clearing in multi-step registration
		$('.clear-all').after('<button type="button" class="btn btn-danger clear-all-trigger">Clear</button>').remove();
		// Set basic fields on clearing form
		$('.clear-all-trigger').on('click', function (){ formBuilder.actions.setData(JSON.stringify(defaultFieldsComplete));	});

	  });	  

	// Update db with current form settings
	function formBuilderCallback(data) {
		window.location.href = location.href + "?success=1";
	}
	$('.submit-custom-form').on('click', function (){
    	var formBuilderData = formBuilder.actions.getData('json');
    	var formGenerator = $('.form-generator');
    	if (formBuilderData != "[]") {
	    	$(this).addClass('disabled');
	    	$(this).button('loading');
	    	// Check if url is valid
	    	if ($('input[name="tos_link"]').val() && !ValidURL($('input[name="tos_link"]').val()) && $('input[name="tos_link"]').val() != "http://") {
	    		alert('Please enter a valid url starting with http:// or https://');  	
	    		$(this).removeClass('disabled');
	    		$(this).button('reset'); 
	    		return;
	    	}
			var data = {
				company_id: formGenerator.data('company-id'),
				raw_form_json: formBuilderData,
				form_name: ($('input[name="form_name"]').val() != '') ? $('input[name="form_name"]').val() : 'Referral form',
				subdomain_login_text: tinyMCE.activeEditor.getContent(),
				foreground_color: $('input[name="foreground_color"]').val(),
				background_color: $('input[name="background_color"]').val(),
				footer_color: $('input[name="footer_color"]').val(),
				tos_text: $('input[name="tos_text"]').val(),
				tos_link: ($('input[name="tos_link"]').val() == "http://" ? "" : $('input[name="tos_link"]').val()),
			};
			ajaxHelper("/program-options/referral-program-settings", data, "POST", formBuilderCallback);
    	}
	});

	// Set basic fields on clearing form
	$('.clear-all-trigger').on('click', function (){ formBuilder.actions.setData(JSON.stringify(defaultFieldsBasic));	});

	/* var fbRender = document.getElementById('fb-rerender'),
	  formData = formBuilder.actions.getData("json");
	  var formRenderOpts = {
	    formData,
	    dataType: 'json'
	  };
	  $(fbRender).formRender(formRenderOpts);		  
	*/

// END - JQUERY FORMBUILDER

// JQUERY STEPS
	var form = $("#register-form-multistep");
	var multiStepRegistration = [
		'We need some basic information about you to get started.',
		'Tell Us About Your Company',
		'What information do you need to follow up with a referral? <span class="subtext">This is the information your referral club members will enter when submitting a referral.</span>',
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
	var multiStep = form.children("div").steps({
		headerTag: "h3",
		bodyTag: "section",
		//startIndex: 3,
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

			// Change reward ratio text
			$('select[name="reward_kind"]').change(function (){
				if ($(this).find('option:selected').val()) {
					$('.reward-kind').text($(this).find('option:selected').text());
				}
			});
			
			// Add form validation
			$('#steps-uid-0 .actions').append('<ul><li class="multi-step-previous"><a href="javascript:void(0);">Back</a></li><li><a href="javascript:void(0);" class="multi-step-next">Next</a></li><li class="multi-step-submit hidden"><a href="#finish">Submit</a></li></ul>').find('ul').eq(0).addClass('hidden');		
			var data;
			$('.multi-step-next').click(function (){
				var currentIndex = form.children("div").steps("getCurrentIndex");
				var $errorMessages = $('.register-main .alert.alert-success');	

				switch (currentIndex) {
					case (0):
						var $userForm = $('#steps-uid-0-p-0');	
						data = {
							type: 'user',
							first_name: $userForm.find('input[name="first_name"]').val(),
							last_name: $userForm.find('input[name="last_name"]').val(),
							phone: $userForm.find('input[name="phone"]').val(),
							email: $userForm.find('input[name="email"]').val(),
							password: $userForm.find('input[name="password"]').val(),
							password_confirmation: $userForm.find('input[name="password_confirmation"]').val(),
						}
						break;
					case (1):
						var $companyForm = $('#steps-uid-0-p-1');	
						data = {
							type: 'company',
							company_name: $companyForm.find('input[name="company_name"]').val(),
							subdomain: $companyForm.find('input[name="subdomain"]').val(),
							company_phone: $companyForm.find('input[name="company_phone"]').val(),
							company_email: $companyForm.find('input[name="company_email"]').val(),
							business_type: $companyForm.find('select[name="business_type"]').val(),
							company_address_1: $companyForm.find('input[name="company_address_1"]').val(),
							company_address_2: $companyForm.find('input[name="company_address_2"]').val(),
							company_city: $companyForm.find('input[name="company_city"]').val(),
							state: $companyForm.find('select[name="state"]').val(),
							company_zip: $companyForm.find('input[name="company_zip"]').val(),
						}
						break;
					case (3):
						var $companyForm = $('#steps-uid-0-p-3');	
						data = {
							type: 'reward_info',
							reward_title: $companyForm.find('input[name="reward_title"]').val(),
							reward_kind: $companyForm.find('select[name="reward_kind"]').val(),
							reward_send: $companyForm.find('select[name="reward_send"]').val(),
							leader_board: $companyForm.find('select[name="leader_board"]').val(),
						}
						break;
				}

				// Post data for validation
				ajaxHelper("/ajax-validate", data, "POST", function (data){
					$('.register-main .alert.alert-success ul li').remove();
					if (data != 'success') {
						$('.register-main .alert.alert-success').removeClass('hidden');
						$.each(data, function (itm, val){
							$('.register-main .alert.alert-success ul').append('<li>' + val[0] + '</li>');
						});
					} else {
						$('.register-main .alert.alert-success').addClass('hidden');
						multiStep.steps('next');
					}
					stepsContentHeight();
				});
			});

			$('.multi-step-previous').click(function (){ multiStep.steps('previous');$('.multi-step-next').removeClass('hidden'); });
			$('.multi-step-submit').click(function (){ $('#register-form-multistep').submit(); });
		},
		onStepChanging: function (event, currentIndex, newIndex)
		{

			// Highlight current step number
			$('.form-multistep-number li.current').removeClass('current');
			$('.form-multistep-number li').eq(newIndex).addClass('current');

			// Add processing before next step
			switch (true) {
				case (newIndex == 2 && !setFormGen):
			  		$('#register-form-multistep #steps-uid-0-p-2').append($('.form-generator'));
			  		setFormGen = 1;
					break;
				case (newIndex == 4):
			  		$('#register-form-multistep section:not(.form-builder) input, #register-form-multistep section:not(.form-builder) select').each(function(){
			  			$('.review-form').append('<div class="form-group"><label>' + $(this).closest('.form-group').find('label').text() + '</label><div class="form-control">' + $(this).val() + '</div>');
			  		});

			  		// Get form generated json data
			  		$('input[name="referral_form_json"]').val(formBuilder.actions.getData('json'));

			  		// Hide next button and show submit button on last step of multi-step registration
					$('.multi-step-next').addClass('hidden');
					$('.multi-step-submit').removeClass('hidden');
					break;
			}

			form.closest('.register-main').find('.top-content').html(multiStepRegistration[newIndex]);
			stepsContentHeight();

			return true;//form.valid();
		},
		onFinishing: function (event, currentIndex)
		{
			//steps-uid-0
			//form.validate().settings.ignore = ":disabled";
			return true; //form.valid();
		},
		onFinished: function (event, currentIndex)
		{
			$('#register-form-multistep').submit();
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
	var options = {
		selector: '.tinymce',
		menubar: false,
		statusbar: false,
		plugins: 'link image'
     }
	tinymceHelper(options, false);
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

	$('.accept-terms').change(function (){
		if ($(this).prop('checked')) {
			$('.btn-register').removeAttr('disabled');
		} else {			
			$('.btn-register').prop('disabled', 'true');
		}
	});

	//	Add js url validation
	function ValidURL(str) {	
		return /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test( str );
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
	var dateSet = $('input[name="daterange"]').val();
	
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
	if (!dateSet) {
		$('input[name="daterange"]').val('All time')
	}

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
		readImage(this, updateLogo);
	}).closest('.company-logo').find('.ajax-logo').on('click', function (){	
		$('.logo-input').trigger('click');
	});
// END CREATE COMPANY

// MESSAGES
	var options = {
		selector: 'textarea[name="message"]',
		menubar: false,
		statusbar: false,
		plugins: 'link image'
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

// EMAIL TEMPLATE FORM

	function renderHTML() {
		$('#email_html').val($('#email_html').val().split("{ {").join("{{"));
	    $('#renderer_iframe').contents().find('body').html( $('#email_html').val() );
	    //$('#renderer_iframe').contents().find('body').css('border', '1px solid black');
	    //$('#renderer_iframe').contents().find('#safe-area').css('border', '1px solid gray');
	}

	function changeToDefaultHTML() {		
	    
	var html2 = `
		<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
		   <tr>
		      <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
		         <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
		            <tr>
		               <td class="header" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
		                  <a href="https://app.exnf.com" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
		                  Perxi
		                  </a>
		               </td>
		            </tr>
		            <!-- Email Body -->
		            <tr>
		               <td class="body" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; border-bottom: 1px solid #EDEFF2; border-top: 1px solid #EDEFF2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
		                  <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
		                     <!-- Body content -->
		                     <tr>
		                        <td class="content-cell" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
		                           <h1 style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #2F3133; font-size: 19px; font-weight: bold; margin-top: 0; text-align: left;">Hello!</h1>
		                           <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">The introduction to the notification.</p>
		                           <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
		                              <tr>
		                                 <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
		                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
		                                       <tr>
		                                          <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
		                                             <table border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
		                                                <tr>
		                                                   <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
		                                                      <a href="https://ayc.incentful.loc" class="button button-blue" target="_blank" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;">Notification Action</a>
		                                                   </td>
		                                                </tr>
		                                             </table>
		                                          </td>
		                                       </tr>
		                                    </table>
		                                 </td>
		                              </tr>
		                           </table>
		                           <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Thank you for using our application!</p>
		                           <!-- Salutation -->
		                           <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Regards,<br>Perxi</p>
		                           <!-- Subcopy -->
		                           <table class="subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-top: 1px solid #EDEFF2; margin-top: 25px; padding-top: 25px;">
		                              <tr>
		                                 <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
		                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; line-height: 1.5em; margin-top: 0; text-align: left; font-size: 12px;">If you’re having trouble clicking the "Notification Action" button, copy and paste the URL below
		                                       into your web browser: <a href="https://ayc.incentful.loc" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #3869D4;"></a><a href="https://ayc.incentful.loc" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #3869D4;">https://ayc.incentful.loc</a>
		                                    </p>
		                                 </td>
		                              </tr>
		                           </table>
		                        </td>
		                     </tr>
		                  </table>
		               </td>
		            </tr>
		            <tr>
		               <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
		                  <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
		                     <tr>
		                        <td class="content-cell" align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
		                           <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #AEAEAE; font-size: 12px; text-align: center;">© 2017 Perxi. All rights reserved.</p>
		                        </td>
		                     </tr>
		                  </table>
		               </td>
		            </tr>
		         </table>
		      </td>
		   </tr>
		</table>
	`;

		$('#email_html').val(html2);
	    renderHTML();	        
	}


	function showBack() {
	    if ( $('[name=back_or_message]:checked').val() == 1 ) {
	        $('#postcard_back_message').hide();
	        $('#postcard_back_image').show();
	    }
	    if ( $('[name=back_or_message]:checked').val() == 0 ) {
	        $('#postcard_back_message').show();
	        $('#postcard_back_image').hide();
	    }
	}

	$('#renderHtml').on('click', function() { renderHTML(); });
	$('#defaultHtml').on('click', function() { changeToDefaultHTML(); });
	$('[name=back_or_message]').on('click', function() { showBack(); });

	$('#renderer_iframe').on("load", function() {
	    renderHTML();
	});

	if ($('#email_html').length) {
		// Fix curly brackets being hidden automatically
		$('.placeholder-name .list-inline li a').click(function (){
			var caretPos = document.getElementById("email_html").selectionStart;
		    var textAreaTxt = $("#email_html").val();
		    var txtToAdd = $(this).text();
		    $("#email_html").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );


		}).each(function (){
			$(this).html($(this).html().split("{ {").join("{{"));
		});

		if (!$('#email_html').val()) {
			changeToDefaultHTML();
		}

		renderHTML();		
		var options = {
			selector: '#email_html',
			menubar: false,
			statusbar: false,
			plugins: 'link image'
		}
		//tinymceHelper(options, false);
        //tinyMCE.activeEditor.setContent('33333333');
	}
	showBack();

	$('.btn-reset').click(function (){
		$('#email_html').html('');
	    renderHTML();
	});

	$('.table-notification-emails .switch input[type="checkbox"]').change(function (){

		var data = {
			type: $(this).data('value'),
			status: $(this).prop('checked') ? 0 : 1
		};

		ajaxHelper("/program-options/notification-emails", data, "POST", processCheckbox);
	});
	function processCheckbox(data){}

// END EMAIL TEMPLATE FORM

// SPECTRUM COLOR PICKER
	$('.render-spectrum').spectrum({
		showInput: true,
		preferredFormat: "hex"
	});
// END SPECTRUM COLOR PICKER

// X-EDITABLE
	$('#username').editable({
	    type: 'text',
	    url: '/post',    
	    pk: 1,    
	    title: 'Enter username',
	    ajaxOptions: {
	        type: 'put'
	    }        
	});

// END X-EDITABLE

});