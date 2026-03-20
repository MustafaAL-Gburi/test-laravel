// ===== FIX MISSING FUNCTIONS =====
function checkPflichtfelder() { }
function spinnerON() { }
function spinnerOFF() { }
function waehrung() { }
function formatIBAN() { }
function zeit() { }

var tooltipactive = 0;
var modelHistorie = false;
// =================================
var dialogLoading = false;

/** enter submit verbieten */
function preventDialog() {
    $('.dialog input').keydown(function (event) {
        // console.log(event.keyCode);
        if (event.keyCode == 13 /*|| event.keyCode == 9*/) {
            // console.log(event.keyCode);
            event.preventDefault();
            var inputs = $(this).closest('form').find(':input:visible');
            inputs.eq(inputs.index(this) + 1).focus();
            $(this).next('input').focus();
            return false;
        }
    });
}

/** .enter submit verbieten */


/** initSelect2 with 100% */
function initSelect2() {
    $(".select2-container").width('100%');
}

/** .initSelect2 with 100% */

$(document).ready(function () {
    checkPflichtfelder();

    if ($('#volltext').length) {
        $('#volltext').focus();
    }
    $('copy2clipboard').on('click', function () {
        copyToClipboard($(this));
    });
    $('#header-navi-button').on('click', function () {
        if (!$('#header-nav').hasClass('d-none')) {
            $('#header-nav').addClass('d-none');
            $('#header-date-box').addClass('d-none');
            $('#header-user-box').addClass('d-none');
        } else {
            $('#header-nav').removeClass('d-none');
            $('#header-date-box').removeClass('d-none');
            $('#header-user-box').removeClass('d-none');
        }
    });
    $('nav > div').on('mouseenter', function () {
        if ($('nav').hasClass('show') && !$(this).find('.dropdown-menu').hasClass('show')) {
            $('nav > div > .dropdown-menu.show').removeClass('show');
            $(this).find('.dropdown-menu').addClass('show');
        }
    });
    $('table.fixed-header').each(function () {
        var txt;
        $(this).find('th').each(function () {
            txt = $(this).html();
            $(this).wrapInner('<div style="width: ' + $(this).width() + 'px"></div>');
            $(this).append(txt);
        });
    });
    registerDefaultEvents($(document.body));
    if ($('#flash-message').length) {
        if ($('#flash-message').attr('data-type') == 'alert') {
            messageAlert($('#flash-message').html());
        } else if ($('#flash-message').attr('data-type') == 'error') {
            flashError($('#flash-message').html());
        } else {
            flashSuccess($('#flash-message').html());
        }
        $('#flash-message').remove();
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function registerDefaultEvents(obj) {
    if (obj !== false && obj !== undefined) {
        $('a.list-action', obj).off('click').each(function () {
            var targetUrl = $(this).attr('href');
            if ($(this).hasClass('open-dialog')) {
                $(this).parent().parent().css('cursor', 'pointer').dblclick(function () {
                    openDialog(targetUrl);
                });
            } else {
                $(this).parent().parent().dblclick(function () {
                    window.location.href = targetUrl;
                });
            }
        });
        $('.open-dialog', obj).off('click').on('click', function (e) {
            e.preventDefault();
            openDialog($(this).attr('href'), {});
            e.stopPropagation();
        });
        $('.dialog-delete', obj).off('click').on('click', function (e) {
            e.preventDefault();

            let url = $(this).attr('href');

            if (!confirm($(this).attr('data-dialog'))) return;

            sendAjaxRequest(url);
        });
        // Dropdowns
        $('.dropdown-toggle', obj).on('click', function (myevent) {
            if ($(this).parent().find('.dropdown-menu').hasClass('show')) {
                $(this).parent().find('.dropdown-menu').removeClass('show');
                $('html').off('click.dropdown');
            } else {
                $(this).parent().find('.dropdown-menu').addClass('show');
                if ($(this).parent().parent().is('nav')) {
                    $(this).parent().parent().addClass('show');
                }
                myevent.stopPropagation();
                obj.on('click.dropdown', function (event) {
                    if ($(event.target).parents('.dropdown-menu').length == 0) {
                        console.log('off');
                        $('html').off('click.dropdown');
                        $('.dropdown-menu').removeClass('show');
                        $('nav.show').removeClass('show');
                    }
                });
            }


            // if ($(this).parent().hasClass('.show')) {
            //     $(this).parent().removeClass('show');
            //     $('html').off('click.dropdown');
            // } else {
            //     if ($('.dropdown.show', obj).length) {
            //         $('.dropdown.show', obj).removeClass('show');
            //         $('html').off('click.dropdown');
            //     }
            //     $(this).parent().addClass('show');
            //     obj.on('click.dropdown', function (event) {
            //         if ($(event.target).parents('.dropdown').length == 0 && !$('.dropdown').is($(event.target))) {
            //             $('html').off('click.dropdown');
            //             $('.dropdown').removeClass('show');
            //             $('.nav.show').removeClass('show');
            //         }
            //     });
            // }
        });
        // Datepicker
        if ($.fn.datepicker) {
            $('.datepicker', obj).datepicker({
                format: 'yyyy-mm-dd',
                weekStart: 1,
                todayButton: true,
                autoHide: true,
                autoClose: true
            });
        }
        // Select2
        // $('.select2', obj).select2({placeholder: '- Please choose -'});
        // Prevent Enter (Enter zu tab machen in dialog)
        preventDialog();
        // Währungs prüfung für dialoge aktivieren
        waehrung();
        // IBAN Formatierung
        formatIBAN();
        // select2 init
        initSelect2();
        // Zeit formatierung in inputs
        zeit();
        // checken von Pflichtfeldern in Dialog
        checkPflichtfelder();
        // tootip reinitial
        if (tooltipactive === 1) {
            $('[data-toggle="tooltip"]').tooltip();
        }

        if (obj.hasClass('dialog')) {
            if (typeof dialogReady === 'function') {
                dialogReady();
            }
            $('.dialog-delete-ajax', obj).on('click', function (e) {
                e.preventDefault();
                $.dialog({
                    title: $(this).attr('title'),
                    content: '<p>' + $(this).attr('data-dialog') + '</p><div class="buttonbar bordertop"><button class="btn btn-danger" type="button" onclick="closeDialog(); sendAjaxRequest(\'' + $(this).attr('href') + '\', {});">Yes</button><button class="btn btn-default" type="button" onclick="closeDialog();">No</button></div>'
                });
                e.stopPropagation();
            });
        }
    }
}

function showToast(msg, type = 'success') {
    let color = type === 'success' ? '#28a745' : '#dc3545';

    let toast = $(`
        <div style="
            background: ${color};
            color: white;
            padding: 10px 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        ">
            ${msg}
        </div>
    `);

    $('#toast-container').append(toast);

    setTimeout(() => {
        toast.fadeOut(300, () => toast.remove());
    }, 2500);
}

function messageAlert(msg, title) {
    if (title === undefined) {
        title = 'Ein Fehler ist aufgetreten';
    }
    if (msg == 'The given data was invalid.') {
        msg = '<!--<div class="row"><div class="col-10">-->Bitte überprüfen Sie Ihre Eingaben und<br>beachten Sie die Inforamtionen unter den betroffenen Feldern!<!--</div><div calss="2"><img src="/img/eastereggs/error_01.gif" style="width:4rem;"></div></div>-->';
    }
    message(msg, 'alert', { title: title });
}

function messageSuccess(msg, title) {
    if (title === undefined) {
        title = 'Erfolg';
    }
    message(msg, 'success', { title: title });
}

function flashSuccess(msg, duration) {
    if (duration === undefined) {
        duration = 3000;
    }
    // Existierendes Element entfernen, falls vorhanden
    if ($('#flash-success').length > 0) {
        setTimeout(function () {
            $('#flash-success').fadeOut(400, function () {
                $('#flash-success').remove();
            });
        }, 500);
    }
    $('header').after('<div id="flash-success"><i class="fa fa fa-check"></i> ' + msg + '</div>');
    $('#flash-success').css('left', ($(window).width() - $('#flash-success').width()) / 2).show().animate({ bottom: -4 }, 700, function () {
        setTimeout(function () {
            $('#flash-success').fadeOut(400, function () {
                $('#flash-success').remove();
            });
        }, duration);
    }).css('z-index', GetNewZIndex());
}


function flashError(msg, duration) {
    if (duration === undefined) {
        duration = 3000;
    }
    // Existierendes Element entfernen, falls vorhanden
    if ($('#flash-success').length > 0) {
        setTimeout(function () {
            $('#flash-success').fadeOut(400, function () {
                $('#flash-success').remove();
            });
        }, 500);
    }
    $('header').after('<div id="flash-success"><i class="fa fa fa-check"></i> ' + msg + '</div>');
    $('#flash-success').css('background-color', 'red').css('left', ($(window).width() - $('#flash-success').width()) / 2).show().animate({ bottom: -4 }, 700, function () {
        setTimeout(function () {
            $('#flash-success').fadeOut(400, function () {
                $('#flash-success').remove();
            });
        }, duration);
    }).css('z-index', GetNewZIndex());
}

function message(msg, type, options) {
    if (options === undefined) {
        options = { title: 'Message' };
    }
    if (type === undefined) {
        type = 'alert';
    }
    if (options['class'] !== undefined) {
        options['dialogClass'] = options['class'];
    }
    switch (type) {
        case 'success':
            options['titlebarClass'] = 'success';
            options['content'] = '<p>' + msg + '</p><div class="buttonbar bordertop"><button class="btn btn-primary" type="button" onclick="closeDialog();">Ok</button></div>';
            break;
        case 'confirm':
            if (options['title'] == 'Message') {
                options['title'] = 'Please confirm';
            }
            options['content'] = '<p>' + msg + '</p><div class="buttonbar bordertop">';
            options['content'] += '<button class="btn btn-danger" type="button" onclick="window.location.href = \'' + options['href'] + '\';">Ok</button>';
            options['content'] += '<button class="btn btn-primary" style="float: right; margin-right: 0;" type="button" onclick="closeDialog();">Abbrechen</button></div>';
            break;
        default:
            options['titlebarClass'] = 'alert';
            options['content'] = '<p>' + msg + '</p><div class="buttonbar bordertop"><button class="btn btn-primary" type="button" onclick="closeDialog();">Ok</button></div>';
            break;
    }
    $.dialog(options);
}

function openDialog(url, options) {
    if (options === undefined) {
        options = {};
    }
    if (!dialogLoading) {
        dialogLoading = true;
        $.get(url, function (data) {
            dialogLoading = false;
            if (typeof data == 'object') {
                if (data['redirect'] !== undefined) {
                    window.location.href = data['redirect'];
                } else {
                    if (data['error'] !== undefined && data['error']) {
                        messageAlert(data['msg']);
                    } else {
                        $.extend(options, data);
                        registerDefaultEvents($.dialog(options));
                        //$('   .dialog-content form:first *:input[type!=hidden]:first').focus();
                    }
                }
            } else {
                var dialogObj = $.dialog({ title: 'Dialog', content: data });
                if (dialogObj.find('.dialog-title').length) {
                    dialogObj.find('.dialog-titlebar').html(dialogObj.find('.dialog-title').html());
                    dialogObj.find('.dialog-title').remove();
                }
                dialogObj.find('.dialog-alert').remove();
                registerDefaultEvents(dialogObj);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 401) {
                window.location.href = '/login';
            }
        });
    }
}

function closeDialog() {
    if ($.fn.datepicker) {
        $('.datepicker').datepicker('hide');
    }
    $.dialog('close');
}

function spinnerON() {
    $('#spinner').show();
}

function spinnerOFF() {
    $('#spinner').hide();
}

function submitDialog(form) {
    spinnerON();
    $.ajax({
        url: $(form).attr('action'),
        type: 'post',
        dataType: 'json',
        data: $(form).serialize(),
        success: function (response) {
            if (typeof response == 'object') {
                if ((response['success'] !== undefined && response['success']) || (response['error'] !== undefined && !response['error'])) {
                    spinnerOFF();
                    if (response['dontclose'] === undefined) {
                        $.dialog('close');
                    }
                    $('.form-group').find('.invalid-feedback').remove();
                    $('.form-control.is-invalid').removeClass('is-invalid');
                    if (response['msg'] !== undefined) {
                        if (response['msg_title'] !== undefined) {
                            messageSuccess(response['msg'], response['msg_title']);
                        } else {
                            showToast(response['msg'], 'success')
                        }
                    }
                    if (response['execute'] !== undefined) {
                        eval(response['execute']);
                    } else {
                        if (response['redirect'] !== undefined) {
                            window.location.href = response['redirect'];
                        } else if (response['stream2newtab'] !== undefined) {
                            window.open("data:application/pdf," + escape(response.stream));
                        } else if (response['reloadParent'] !== undefined) {
                            console.log(response.test);
                            closeDialog();
                            openDialog(response.reloadParent);
                        } else {
                            window.location.reload();
                        }
                    }
                } else {
                    if (response['parent_content'] !== undefined) {
                        $.dialog('close');
                        // previous dialog keeps displayed
                        registerDefaultEvents($.dialog('content', response['parent_content']));
                    } else {
                        if (response['content'] !== undefined && response['content'] != '') {
                            registerDefaultEvents($.dialog('content', response['content']));
                        }
                    }
                    if (response['msg'] !== undefined) {
                        if (response['msg_title'] !== undefined) {
                            messageAlert(response['msg'], response['msg_title']);
                        } else {
                            messageAlert(response['msg']);
                        }
                    }
                    if (response['execute'] !== undefined) {
                        eval(response['execute']);
                    }
                }
            } else {
                var dialogObj = $.dialog('content', response);
                if (dialogObj.find('.dialog-title').length) {
                    $.dialog('title', dialogObj.find('.dialog-title').html());
                    dialogObj.find('.dialog-title').remove();
                }
                if (dialogObj.find('.dialog-alert').length) {
                    if (dialogObj.find('.dialog-alert-title').length) {
                        messageAlert(dialogObj.find('.dialog-alert').html(), dialogObj.find('.dialog-alert-title').html());
                        dialogObj.find('.dialog-alert-title').remove();
                    } else {
                        messageAlert(dialogObj.find('.dialog-alert').html());
                    }
                    dialogObj.find('.dialog-alert').remove();
                }
                registerDefaultEvents(dialogObj);
            }
        },
        error: function (data) {
            spinnerOFF();
            // Remove previous errors
            $('.form-control.is-invalid').removeClass('is-invalid');
            $('.form-group').find('.invalid-feedback').remove();
            // Add new errors
            var response = (data['responseJSON'] !== undefined) ? data['responseJSON'] : $.parseJSON(data.responseText);
            if (typeof response == 'object') {
                if (response['errors'] !== undefined) {
                    $.each(response['errors'], function (index, messages) {
                        // console.log(index);
                        if ($('#' + index + ' .select2').length) {
                            $.each(messages, function (mid, msg) {
                                console.log($('div #' + index).children($('div .col-md-8')));
                                $('#' + index + ' .select2').next().css('color', 'red').addClass('is-invalid')
                                $('div .' + index).next($('.col-md-8')).append('<div class="invalid-feedback">' + msg + '</div>');
                            });
                        }
                        if ($('#' + index).length) {
                            $('#' + index).addClass('is-invalid');
                            $.each(messages, function (mid, msg) {
                                $('#' + index).parent().append('<div class="invalid-feedback">' + msg + '</div>');
                            });
                        }
                    });
                    messageAlert(response['message']);
                }
            } else {
                // messageAlert(msg);
                messageAlert('Form could not be submitted correctly');
            }
        }
    });
    return false;
}

function sendAjaxRequest(url) {
    $.get(url, function (response) {

        // تحديث المحتوى إذا موجود
        if (response['parent_content'] !== undefined) {
            registerDefaultEvents($.dialog('content', response['parent_content']));
        }

        if (response['content'] !== undefined && response['content'] != '') {
            registerDefaultEvents($.dialog('content', response['content']));
        }

        // 🔥 أهم جزء (Toast بدل Dialog)
        if (response['msg'] !== undefined) {
            if (response['success']) {
                showToast(response['msg'], 'success');
            } else {
                showToast(response['msg'], 'error');
            }
        }

        // تنفيذ أوامر إضافية (تحديث الجدول)
        if (response['execute'] !== undefined) {
            eval(response['execute']);
        }

        // redirect إذا موجود
        if (response['redirect'] !== undefined) {
            window.location.href = response['redirect'];
        }

    }, "json");
}

/* DIALOG */

(function ($) {

    var dialogIndex, dialog = new Array, settings = {},
        defaultSettings = { 'title': 'Dialog', 'content': '[no content]', 'dialogCloseButton': true };

    function _openDialog() {
        $('body').append('<div class="dialog-overlay"></div>');
        $('div.dialog-overlay:last').css('z-index', parseInt($('div.dialog-overlay:last').css('z-index')) + dialog.length);
        var obj = $('<div class="dialog" tabindex="-1"></div>');
        $('body').append(obj);
        obj.append('<div class="dialog-titlebar">' + settings.title + '</div>');
        // obj.append('<div class="dialog-toolbar" style="position:absolute;top:5px;right:10px;">' +
        //     '<button class="dialog-btn-minimize" title="Minimieren" style="margin-right:4px;">_</button>' +
        //     '<button class="dialog-btn-maximize" title="Maximieren/Verringern" style="margin-right:4px;">▢</button>' +
        //     '<button class="dialog-btn-fullscreen" title="Vollbild">⛶</button>' +
        //     '</div>');
        obj.append('<div class="dialog-content"></div>');
        obj.find('div.dialog-content').html(settings.content);
        obj.css('z-index', parseInt(obj.css('z-index')) + dialog.length).focus();
        if (dialog.length == 0) {
            $(document).on('keyup', function (e) {
                if (e.which === 27) {
                    if ($.contains(obj[0], document.activeElement) || $(document.activeElement).hasClass('dialog')) {
                        _closeDialog();
                    }
                }
            });
        }
        // if (settings.dialogCloseButton) {
        //     obj.prepend('<div class="actions"><a id="dialog-minimize-btn" class="icon dialog-close-btn">_</a><a id="dialog-fullscreen-btn" class="icon dialog-close-btn">▢</a><a id="dialog-close-btn" class="dialog-close-btn">X</a></div>');
        //     obj.find('#dialog-minimize-btn').on('click', function () {
        //         // _minimizeDialog();
        //         alert("minimizeing");
        //     });
        //     obj.find('#dialog-fullscreen-btn').on('click', function () {
        //         // _fullscreenDialog();
        //         alert("fullscreening");
        //     });
        //     obj.find('#dialog-close-btn').on('click', function () {
        //         _closeDialog();
        //     });
        // }
        if (settings.dialogCloseButton) {
            obj.prepend('<a class="dialog-close-btn">X</a>');
            obj.find('a.dialog-close-btn').on('click', function () {
                _closeDialog();
            });
        }
        if (settings.titlebarClass !== undefined) {
            obj.find('.dialog-titlebar').addClass(settings.titlebarClass);
        }
        dialog.push(obj);
        _centerDialog();
        _makeDraggable(obj);
        _prepareFieldsIfHistorieExists();
        return obj;
    }

    function _prepareFieldsIfHistorieExists() {
        if (modelHistorie) {
            $('.dialog form input, .dialog form textarea, .dialog form select, .dialog form .select2').prop('readonly', true).prop('disabled', true);
            $('.dialog .btn.btn-success').hide();
            $('.dialog .dialog-titlebar').addClass('status_historie_aktiv').css('color', 'white');
            // $('.dialog .dialog-titlebar').css('background', 'rgba(11, 97, 164, 0.68)');
            // alert("test");
        }
    }

    function _centerDialog() {
        if (dialog.length > 0) {
            dialogIndex = dialog.length - 1;
            var left = ($(window).width() - dialog[dialogIndex].outerWidth()) / 2,
                top = ($(window).height() - dialog[dialogIndex].outerHeight()) / 2;
            if (left < 0) {
                left = 0;
            }
            if (top < 0) {
                top = 6;
            }
            dialog[dialogIndex].css('left', left).css('top', top);
        }
    }

    function _closeDialog() {
        $(document.activeElement).blur();
        $('[data-toggle="tooltip"]').tooltip('hide');
        $('[data-toggle="tooltip"]').tooltip('dispose');
        if (dialog.length > 0) {
            dialogIndex = dialog.length - 1;
            dialog[dialogIndex].remove();
            $('div.dialog-overlay:last').remove();
            dialog.pop();
            if (dialog.length == 0) {
                $(document).off('keyup');
            }
        }
        registerDefaultEvents($(document));
    }

    function _replaceContent(content) {
        if (dialog.length > 0) {
            dialogIndex = dialog.length - 1;
            dialog[dialogIndex].find('div.dialog-content').html(content);
            return dialog[dialogIndex];
        }
        return false
    }

    function _replaceTitle(title) {
        if (dialog.length > 0) {
            dialogIndex = dialog.length - 1;
            dialog[dialogIndex].find('div.dialog-titlebar').html(title);
            return dialog[dialogIndex];
        }
        return false
    }

    function _makeDraggable(dialogObj) {
        var titleBar = dialogObj.find('div.dialog-titlebar');
        titleBar.css('cursor', 'move');
        titleBar.on('mousedown', function (e) {
            var pos = dialogObj.offset(), mousestart = e, maxLeft = $(document).width() - dialogObj.outerWidth(),
                maxTop = $(document).height() - dialogObj.outerHeight(), left, top;
            $(window).on('mousemove', function (e) {
                $('body').css('user-select', 'none');
                e.preventDefault;
                e.stopPropagation();
                left = e.pageX - mousestart.pageX + pos.left;
                top = e.pageY - mousestart.pageY + pos.top;
                if (left <= 0) {
                    left = 0;
                }
                if (left > maxLeft) {
                    left = maxLeft;
                }
                if (top <= 0) {
                    top = 0;
                }
                if (top > maxTop) {
                    top = maxTop;
                }
                dialogObj.css('left', left);
                dialogObj.css('top', top);
                $(window).on('mouseup', function () {
                    $(window).off('mousemove');
                    $('body').css('user-select', 'auto');
                });
            });
        });
    }

    $.dialog = function (options, value) {
        if (typeof options === 'string') {
            $.extend(settings, defaultSettings);
            if (options == 'close') {
                _closeDialog();
            } else if (options == 'center') {
                _centerDialog();
            } else if (options == 'content') {
                return _replaceContent(value);
            } else if (options == 'title') {
                return _replaceTitle(value);
            } else {
                return _openDialog();
            }
        } else {
            settings = {};
            $.extend(settings, defaultSettings, options);
            return _openDialog();
        }
    };

})(jQuery);

/* AJAX TABLES */

(function ($) {

    var defaultOpts = {
        url: '',
        method: 'post',
        cols: [],
        sortable: [],
        search: {},
        defaultSort: [],
        perPageSelect: '',
        info: '.pagination-info',
        paginate: '.pagination-numbers',
        paginateLength: 10,
        perPage: 10,
        perPageOptions: [10, 25, 50, 100],
        onUpdate: function () {
        }
    };
    var table, useView = false, opts = {}, total = null, reqTotal = true, page = 1, pages = 0, perPage = 10,
        counter = 0, cols = 0, sort = [], searchObj = {};

    function performRequest() {
        spinnerON();
        $('.lupeinput').find('i').toggleClass('fa-search fa-spinner').addClass('lupeinput-icon-rotate');
        var data = {
            'draw': ++counter,
            'length': perPage,
            'start': (page - 1) * perPage,
            'order': sort
        };
        if (reqTotal) {
            data['total'] = true;
        }
        data['search'] = searchObj;
        $.ajax({
            url: opts.url,
            type: opts.method,
            data: data,
            success: function (result) {
                if (result.draw == counter) {
                    if (result.total !== undefined) {
                        total = result.total;
                    }
                    if (useView) {
                        table.html(result.view);
                        setTableHeader(table.find('table'));
                    } else {
                        draw(result);
                    }
                    buildPagination();
                    opts.onUpdate();
                }
                reqTotal = false;
            },
            error: function () {
                location.reload();
            },
            complete: function () {
                spinnerOFF();
                $('.lupeinput').find('i').toggleClass('fa-spinner fa-search').removeClass('lupeinput-icon-rotate');
            }
        });
    }

    function draw(result) {
        table.find("tr:not(:first)").remove();
        var html = '', i = 0, content = '';
        if (opts.cols.length > 0) {
            // cols are defined
            i = 1;
            $.each(result.data, function (key, row) {
                i++;
                html += '<tr>';
                $.each(opts.cols, function (index, col) {
                    content = '';
                    if (typeof col === 'function') {
                        content = col.call(this, row);
                    } else if (typeof col === 'object') {
                        $.each(col, function (index2, item) {
                            content += (row[item] !== undefined) ? row[item] : item;
                        })
                    } else {
                        content = (row[col] !== undefined) ? row[col] : col;
                    }
                    html += '<td>' + content + '</td>';
                });
                html += '</tr>';
            });
        } else {
            // cols are undefined
            $.each(result.data, function (key, row) {
                html += '<tr>';
                i = 0;
                $.each(row, function (index, col) {
                    if (i++ < cols) {
                        html += '<td>' + col + '</td>';
                    }
                });
                html += '</tr>';
            });
        }
        table.append(html);
    }

    function buildPagination() {
        if (opts.paginate !== false) {
            pages = Math.ceil(total / perPage);
            var first = 1, last = opts.paginateLength, prev = false, next = true, html = '<ul class="pagination">';
            var middle = Math.floor(opts.paginateLength / 2);
            if (page > 1) {
                prev = true;
            }
            if (page == pages) {
                next = false;
            }
            if (page > middle) {
                first = page - middle;
                last = page + middle;
            }
            if (page > pages - middle) {
                first = pages - opts.paginateLength;
                last = pages;
            }
            // html += '<input type="text" name="volltext" id="volltext" class="volltext form-control w-100" placeholder="Volltextsuche" onchange="return submitDialog(this);">';
            html += '<li class="page-item"><a class="page-link at-page" data-idx="1"><i class="fa fa-angle-double-left"></i></a></li>';
            if (prev) {
                html += '<li class="page-item"><a class="page-link at-page" data-idx="' + (page - 1) + '"><i class="fa fa-angle-left"></i></a></li>';
            }
            if (first < 1) {
                first = 1;
            }
            if (last > pages) {
                last = pages;
            }
            for (var i = first; i <= last; i++) {
                if (i == page) {
                    html += '<li class="page-item active"><a class="page-link"><span>' + i + '</span></a></li>';
                } else {
                    html += '<li class="page-item"><a class="page-link at-page" data-idx="' + i + '">' + i + '</a></li>';
                }
            }
            if (next) {
                html += '<li class="page-item"><a class="page-link at-page" data-idx="' + (page + 1) + '"><i class="fa fa-angle-right"></i></a></li>';
            }
            html += '<li class="page-item"><a class="page-link at-page" data-idx="' + pages + '"><i class="fa fa-angle-double-right"></i></a></li></ul>';
            $(opts.paginate).html(html);
            $('a.at-page').on('click', function () {
                page = parseInt($(this).attr('data-idx'));
                performRequest();
            });
            first = (page - 1) * perPage + 1;
            last = first + perPage - 1;
            if (last > total) {
                last = total;
            }
            $(opts.info).html('Zeige ' + first + ' bis ' + last + ' von ' + total + ' Einträgen');
        }
    }

    function setTableHeader(obj) {
        obj.find('th').each(function (i) {
            if (opts.sortable[i] !== undefined && opts.sortable[i] !== false && opts.sortable[i] != '') {
                $(this).addClass('at-sortable').on('click', function () {
                    toggleSort(i);
                });
                $(this).append($('<span id="at-th-' + i + '-sort-desc" class="at-sort-desc"><i class="fa fa-caret-down"></i></span>').on('click', function (e) {
                    e.stopPropagation();
                    setSort(i, 'desc');
                }));
                $(this).append($('<span id="at-th-' + i + '-sort-asc" class="at-sort-asc"><i class="fa fa-caret-up"></i></span>').on('click', function (e) {
                    e.stopPropagation();
                    setSort(i, 'asc');
                }));
            }
        });
        if (useView && sort.length > 0) {
            for (var i = 0; i < sort.length; i++) {
                var th = opts.sortable.indexOf(sort[i][0]);
                $('#at-th-' + th + '-sort-' + sort[i][1]).addClass('active');
            }
        }
        cols = obj.find('th').length;
    }

    function toggleSort(index) {
        if ($('#at-th-' + index + '-sort-asc').hasClass('active')) {
            setSort(index, 'desc');
        } else {
            setSort(index, 'asc');
        }
    }

    function setSort(index, direction) {
        if (opts.sortable[index] !== undefined && opts.sortable[index] !== false && opts.sortable[index] != '') {
            sort = [[opts.sortable[index], direction]];
            $('.at-sort-asc').removeClass('active');
            $('.at-sort-desc').removeClass('active');
            $('#at-th-' + index + '-sort-' + direction).addClass('active');
            performRequest();
        }
    }

    function setDefaultSort() {
        sort = opts.defaultSort;
        if (sort.length > 0) {
            var index = opts.sortable.indexOf(sort[0][0]);
            if (index >= 0) {
                setSort(index, sort[0][1]);
            }
        }
    }

    function initDefaultSort() {
        if (typeof opts.defaultSort === 'string') {
            opts.defaultSort = (opts.defaultSort != '') ? [[opts.defaultSort, 'asc']] : [];
        } else {
            if (opts.defaultSort.length > 0) {
                sort = opts.defaultSort;
                opts.defaultSort = [];
                var i = 0;
                $.each(sort, function (key, val) {
                    if (typeof val === 'string') {
                        if (val === 'asc' || val === 'ASC') {
                            opts.defaultSort[--i][1] = 'asc';
                            val = '';
                        }
                        if (val === 'desc' || val === 'DESC') {
                            opts.defaultSort[--i][1] = 'desc';
                            val = '';
                        }
                        if (val != '') {
                            opts.defaultSort[i] = [val, 'asc'];
                            i++;
                        }
                    } else {
                        if (val[1] === undefined) {
                            val[1] = 'asc';
                        }
                        opts.defaultSort[i] = val;
                        i++;
                    }
                });
            }
        }
        setDefaultSort();
    }

    function setPerPageSelection() {
        if (opts.perPageSelect !== false && $(opts.perPageSelect).length) {
            //
            // <div class="input-group">
            //         <span class="input-group-addon" id="basic-addon1">@</span>
            //     <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
            //         </div>

            var html = '<select class="at-per-page-selection">';
            for (var i = 0; i < opts.perPageOptions.length; i++) {
                html += '<option value="' + opts.perPageOptions[i] + '"' + ((perPage == opts.perPageOptions[i]) ? ' selected="selected"' : '') + '>' + opts.perPageOptions[i] + '</option>';
            }
            $(opts.perPageSelect).html(html + '</select>');
            $('.at-per-page-selection').on('change', function () {
                perPage = parseInt($(this).val());
                pages = Math.ceil(total / perPage);
                if (page > pages) {
                    page = 1;
                }
                performRequest();
            });
        }
    }

    function initSearchValues() {
        $.each(searchObj, function (index) {
            searchObj[index] = $('#' + index).val();
        });
    }

    function init() {
        // Check if the given Object is a 'table' otherwise use the view mode
        if (!table.is('table')) {
            useView = true;
        }
        perPage = opts.perPage;
        setPerPageSelection();
        if (useView) {
            initDefaultSort();
        } else {
            setTableHeader(table);
            initDefaultSort();
        }
        if (counter == 0) {
            // start request if not started
            performRequest();
        }
        return this;
    }

    this.search = function (name, value) {
        searchObj[name] = value;
        page = 1;
        reqTotal = true;
        performRequest();
    };

    this.searchObserve = function (elements) {
        $.each(elements, function (index, element) {
            searchObj[element] = $('#' + element).val();
            $('#' + element).on('change', function () {
                performSearch();
            });
            performSearch();
        });
    };

    this.performSearch = function () {
        initSearchValues();
        page = 1;
        reqTotal = true;
        performRequest();
    };

    $.fn.AjaxTable = function (options) {
        table = this;
        opts = {};
        $.extend(opts, defaultOpts, options);
        return init();
    };
})(jQuery);

function nl2br(str, replaceMode, isXhtml) {
    var breakTag = (isXhtml) ? '<br />' : '<br>';
    var replaceStr = (replaceMode) ? '$1' + breakTag : '$1' + breakTag + '$2';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
}

function br2nl(str, replaceMode) {
    var replaceStr = (replaceMode) ? "\n" : '';
    // Includes <br>, <BR>, <br />, </br>
    return str.replace(/<\s*\/?br\s*[\/]?>/gi, replaceStr);
}


