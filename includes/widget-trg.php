<?php

namespace Total_Recipe_Generator_El\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly


class Widget_Total_Recipe_Generator_El extends Widget_Base {

    public function get_name() {
        return 'total-recipe-generator';
    }

    public function get_title() {
        return __('Total Recipe Generator', 'trg_el');
    }

    public function get_icon() {
        return 'fas fa-utensils';
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_general',
            [
                'label' => __('General', 'trg_el'),
            ]
        );

    $this->add_control(
        'template',
        [
            'label' => __( 'Recipe Template', 'trg_el' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'recipe' => __( 'Standard (1 col)', 'trg_el' ),
                'recipe2' => __( 'Ingredients + Method (2 col)', 'trg_el' ),
                'recipe3' => __( 'Method + Ingredients (2 col)', 'trg_el' )
            ],
            'default' => 'recipe',
            'description' => __( 'Select a recipe template', 'trg_el' )
        ]
    );

    $this->add_responsive_control(
        'method_width',
        [
            'label' => __( 'Method section width', 'trg_el' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ '%' ],
            'range' => [
                '%' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 1,
                ]
            ],
            'default' => [
                'unit' => '%',
                'size' => 60,
            ],
            'selectors' => [
                '{{WRAPPER}} .ingredients-section' => 'flex-basis: calc(100% - {{SIZE}}% );',
                '{{WRAPPER}} .method-section' => 'flex-basis: {{SIZE}}%;'
            ],
            'description' => __( 'Select width for the method section.', 'trg_el' ),
'condition' => [ 'template' => ['recipe2', 'recipe3'] ]
        ]
    );

    $this->add_responsive_control(
            'method_gutter',
            [
                'label' => __( 'Method section gap', 'trg_el' ),
                'label_block' => true,
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 15,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 15,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ingredients-section, {{WRAPPER}} .method-section' => 'padding: 0 {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .trg-row' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};'
                ],
                'description' => __( 'Select a gap width between methods section and ingredients section.', 'trg_el' ),
'condition' => [ 'template' => ['recipe2', 'recipe3'] ]
            ]
        );

    $this->add_control(
        'method_fullwidth_tablet',
        [
            'type' => Controls_Manager::SWITCHER,
            'label' => __( 'Full width (Tablet)', 'trg_el' ),
            'default' => '',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'prefix_class' => 'method-full-tablet-',
            'description' => __( 'Force method and ingredients section full width on tablet.', 'trg_el' )
        ]
    );

    $this->add_control(
        'method_fullwidth_mobile',
        [
            'type' => Controls_Manager::SWITCHER,
            'label' => __( 'Full width (Mobile)', 'trg_el' ),
            'default' => '',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'prefix_class' => 'method-full-mobile-',
            'description' => __( 'Force method and ingredients section full width on mobile.', 'trg_el' )
        ]
    );

    $this->add_control(
        'name_src',
        [
            'label' => __( 'Recipe Name', 'trg_el' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'post_title' => __( 'Use Post Title', 'trg_el' ),
                'custom' => __( 'Custom Name', 'trg_el' ),
                'hide' => __( 'Do not show', 'trg_el' )
            ],
            'default' => 'post_title',
            'description' => __( 'Choose a name source for Recipe', 'trg_el' )
        ]
    );

    $this->add_control(
        'name_txt',
        [
            'label' => __( 'Custom Recipe Name', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide a name for the recipe', 'trg_el' ),
            'condition' => [ 'name_src' => ['custom'] ]
        ]
    );

    $this->add_control(
        'show_date',
        [
            'type' => Controls_Manager::SWITCHER,
            'label' => __( 'Publish date', 'trg_el' ),
            'default' => '',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Show or hide recipe publish date.', 'trg_el' )
        ]
    );

    $this->add_control(
        'show_author',
        [
            'type' => Controls_Manager::SWITCHER,
            'label' => __( 'Recipe Author', 'trg_el' ),
            'default' => '',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Show or hide recipe author name.', 'trg_el' )
        ]
    );

    $this->add_control(
        'author_src',
        [
            'label' => __( 'Recipe Author', 'trg_el' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'post_author' => __( 'Use Post Author', 'trg_el' ),
                'custom' => __( 'Custom Author Name', 'trg_el' )
            ],
            'default' => 'post_author',
            'description' => __( 'Select author name source for recipe', 'trg_el' ),
            'condition' => [ 'show_author' => ['true'] ]
        ]
    );

    $this->add_control(
        'author_name',
        [
            'label' => __( 'Custom Author name', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide name of author', 'trg_el' ),
            'condition' => [ 'author_src' => ['custom'] ]
        ]
    );

    $this->add_control(
        'author_url',
        [
            'label' => __( 'Author profile URL', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'The profile URL of recipe Author. Leave blank to use WordPress user URL.', 'trg_el' )
        ]
    );

    $this->add_control(
        'show_summary',
        [
            'type' => Controls_Manager::SWITCHER,
            'label' => __( 'Recipe summary', 'trg_el' ),
            'default' => 'true',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Show or hide recipe summary text.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'summary',
        [
            'label' => __( 'Recipe Summary', 'trg_el' ),
            'type' => Controls_Manager::WYSIWYG,
            'default' => 'This is a recipe summary text. It can be a small excerpt about what you are going to cook.',
            'description' => __( 'Provide a short summary or description of your recipe', 'trg_el' ),
            'condition' => [ 'show_summary' => ['true'] ]
        ]
    );

    $this->end_controls_section();

$this->start_controls_section(
        'section_image',
        [
            'label' => __('Recipe Image', 'trg_el'),
        ]
    );

    $this->add_control(
        'img_src',
        [
            'label' => __( 'Recipe Image', 'trg_el' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'featured' => __( 'Use featured image', 'trg_el' ),
                'media_lib' => __( 'Select from media library', 'trg_el' ),
                'hide' => __( 'Do not show', 'trg_el' )
            ],
            'default' => 'featured',
            'description' => __( 'Select image source', 'trg_el' )
        ]
    );

    $this->add_control(
        'img_lib',
        [
            'label' => __( 'Add recipe image', 'trg_el' ),
            'type' => Controls_Manager::MEDIA,
            'label_block' => true,
            'default' => ['url' => ''],
            'description' => __( 'Add a recipe image', 'trg_el' ),
            'condition' => [ 'img_src' => ['media_lib'] ]
        ]
    );

    $this->add_responsive_control(
        'img_align',
        [
            'label' => __( 'Image Align', 'trg_el' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __( 'Left', 'trg_el' ),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __( 'Center', 'trg_el' ),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __( 'Right', 'trg_el' ),
                    'icon' => 'fa fa-align-right',
                ],
                'none' => [
                    'title' => __( 'None', 'trg_el' ),
                    'icon' => 'fa fa-align-justify',
                ],
            ],
            'default' => '',
            'label_block' => true,
            'toggle' => true,
            'prefix_class' => 'recipe-img%s-'
        ]
    );

    $this->add_responsive_control(
        'img_margin',
        [
            'label' => __( 'Image Margin', 'trg_el' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', 'rem', '%' ],
            'selectors' => [
                '{{WRAPPER}} .recipe-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
        ]
    );

    $this->add_control(
        'imgsize',
        [
            'label' => __( 'Image Size', 'trg_el' ),
            'type' => Controls_Manager::SELECT,
            'options' => trg_el_get_all_image_sizes(),
        'default' => 'custom',
        'description' => __( 'Select image size.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'imgwidth',
        [
            'label' => __( 'Width', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '10',
            'max' => '2000',
            'step' => '1',
            'description' => __( 'Provide image width (in px, without unit) for the recipe image.', 'trg_el' ),
            'condition' => [ 'imgsize' => ['custom'] ]
        ]
    );

    $this->add_control(
        'imgheight',
        [
            'label' => __( 'Height', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '10',
            'max' => '2000',
            'step' => '1',
            'description' => __( 'Provide image height (in px, without unit) for the recipe image.', 'trg_el' ),
            'condition' => [ 'imgsize' => ['custom'] ]
        ]
    );

    $this->add_control(
        'imgquality',
        [
            'label' => __( 'Quality', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '1',
            'max' => '100',
            'step' => '1',
            'description' => __( 'Provide image quality (in %, without unit) for the thumbnail image. Range 0 - 100', 'trg_el' ),
            'condition' => [ 'imgsize' => ['custom'] ]
        ]
    );

    $this->add_control(
        'imgcrop',
        [
            'type' => Controls_Manager::SWITCHER,
            'label' => __( 'Hard Crop', 'trg_el' ),
            'default' => '',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Enable hard cropping of thumbnail image.', 'trg_el' ),
            'condition!' => [ 'img_src' => ['ext'] ],
            'condition' => [ 'imgsize' => ['custom'] ]
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_meta',
        [
            'label' => __('Recipe Meta', 'trg_el')
        ]
    );

    $this->add_control(
        'prep_time',
        [
            'label' => __( 'Preparation Time (Minutes)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '5',
            'min' => '1',
            'max' => '99999',
            'step' => '1',
            'description' => __( 'Provide preparation time (in minutes). E.g. 10', 'trg_el' ),
        ]
    );

    $this->add_control(
        'cook_time',
        [
            'label' => __( 'Cooking Time (Minutes)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '10',
            'min' => '1',
            'max' => '99999',
            'step' => '1',
            'description' => __( 'Provide cooking time (in minutes). E.g. 30', 'trg_el' ),
        ]
    );

    $this->add_control(
        'total_time',
        [
            'label' => __( 'Total Time (Minutes)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '1',
            'max' => '99999',
            'step' => '1',
            'description' => __( 'Optional total recipe time (in minutes) if prep time and cook time are not provided. E.g. 20. Leave blank for auto calculation from prep time and cook time.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'ready_in',
        [
            'label' => __( 'Ready in', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide approximate time in which recipe will be ready. This option can be used for recipes which take long time for cooling or settling.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'recipe_yield',
        [
            'label' => __( 'Recipe Yield', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide a recipe yield. E.g. 1 Pizza, or 1 Bowl Rice', 'trg_el' ),
        ]
    );

    $this->add_control(
        'serving_size',
        [
            'label' => __( 'Serving Size', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide a serving size per container. E.g. 1 Piece(20g), or 100g', 'trg_el' ),
        ]
    );

    $this->add_control(
        'calories',
        [
            'label' => __( 'Energy (Calories per serving)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'Provide approximate calories (without unit) per serving. E.g. 240', 'trg_el' ),
        ]
    );

    $this->add_control(
        'total_cost',
        [
            'label' => __( 'Total Cost', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide total cost of recipe.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'cost_per_serving',
        [
            'label' => __( 'Cost per serving', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide cost per serving.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'cust_meta_heading',
        [
            'label' => __( 'Custom Info Board Meta', 'trg_el' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]
    );

    $this->add_control(
        'cust_meta',
        [
            'type' => Controls_Manager::REPEATER,
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __( 'Meta Label', 'trg_el' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Meta Label', 'trg_el' ),
                    'description' => __( 'The label for custom meta item. E.g. Age Group', 'trg_el' ),
                ],

                [
                    'name' => 'value',
                    'label' => __( 'Meta Value', 'trg_el' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Label Value', 'trg_el' ),
                    'description' => __( 'The value for custom meta item. E.g. 30 Yr. to 60 Yr.', 'trg_el' ),
                ]
            ],
            'description' => __( 'Add custom meta for the recipe.', 'trg_el' )
        ]
    );

    $this->add_control(
        'recipe_cuisine',
        [
            'label' => __( 'Recipe Cuisine', 'trg_el' ),
            'type' => Controls_Manager::SELECT2,
            'options' => apply_filters( 'trg_cuisine_list', [
                    __( 'American', 'trg_el' ) => __( 'American', 'trg_el' ),
                    __( 'Chinese', 'trg_el' ) => __( 'Chinese', 'trg_el' ),
                    __( 'French', 'trg_el' ) => __( 'French', 'trg_el' ),
                    __( 'Indian', 'trg_el' ) => __( 'Indian', 'trg_el' ),
                    __( 'Italian', 'trg_el' ) => __( 'Italian', 'trg_el' ),
                    __( 'Japanese', 'trg_el' ) => __( 'Japanese', 'trg_el' ),
                    __( 'Mediterranean', 'trg_el' ) => __( 'Mediterranean', 'trg_el' ),
                    __( 'Mexican', 'trg_el' ) => __( 'Mexican', 'trg_el' ),
                ]
            ),
            'default' => [ __( 'American', 'trg_el' ), __( 'French', 'trg_el' ) ],
            'description' => __( 'Select recipe cuisine from above list or use custom field below', 'trg_el' ),
            'multiple' => true
        ]
    );

    $this->add_control(
        'recipe_cuisine_other',
        [
            'label' => __( 'Other recipe cuisine', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide comma separated cuisines if not in above list. E.g. Rajasthani, Gujarati', 'trg_el' ),
        ]
    );

    $this->add_control(
        'recipe_category',
        [
        'label' => __( 'Course', 'trg_el' ),
        'type' => Controls_Manager::SELECT2,
        'options' => apply_filters( 'trg_category_list', [
            __( 'Appetizer', 'trg_el' ) => __( 'Appetizer', 'trg_el' ),
            __( 'Breakfast', 'trg_el' ) => __( 'Breakfast', 'trg_el' ),
            __( 'Dessert', 'trg_el' ) => __( 'Dessert', 'trg_el' ),
            __( 'Drinks', 'trg_el' ) => __( 'Drinks', 'trg_el' ),
            __( 'Main Course', 'trg_el' ) => __( 'Main Course', 'trg_el' ),
            __( 'Salad', 'trg_el' ) => __( 'Salad', 'trg_el' ),
            __( 'Snack', 'trg_el' ) => __( 'Snack', 'trg_el' ),
            __( 'Soup', 'trg_el' ) => __( 'Soup', 'trg_el' ),
            ]
        ),
        'default' => ['Appetizer', 'Breakfast'],
        'description' => __( 'Select recipe course/categories from above list or use custom field below', 'trg_el' ),
        'multiple' => true
        ]
    );

    $this->add_control(
        'recipe_category_other',
        [
            'label' => __( 'Other recipe course', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide comma separated categories if not in above list. E.g. Lunch, Starter', 'trg_el' ),
        ]
    );

    $this->add_control(
        'show_tags',
        [
            'label' => __( 'Show Tags', 'trg_el' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Enabling this option will show post tags. You can add tags in the "Tags" panel of post edit screen.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'recipe_keywords',
        [
            'label' => __( 'Recipe Keywords', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide comma separated keywords relevant to your recipe. E.g. fast food, quick meal, vegetarian. These values will be used for Schema only.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'cooking_method',
        [
            'label' => __( 'Cooking Method', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide a cooking method. E.g. Roasting, Steaming', 'trg_el' ),
        ]
    );

    $this->add_control(
        'suitable_for_diet',
        [
            'label' => __( 'Suitable for Diet', 'trg_el' ),
            'type' => Controls_Manager::SELECT2,
            'options' => [
                'DiabeticDiet' => __( 'Diabetic', 'trg_el' ),
                'GlutenFreeDiet' => __( 'Gluten Free', 'trg_el' ),
                'HalalDiet' => __( 'Halal', 'trg_el' ),
                'HinduDiet' => __( 'Hindu', 'trg_el' ),
                'KosherDiet' => __( 'Kosher', 'trg_el' ),
                'LowCalorieDiet' => __( 'Low Calorie', 'trg_el' ),
                'LowFatDiet' => __( 'Low Fat', 'trg_el' ),
                'LowLactoseDiet' => __( 'Low Lactose', 'trg_el' ),
                'LowSaltDiet' => __( 'Low Salt', 'trg_el' ),
                'VeganDiet' => __( 'Vegan', 'trg_el' ),
                'VegetarianDiet' => __( 'Vegetarian', 'trg_el' )
            ],
            'default' => [ __( 'Vegetarian', 'trg_el' ), __( 'Low Salt', 'trg_el' ) ],
            'description' => __( 'Select diet for which this recipe is suitable. Remove selection using "ctrl + select" if not applicable.', 'trg_el' ),
            'multiple' => true
        ]
    );

    $this->add_control(
        'suitable_for_diet_other',
        [
            'label' => __( 'Other Suitable for Diet', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide comma separated values for other suitable for diet. E.g. Organic, Jain', 'trg_el' ),
        ]
    );

    $this->add_control(
        'cust_attr_heading',
        [
            'label' => __( 'Custom Recipe Attributes', 'trg_el' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]
    );

    $this->add_control(
        'cust_attr',
        [
            'type' => Controls_Manager::REPEATER,
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __( 'Attribute Label', 'trg_el' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Attribute Label', 'trg_el' ),
                    'description' => __( 'The label for custom recipe attribute. E.g. Colors', 'trg_el' ),
                ],

                [
                    'name' => 'value',
                    'label' => __( 'Attribute Value', 'trg_el' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Attibute Values', 'trg_el' ),
                    'description' => __( 'Attribute values, separated by comma. E.g. Green, Yellow, Brown', 'trg_el' ),
                ]
            ],
            'description' => __( 'Add custom recipe attributes, used as tags or categories.', 'trg_el' )
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_ingredients',
        [
            'label' => __('Ingredients', 'trg_el')
        ]
    );

    $this->add_control(
        'ing_heading',
        [
            'label' => __( 'Ingredients Title', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => ''
        ]
    );

    $this->add_control(
        'ingredients_heading',
        [
            'label' => __( 'Add ingredients', 'trg_el' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $this->add_control(
        'ingredients',
        [
            'type' => Controls_Manager::REPEATER,
            'default' => [
                [
                    'title' => __( 'For the burger', 'trg_el' ),
                    'list' => "200g wheat floor\r\n1 tbsp vegetable oil\r\n2 tsp sugar\r\n3 cups water"
                ],

                [
                    'title' => __( 'For the curry', 'trg_el' ),
                    'list' => "1 tbsp red chilli powder\r\n1 tea spoon vegetable oil\r\n2 tbsp coconut powder\r\n1 cup water"
                ]
            ],

            'fields' => [
                [
                    'name' => 'title',
                    'label' => __( 'Ingredients group title', 'trg_el' ),
                    'type' => Controls_Manager::TEXT,
                    'description' => __( 'Provide optional group title if you want to separate ingredients in groups.', 'trg_el' ),
                ],

                [
                    'name' => 'list',
                    'label' => __( 'Ingredients list', 'trg_el' ),
                    'type' => Controls_Manager::WYSIWYG,
                    'default' => "Ingredient name 1\r\nIngredient name 2",
                    'description' => __( 'Enter ingredient items, each on new line using Shift + Enter. (Use line break, not paragraph break).', 'trg_el' ),
                ]
            ],
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_method',
        [
            'label' => __('Recipe Method', 'trg_el')
        ]
    );

    $this->add_control(
        'method_heading',
        [
            'label' => __( 'Method Steps Title', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => ''
        ]
    );

    $this->add_control(
        'enable_numbering',
        [
            'label' => __( 'Auto numbering', 'trg_el' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'true',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Enable auto numbering on method steps', 'trg_el' ),
        ]
    );

    $this->add_control(
        'reset_count',
        [
            'label' => __( 'Reset numbering', 'trg_el' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Reset numbering for each method group.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'methods',
        [
            'type' => Controls_Manager::REPEATER,
            'default' => [
                [
                    'method_title' => __( 'Preparing the spices', 'trg_el' ),
                    'method_content' => "<p>Take 8-10 red chillies and grind them in fine powder.</p>"
                ],

                [
                    'method_title' => '',
                    'method_content' => "<p>Mix chilli powder with 1 tsp vegetable oil and add salt to it.</p>"
                ]
            ],

            'fields' => [
                [
                    'name' => 'method_title',
                    'label' => __( 'Method step title', 'trg_el' ),
                    'type' => Controls_Manager::TEXT,
                    'description' => __( 'Provide optional title for the method step.', 'trg_el' ),
                ],

                [
                    'name' => 'method_content',
                    'label' => __( 'Method instruction', 'trg_el' ),
                    'type' => Controls_Manager::WYSIWYG,
                    'default' => '',
                    'description' => __( 'Provide detailed method instruction. Use one step per field.', 'trg_el' ),
                ]
            ]
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_nutrition',
        [
            'label' => __('Nutrition Facts', 'trg_el')
        ]
    );

    $this->add_control(
        'show_nutrition',
        [
            'type' => Controls_Manager::SWITCHER,
            'label' => __( 'Nutrition Facts', 'trg_el' ),
            'default' => 'true',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Show or hide Nutrition facts table.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'display_style',
        [
            'label' => __( 'Nutrition table style', 'trg_el' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
            'std' => __( 'Standard', 'trg_el' ),
            'classic' => __( 'Classic', 'trg_el' ),
            'classic tabular' => __( 'Classic Tabular', 'trg_el' ),
            'flat' => __( 'Flat', 'trg_el' ),
            'flat striped' => __( 'Flat Striped', 'trg_el' ),
            'lined' => __( 'Lined', 'trg_el' ),
        ],
        'default' => 'classic',
        'description' => __( 'Select a style for Nutrition table.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'show_dv',
        [
            'type' => Controls_Manager::SWITCHER,
            'label' => __( 'Show standard Daily Values', 'trg_el' ),
            'default' => '',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Enabling this option will show standard Daily Values in the chart.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'extra_notes',
        [
            'label' => __( 'Nutrition label extra notes', 'trg_el' ),
            'type' => Controls_Manager::TEXTAREA,
            'default' => '* The % Daily Value (DV) tells you how much a nutrient in a serving of food contributes to a daily diet. 2,000 calories a day is used for general nutrition advice.',
            'description' => __( 'Provide extra notes for the Nutrition table. This will be displayed at the end of table.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'serving_per_cont',
        [
            'label' => __( 'Serving Per Container', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'Provide serving per container. E.g. 30', 'trg_el' )
        ]
    );

    $this->add_control(
        'total_fat',
        [
            'label' => __( 'Total Fat', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Total Fat (g), without unit. Standard daily value is 78 g', 'trg_el' )
        ]
    );

    $this->add_control(
        'saturated_fat',
        [
            'label' => __( 'Saturated Fat', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Saturated Fat (g), without unit. Standard daily value is 20 g', 'trg_el' )
        ]
    );

    $this->add_control(
        'trans_fat',
        [
            'label' => __( 'Trans Fat', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Trans Fat (g), without unit. ', 'trg_el' )
        ]
    );

    $this->add_control(
        'polyunsat_fat',
        [
            'label' => __( 'Polyunsaturated Fat', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Polyunsaturated Fat (g), without unit. ', 'trg_el' )
        ]
    );

    $this->add_control(
        'monounsat_fat',
        [
            'label' => __( 'Monounsaturated Fat', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Monounsaturated Fat (g), without unit. ', 'trg_el' )
        ]
    );

    $this->add_control(
        'cholesterol',
        [
            'label' => __( 'Cholesterol', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Cholesterol (mg), without unit. Standard daily value is 300 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'sodium',
        [
            'label' => __( 'Sodium', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Sodium (mg), without unit. Standard daily value is 2300 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'carbohydrate',
        [
            'label' => __( 'Total Carbohydrate', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Total Carbohydrate (g), without unit. Standard daily value is 275 g', 'trg_el' )
        ]
    );

    $this->add_control(
        'fiber',
        [
            'label' => __( 'Dietary Fiber', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Dietary Fiber (g), without unit. Standard daily value is 28 g', 'trg_el' )
        ]
    );

    $this->add_control(
        'sugar',
        [
            'label' => __( 'Total Sugars', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Total Sugars (g), without unit. ', 'trg_el' )
        ]
    );

    $this->add_control(
        'added_sugar',
        [
            'label' => __( 'Added Sugars', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Added Sugars (g), without unit. Standard daily value is 50 g', 'trg_el' )
        ]
    );

    $this->add_control(
        'sugar_alcohal',
        [
            'label' => __( 'Sugar Alcohal', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Sugar Alcohal (g), without unit. ', 'trg_el' )
        ]
    );

    $this->add_control(
        'protein',
        [
            'label' => __( 'Protein', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Protein (g), without unit. Standard daily value is 50 g', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_d',
        [
            'label' => __( 'Vitamin D (Cholecalciferol)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin D (Cholecalciferol) (IU), without unit. Standard daily value is 800 IU (International Units) or 20 mcg', 'trg_el' )
        ]
    );

    $this->add_control(
        'calcium',
        [
            'label' => __( 'Calcium', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Calcium (mg), without unit. Standard daily value is 1300 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'iron',
        [
            'label' => __( 'Iron', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Iron (mg), without unit. Standard daily value is 18 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'potassium',
        [
            'label' => __( 'Potassium', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Potassium (mg), without unit. Standard daily value is 4700 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_a',
        [
            'label' => __( 'Vitamin A', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin A (International Units), without unit. Standard daily value is 900 mcg', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_c',
        [
            'label' => __( 'Vitamin C (Ascorbic Acid)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin C (Ascorbic Acid) (mg), without unit. Standard daily value is 90 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_e',
        [
            'label' => __( 'Vitamin E (Tocopherol)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin E (Tocopherol) (IU), without unit. Standard daily value is 33 IU or 15 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_k',
        [
            'label' => __( 'Vitamin K', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin K (mcg), without unit. Standard daily value is 120 mcg', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_b1',
        [
            'label' => __( 'Vitamin B1 (Thiamin)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin B1 (Thiamin) (mg), without unit. Standard daily value is 1.2 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_b2',
        [
            'label' => __( 'Vitamin B2 (Riboflavin)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin B2 (Riboflavin) (mg), without unit. Standard daily value is 1.3 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_b3',
        [
            'label' => __( 'Vitamin B3 (Niacin)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin B3 (Niacin) (mg), without unit. Standard daily value is 16 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_b6',
        [
            'label' => __( 'Vitamin B6 (Pyridoxine)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin B6 (Pyridoxine) (mg), without unit. Standard daily value is 1.7 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'folate',
        [
            'label' => __( 'Folate', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Folate (mcg), without unit. Standard daily value is 400 mcg', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_b12',
        [
            'label' => __( 'Vitamin B12 (Cobalamine)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin B12 (Cobalamine) (mcg), without unit. Standard daily value is 2.4 mcg', 'trg_el' )
        ]
    );

    $this->add_control(
        'biotin',
        [
            'label' => __( 'Biotin', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Biotin (mcg), without unit. Standard daily value is 30 mcg', 'trg_el' )
        ]
    );

    $this->add_control(
        'choline',
        [
            'label' => __( 'Choline', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Choline (mg), without unit. Standard daily value is 550 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'vitamin_b5',
        [
            'label' => __( 'Vitamin B5 (Pantothenic acid)', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Vitamin B5 (Pantothenic acid) (mg), without unit. Standard daily value is 5 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'phosphorus',
        [
            'label' => __( 'Phosphorus', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Phosphorus (mg), without unit. Standard daily value is 1250 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'iodine',
        [
            'label' => __( 'Iodine', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Iodine (mcg), without unit. Standard daily value is 150 mcg', 'trg_el' )
        ]
    );

    $this->add_control(
        'magnesium',
        [
            'label' => __( 'Magnesium', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Magnesium (mg), without unit. Standard daily value is 420 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'zinc',
        [
            'label' => __( 'Zinc', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Zinc (mg), without unit. Standard daily value is 11 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'selenium',
        [
            'label' => __( 'Selenium', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Selenium (mcg), without unit. Standard daily value is 55 mcg', 'trg_el' )
        ]
    );

    $this->add_control(
        'copper',
        [
            'label' => __( 'Copper', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Copper (mg), without unit. Standard daily value is 0.9 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'manganese',
        [
            'label' => __( 'Manganese', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Manganese (mg), without unit. Standard daily value is 2.3 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'chromium',
        [
            'label' => __( 'Chromium', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Chromium (mcg), without unit. Standard daily value is 35 mcg', 'trg_el' )
        ]
    );

    $this->add_control(
        'molybdenum',
        [
            'label' => __( 'Molybdenum', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Molybdenum (mcg), without unit. Standard daily value is 45 mcg', 'trg_el' )
        ]
    );

    $this->add_control(
        'chloride',
        [
            'label' => __( 'Chloride', 'trg_el' ),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'min' => '0',
            'step' => '1',
            'description' => __( 'The amount of Chloride (mg), without unit. Standard daily value is 2300 mg', 'trg_el' )
        ]
    );

    $this->add_control(
        'cust_nutrients_heading',
        [
            'label' => __( 'Add custom nutrients', 'trg_el' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $this->add_control(
        'custom_nutrients',
            [
                'type' => Controls_Manager::REPEATER,
                'default' => [],
                'fields' => [
                    [
                        'name' => 'name',
                        'label' => __( 'Nutrient name', 'trg_el' ),
                        'type' => Controls_Manager::TEXT,
                        'description' => __( 'Provide a nutrient name. E.g. Power Protein', 'trg_el' )
                    ],

                    [
                        'name' => 'unit',
                        'label' => __( 'Nutrient Quantity Unit', 'trg_el' ),
                        'type' => Controls_Manager::TEXT,
                        'description' => __( 'Provide a nutrient unit. E.g. mg', 'trg_el' )
                    ],

                    [
                        'name' => 'amt',
                        'label' => __( 'Amount per serving', 'trg_el' ),
                        'type' => Controls_Manager::TEXT,
                        'description' => __( 'Provide amount per serving (without unit). E.g. 20', 'trg_el' )
                    ],

                    [
                        'name' => 'sv',
                        'label' => __( 'Standard daily value', 'trg_el' ),
                        'type' => Controls_Manager::TEXT,
                        'description' => __( 'Provide standard daily value of Nutrient (without unit). E.g. 200', 'trg_el' )
                    ],

                    [
                        'name' => 'level',
                        'label' => __( 'Nutrient indent level', 'trg_el' ),
                        'type' => Controls_Manager::SELECT,
                        'options' => [
                            '0' => __( 'Level 0', 'trg_el' ),
                            '1' => __( 'Level 1', 'trg_el' ),
                            '2' => __( 'Level 2', 'trg_el' ),
                            '3' => __( 'Level 3', 'trg_el' )
                        ],
                    'default' => '',
                    'description' => __( 'Select indent level for Nutrient entry in table.', 'trg_el' ),
                    ],

                    [
                        'name' => 'text_style',
                        'label' => __( 'Nutrient text style', 'trg_el' ),
                        'type' => Controls_Manager::SELECT,
                        'options' => [
                        'normal' => __( 'Normal', 'trg_el' ),
                        'bold' => __( 'Bold', 'trg_el' ),
                    ],
                    'default' => '',
                    'description' => __( 'Select text style for the nutrient entry.', 'trg_el' )
                ]
            ]
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_misc',
        [
            'label' => __('Miscellaneous', 'trg_el')
        ]
    );

    $this->add_control(
        'other_notes',
        [
            'label' => __( 'Other notes', 'trg_el' ),
            'type' => Controls_Manager::WYSIWYG,
            'default' => 'This is an extra note from author. This can be any tip, suggestion or fact related to the recipe.',
            'description' => __( 'Provide extra notes to be shown at the end of recipe', 'trg_el' )
        ]
    );

    if ( current_user_can( 'administrator' ) || current_user_can( 'editor' ) ) {
        $this->add_control(
            'ad_spot_1',
            [
                'label' => __( 'Ad Spot 1', 'trg_el' ),
                'type' => Controls_Manager::CODE,
                'default' => '',
                'description' => __( 'Advertisement spot before ingredients section. You can use custom HTML or ad script in this field.', 'trg_el' ),
                'language' => 'html'
            ]
        );

        $this->add_control(
            'ad_spot_2',
            [
                'label' => __( 'Ad Spot 2', 'trg_el' ),
                'type' => Controls_Manager::CODE,
                'default' => '',
                'description' => __( 'Advertisement spot before method steps section. You can use custom HTML or ad script in this field.', 'trg_el' ),
                'language' => 'html'
            ]
        );

        $this->add_control(
            'ad_spot_3',
            [
                'label' => __( 'Ad Spot 3', 'trg_el' ),
                'type' => Controls_Manager::CODE,
                'default' => '',
                'description' => __( 'Advertisement spot after nutrition facts section. You can use custom HTML or ad script in this field.', 'trg_el' ),
                'language' => 'html'
            ]
        );
    }

    $this->add_control(
        'json_ld',
        [
            'label' => __( 'JSON LD Schema', 'trg_el' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Enabling this option will add json ld schema data in recipe container.', 'trg_el' )
        ]
    );

    $this->add_control(
        'website_schema',
        [
            'label' => __( 'Website Schema', 'trg_el' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __( 'On', 'trg_el' ),
            'label_off' => __( 'Off', 'trg_el' ),
            'return_value' => 'true',
            'description' => __( 'Add website schema. This should be off if your theme already includes website schema, or you are using an SEO plugin like Yoast for website schema.', 'trg_el' )
        ]
    );

    $this->add_control(
        'rating_schema_heading',
        [
            'label' => __( 'Rating Schema', 'trg_el' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]
    );

    $this->add_control(
        'rating_src',
        [
            'label' => __( 'Include Rating Schema from', 'trg_el' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'mts' => __( 'WP Review Plugin', 'trg_el' ),
                'rmp' => __( 'Rate My Post Plugin', 'trg_el' )
            ],
            'default' => 'mts',
            'description' => __( 'Rating schema value can be included from visitor rating of <a href="https://wordpress.org/plugins/wp-review/" target="_blank">WP Review</a> or <a href="https://wordpress.org/plugins/rate-my-post/" target="_blank">Rate my Post</a> plugin. Choose which one you are using.', 'trg_el' )
        ]
    );

    $this->add_control(
        'video_schema_heading',
        [
            'label' => __( 'Video Schema', 'trg_el' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]
    );

    $this->add_control(
        'vid_name',
        [
            'label' => __( 'Video Name', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => get_the_title()
        ]
    );

    $this->add_control(
        'vid_url',
        [
            'label' => __( 'Video URL', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide a URL of recipe video. E.g. https://www.youtube.com/watch?v=RTleJqGUJKE', 'trg_el' )
        ]
    );

    $this->add_control(
        'vid_thumb_url',
        [
            'label' => __( 'Video Thumbnail', 'trg_el' ),
            'type' => Controls_Manager::MEDIA,
            'label_block' => true,
            'default' => ['url' => ''],
            'description' => __( 'Add a video thumbnail image.', 'trg_el' )
        ]
    );

    $this->add_control(
        'vid_description',
        [
            'label' => __( 'Video Description', 'trg_el' ),
            'type' => Controls_Manager::TEXTAREA,
            'default' => '',
            'description' => __( 'Provide video description to be used in schema.', 'trg_el' ),
        ]
    );

    $this->add_control(
        'vid_date',
        [
            'label' => __( 'Video upload date', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => get_the_date( 'c' ),
            'description' => __( 'Provide date of uploading the video.', 'trg_el' )
        ]
    );

    $this->add_control(
        'vid_duration',
        [
            'label' => __( 'Video duration', 'trg_el' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __( 'Provide video duration in ISO 8601 format. E.g. PT8M33S (for 8min 33 sec duration)', 'trg_el' )
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_title',
        [
            'label' => __('Recipe Title', 'trg_el'),
            'tab' => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ]
    );

    $this->add_control(
        'recipe_title_tag',
        [
            'label' => __( 'Recipe Title Tag', 'trg_el' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'h1' => __( 'h1', 'trg_el' ),
                'h2' => __( 'h2', 'trg_el' ),
                'h3' => __( 'h3', 'trg_el' ),
                'h4' => __( 'h4', 'trg_el' ),
                'h5' => __( 'h5', 'trg_el' ),
                'p' => __( 'p', 'trg_el' ),
                'span' => __( 'span', 'trg_el' ),
            ],
            'default' => 'h2'
        ]
    );

    $this->add_control(
        'title_color',
        [
            'label' => __( 'Title color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .recipe-title' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Title Typography', 'trg_el' ),
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .recipe-title',
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_summary',
        [
            'label' => __('Recipe Summary', 'trg_el'),
            'tab' => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ]
    );

    $this->add_control(
        'summary_color',
        [
            'label' => __( 'Text color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .recipe-summary' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Summary Text Typography', 'trg_el' ),
            'name' => 'summary_typography',
            'selector' => '{{WRAPPER}} .recipe-summary',
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_info_board',
        [
            'label' => __('Info Board', 'trg_el'),
            'tab' => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ]
    );

    $this->add_control(
        'ib_label_color',
        [
            'label' => __( 'Labels color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .info-board>li .ib-label' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Labels Typography', 'trg_el' ),
            'name' => 'ib_label_typography',
            'selector' => '{{WRAPPER}} .info-board>li .ib-label',
        ]
    );

    $this->add_control(
        'highlights',
        [
            'label' => __( 'Highlights color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .info-board>li .ib-value' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Highlights Typography', 'trg_el' ),
            'name' => 'ib_hl_typography',
            'selector' => '{{WRAPPER}} .info-board>li .ib-value',
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_recipe_meta',
        [
            'label' => __('Recipe Meta', 'trg_el'),
            'tab' => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ]
    );

    $this->add_control(
        'rm_labels',
        [
            'label' => __( 'Meta Labels color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .cuisine-meta .cm-label' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Meta Labels Typography', 'trg_el' ),
            'name' => 'rm_lbl_typography',
            'selector' => '{{WRAPPER}} .cuisine-meta .cm-label',
        ]
    );

    $this->add_control(
        'tags_bg',
        [
            'label' => __( 'Tag links background', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .cuisine-meta .cm-value:not(.link-enabled),{{WRAPPER}} .cuisine-meta .cm-value a' => 'background-color: {{VALUE}};',
                ]
        ]
    );

    $this->add_control(
        'tags_color',
        [
            'label' => __( 'Tag links color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .cuisine-meta .cm-value:not(.link-enabled),{{WRAPPER}} .cuisine-meta .cm-value a' => 'color: {{VALUE}}; box-shadow: none;',
                ]
        ]
    );

    $this->add_control(
        'tags_bg_hover',
        [
            'label' => __( 'Tag links background hover color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'description' => __( 'Choose a hover background color for tag links', 'trg_el' ),
            'selectors' => [
                    '{{WRAPPER}} .cuisine-meta .cm-value a:hover,.cuisine-meta .cm-value a:active' => 'background-color: {{VALUE}};',
                ]
        ]
    );

    $this->add_control(
        'tags_color_hover',
        [
            'label' => __( 'Tag links hover color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'description' => __( 'Choose a hover color for tag links', 'trg_el' ),
            'selectors' => [
                    '{{WRAPPER}} .cuisine-meta .cm-value a:hover,.cuisine-meta .cm-value a:active' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Tag links Typography', 'trg_el' ),
            'name' => 'rm_tags_typography',
            'selector' => '{{WRAPPER}} .cuisine-meta .cm-value:not(.link-enabled),{{WRAPPER}} .cuisine-meta .cm-value a',
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_ing_heading',
        [
            'label' => __('Ingredients', 'trg_el'),
            'tab' => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ]
    );

    $this->add_control(
        'ing_icon',
        [
            'label' => __( 'Ingredients Heading Icon', 'trg_el' ),
            'label_block' => true,
            'type' => Controls_Manager::ICONS,
            'default' => ['value' => 'fas fa-shopping-basket'],
            'description' => __( 'Choose an icon for ingredients heading.', 'trg_el' )
        ]
    );

    $this->add_control(
            'icon_gap',
            [
                'label' => __( 'Space between', 'trg_el' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => .75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ing-title .trg-icon' => 'margin: 0 {{SIZE}}{{UNIT}} 0 0;',
                    '.rtl {{WRAPPER}} .ing-title .trg-icon' => 'margin: 0 0 0 {{SIZE}}{{UNIT}};'
                ],
                'description' => __( 'Select a gap between icon and heading.', 'trg_el' )
            ]
        );

    $this->add_control(
        'ing_icon_color',
        [
            'label' => __( 'Icon color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .ing-title .trg-icon' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_control(
        'ing_h_color',
        [
            'label' => __( 'Heading color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .ing-title' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Heading Typography', 'trg_el' ),
            'name' => 'ing_h_typography',
            'selector' => '{{WRAPPER}} .ing-title',
        ]
    );

    $this->add_control(
        'ing_sub_h_color',
        [
            'label' => __( 'Sub Heading color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .list-subhead' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Sub Heading Typography', 'trg_el' ),
            'name' => 'ing_sub_h_typography',
            'selector' => '{{WRAPPER}} .list-subhead',
        ]
    );

    $this->add_control(
        'ing_list_icon',
        [
            'label' => __( 'Ingredient List Icon', 'trg_el' ),
            'label_block' => true,
            'type' => Controls_Manager::ICONS,
            'default' => ['value' => 'fas fa-check-circle'],
            'description' => __( 'Choose an icon for ingredient list.', 'trg_el' )
        ]
    );

    $this->add_control(
            'list_icon_gap',
            [
                'label' => __( 'Space between', 'trg_el' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ing-list .trg-icon' => 'margin: 0 {{SIZE}}{{UNIT}} 0 0;',
                    '.rtl {{WRAPPER}} .ing-list .trg-icon' => 'margin: 0 0 0 {{SIZE}}{{UNIT}};'
                ],
                'description' => __( 'Select a gap between icon and list text.', 'trg_el' )
            ]
        );

    $this->add_control(
        'list_icon_color',
        [
            'label' => __( 'List Icon color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .ing-list .trg-icon' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Ingredient List Typography', 'trg_el' ),
            'name' => 'ing_list_typography',
            'selector' => '{{WRAPPER}} .ing-list > li',
        ]
    );

    $this->add_control(
            'ing_list_gap',
            [
                'label' => __( 'List items gap', 'trg_el' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ing-list > li' => 'padding: calc({{SIZE}}{{UNIT}} / 2 ) 0 calc({{SIZE}}{{UNIT}} / 2 ) 0;'
                ],
                'description' => __( 'Select a gap between ingredient list items.', 'trg_el' )
            ]
        );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_method_styles',
        [
            'label' => __('Method', 'trg_el'),
            'tab' => Controls_Manager::TAB_STYLE,
            'show_label' => false,
        ]
    );

    $this->add_control(
        'method_icon',
        [
            'label' => __( 'Method Heading Icon', 'trg_el' ),
            'label_block' => true,
            'type' => Controls_Manager::ICONS,
            'default' => ['value' => 'fas fa-utensils'],
            'description' => __( 'Choose an icon for method heading.', 'trg_el' )
        ]
    );

    $this->add_control(
            'method_icon_gap',
            [
                'label' => __( 'Space between', 'trg_el' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => .75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ins-title .trg-icon' => 'margin: 0 {{SIZE}}{{UNIT}} 0 0;',
                    '.rtl {{WRAPPER}} .ins-title .trg-icon' => 'margin: 0 0 0 {{SIZE}}{{UNIT}};'
                ],
                'description' => __( 'Select a gap between icon and heading.', 'trg_el' )
            ]
        );

    $this->add_control(
        'method_icon_color',
        [
            'label' => __( 'Icon color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .ins-title .trg-icon' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_control(
        'method_h_color',
        [
            'label' => __( 'Heading color', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                    '{{WRAPPER}} .ins-title' => 'color: {{VALUE}};',
                ]
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Heading Typography', 'trg_el' ),
            'name' => 'method_h_typography',
            'selector' => '{{WRAPPER}} .ins-title',
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Sub Heading Typography', 'trg_el' ),
            'name' => 'method_sub_h_typography',
            'selector' => '{{WRAPPER}} .inst-subhead',
        ]
    );

    $this->add_control(
        'count_color',
        [
            'label' => __( 'Color for number count', 'trg_el' ),
            'type' => Controls_Manager::COLOR,
            'description' => __( 'Choose a color for number count in recipe method', 'trg_el' ),
            'selectors' => [ '{{WRAPPER}} .step-num' => 'color: {{VALUE}}']
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Counter Typography', 'trg_el' ),
            'name' => 'count_typography',
            'selector' => '{{WRAPPER}} .step-num',
        ]
    );

    $this->add_control(
        'counter_width',
        [
            'label' => __( 'Counter Width', 'trg_el' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1,
                ]
            ],
            'default' => [
                'unit' => 'px',
                'size' => 48,
            ],
            'selectors' => [
                '{{WRAPPER}} .number-enabled .recipe-instruction .step-num' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .number-enabled .recipe-instruction .step-content' => 'width: calc(100% - {{SIZE}}{{UNIT}});',
            ],
            'description' => __( 'Select a width for number counter.', 'trg_el' )
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'label' => __( 'Recipe Method Typography', 'trg_el' ),
            'name' => 'method_typography',
            'selector' => '{{WRAPPER}} .step-content',
        ]
    );

    $this->end_controls_section();

}

// Recipe function
    function trg_recipe( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'template'          => 'recipe',
            // Image specific
            'img_src'           => 'featured', //media_lib
            'img_lib'           => '',
            'imgsize'           => 'custom',
            'imgwidth'          => '',
            'imgheight'         => '',
            'imgcrop'           => '',
            'imgquality'        => '',
            'img_align'         => 'none',
            'json_ld'           => 'true', // Whether to include JSON LD microdata
            'website_schema'    => false,

            // Recipe name and summary
            'name_src'          => 'post_title', // custom
            'name_txt'          => '',
            'show_name'         => false,
            'summary'           => '',
            'show_summary'      => false,
            'author_src'        => 'post_author',
            'author_name'       => '',
            'author_url'        => '',
            'show_author'       => false,
            'show_date'         => false,

            // Recipe meta
            'prep_time'         => '5', // in minutes
            'cook_time'         => '10', // in minutes
            'total_time'        => '',
            'ready_in'          => '',
            'cooking_method'    => '',
            'recipe_category'   => '',
            'recipe_category_other' => '',
            'recipe_cuisine'    => '',
            'recipe_cuisine_other'  => '',
            'ingredients'       => '', // Textarea data each on new line
            'ing_heading'       => __( 'Ingredients', 'trg_el' ),
            'total_cost'        => '',
            'cost_per_serving'  => '',
            'method_heading'        => __( 'Method', 'trg_el' ),
            'enable_numbering'  => 'true',
            'reset_count'       => '',
            'other_notes'       => '',
            'social_buttons'    => '',
            'social_heading'    => '',
            'social_sticky'     => '',
            'custom_nutrients'  => '',
            'methods'           => null,
            'show_tags'         => '',
            'recipe_keywords'  => '',
            'ing_icon'          => 'fas fa-shopping-basket',
            'ing_list_icon'     => 'fas fa-check-circle',
            'method_icon'       => 'fa fa-cutlery',

            // Nutrition facts
            'recipe_yield'      => '',
            'suitable_for_diet' => '',
            'suitable_for_diet_other'   => '',
            'show_nutrition'    => false,
            'display_style'     => 'std',
            'serving_per_cont'  => '',
            'serving_size'      => '',
            'calories'          => '',
            'nutri_heading'     => __( 'Nutrition Facts', 'trg_el' ),
            'extra_notes'       => __( '*Percent Daily Values are based on a 2,000 calorie diet. Your daily values may be higher or lower depending on your calorie needs.', 'trg_el' ),
            'show_dv'           => false,
            'cust_meta'         => '',
            'cust_attr'         => '',
            // Nutrients
            'total_fat'         => '',
            'saturated_fat'     => '',
            'trans_fat'         => '',
            'polyunsat_fat'     => '',
            'monounsat_fat'     => '',
            'cholesterol'       => '',
            'sodium'            => '',
            'carbohydrate'      => '',
            'fiber'             => '',
            'sugar'             => '',
            'added_sugar'       => '',
            'sugar_alcohal'     => '',
            'protein'           => '',
            'vitamin_d'         => '',
            'calcium'           => '',
            'iron'              => '',
            'potassium'         => '',
            'vitamin_a'         => '',
            'vitamin_c'         => '',
            'vitamin_e'         => '',
            'vitamin_k'         => '',
            'vitamin_b1'        => '',
            'vitamin_b2'        => '',
            'vitamin_b3'        => '',
            'vitamin_b6'        => '',
            'folate'            => '',
            'vitamin_b12'       => '',
            'biotin'            => '',
            'vitamin_b5'        => '',
            'phosphorus'        => '',
            'iodine'            => '',
            'magnesium'         => '',
            'zinc'              => '',
            'selenium'          => '',
            'copper'            => '',
            'manganese'         => '',
            'chromium'          => '',
            'molybdenum'        => '',
            'chloride'          => '',

            // Misc
            'ad_spot_1'         => '',
            'ad_spot_2'         => '',
            'ad_spot_3'         => '',
            'recipe_title_tag'  => 'h2',

            // Colors
            'icon_color'        => '',
            'heading_color'     => '',
            'tags_bg'           => '',
            'tags_color'        => '',
            'tags_bg_hover'     => '',
            'tags_color_hover'  => '',
            'label_color'       => '',
            'highlights'        => '',
            'count_color'       => '',
            'tick_color'        => '',

            // Video Schema
            'vid_name'          => '',
            'vid_duration'      => '',
            'vid_date'          => get_the_date( 'c' ),
            'vid_description'   => '',
            'vid_url'           => '',
            'vid_thumb_url'     => '',
            'rating_src'        => 'mts'
        ), $atts ) );


        // Global settings
        $ad_spots = get_option( 'trg_adspots' );
        $social = get_option( 'trg_social' );
        $display = get_option( 'trg_display' );

        ob_start();

        $template_path = apply_filters( 'trg_template_path', '/trg-templates/' );

        if ( '' == $template ) {
            $template = 'recipe';
        }
        if ( locate_template( $template_path . $template . '.php' ) ) {
            require( get_stylesheet_directory() . $template_path . $template . '.php' );
        }
        else {
            require( dirname( __FILE__ ) . $template_path . $template . '.php' );
        }

        $out = ob_get_contents();

        ob_end_clean();

        return $out;

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        echo $this->trg_recipe( $settings );
    }

    protected function _content_template() {
    }
}