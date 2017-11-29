'use strict';

$(function () {

    // Allows new marks.

    var $collectionHolder = $('.marks'),

    // setup an "add a mark" link
        $addMarkLink = createAddMarkLink(),
        $addMarkLinkContainer = getLastMarkLinkContainer();

    // add the "add a mark" anchor
    $addMarkLinkContainer.html($addMarkLink);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('> .row').length);

    activeAddMarkLink();

    activeRemoveMarkForm();


    /*********************************************
     Functions
     *********************************************/

    function activeAddMarkLink() {
        $collectionHolder.on('click', '.add-new-mark', function (e) {
            e.preventDefault();

            // Add a new mark form
            addMarkForm($collectionHolder, $(this));
        });
    }

    function activeRemoveMarkForm() {
        $collectionHolder.on('click', '.remove-mark-form', function (e) {
            e.preventDefault();

            // Remove the mark form
            $(this).closest('.row').remove();
        });
    }

    function addMarkForm($collectionHolder, $addMarkLink) {

        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        var newForm = prototype;

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page
        getParentRow($addMarkLink).after(newForm);
    }

    function createAddMarkLink() {
        return $('<a href="#" class="btn btn-info btn-outline btn-circle btn-sm add-new-mark"><i class="fa fa-plus"></i></a>');
    }

    function getLastMarkLinkContainer() {
        return $('.marks > .row').last().find('.add-mark-container');
    }

    function getParentRow($target) {
        return $target.closest('.row');
    }
});
