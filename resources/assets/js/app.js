
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
		$('#referral-create-form input[name="phone"]').autocomplete();
		$('#referral-create-form input[name="email"]').autocomplete({
			source: function (request, response){
				$.get('/referral/autocomplete', {

				}, function (data){
					console.log(data);
					response(data);
				});
			}
		});
		//alert();
	})

// END - SUBMIT REFERRALS