
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'jquery-ui/ui/widgets/autocomplete.js';

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
		$('#referral-create-form input[name="phone"]').blur(function (){
			if ($(this).val()) {
				$.get('/referral/check-duplicate', {
					phone: $(this).val()
				}, function (data){
					if (data.phone.id) {
						console.log('Phone Exists!');
						console.log(data);
					}
				});
			}
		});
		$('#referral-create-form input[name="email"]').blur(function (){
			if ($(this).val()) {
				$.get('/referral/check-duplicate', {
					email: $(this).val()
				}, function (data){
					if (data.email.id) {
						console.log('Email Exists!');
						console.log(data);
					}
				});
			}
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