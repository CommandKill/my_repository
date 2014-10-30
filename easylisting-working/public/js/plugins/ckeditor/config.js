/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
//	config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.filebrowserBrowseUrl = '../../../js/plugins/elfinder/elfinder.html';
    config.filebrowserWindowHeight = 800;
    config.filebrowserWindowWidth = 800;
    config.toolbar = 'MyToolbar';
//    config.toolbarGroups = [
//        { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
//        { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
//        { name: 'links' },
//        { name: 'insert' },
//        { name: 'forms' },
//        { name: 'tools' },
//        { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
//        { name: 'others' },
//        '/',
//        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
//        { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
//        { name: 'styles' },
//        { name: 'colors' },
//        { name: 'about' }
//    ];
    config.toolbar_MyToolbar =
        [
            ['Source','Templates'],
            ['Cut','Copy','Paste','SpellChecker','-','Scayt'],
            ['Undo','Redo','-','Find','Replace'],
            ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
            ['Maximize','-','About'],
            '/',
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','SelectAll','RemoveFormat'],
            ['Link','Unlink','Anchor'],
            ['Styles','Format','Font','FontSize'],
            ['TextColor','BGColor']
        ];
    config.shiftEnterMode = CKEDITOR.ENTER_P;
    config.enterMode = CKEDITOR.ENTER_BR;
    config.autoParagraph = false;
};
