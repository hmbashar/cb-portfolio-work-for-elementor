<?php 

namespace CB_Portfolio_Work;



class Elementor_CB_Pwork extends \Elementor\Widget_Base {

    public function get_name() {
        return 'cb_pwork_portfolio';
    }

    public function get_title() {
        return esc_html__( 'CB Portfolio Work', 'cbpw' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function register_controls() {

        // Content Tab Start

        $this->start_controls_section(
            'cb_pwork_content_section',
            [
                'label' => esc_html__( 'Settings', 'cbpw' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // How many posts show?
        $this->add_control(
            'cb_pwork_count',
            [
                'label' => esc_html__( 'How Many posts show?', 'cbpw' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => esc_html__( 8, 'cbpw' ),
                'label_block' => true,
            ]
        );

        // How many columns
        $this->add_control(
            'cb_pwork_column',
            [
                'label' => esc_html__( 'Column', 'cbpw' ),
                'type' => \Elementor\Controls_Manager::SELECT,                
                'label_block' => true,
                'default' => 'cb_pwork_two_column',
				'options' => [
					'cb_pwork_two_column'  => esc_html__( '2', 'cbpw' ),
					'cb_pwork_three_column' => esc_html__( '3', 'cbpw' ),
					'cb_pwork_four_column' => esc_html__( '4', 'cbpw' ),
				],
            ]
        );

        $this->end_controls_section();

        // Content Tab End

        // Style Tab Start

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Title', 'cbpw' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Text Color', 'cbpw' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cb_pwork-our-work-title h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab End

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

            <div class="cb_pwork-our-works-area">
                
                <?php 

                    $post_count = $settings['cb_pwork_count'] ? $settings['cb_pwork_count'] : '10'; // how many posts do you want to show?
                    $cb_pwork_column = $settings['cb_pwork_column']; // how many column


                    $our_works = new \WP_Query(array(
                        'post_type'	=> 'our-works', 
                        'posts_per_page' => $post_count,
                    ));
                                            
                if($our_works->have_posts()) : while($our_works->have_posts()) : $our_works->the_post();
                    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); // get thumbnail full size
            
            
                ?>
                <!-- Single Our Work -->	
                
                <div class="cb_pwork-our-works <?php echo esc_attr($cb_pwork_column);?>">
                    <div class="cb_pwork-our-work-thumb">
                        <?php the_post_thumbnail('our-work');
                            the_excerpt();
                        ?>
                    </div>
                    <div class="cb_pwork-our-work-content">
                        <div class="cb_pwork-our-work-icons">
                            <a href="<?php the_permalink();?>"><i class="fas fa-link"></i></a>
                            <a href="<?php echo esc_url($featured_img_url);?>"><i class="fas fa-search"></i></a>
                        </div>
                        <div class="cb_pwork-our-work-title">
                            <a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
                            <p>
                                <?php 
                                $cb_pwork_work_cats = get_the_terms(get_the_ID(), 'work_category');								

                                    if(is_array($cb_pwork_work_cats)) {
                                    foreach ($cb_pwork_work_cats as $cb_pwork_cat) {
                                        $work_cat_slug = get_term_link($cb_pwork_cat->slug, 'work_category');								 
                                        echo '<a href="'.esc_url($work_cat_slug).'">'.esc_html($cb_pwork_cat->name).'</a>';
                                    }
                                    }
                                ?>
                                
                            </p>
                        </div>
                        
                        
                    </div>
                </div>		
                <!--/single our work-->
                <?php endwhile; endif; ?>
                
                
            </div>
	

        <?php
    }
}