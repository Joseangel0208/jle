<?php
/**
 * News Grid template four
 * 
 * @package Digital Newspaper
 * @since 1.0.0
 */
extract( $args );
?>
<div <?php if( isset( $options->blockId ) && !empty($options->blockId) ) echo 'id="' .esc_attr( $options->blockId ). '"'; ?> class="news-grid<?php if( isset($options->thumbOption) && ! $options->thumbOption ) echo ' section-no-thumbnail'; ?> <?php echo esc_attr( 'layout--' . $options->layout );?>">
    <?php
        do_action( 'digital_newspaper_section_block_view_all_hook', array(
            'option'=> isset( $options->viewallOption ) ? $options->viewallOption : false,
            'classes' => 'view-all-button',
            'link'  => isset( $options->viewallUrl ) ? $options->viewallUrl : '',
            'text'  => false
        ));

        if( $options->title ) :
    ?>
            <h2 class="digital-newspaper-block-title">
                <span><?php echo esc_html( $options->title ); ?></span>
            </h2>
    <?php
        endif;
    ?>

    <div class="news-grid-post-wrap<?php echo esc_attr( ' column--' .$options->column ); ?>">
        <?php
            $post_args = apply_filters( 'digital_newspaper_query_args_filter', $post_args );
            $post_query = new WP_Query( $post_args );
            if( $post_query -> have_posts() ) :
                while( $post_query -> have_posts() ) : $post_query -> the_post();
                ?>
                    <article class="grid-item digital-newspaper-category-no-bk <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
                        <div class="blaze_box_wrap">
                            <figure class="post-thumb-wrap">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php if( has_post_thumbnail() ) { 
                                            the_post_thumbnail('digital-newspaper-list', array(
                                                'title' => the_title_attribute(array(
                                                    'echo'  => false
                                                ))
                                            ));
                                        }
                                    ?>
                                    </a>
                            </figure>
                            <div class="post-element">
                                <div class="post-element-inner">
                                    <?php if( $options->categoryOption ) digital_newspaper_get_post_categories( get_the_ID(), 2 ); ?>

                                    <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                                    <div class="post-meta">
                                        <?php if( $options->authorOption ) digital_newspaper_posted_by(); ?>
                                        <?php if( $options->dateOption ) digital_newspaper_posted_on(); ?>
                                        <?php if( $options->commentOption ) echo '<span class="post-comment">' .absint( get_comments_number() ). '</span>'; ?>
                                    </div>
                                    <?php if( $options->excerptOption ) : 
                                        $excerptLength = isset( $options->excerptLength ) ? $options->excerptLength: 10;
                                        ?>
                                            <div class="post-excerpt"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), $excerptLength ) ); ?></div>
                                    <?php endif;
                                    
                                        do_action( 'digital_newspaper_section_block_view_all_hook', array(
                                            'option'    => isset( $options->buttonOption ) ? $options->buttonOption : false
                                        ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            endif;
        ?>
    </div>
</div>