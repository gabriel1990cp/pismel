(function() {
    tinymce.PluginManager.add('small_button', function( editor, url ) {
        editor.addButton( 'small_button', {
            title: titleName,
            icon: 'icon dashicons-editor-textcolor',
            onclick: function() {
            	selected = editor.selection.getContent();

            	if(selected) {
            		editor.insertContent('<small class="small">'+selected+'</small>');
            	} else {
            		window.alert(alertTitle);
            	}
            }
        });
    });
})();