// gird masonry layout integration for guttenburg default gallery listing block

var $ = require("jquery");
var jQueryBridget = require("jquery-bridget");
var Masonry = require("masonry-layout");
// make Masonry a jQuery plugin
jQueryBridget("masonry", Masonry, $);
// now you can use $().masonry()
var gallery = $(".wp-block-gallery");
if (gallery.length) {
    gallery.masonry({
    itemSelector: ".block-image",
  });
}
