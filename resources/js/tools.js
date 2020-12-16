require('./tools/date')

$('.json-code').on('keydown', function(e) {
    if (e.keyCode === 9) {
        e.preventDefault();
        var cursorPos = $(this).prop('selectionStart');
        console.log(cursorPos);
        var v = $(this).val();
        var textBefore = v.substring(0,  cursorPos);
        var textAfter  = v.substring(cursorPos, v.length);
        $(this).val(textBefore + '    ' + textAfter);
        $(this).prop({
            'selectionStart': cursorPos + 4,
            'selectionEnd': cursorPos + 4
        });
    } else if (event.shiftKey) {
        if (e.keyCode === 222 || e.keyCode === 219) {
            e.preventDefault();
            var cursorPos = $(this).prop('selectionStart');
            console.log(cursorPos);
            var v = $(this).val();
            var textBefore = v.substring(0,  cursorPos);
            var textAfter  = v.substring(cursorPos, v.length);
            let targettxt = (e.keyCode === 222) ? '""' : '{}'
            $(this).val(textBefore + targettxt + textAfter);
            $(this).prop({
                'selectionStart': cursorPos + 1,
                'selectionEnd': cursorPos + 1
            });
        }
    }
});