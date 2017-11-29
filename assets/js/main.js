'use strict';

$(function () {
    $('.btn-loading').on('click', function () {
        var btn = $(this);
        btn.button('loading');
    });
});
