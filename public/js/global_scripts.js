UIBlocker = new KTBlockUI(document.querySelector(".modal-content"));
var showHidePass = function( fieldId , showPwIcon )
{
    var passField = $("#" + fieldId);

    if ( passField.attr("type") === "password")
    {
        passField.attr("type","text");
        showPwIcon.children().eq(0).removeClass("fa-eye").addClass("fa-eye-slash");
    }
    else
    {
        passField.attr("type","password");
        showPwIcon.children().eq(0).removeClass("fa-eye-slash").addClass("fa-eye");
    }

}

var blockUi = function(id) {
    /** block container ui **/
    KTApp.block(id, {
        overlayColor: '#000000',
        state: 'danger',
        message: __('برجاء الانتظار....'),
    });
}

var unBlockUi = function(id, timer = 0) {
    /** unblock container ui **/
    setTimeout(function() {
        KTApp.unblock(id);
    }, timer);
}

var initTinyMc = function( editingInp = false, height = 400 ) {

    tinymce.init({
        height,
        selector: ".tinymce",
        menubar: false,
        toolbar: ["styleselect",
            "undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify forecolor backcolor",
            "bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code"],
        plugins : "advlist autolink link lists charmap print preview code save",
        save_onsavecallback: function () { }
    });

    if ( ! editingInp )
        $('.tinymce').val(null);

}

$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
});

var getImagePathFromDirectory = function(imageName, directory, defaultImage = 'default.jpg') {
    var path = `/storage/Images/${directory}/${imageName}`;

    if ( imageName && directory && isFileExists( path ))

        return path;

}

function isFileExists(urlToFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();

    if (xhr.status == "404") {
        return false;
    } else {
        return true;
    }
}

var removeValidationMessages = function() {
    var errorElements = $('.invalid-feedback');
    errorElements.html('').css('display','none');
    $('form .form-control').removeClass('is-invalid is-valid')
    $('form .form-select').removeClass('is-invalid is-valid')
}

var displayValidationMessages = function(errors ,form) {
    form.find('.form-control:not(".controls")').addClass('is-valid')
    form.find('.form-select').addClass('is-valid')
    $.each(errors, (key, errorMessage) => getErrorElement(key).html(errorMessage).css('display','block'));
    $.each(errors, (key, errorMessage) => getExcelError('excel_error').html(errorMessage).css('display','block'));
    scrollToFirstErrorElement(errors);
}

function scrollToFirstErrorElement(errors) {
    var firstErrorElementId = Object.keys(errors)[0].replaceAll('.','_');
    var firstErrorElement   = document.getElementById(firstErrorElementId);

    if (!firstErrorElement){
        var inputName = getFormRepeaterInputName(Object.keys(errors)[0]);
        firstErrorElement = document.getElementsByName(inputName)[0];
    }

    if(firstErrorElement)
        firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

var showMoreInDT = function( element ) {
    console.log(12)
    $(element).next().hide();
    $(element).next().next().show();

}

var getStatusObject = function( statusNameEn ) {
    return ordersStatuses.find( ( status ) => status['name_en'] === statusNameEn  ) ?? { "name_ar" : statusNameEn , "name_en" : statusNameEn, "color" : "#219ed4" };
}

function getErrorElement(errorKey) {
    var inputId = errorKey.replaceAll('.','_');
    var errorInput   = $("#" + inputId + '_inp' );
    var errorElement = $("#" + inputId );

    if (!errorElement.length){
        var inputName = getFormRepeaterInputName(errorKey);
        errorInput = $(`[name='${inputName}']`);
        errorElement = errorInput.siblings('.error-element');
    }
    errorInput.removeClass('is-valid');
    errorInput.addClass('is-invalid');
    /** For select2 **/
    if (errorInput.hasClass('form-select')) {
        var $select2Span = errorInput.siblings('.select2-container').find('.select2-selection');
        $select2Span.removeClass('is-valid');
        $select2Span.addClass('is-invalid');
    }

    return errorElement
}

function getExcelError(errorKey) {
    var inputId = errorKey;
    var errorInput   = $("#" + inputId + '_inp' );
    var errorElement = $("#" + inputId );

    if (!errorElement.length){
        var inputName = getFormRepeaterInputName(errorKey);
        errorInput = $("#excel_error");
        errorElement = errorInput.siblings('.error-element');
    }
    errorInput.removeClass('is-valid');
    errorInput.addClass('is-invalid');
    /** For select2 **/
    if (errorInput.hasClass('form-select')) {
        var $select2Span = errorInput.siblings('.select2-container').find('.select2-selection');
        $select2Span.removeClass('is-valid');
        $select2Span.addClass('is-invalid');
    }

    return errorElement
}

function getFormRepeaterInputName(errorKey){
    var repeaterInputNameParts = errorKey.split(".");
    var formRepeaterName = repeaterInputNameParts[0];
    var repeaterInputIndex = repeaterInputNameParts[1];
    var repeaterInputName = repeaterInputNameParts[2];

    return `${formRepeaterName}[${repeaterInputIndex}][${repeaterInputName}]`;
}


/** Begin :: System Alerts  **/

var deleteAlert = function(message = '') {
    if(message === '')
        message = `${__('Are you sure you want to delete this') + ' ' + __('item') + ' ' + __('?') + ' ' + __('All data related to this') + ' ' + __('item') + ' ' + __('will be deleted') }`
    return Swal.fire({
        text: message,
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: __('Yes, Delete !'),
        cancelButtonText: __('No, Cancel'),
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    })
}
var confirmationAlert = function({message = __('Are You sure for doing this action ?'), icon = 'waring', confirmBtnText= __('Yes, Sure !'), cancelButtonText = __('No, Cancel')}) {

    return Swal.fire({
        text: message,
        icon: icon,
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: confirmBtnText,
        cancelButtonText: cancelButtonText,
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary"
        }
    })
}


