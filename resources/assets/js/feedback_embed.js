// Set up defaults which may be overridden in the page
if(api_key == undefined)
    var api_key = '';
if(default_location == undefined)
    var default_location = '';
if(default_rating == undefined)
    var default_rating = '3';
if(additional_fields == undefined)
    var additional_fields = {};
if(location_results == undefined)
    var location_results = 10;
if(show_review_request == undefined)
    var show_review_request = false;
if(review_request_minimum_rating == undefined)
    var review_request_minimum_rating = 4;
if(rating_display == undefined)
    var rating_display = 'rating';

// Begin the View-Model code
var Review = function() {
    var self = this;

    // Observable parameters
    self.status = ko.observable('new');
    self.reviewer_name = ko.observable();
    self.reviewer_email = ko.observable();
    self.review_text = ko.observable();
    self.rating = ko.observable(default_rating);
    self.rating_display = ko.observable(rating_display);
    self.location_id = ko.observable(default_location);
    self.location_search = ko.observable();
    self.has_selected_location = ko.observable(false);
    self.selected_location = ko.observableArray();
    self.location_list = ko.observableArray();
    self.show_location_list = ko.observable(false);
    self.review_sites = ko.observableArray();

    // Helper functions to determine which content to show
    self.showFeedbackForm = ko.computed(function() {
        return (self.status() == 'new');
    });
    self.showThankYouMessage = ko.computed(function() {
        return (self.status() == 'sent');
    });
    self.showReviewRequest = ko.computed(function() {
        return (self.status() == 'sent'
            && show_review_request
            && self.rating() >= review_request_minimum_rating
            && self.review_sites().length > 0);
    });

    // Operations
    self.setRating = function(rating) {
        self.rating(rating);
        return false;
    };

    // Submit to RP Server
    self.save = function() {
        var review = {
            name: self.reviewer_name(),
            email: self.reviewer_email(),
            review: self.review_text(),
            rating: self.rating(),
            rating_display: self.rating_display(),
            location_id: self.location_id(),
            metadata: {}
        };
        // Append additional fields to the review text
        for(var fieldName in additional_fields) {
            var fieldContents = $('#'+fieldName).val();
            if(fieldContents != undefined && fieldContents != '')
                review['metadata'][additional_fields[fieldName]] = fieldContents;
        }
        var dataToSave = {
            key: api_key,
            review: JSON.stringify(review)
        };
        // Send via JSONP
        $.ajax({
            type: "GET",
            url: "https://go.reviewpush.com/api/reviews.json",
            data: dataToSave,
            dataType: 'jsonp',
            cache: false,
            success: function(result){
                self.review_sites(result.review_sites);
                self.status("sent");
            },
            error: function(error){
            }
        });
    };

    // Grab the nearest locations for this company, populate the locations list
    self.nearestLocations = function() {
        $.ajax({
            type: "GET",
            url: "https://go.reviewpush.com/api/feedback.json?data=nearby&limit="+location_results+"&key="+api_key,
            dataType: 'jsonp',
            cache: false,
            success: function(result){
                self.location_list.removeAll();
                self.location_list(result);
                // If we got results, and the user doesn't have a selected location, set it to the first one.
                if(!self.has_selected_location() && result.length > 0) {
                    self.selected_location(result[0]);
                    self.location_id(result[0].id);
                    self.has_selected_location(true);
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    };

    // Search the locations for this company, populate the locations list
    self.searchLocations = function() {
        $.ajax({
            type: "GET",
            url: "https://go.reviewpush.com/api/feedback.json?data=locations&limit="+location_results+"&search="+self.location_search()+"&key="+api_key,
            dataType: 'jsonp',
            cache: false,
            success: function(result){
                self.location_list.removeAll();
                self.location_list(result);
            },
            error: function(error){
                console.log(error);
            }
        });
    };

    // Helper functions to show/hide the locations list if it's a popup
    self.toggleLocationList = function() {
        if(self.show_location_list())
            self.hideLocationList();
        else
            self.showLocationList();
    };
    self.showLocationList = function() {
        self.show_location_list(true);
    };
    self.hideLocationList = function() {
        self.show_location_list(false);
    };

    // Method to select a location from the locations list
    self.selectLocation = function(location) {
        self.selected_location(location);
        self.location_id(location.id);
        self.hideLocationList();
    };

    // Watch for changes to the location search value, call the search API
    self.location_search.subscribe(function(newValue) {
        if(self.location_search() == '')
            self.nearestLocations();
        else
            self.searchLocations();
    });
};

// Create a new Review View-Model
var vm = new Review();

// Apply the Knockout.js bindings to our View-Model
ko.applyBindings(vm);

// After jQuery has loaded, pull the nearest locations to the user
$(document).ready(function(){
    if(default_location == '')
        vm.nearestLocations();
});
