$('#form_repeater').repeater({
    initEmpty: false,
    isFirstItemUndeletable: true,
    show: function () {
        $(this).slideDown();
    },

    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    }
});
