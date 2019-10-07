function showOverlay(text='') {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fa fa-spinner fa-spin",
        fontawesomeColor: "#e46a76",
        size: 3,
        text: text,
        textColor: "#e46a76"
    });
}

function hideOverlay() {
    $.LoadingOverlay("hide");
}

function showErrorToast(msg) {
    $.toast({
        heading: '错误',
        text: msg,
        position: 'top-right',
        loaderBg:'#ff6849',
        icon: 'error',
        hideAfter: 5000
    });
}

const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'AUD',
    minimumFractionDigits: 2
});

function formatPrice(val) {
    if (val > 0)
        return '$' + val;

    if (val == 0)
        return '-';

    if (val < 0)
        return '($' + Math.abs(val) + ')';
}
