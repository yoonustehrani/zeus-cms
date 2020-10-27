require('ace-builds/webpack-resolver')
window.ace = require('ace-builds/src-min-noconflict/ace');

$('.user_editor_container').each(function() {
    let id = $(this).attr('id');
    if (id) {
        let editor = ace.edit(id);
        editor.setTheme("ace/theme/twilight");
        editor.session.setMode("ace/mode/json");
    } else console.log('One on Editors do not have Id attribute')
})
