$(document).ready(function() {
    function confirmDialog(message, onConfirm) {
        var fClose = function () {
            modal.modal("hide");
        };
        var modal = $("#confirmModal");
        modal.modal("show");
        $("#confirmMessage").empty().append(message);
        $("#confirmOk").unbind().one('click', onConfirm).one('click', fClose);
        $("#confirmCancel").unbind().one("click", fClose);
    }

    $('.js-btn-delete').on('click', function (e, options) {
        options = options || {};

        if (options.confirm_check_complete) {
            $.ajax({
                type: 'POST',
                url: $(e.currentTarget).data('href'),
                data: {id: $(e.currentTarget).data('id')},
                dataType: 'json',
                success: function (data) {
                    window.location.replace(data.location);
                }
            });
        }

        e.preventDefault();
        confirmDialog('Confirma a exclusão?', function () {
            $(e.currentTarget).trigger('click', {'confirm_check_complete': true});
        });
    });
});