
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

// SUBMIT REFERRALS
	$(function (){
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
		$('.submit-referral').on('click', function (){
			$('.referral-email').removeClass('duplicate-referral');
			$('.bfh-phone').removeClass('duplicate-referral');
			$('#referral-create-form').submit();
		});
		$('.cancel-referral').on('click', function (){
			location.href = '/';
		});
	});
// END - SUBMIT REFERRALS

// NOTIFICATIONS
	$(function (){
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
	});
// END - NOTIFICATIONS

// GET MEMBERS
	$(function (){
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
	});
// END - GET MEMBERS

// ADJUST HEIGHT
	$(function (){
		adjustMainBodyHeight();
		$( window ).resize(function() {
			adjustMainBodyHeight();
		});
		function adjustMainBodyHeight(){
			var height = $('.panel-body').height() > $('.col-sidebar').height() ? $('.panel-body').height() : $('.col-sidebar').height();
			height = height > $('body').height() ? height : $('body').height();
			$('.logged-in .main-content').height(height);
		}
	});
// END - ADJUST HEIGHT

// jQuery formBuilder
	$(function (){
		  let fields = [
		    {
		      label: 'Star Rating',
		      attrs: {
		        type: 'starRating'
		      },
		      icon: 'ðŸŒŸ'
		    }
		  ];

		  let templates = {
		    starRating: function(fieldData) {
		      return {
		        field: '<span id="'+fieldData.name+'">',
		        onRender: function() {
		          $(document.getElementById(fieldData.name)).rateYo({rating: 3.6});
		        }
		      };
		    }
		  };

		  let inputSets = [{
		        label: 'User Details',
		        name: 'user-details', // optional
		        showHeader: true, // optional
		        fields: [{
		          type: 'text',
		          label: 'First Name',
		          className: 'form-control'
		        }, {
		          type: 'select',
		          label: 'Profession',
		          className: 'form-control',
		          values: [{
		            label: 'Street Sweeper',
		            value: 'option-2',
		            selected: false
		          }, {
		            label: 'Brain Surgeon',
		            value: 'option-3',
		            selected: false
		          }]
		        }, {
		          type: 'textarea',
		          label: 'Short Bio:',
		          className: 'form-control'
		        }]
		      }, {
		        label: 'User Agreement',
		        fields: [{
		          type: 'header',
		          subtype: 'h3',
		          label: 'Terms & Conditions',
		          className: 'header'
		        }, {
		          type: 'paragraph',
		          label: 'Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.',
		        }, {
		          type: 'paragraph',
		          label: 'Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.',
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

		  /**
		   * Toggles the edit mode for the demo
		   * @return {Boolean} editMode
		   */
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

		    Object.keys(apiBtns).forEach(action => {
		      document.getElementById(action)
		      .addEventListener('click', e => apiBtns[action]());
		    });

		    document.getElementById('setLanguage')
		    .addEventListener('change', e => fb.actions.setLang(e.target.value));
		  });


		  document.getElementById('edit-form').onclick = function() {
		    toggleEdit();
		  };
	});

// END - jQuery formBuilder