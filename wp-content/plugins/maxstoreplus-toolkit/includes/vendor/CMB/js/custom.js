(function($){
    $('document').ready(function() {
        $(document).on('click','.kt_group_menu .arow',function(){
            $(this).closest('.kt_item_menu').toggleClass('show-submenu');
        });
        var $parent_container = [];
        jQuery( '*[data-dependency="on"]' ).each(function(){
            var $this = jQuery( this );
            var $parent_id = $this.data( 'did' );
            $parent = jQuery( '*[name="' + $parent_id +'"]' );
            if($this.data( 'dependency' ) != 'on'){
                dependency( $this, $parent);
            }else{
                mul_dependency( $this, $parent);
            }
            if( jQuery.inArray( $parent_id, $parent_container ) == -1 ){
                $parent.change( function() {
                    var $e_parent = jQuery( this );
                    jQuery( '*[data-did="' + $e_parent.attr( 'name' ) + '"]' ).each(function(){
                        var $this    = jQuery(this);
                        if($this.data( 'dependency' ) != 'on'){
                            dependency( $this, $e_parent);
                        }else{
                            mul_dependency( $this, $e_parent);
                        }
                    });
                });
                $parent_container.push($parent_id);
            }
        });

        var $select_option = new Array();
        jQuery('option').each(function () {
            var $this = jQuery(this);
            var $src = $this.data('attr');
            if( typeof $src != 'undefined'){
                var $select = $this.closest('select');
                var $select_id = $select.attr('id');
                if( typeof $select_id == 'undefined'){
                    $select_id = $select.attr('name');
                }
                if( jQuery.inArray( $select_id, $select_option ) == -1 ){
                    //Initial
                    preview_image( $select);
                    //Event change preview photo
                    $select.on( 'change', function () {
                        preview_image($select);
                    } );
                    $select_option.push($select_id);
                }

            }
        });
        $( '.multi-select.select2' ).each(function() {
            var instance = $( this );
            $( instance ).select2();

            $( instance ).select2( 'container' ).find( 'ul.select2-choices' ).sortable({
                containment: 'parent',
                start: function() { $( instance ).select2( 'onSortStart' ); },
                update: function() { $( instance ).select2( 'onSortEnd' ); }
            });
        });

    });
    function  preview_image($select) {
        var $container = $select.parent();
        var $option = $select.find( 'option:selected' );
        var $img_src = $option.data('attr');
        if( typeof $img_src != 'undefined' ){
            if( ! $container.hasClass('has_attr') ){
                $container.addClass('has_attr');
            }
            var $html_preview_photo = $container.find('.image_preview');
            if(  $html_preview_photo.length < 1 ){
                $html = '<div class="html_preview_photo">';
                $html += '<img class="image_preview" src="'+$img_src+'" />';
                $html += '</div>';
                $container.append( jQuery( $html ) );
            }else{
                $html_preview_photo.attr('src', $img_src);
                $container.find( '.html_preview_photo' ).show();
            }
        }else{
            $container.find( '.html_preview_photo' ).hide();
        }
    }
    function mul_dependency( $this, $parent ){
        //Check child existence
        $childen = jQuery( '*[data-did="' + $this.attr( 'name' ) + '"]' );
        if( $childen.length < 1 && $parent.data( 'dependency' ) != 'on' ){
            dependency($this, $parent);
        }else{
            $childen.each(function () {
                var $child = jQuery(this);
                var $row_c = $child.closest( '.cmb-row' );
                $row_c.slideUp();
            });
            if( $childen.length > 0 || $parent.hasClass('active')){
                dependency($this, $parent);
            }
        }
    }
    function dependency( $this, $parent ){
        var equalval = $this.data( 'dval' ).toString().split(',');
        var operator = $this.data( 'operator' );
        var $row = $this.closest( '.cmb-row' );

        if( $parent.attr( 'type' ) == 'radio' ) {
            var parent_val = jQuery( '*[name="' + $this.data( 'did' ) +'"]:checked' ).val();
        }else {
            var parent_val = $parent.val();
        }

        if( operator == 'equal' ){
            if( jQuery.inArray( parent_val, equalval ) != -1 ){
                $row.slideDown();
                $this.addClass('active');
            }else{
                $row.slideUp();
                $this.removeClass('active');
            }
        }else{
            if( jQuery.inArray( parent_val, equalval ) == -1 ){
                $row.slideDown();
                $this.addClass('active');
            }else{
                $row.slideUp();
                $this.removeClass('active');
            }
        }
        $this.trigger( "change" );
    }
})(jQuery);