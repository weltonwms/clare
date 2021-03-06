/*!
 * jquery.confirm
 *
 * @version 2.0.1
 *
 * @author My C-Labs
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @author Russel Vela
 *
 * @license MIT
 * @url http://myclabs.github.io/jquery.confirm/
 */
(function ($) {

    /**
     * Confirm a link or a button
     * @param options {title, text, confirm, cancel, confirmButton, cancelButton, post}
     */
    $.fn.confirm = function (options) {
        if (typeof options === 'undefined') {
            options = {};
        }

        this.click(function (e) {
            e.preventDefault();

            var newOptions = $.extend({
                button: $(this)
            }, options);

            $.confirm(newOptions, e);
        });

        return this;
    };

    /**
     * Show a confirmation dialog
     * @param options {title, text, confirm, cancel, confirmButton, cancelButton, post}
     */
    $.confirm = function (options, e) {
        teste= " ";
        //teste+= e.currentTarget.attributes['data-teste'].value;
        // Default options
        var settings = $.extend({
            text: "Are you sure?",
            title: "",
            confirmButton: "Yes",
            classConfirmButton:"btn btn-danger",
            classIconConfirmButton:"glyphicon glyphicon-trash",
            cancelButton: "Cancel",
            post: false,
            confirm: function (o) {
                var url = e.currentTarget.attributes['href'].value;
                
                if (options.post) {
                    var form = $('<form method="post" class="hide" action="' + url + '"></form>');
                    $("body").append(form);
                    form.submit();
                } else {
                    window.location = url;
                }
            },
            cancel: function (o) {
            },
            button: null
        }, options);

        // Modal
        var modalHeader = '';
        if (settings.title !== '') {
            modalHeader =
                '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                    '<h4 class="modal-title ">' + '<span class="glyphicon glyphicon-exclamation-sign"></span>' + settings.title+'</h4>' +
                '</div>';
        }
        var modalHTML =
                '<div class="confirmation-modal bs-example-modal-sm modal fade" tabindex="-1" role="dialog">' +
                    '<div class="modal-dialog modal-sm" id="modalexc">' +
                        '<div class="modal-content ">' +
                            modalHeader +
                            '<div class="modal-body ">' + settings.text + teste+ '</div>' +
                            '<div class="modal-footer">' +
                                '<button class="confirm '+settings.classConfirmButton+'" type="button" data-dismiss="modal">' +
				'<span	class="'+settings.classIconConfirmButton+'"></span>' +	
                                    settings.confirmButton +
                                '</button>' +
                                '<button class="cancel btn btn-default" type="button" data-dismiss="modal">' +
				'<span	class="glyphicon glyphicon-ban-circle"></span>' +	
                                    settings.cancelButton +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';

        var modal = $(modalHTML);

        modal.on('shown', function () {
            modal.find(".btn-primary:first").focus();
        });
        modal.on('hide.bs.modal', function () {
            modal.remove();
        });
        modal.find(".confirm").click(function () {
            settings.confirm(settings.button);
        });
        modal.find(".cancel").click(function () {
            settings.cancel(settings.button);
        });

        // Show the modal
        $("body").append(modal);
        modal.modal('show');
    };

})(jQuery);
