define(['jquery'],
    function($) {

        "use strict";

        return function meLnHints(hintClass) {

            $(function () {

                setTimeout(function() {

                    $('#me-ln-control-block .mageugenes-bs-settings').show();
                    $('#me-ln-control-block .mageugenes-bs-loading').hide();

                    $('.' + hintClass).each(function (index) {

                        let currentHintBlockBegin = $(this),
                            blockHintId = currentHintBlockBegin.attr('id'),
                            child = currentHintBlockBegin.next('.me-ln-wrapper'),
                            maxElementWidth = 0,
                            beginHintBlockOffset = child.offset(),
                            endHintBlockOffset = beginHintBlockOffset,
                            endHintBlockHeight = 0,
                            isFirstChild = true;

                        do {

                            child = child.next();

                            if (child.hasClass('debugging-hint-mageugenes-layoutnames-end')) {
                                break;
                            }

                            let tagName = child.prop("tagName");


                            if (tagName == 'SCRIPT' ||
                                tagName == 'STYLE' ||
                                tagName == 'META' ||
                                tagName == 'NOSCRIPT' ||
                                child.css('display') == 'none') {
                                continue;
                            }

                            if (child.width() > maxElementWidth) {
                                maxElementWidth = child.width();
                            }

                            if (isFirstChild) {

                                if (!child.hasClass('debugging-hint-mageugenes-layoutnames')) {
                                    child.prepend($('#me-ln-wrapper-' + blockHintId));
                                    beginHintBlockOffset = child.offset();
                                }

                                isFirstChild = false;
                            }

                            endHintBlockOffset = child.offset();
                            endHintBlockHeight = child.outerHeight();

                        } while (true);

                        let height = endHintBlockOffset.top + endHintBlockHeight - beginHintBlockOffset.top;

                        if (height) {
                            $('#me-ln-wrapper-' + blockHintId).css({
                                'width': maxElementWidth + 'px',
                                'height':  height + 'px',
                                'z-index': index * 1000});

                            if (index % 2) {
                                $('#me-ln-wrapper-' + blockHintId).addClass('me-ln-active-invert');
                            }

                            $('#me-ln-wrapper-' + blockHintId).on('click', function (event) {

                                event.stopPropagation();

                                if ($(this).hasClass('me-ln-active')) {
                                    $(this).removeClass('me-ln-active');

                                    $('.me-ln-name-template', $(this)).removeClass('me-ln-name-template-show');

                                    return false;
                                }

                                let meLnWrapper = $(this);

                                meLnWrapper.addClass('me-ln-active');

                                let meLnNameTemplate = $('.me-ln-name-template', $('#me-ln-wrapper-' + blockHintId));

                                meLnNameTemplate.addClass('me-ln-name-template-show');

                                let meLnNameTemplateRight = $(window).width() - (meLnNameTemplate.offset().left + meLnNameTemplate.outerWidth());
                                let meLnNameTemplateTop = meLnNameTemplate.offset().top;

                                if (meLnNameTemplateRight < 0) {
                                    meLnNameTemplate.css('left', meLnNameTemplateRight + 'px');
                                }

                                if (meLnNameTemplateTop < 0) {
                                    meLnNameTemplate.css('top', '100%');
                                    meLnNameTemplate.css('left', -1);
                                }

                                return false;

                            });
                        }

                        $('*').each(function () {
                            let element =  $(this),
                                elementZIndex = element.css('z-index');

                            if (element.css('position') !== 'static' &&
                                elementZIndex !== 'auto' &&
                                !element.hasClass('me-ln-wrapper')) {

                                let maxZIndex = 0;

                                element.find('.me-ln-wrapper').each(function () {
                                    let meLnWrapper =  $(this);

                                    let zIndex = meLnWrapper.css('z-index');

                                    if (zIndex > maxZIndex) {
                                        maxZIndex = zIndex;
                                    }
                                });

                                if (maxZIndex > elementZIndex) {
                                    element.css('z-index', maxZIndex);
                                }
                            }
                        });
                    });
                }, 1000);
            });
        }
    });
