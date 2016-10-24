/**
 * Created by yama_gs on 21.10.2016.
 */


jQuery( document ).ready(function () {
	jQuery( '#tabs' )
		.tabs();

	tinymce.init({
		selector : '#tabs textarea', height : "380",
		theme: 'modern',
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace wordcount visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools'
		],
		toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		toolbar2: 'print preview media | forecolor backcolor emoticons | add_author',
		image_advtab: true,
		setup: function (editor) {
			editor.addButton('add_author', {
				text: 'Add Author',
				icon: false,
				onclick: function () {
					editor.insertContent( '[add_author_short_code]' );
				}
			});
		},
	});
});
