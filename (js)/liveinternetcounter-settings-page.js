jQuery(document).ready(function($){
    var size = $('#wordefinery-liveinternetcounter-size');
    var style = $('#wordefinery-liveinternetcounter-style');
    var color = $('#wordefinery-liveinternetcounter-color');
    var align = $('#wordefinery-liveinternetcounter-align');
    var size_sel = $('#wordefinery-liveinternetcounter-counter').find('div.size');
    var style_sel = new Array();
    style_sel[1] = $('#wordefinery-liveinternetcounter-counter').find('div.style-1');
    style_sel[2] = $('#wordefinery-liveinternetcounter-counter').find('div.style-2');
    style_sel[3] = $('#wordefinery-liveinternetcounter-counter').find('div.style-3');
    style_sel[4] = $('#wordefinery-liveinternetcounter-counter').find('div.style-4');
    var style_sel_all = $('#wordefinery-liveinternetcounter-counter').find('div.style');;
    var color_sel = new Array();
    color_sel[1] = $('#wordefinery-liveinternetcounter-counter').find('div.color-1');
    color_sel[2] = $('#wordefinery-liveinternetcounter-counter').find('div.color-2');
    color_sel[3] = $('#wordefinery-liveinternetcounter-counter').find('div.color-3');
    color_sel[4] = $('#wordefinery-liveinternetcounter-counter').find('div.color-4');
    var color_sel_all = $('#wordefinery-liveinternetcounter-counter').find('div.color');;
    var align_sel = $('#wordefinery-liveinternetcounter-preview').find('div.align');
    var preview_sel = $('#wordefinery-liveinternetcounter-preview').find('div.preview');

    var size_f = function() {
        size_sel.find('a').removeClass('selected');
        $(this).addClass('selected');
        size.val($(this).prop('name'));
        style_sel_all.hide();
        style_sel[size.val()].show();
        color_sel_all.hide();
        if (style_sel[size.val()].find('.selected').length) {
            color_sel[size.val()].show();
        };
    }
    var style_f = function() {
        style_sel_all.find('a').removeClass('selected');
        $(this).addClass('selected');
        style.val($(this).prop('name'));
        color_sel_all.hide();
        color_sel[size.val()].find('img').each(function (i) {
            $(this).attr('src', 'http://counter.yadro.ru/logo?' + style.val() + '.' + $(this).parent().prop('name'));
        })
        color_sel[size.val()].show();
        if (!color_sel[size.val()].find('.selected').length) {
            color.val('0');
            color_sel_all.find('a').removeClass('selected');
        } else {
            preview_sel.find('img').attr('src', 'http://counter.yadro.ru/logo?' + style.val() + '.' + color.val());
        };
    }
    var color_f = function() {
        color_sel_all.find('a').removeClass('selected');
        $(this).addClass('selected');
        color.val($(this).prop('name'));
        preview_sel.find('img').attr('src', 'http://counter.yadro.ru/logo?' + style.val() + '.' + color.val());
    }
    var align_f = function() {
        align_sel.find('a').removeClass('selected');
        $(this).addClass('selected');
        align.val($(this).prop('name'));
        preview_sel.css('text-align', align.val());
    }
    size_sel.find('a').click(size_f);
    style_sel_all.find('a').click(style_f);
    color_sel_all.find('a').click(color_f);
    align_sel.find('a').click(align_f);
    if (size.val()>0) {
        if (color.val()>0) color_sel[size.val()].find('a[name='+color.val()+']').addClass('selected');
        size_sel.find('a[name='+size.val()+']').click();
        if (style.val()>0) style_sel_all.find('a[name='+style.val()+']').click();
    }
    if (align.val()!='0' && align.val()!='') align_sel.find('a[name='+align.val()+']').click();
    if (color.val()>0 && size.val()>0) color_sel[size.val()].scrollTop(color_sel[size.val()].find('a[name='+color.val()+']').position().top - 5);
    if (style.val()>0 && size.val()>0) style_sel[size.val()].scrollTop(style_sel[size.val()].find('a[name='+style.val()+']').position().top - 5);
});