var errorAlert = function(message = __("something went wrong"), time = 5000) {
    return Swal.fire({
        text: __(message),
        icon: "error",
        buttonsStyling: false,
        showConfirmButton: false,
        timer: time,
        customClass: {
            confirmButton: "btn fw-bold btn-primary",
        }
    });
}

var successAlert = function(message = __("Operation done successfully") , timer = 2000) {

    return Swal.fire({
        text: message,
        icon: "success",
        buttonsStyling: false,
        showConfirmButton: false,
        timer: timer
    });

}

var restoreAlert = function() {
    return Swal.fire({
        text: __('تم الحذف بنجاح'),
        icon: "success",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: __("إسترجاع البيانات"),
        cancelButtonText: __("حسناُ"),
        customClass: {
            confirmButton: "btn fw-bold btn-warning",
            cancelButton: "btn fw-bold btn-primary",
        }
    })
}

var inputAlert = function() {

    return Swal.fire({
        icon:'warning',
        title: __('write a comment'),
        html: '<input id="swal-input1" class="form-control">',
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonColor:'#1E1E2D',
        cancelButtonColor:'#c61919',
        confirmButtonText: `<span> ${ __('change')} </span>`,
        cancelButtonText: `<span> ${__('cancel')} </span>`,
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
            ]
        },
    });

}

var changeStatusAlert = function(type = "change") {

    if(type == 'date')
    {
        return Swal.fire({
            icon:'warning',
            title: __('Pick new date'),
            html: '<input type="date" required id="swal-input1" class="form-control">',
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonColor:'#1E1E2D',
            cancelButtonColor:'#c61919',
            confirmButtonText: `<span> ${ __('change')} </span>`,
            cancelButtonText: `<span> ${__('cancel')} </span>`,
            preConfirm: () => {
                return [
                    document.getElementById('swal-input1').value,
                ]
            },
        });
    }

    return Swal.fire({
        icon:'warning',
        title: __('change order status'),
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonColor:'#1E1E2D',
        cancelButtonColor:'#c61919',
        confirmButtonText: `<span> ${ __('change')} </span>`,
        cancelButtonText: `<span> ${__('cancel')} </span>`,

    });

}

var warningAlert        = function(title , message , time = 5000) {
    return swal.fire({
        title: __(title),
        text: __(message),
        icon: "warning",
        showConfirmButton: false,
        timer: time
    });
}

var unauthorizedAlert   = function() {
    return swal.fire({
        title: __("Error !"),
        text: __("This action is unauthorized."),
        icon: "error",
        showConfirmButton: false,
        timer: 5000,
    });
}

var loadingAlert  = function(message = __("Loading...") ) {

    return  Swal.fire({
        text: message,
        icon: "info",
        buttonsStyling: false,
        showConfirmButton: false,
        timer: 2000
    });

}

/** End :: System Alerts  **/


/** Start :: Helper Functions  **/

var deleteElement = (deletedElementName , deletionUrl , callback ) =>
{
    deleteAlert(deletedElementName).then(function (result) {

        if (result.value) {

            loadingAlert( __('deleting now ...') );

            $.ajax({
                method: 'delete',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: deletionUrl,
                success: (response) => {

                    setTimeout( () => {

                        successAlert(`${__('You have deleted the') + ' ' + deletedElementName + ' ' + __('successfully !')} `)
                            .then(function () {

                                if (typeof callback === "function") {
                                    callback(response)
                                }

                            });
                    } , 1000)
                },
                error: (err) => {

                    if (err.hasOwnProperty('responseJSON')) {
                        if (err.responseJSON.hasOwnProperty('message')) {
                            errorAlert(err.responseJSON.message);
                        }
                    }
                }
            });

        } else if (result.dismiss === 'cancel') {
            errorAlert( __('was not deleted !') )
        }
    });

}

