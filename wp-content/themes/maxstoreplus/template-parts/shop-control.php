<div class="filter-select">
    <div class="row">
        <div class="col-lg-5 col-md-12">
            <div class="filter-left">
                <?php
                $args = array(
                    'delimiter'   => '',
                    'wrap_before' => '<nav class="woocommerce-breadcrumb breadcrumbs">',
                    'wrap_after'  => '</nav>',
                    'before'      => '',
                    'after'       => '',
                );
                ?>
                <?php woocommerce_breadcrumb( $args ); ?>
            </div>
        </div>
        <div class="col-lg-7 col-md-12">
            <div class="filter-right">
                <?php woocommerce_result_count();?>
                <?php woocommerce_catalog_ordering();?>
            </div>
        </div>
    </div>
</div>