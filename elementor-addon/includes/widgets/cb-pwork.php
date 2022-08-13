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

        // How many words show?
        $this->add_control(
            'cb_pwork_excerpt',
            [
                'label' => esc_html__( 'Word Excerpt', 'cbpw' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => esc_html__( 8, 'cbpw' ),
                'label_block' => true,
                'default' => 40,
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
					'cb_pwork_two_column'  => esc_html__( '2 Columns', 'cbpw' ),
					'cb_pwork_three_column' => esc_html__( '3 Columns', 'cbpw' ),
					'cb_pwork_four_column' => esc_html__( '4 Columns', 'cbpw' ),
				],
            ]
        );

        $this->end_controls_section();

        // Content Tab End

        // Style Tab Start

        //Start Section
        $this->start_controls_section(
            'cb_pwork_normal_section',
            [
                'label' => esc_html__( 'Normal View', 'cbpw' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'cbpw' ),
				'selector' => '{{WRAPPER}} .cb_pwork-our-works',
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
			]
		);

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'cbpw' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cb_pwork-our-work-thumb p' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Content Typography', 'cbpw' ),
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .cb_pwork-our-work-thumb p',
			]
		);


        $this->end_controls_section(); //End Section

        //Start Section
        $this->start_controls_section(
            'cb_pwork_hover_section',
            [
                'label' => esc_html__( 'Hover View', 'cbpw' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'cbpw' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cb_pwork-our-work-title h2' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Title Typography', 'cbpw' ),
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .cb_pwork-our-work-title h2',
                
			]
		);

        $this->add_control(
            'category_color',
            [
                'label' => esc_html__( 'Category Color', 'cbpw' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cb_pwork_cat a' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
                'label' => esc_html__( 'Category Typography', 'cbpw' ),
				'name' => 'category_typography',
				'selector' => '{{WRAPPER}} .cb_pwork_cat a',
                
			]
		);


        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__( 'Background Color', 'cbpw' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .cb_pwork-our-work-content',
                'separator' => 'before',
			]
		);


        $this->end_controls_section(); //End Section
        

        // Style Tab End

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

            <div class="cb_pwork-our-works-area">
                
                <?php 

                    $post_count = $settings['cb_pwork_count'] ? $settings['cb_pwork_count'] : '10'; // how many posts do you want to show?
                    $cb_pwork_column = $settings['cb_pwork_column']; // how many column
                    $cb_pwork_excerpt = $settings['cb_pwork_excerpt'] ? $settings['cb_pwork_excerpt'] : 40; // content excerpt


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
                            $contens = wp_trim_words(get_the_content(), $cb_pwork_excerpt, NULL);
                            echo $contens;
                        ?>
                    </div>
                    <div class="cb_pwork-our-work-content">
                        <div class="cb_pwork-our-work-icons">
                            <!--Link will be add in the next update after single page design-->
                            <!--
                            <a href="<?php the_permalink();?>"><svg baseProfile="tiny"  id="Layer_1" version="1.2" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M18.277,6.321c-0.43-0.43-1.126-0.43-1.556,0L15,8.043l-0.308-0.308c-1.168-1.168-3.216-1.168-4.384,0l-4.172,4.172  C5.552,12.491,5.23,13.27,5.23,14.099s0.322,1.608,0.906,2.192l0.308,0.308l-1.722,1.722c-0.43,0.43-0.43,1.126,0,1.556  c0.215,0.215,0.496,0.322,0.778,0.322s0.563-0.107,0.778-0.322L8,18.155l0.308,0.308c0.584,0.584,1.362,0.906,2.192,0.906  s1.608-0.322,2.192-0.906l4.172-4.172c0.584-0.584,0.906-1.362,0.906-2.192s-0.322-1.608-0.906-2.192l-0.308-0.308l1.722-1.722  C18.707,7.447,18.707,6.751,18.277,6.321z M15.308,12.735l-4.172,4.172c-0.168,0.168-0.402,0.253-0.636,0.253  s-0.468-0.084-0.636-0.253l-0.308-0.308l0.722-0.722c0.43-0.43,0.43-1.126,0-1.556c-0.215-0.215-0.496-0.322-0.778-0.322  s-0.563,0.107-0.778,0.322L8,15.043l-0.308-0.308c-0.168-0.168-0.261-0.395-0.261-0.636s0.093-0.468,0.261-0.636l4.172-4.172  C12.032,9.123,12.258,9.03,12.5,9.03s0.468,0.093,0.636,0.261l0.308,0.308l-0.722,0.722c-0.43,0.43-0.43,1.126,0,1.556  c0.215,0.215,0.496,0.322,0.778,0.322s0.563-0.107,0.778-0.322L15,11.155l0.308,0.308c0.168,0.168,0.261,0.395,0.261,0.636  S15.476,12.567,15.308,12.735z"/></svg></a>
                            -->
                            <a href="<?php echo esc_url($featured_img_url);?>"><svg  viewBox="0 0 48 48"  xmlns="http://www.w3.org/2000/svg"><path d="M31 28h-1.59l-.55-.55c1.96-2.27 3.14-5.22 3.14-8.45 0-7.18-5.82-13-13-13s-13 5.82-13 13 5.82 13 13 13c3.23 0 6.18-1.18 8.45-3.13l.55.55v1.58l10 9.98 2.98-2.98-9.98-10zm-12 0c-4.97 0-9-4.03-9-9s4.03-9 9-9 9 4.03 9 9-4.03 9-9 9z"/><path d="M0 0h48v48h-48z" fill="none"/></svg></a>
                        </div>
                        <div class="cb_pwork-our-work-title">
                            <a ><h2><?php the_title(); ?></h2></a> <!--Link will be add in the next update after single page design-->
                            <p class="cb_pwork_cat">
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