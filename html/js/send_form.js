jQuery(document).ready(function () {
    jQuery('#order-form').submit(function (e) {
            e.preventDefault();
            sendAjaxForm('./order_form.php');
        }
    );
});

function sendAjaxForm(url) {
    jQuery.ajax({
        url: url,
        type: "POST",
        dataType: "html",
        data: jQuery('#order-form').serialize(),
        success: function (response) {
            let html = 'Спасибо, ваш заказ будет доставлен по адресу: “тут адрес клиента”<br>' +
                'Номер вашего заказа: #ID <br>' +
                'Это ваш n-й заказ!<br>';
            jQuery('#order-send-info').html(response);
            jQuery('#order-form')[0].reset();
        },
        error: function (response) {
            alert("Данные не отправлены");
        }
    });
}