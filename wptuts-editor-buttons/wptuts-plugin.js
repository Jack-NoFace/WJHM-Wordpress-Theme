(function() {

    var user_selected_images = {};

    var open_media_window = function (title, type, ed) {
        var first = {};

        var window = wp.media({
            title: title,
            library: {type: 'image'},
            multiple: false,
            button: {text: 'Insert'}
        });
        window.on('select', function () {
            var files = window.state().get('selection').toArray();
            first = files[0].toJSON();

            user_selected_images[type] = first.url;

            // If both images have been selected, add shortcode
            if (user_selected_images.new) {
                var selected_text = ed.selection.getContent();
                ed.execCommand('mceInsertContent', false, '<section class="hero section section--block section--image" style="background-image:url(' + user_selected_images.new + ');">' + '<div class="section__content">' + selected_text + '</div>' + '</section>');
            }
        });

        window.open();
    };

    tinymce.create('tinymce.plugins.Wptuts', {
        /**
        * Initializes the plugin, this will be executed after the plugin has been created.
        * This call is done before the editor instance has finished it's initialization so use the onInit event
        * of the editor instance to intercept that event.
        *
        * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
        * @param {string} url Absolute URL to where the plugin is located.
        */
        init : function(ed, url) {

            ed.addButton('showrecent', {
                title : 'Add recent posts shortcode',
                cmd : 'showrecent',
                image : url + '/test2.png'
            });

            ed.addButton('paragraph', {
                title : 'Add paragraph container',
                cmd : 'paragraph',
                image : url + '/test2.png'
            });

            ed.addButton('addimage', {
                title: 'Custom Image',
                cmd : 'addimage',
                image : url + '/section.png'
            });

            ed.addButton('youtube', {
                title: 'YouTube Video',
                cmd : 'youtube',
                image : url + '/youtube.png'
            });

            ed.addCommand('addimage', function() {
                //Erase any old data
                user_selected_images = {};
                //Opens first
                open_media_window("Select new photo", "new", ed);
            });

            ed.addCommand('youtube', function() {
                var id = prompt("Enter the URL link to the YouTube video you wish to embed"), shortcode;

                if (id !== null) {
                    shortcode = '<div class="videoWrapper"><iframe src="http://www.youtube.com/embed/' + id + '?rel=0&amp;hd=1" width="560" height="349" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>';
                    ed.execCommand('mceInsertContent', 0, shortcode);
                }
                else {
                    alert("Please enter a valid YouTube URL");
                }
            });

        },

        /**
        * Creates control instances based in the incomming name. This method is normally not
        * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
        * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
        * method can be used to create those.
        *
        * @param {String} n Name of the control to create.
        * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
        * @return {tinymce.ui.Control} New control instance or null if no control was created.
        */
        createControl : function(n, cm) {
            return null;
        },

        /**
        * Returns information about the plugin as a name/value array.
        * The current keys are longname, author, authorurl, infourl and version.
        *
        * @return {Object} Name/value array containing information about the plugin.
        */
        getInfo : function() {
            return {
                longname : 'Wptuts Buttons',
                author : 'Lee',
                authorurl : 'http://wp.tutsplus.com/author/leepham',
                infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
                version : "0.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add( 'wptuts', tinymce.plugins.Wptuts );
})();