function ajaxSubmission({form, successCallback, errorCallback, complete}) {

    var formData  = new FormData( form );
    form = $(form);
    var submitBtn = $(form).find("[type=submit]");
    submitBtn.attr('disabled', true);

    $.ajax({
        method: form.attr('method'),
        url: form.attr('action'),
        data: formData,
        enctype: 'multipart/form-data',
        processData:false,
        contentType: false,
        cache: false,
        success: successCallback,
        error: errorCallback,
        complete: complete
    });
}

/** Start :: save tiny mce  **/
var saveTinyMceDataIntoTextArea = () => {
    if ( $('textarea[class="tinymce"]').length )
        tinymce.triggerSave();
}
/** Start :: save tiny mce  **/

function onImgError(image, placeholder = "/placeholder_images/default.png") {
    image.src = placeholder;
}

/** Start :: Submit any form in dashboard function  **/
var submitForm = (form) => {

    var submitBtn = $(form).find("[type=submit]");

    submitBtn.attr('disabled',true).attr("data-kt-indicator", "on");

    saveTinyMceDataIntoTextArea();

    ajaxSubmission({
        form: form,
        successCallback: function (response) {
            form = $(form);
            removeValidationMessages();

            if ( form.data('success-callback') !== undefined ){
                window[ form.data('success-callback') ](response);
                showToast();
            }else{
                if ( form.data('redirection-url') && form.data('redirection-url') !== "#" )
                    window.location.replace( form.data('redirection-url') )
                else
                    showToast();
            }

        },
        errorCallback: function (response) {

            form = $(form);

            removeValidationMessages();

            if (response.status === 422)
                displayValidationMessages(response.responseJSON.errors , form);
            else if (response.status === 403)
                unauthorizedAlert();
            else if (response.status === 419)
                window.location.reload();
            else
                errorAlert(response.responseJSON.message , 5000 )

            if ( form.data('error-callback') !== undefined )
                window[ form.data('error-callback') ](response.status , response)
        },
        complete: function () {
            submitBtn.attr('disabled',false).removeAttr("data-kt-indicator")
        }
    })

}
/** End   :: Submit any form in dashboard function  **/

var showToast = function (message = null) {
    const toastElement = document.getElementById('kt_docs_toast_toggle');
    const toast = bootstrap.Toast.getOrCreateInstance(toastElement);
    if(message)
        $(".toast-body").text(message);
    toast.show();

    playSuccessSound();
}

function playNotificationSound() {
    if (notificationSoundOn)
        playSound($("#notification-sound"))
}

function playSuccessSound() {
    playSound($("#success-sound"))
}

function playErrorSound() {
    playSound($("#error-sound"))
}

function playSound(soundElement) {

    if(soundStatus !== 'stop'){
        try {
            soundElement.trigger('play');
        } catch (error) {
            console.log(error);
        }
    }

}

var reinitializeTooltip = () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
}

var hideValidationMessagesOnModalShow = () => {
    $('#crud_modal').on('hidden.bs.modal', function (e) {
        removeValidationMessages();
    });
    $('#kt_modal_upload').on('hidden.bs.modal', function (e) {
        removeValidationMessages();
    });
}

/** End   :: Helper Functions  **/

$(document).ready(function () {

    hideValidationMessagesOnModalShow();

    /** Start :: ajax request form  **/
    $('.ajax-form').submit( function (event) {
        event.preventDefault();

        submitForm(this);
    });
    /** End   :: ajax request form  **/

    /** Start :: ajax request form  **/
    $('#submitted-form,.submitted-form').submit(function (event) {

        event.preventDefault();

        submitForm( this );

    })
    /** End   :: ajax request form  **/

    /** initialize datepicker inputs */
    var datePickers = $('.datepicker');

    if( datePickers.length )
    {
        datePickers.flatpickr({
           dateFormat: "Y-m-d"
        });
    }
    /** initialize datepicker inputs */

    /** initialize timepicker inputs */
    var timepickers = $('.timepicker');

    if( timepickers.length )
    {
        timepickers.flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            direction: 'ltr'
        });
    }
    /** initialize timepicker inputs */

    /** customizing select2 message */
    var selectBoxes = $('select');

    if( selectBoxes.length )
    {
        selectBoxes.select2({
            "language": {
                "noResults": function () {
                    return __("No results found");
                }
            }
        })
    }
    /** customizing select2 message */

})
