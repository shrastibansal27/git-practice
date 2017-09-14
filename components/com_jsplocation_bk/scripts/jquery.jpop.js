/**
 * jQuery Plugin for a popup
 * The popup works on images and links aswell as youtube and vimeo players
 *
 * @author Sedat Bilen
 * @licence Licensed under the MIT license
 */
(function ($)
{
    /**
     * Default settings
     * @type {{type: string, onClick: string, onClose: string, gallery: boolean}}
     */
    var settings = {
        type: "img",
        onClick: "",
        onClose: "",
        gallery: true
    };
    
    var modal = $("<div id='popup-modal'>");
    var modalContent = $("<div id='content'>");
    
    var overlay = $("<div class='overlay'>");
    
    var arrowsContainer = $("<div id='arrows-container'>");
    var arrowLeft = $("<div id='arrow-left'>");
    var arrowRight = $("<div id='arrow-right'>");
	//var closebtn = $("<div id='closebtn' class='closebtn'>Close</div>");
    
    var $selector;

    var youtube = {
        /**
         * Youtube video parser, get the video id
         * Source: http://stackoverflow.com/a/29003657
         *
         * @param url
         * @returns {*}
         */
        getVideoId: function(url)
        {
            var match = url.match(/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/);
            return match && match[7].length == 11 ? match[7] : false;
        },

        /**
         * Get the Youtube embed url
         * @param videoId
         * @returns {string}
         */
        getEmbedUrl: function(videoId)
        {
            return "https://www.youtube.com/embed/" + videoId + "?autoplay=1";
        }
    };
    
    var vimeo =
    {
        /**
         *
         * @param url
         * @returns {*}
         */
        getVideoId: function(url)
        {
            var match = url.match(/http(s)?:\/\/(www\.)?vimeo.com\/(\d+)(\/)?(#.*)?/)
            return match ? match[3] : false;
                
        },

        /**
         * Get the Vimeo embed url
         * @param   {[[Type]]} videoId [[Description]]
         * @returns {String}   [[Description]]
         */
        getEmbedUrl: function(videoId)
        {
            return "https://player.vimeo.com/video/" + videoId + "?autoplay=1";
        }
    };
    
    var methods = {
        /**
         * Initialize the plugin with the options selected
         * @param $event
         */
        init: function ($event)
        {
            $event.preventDefault();
            $selector = $(this);
            var settings = $event.data;

            // Handle the different actions based on the type
            switch(settings.type)
            {
                case "img": methods.handleImage(); break;
                case "iframe": methods.handleFrame(); break;
            }

            if(typeof settings.onClick == 'function')
            {
                settings.onClick.call();
            }

            // Add the arrows to the page if gallery is enabled
            if(settings.gallery)
            {
                methods.addArrows($event);
            }
            methods.addModal();
            $("body").on("click", $event.data, methods.handleOverlay).on("keyup", $event.data, methods.handleKey);
            
        },

        /**
         * Add the modal to the page
         */
        addModal: function()
        {            
            $("body").append(modal.append(modalContent));
        },

        /**
         * Add the image to the modal
         */
        handleImage: function()
        {
            modalContent.empty().append("<img src='" + $selector.attr("href") + "' />");
        },

        /**
         * Add the iframe to the modal
         * Check if the link is of youtube or vimeo, if it is, add their players with autoplay
         */
        handleFrame: function()
        {
            var link = $selector.attr("href");
            var frame = $("<iframe frameborder='0' allowfullscreen>");
            if(youtube.getVideoId(link) != false)
            {
                frame.attr("src", youtube.getEmbedUrl(youtube.getVideoId(link)));
            }
            else if(vimeo.getVideoId(link) != false)
            {
                frame.attr("src", vimeo.getEmbedUrl(vimeo.getVideoId(link)));
            }
            else
            {
                frame.attr("src", link);
            }
            modalContent.empty().append(frame);
        },

        /**
         * Handle the action based on the overlay
         *
         * @param $event
         */
        handleOverlay: function($event)
        {
            $("body").has(overlay).length ? methods.removePopup($event) : methods.addOverlay($event);

			
        },

        /**
         * Add an overlay to the page
         *
         * @param $event
         */
        addOverlay: function($event)
        {
            $("body").append(overlay);
			//$("#content").append(closebtn);
        },

        /**
         * Add the arrows container with the arrows in the modal container
         * Also add the listeners
         * @param $event
         */
        addArrows: function($event)
        {
            arrowLeft.on("click", $event.data, methods.gallery.previous);
            arrowRight.on("click", $event.data, methods.gallery.next);
            modal.append(arrowsContainer.append(arrowLeft).append(arrowRight));
        },

        /**
         * Methods for the galelry
         */
        gallery: {
            /**
             * Get the current gallery index
             *
             * @param selector
             * @returns {number}
             */
            getCurrentIndex: function(selector)
            {
                var currentIndex = 0;
                if(settings.gallery)
                {
                    currentIndex = selector.data("popup-index");
                }
                return currentIndex;
            },

            /**
             * Handling the previous gallery item
             *
             * @param $event
             */
            previous: function($event)
            {
                var settings = $event.data;
                var curIndex = methods.gallery.getCurrentIndex($selector);
                var total = $(settings.selector).length;
                
                if(total == 1)
                    return;
                
                curIndex = curIndex == 0 ? total - 1 : curIndex - 1;
                $selector = $(settings.selector + "[data-popup-index=" + curIndex + "]");
                
                if(settings.type == "img")
                {
                    modalContent.find("img").attr("src", $selector.attr("href"));
                }
                if(settings.type == "iframe")
                {
                    methods.handleFrame();
                }
            },

            /**
             * Handling the next gallery item
             *
             * @param $event
             */
            next: function($event)
            {
                var settings = $event.data;
                var curIndex = methods.gallery.getCurrentIndex($selector);
                var total = $(settings.selector).length;
                
                if(total == 1)
                    return;
                
                curIndex = curIndex == total - 1 ? 0 : curIndex + 1;
                $selector = $(settings.selector + "[data-popup-index=" + curIndex + "]");
                
                if(settings.type == "img")
                {
                    modalContent.find("img").attr("src", $selector.attr("href"));
                }
                if(settings.type == "iframe")
                {
                    methods.handleFrame();
                }
            }
        },

        /**
         * Handle keyboard actions
         *
         * @param $event
         */
        handleKey: function($event)
        {
            var settings = $event.data;
            
            if($event.keyCode == 27) // ESC
            {
                methods.removePopup($event);
            }
			
			
            
            if($event.keyCode == 37 && settings.gallery) // LEFT
            {
                methods.gallery.previous($event);
            }
            
            if($event.keyCode == 39 && settings.gallery) // RIGHT
            {
                methods.gallery.next($event); 
            }
        },

        /**
         * Remove the popup and arrows
         * @param $event
         * @returns {boolean}
         */
        removePopup: function($event)
        { 
            if(modal.has($event.target).length && $($event.target).attr("id") != "arrows-container")
                return false;
            
            var settings = $event.data;
            if(typeof settings.onClose == 'function')
            {
                settings.onClose.call();
            }
            // Remove the added elements
            overlay.detach();
            modal.detach();
            arrowsContainer.detach();

            // Remove the eventlisteners
            $("body").off("click", methods.handleOverlay).off("keyup", methods.handleKey);
            arrowLeft.off();
            arrowRight.off();
        }
        
    };

    /**
     * Actual plugin call from the outside world
     *
     * @param options
     *          :type: Default: 'img'
     *          :onClick: Default: ''
     *          :onClose: Default: ''
     *          :gallery: Default: true
     * @returns {*}
     */
    $.fn.jPop = function (options)
    {
        //Override settings with given options
        if (options) {
            settings = $.extend(settings, options);
        }
        
        var newSettings = {
            selector: this.selector
        };
        
        $.extend(newSettings, settings);
        
        
        var index = 0;
        this.each(function() {
            $(this).on("click", newSettings, methods.init);
            if(newSettings.gallery)
            {
                $(this).attr("data-popup-index", index++);
            }
        });
        
        //Return this for chaining
        return this;
    }
})(jQuery);
