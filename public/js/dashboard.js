$.ajaxSettings['headers'] = {
    'X-XSRF-TOKEN': decodeURIComponent(document.cookie.split('=')[1])
};

const alertTemplate = $('#alert');
const alertContainer = alertTemplate.parent();
alertTemplate.remove();

function showMessage(msg, type = 'success') {
    const view = alertTemplate.clone(true);
    view.addClass('alert-' + type);
    view.find('#message').text(msg);
    alertContainer.append(view);
    setTimeout(function () {
        view.remove();
    }, 5000)
}
