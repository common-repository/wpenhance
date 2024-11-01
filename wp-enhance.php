<?php
/*
Plugin Name: Wp Enhance
Plugin URI: http://wpenhance.com
Description: WpEnhance is a plugin that can bring more authority to your site amongst the millions of Wordpress sites within a single bar. The plugin also helps you rank better in search engines with pinging power without proxies. Show offer your member count, post count, Alexa rank, Facebook likes, Tweeets and much more.
Author: WpEnhance
Version: 1.6
Author URI: http://WpEnhance.com
*/

if ( !class_exists( 'Agile_wp_enhance' )){
        class Agile_wp_enhance{

                function __construct() {
                        add_action( 'admin_init', array(&$this, 'admin_init') );
                        add_action('init', array(&$this, 'fe_init'));
                        add_action( 'admin_menu', array(&$this, 'addAdminPage') );
                        add_action('admin_enqueue_scripts', array(&$this, 'scripts_method') );
                        add_action('get_search_form', array(&$this, 'show_header') );
                        add_action('wp_footer', array(&$this, 'show_footer') );
                        add_action( 'wp_ajax_agile_enhc_get', array(&$this, 'ping') );
                        add_action('wp_enqueue_scripts', array(&$this, 'frontend_scripts') );
                        register_activation_hook( __FILE__, array($this, 'install') );
                        register_deactivation_hook( __FILE__, array($this, 'de_activate') );
                        add_filter("plugin_action_links_".plugin_basename(__FILE__), array($this, 'add_settings_link') );
                }

                function fe_init(){

                }
                function frontend_scripts(){
                        ?>
                                <script>var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
                        <?php
                        wp_enqueue_style('agile_enhance_front',plugins_url('css/enhce_front.css', __FILE__));
                        wp_enqueue_script('agile_enhance_bar', plugins_url('js/wp_enhc_bar.js', __FILE__) );
                }

                function admin_init(){
                        /* Register our stylesheet. */
                        wp_enqueue_style('agile_wp_enhance', plugins_url('css/enhce_admin.css', __FILE__) );
                }
                function addAdminPage() {
                        add_menu_page('Wp Enhance', 'Wp Enhance', 'manage_options', 'my_enhancement_posts', array(&$this, 'my_enhancement'));
                        add_submenu_page('my_enhancement_posts', 'Settings', 'Settings', 'manage_options', 'my_enhancement_settings', array(&$this, 'edit_setting'));
                }

                function scripts_method(){
                        wp_enqueue_script('jquery');

                }
                function install(){

                }

                function de_activate(){

                }
                function add_settings_link($links) {
                  $settings_link = '<a href="admin.php?page=my_enhancement_settings">Settings</a>';
                  array_unshift($links, $settings_link);
                  return $links;
                }
                //$plugin = plugin_basename(__FILE__);

                function ping(){
                        generic_ping();
                        $services = get_option('ping_sites');
                        //$services = nl2br($services);
                        echo "Sending Ping to \r\n".$services;
                        exit;
                }
                function wp_enhnce_front(){
                        $radio = get_option('_agile_wpenhance_options',$this->settings_defaults());

                        ?>
                        <div class="agile_content" style="background-color:<?php echo $radio['bg'];?>;">
                                <div class="agile_bar_inside">
                                <? $this->display_bar($radio);
                                ?>


                                <?
                                $c=$this->cnt_post();
                                ?>


                                        <div class="imgcol"><img src="<?php echo plugins_url('image/resize-final.png',__FILE__);?>"/></a>
                                        </div>
                                                <?php
                                                        if( $radio['pingme'] == 'Ping me')

                                                {
                                                ?>
                                                <div class="agile_main"><input class="agile_ping" type="button" value="Ping" id="pingme"
                                                        onClick='agile_process_ping();'></div>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                        if($radio['mcount']=='Member')
                                                {
                                                ?>
                                                        <div class="agile_col" style="color:<?php echo $radio['fg'];?>;">Users:
                                                <?php
                                                        echo " ".$c['user_count'];

                                                ?>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                        if($radio['pcount'] == 'Post')
                                                {
                                                ?>
                                                        <div class="agile_col" style="color:<?php echo $radio['fg'];?>;">Posts:
                                                <?php
                                                        echo $c['post_count'];

                                                ?>
                                                        </div>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                        if($radio['catgcount']== 'Category')
                                                        {
                                                ?>
                                                        <div class="agile_col" style="color:<?php echo $radio['fg'];?>;">Categorys:
                                                <?php
                                                        echo " ". $c['cat_count'];

                                                ?>
                                                        </div>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if($radio['comment'] == 'Comment')
                                                {
                                                ?>
                                                <div class="agile_col" style="color:<?php echo $radio['fg'];?>;">Comments:
                                                <?php

                                                echo " ".$c['comment_count'];
                                                ?>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if($radio['fpublish']=='First Publish')
                                                {
                                                ?>
                                                <div class="agile_col" style="color:<?php echo $radio['fg'];?>;">Last Post:
                                                <?php

                                                {
                                                 echo " ".$c['fdate_count'];
                                                }
                                                ?>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if($radio['lpublish'] == 'LAST Publish')
                                                {
                                                ?>
                                                <div class="agile_col" style="color:<?php echo $radio['fg'];?>;">First Post:
                                                <?php
                                                {
                                                echo " ".$c['ldate_count'];
                                                }
                                                ?>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if($radio['alxrank'] == 'Alexa Rank')
                                                {
                                                ?>
                                                <div class="agile_col" style="color:<?php echo $radio['fg'];?>;">Alexa Rank:
                                                <?php
                                                echo " ".$c['aresult'];
                                                ?>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if($radio['link'] == 'Inbound Links')
                                                {
                                                ?>
                                        <div class="agile_col" style="color:<?php echo $radio['fg'];?>;">Alexa Links:
                                                <?php
                                                echo " ".$c['alinksin'];
                                                ?>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if($radio['fb']=='Facebook')
                                        {
                                                ?>
                                        <div class="agile_fb" style="">
                                                        <script>
                                                        (function(d, s, id) {
                                                          var js, fjs = d.getElementsByTagName(s)[0];
                                                          if (d.getElementById(id)) return;
                                                          js = d.createElement(s); js.id = id;
                                                          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                                          fjs.parentNode.insertBefore(js, fjs);
                                                        }(document, 'script', 'facebook-jssdk'));
                                                        </script>
                                                <div class="fb-like" data-action="like" style="padding-bottom:5px;"></div>
                                                <?php
                                        }
                                                ?>
                                        </div>
                                                <?php
                                                if($radio['tw'] == 'Twitter')
                                        {
                                                ?>
                                                <div class="agile_tw" style="">
                                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://agilesolutionspk.com/dev5/enhance-bar/">Tweet</a>
                                                <script>!
                                                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
                                                </script>
                                                <?php
                                        }
                                                ?>
                                                </div>


                                </div> <!--agile content inside-->
                        </div>
                        <?
                }
                function cnt_post(){
                        //get post
                        $args = array(
                        'posts_per_page'   => 1000,
                        'offset'           => 0,
                        'category'         => '',
                        'orderby'          => 'post_date',
                        'order'            => 'DESC',
                        'include'          => '',
                        'exclude'          => '',
                        'meta_key'         => '',
                        'meta_value'       => '',
                        'post_type'        => 'post',
                        'post_mime_type'   => '',
                        'post_parent'      => '',
                        'post_status'      => 'publish',
                        'suppress_filters' => true );
                        $posts = get_posts( $args );
                        $c['post_count']=count($posts);

                        //comment
                        $defaults = array(
                        'author_email' => '',
                        'ID' => '',
                        'karma' => '',
                        'number' => '',
                        'offset' => '',
                        'orderby' => '',
                        'order' => 'DESC',
                        'parent' => '',
                        'post_id' => 0,
                        'post_author' => '',
                        'post_name' => '',
                        'post_parent' => '',
                        'post_status' => '',
                        'post_type' => '',
                        'status' => '',
                        'type' => '',
                        'user_id' => '',
                        'search' => '',
                        'count' => false,
                        'meta_key' => '',
                        'meta_value' => '',
                        'meta_query' => '',
                );
                        $comment=get_comments( $defaults );

                        $c['comment_count']=count($comment);

                        $catargs = array(
                                'type'                     => 'post',
                                'child_of'                 => 0,
                                'parent'                   => '',
                                'orderby'                  => 'name',
                                'order'                    => 'ASC',
                                'hide_empty'               => 0,
                                'hierarchical'             => 1,
                                'exclude'                  => '',
                                'include'                  => '',
                                'number'                   => '',
                                'taxonomy'                 => 'category',
                                'pad_counts'               => false

                        );
                        //get categories
                        $categories = get_categories( $catargs );

                        $c['cat_count']=count($categories);
                        //get users

                        $user= get_users( $args );
                        $c['user_count']= count($user);
                        //get first date
                        $fdate=$this->date_get_desc();
                        $fdate=$fdate['0'];
                        //print_r($fdate);
                        $fdate=$fdate->post_date;
                        $fdate=explode(" ",$fdate);
                        $fdate=$fdate['0'];


                        $c['fdate_count']=$fdate;
                        //get last date
                        $ldate=$this->date_get_asc();
                        $ldate=$ldate['0'];
                        $ldate=$ldate->post_date;
                        $ldate=explode(" ",$ldate);
                        $ldate=$ldate['0'];
                        $c['ldate_count']=$ldate;
                        //site url
                        $url = home_url();
                        $source = file_get_contents('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$url);
                        //Alexa Rank
                        preg_match('/\<popularity url\="(.*?)" text\="([0-9]+)" source\="panel"\/\>/si', $source, $matches);
                         $c['aresult'] = ($matches[2]) ? $matches[2] : 0;
                        //Alexa Sites Linking in
                        preg_match('/\<linksin num\="([0-9]+)"\/\>/si', $source, $cocok);
                        $c['alinksin'] = ($cocok[1]) ? $cocok[1] : 0;
                        return $c;
                }
                function date_get_asc(){
                        global $wpdb;

                        $sql="Select post_date from {$wpdb->prefix}posts  ORDER BY post_date asc";
                        $r = $wpdb->get_results($sql);
                        return $r;
                }
                function date_get_desc(){
                        global $wpdb;

                        $sql="Select post_date from {$wpdb->prefix}posts  ORDER BY post_date desc";
                        $r = $wpdb->get_results($sql);
                        return $r;
                }
                function show_header(){

                        $radio = get_option('_agile_wpenhance_options',$this->settings_defaults());
                        if($radio['header']=='h'){
                                ?><div id="agile_enhc_header" style="display:none;"><?php
                                        $this->wp_enhnce_front();
                                ?></div><?php
                        }

                }

                function show_footer(){
                        $radio = get_option('_agile_wpenhance_options',$this->settings_defaults());
                        if($radio['header']=='f'){
                        $this->wp_enhnce_front();
                        }

                }

                function display_bar(){
                                $radio = get_option('_agile_wpenhance_options',$this->settings_defaults());
                                return $bar;
                }
                function settings_defaults(){

                        $x = array();
                        $x['header'] = 'f';
                        $x ['pingme']= 'Ping me';
                        $x ['mcount']= 'Member';
                        $x ['pcount']= 'Post';
                        $x ['comment']= 'Comment';
                        $x ['catgcount']='Category';
                        $x ['fpublish']= 'First Publish';
                        $x ['lpublish']= 'LAST Publish';
                        $x ['alxrank']= 'Alexa Rank';
                        $x ['link']= 'Inbound Links';
                        $x ['fb']= 'Facebook';
                        $x ['tw']= 'Twitter';
                        $x ['bg']= '#0059b3 ';
                        $x ['fg']= '#FFFFFF;';
                        return $x;

                }
                function reset_default(){
                if(isset($_POST['default'])){
                        update_option('_agile_wpenhance_options',$this->settings_defaults());
                }}
                function edit_setting(){

                        if(isset($_POST['submit'])){
                                $radio= array();
                                $radio['header'] = $_POST['header'];
                                $radio ['pingme']= $_POST['pingme'];
                                $radio ['mcount']= $_POST['mcount'];
                                $radio ['pcount']= $_POST['pcount'];
                                $radio ['comment']= $_POST['comment'];
                                $radio ['catgcount']= $_POST['catgcount'];
                                $radio ['fpublish']= $_POST['fpublish'];
                                $radio ['lpublish']= $_POST['lpublish'];
                                $radio ['alxrank']= $_POST['alxrank'];
                                $radio ['link']= $_POST['link'];
                                $radio ['fb']= $_POST['fb'];
                                $radio ['tw']= $_POST['tw'];
                                $radio ['bg']=$_POST['bg'];
                                $radio ['fg']=$_POST['fg'];
                                update_option('_agile_wpenhance_options',$radio);

                        }
                        $radio = get_option('_agile_wpenhance_options',$this->settings_defaults());

                                if(isset($_POST['submit']))
                                        {
                                ?>
                                        <div class="message">
                                <?php
                                        echo "Settings has been Saved";
                                 ?>
                                        </div>
                                 <?php
                                        }
                                ?>

                                <h1>Settings</h1>
                                <div class="content">


                                <?
                                //$this->display_bar($radio);

                                ?>
                                        <form action="" method="post">
                                        <div class="header-main">
                                        <div class="header-radio"><input type="radio" <?php if ($radio['header']=='h'){ ?> checked <?php } ?> name="header" id="hr" value="h"/>Header</div>

                                        <div class="footer-radio"><input type="radio" <?php if ($radio['header']=='f'){ ?> checked <?php } else  { if(isset($_POST['default'])){ ?> checked <?php  }} ?> name="header" id="fr" value="f"/>Footer</div>

                                        </div >
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox" <?php if ($radio ['pingme']){ ?> checked <?php } ?>name="pingme" value="Ping me"/></div>
                                                <div class="chk-botton">Ping Me</div>
                                        </div>
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox"  <?php if ($radio ['mcount']){ ?> checked <?php } ?> name="mcount" value="Member"/></div>
                                                <div class="chk-botton">Member</div>

                                        </div>
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox" <?php if ($radio ['pcount']){ ?> checked <?php } ?> name="pcount" value="Post"/></div>
                                                <div class="chk-botton">Post</div>

                                        </div>
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox"  <?php if ($radio ['comment']){ ?> checked <?php } ?> name="comment" value="Comment"/></div>
                                                <div class="chk-botton">Comment</div>

                                        </div>
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox"   <?php if ($radio ['catgcount']){ ?> checked <?php } ?> name="catgcount" value="Category"/></div>
                                                <div class="chk-botton">Category</div>

                                        </div>
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox"  <?php if ($radio ['fpublish']){ ?> checked <?php } ?>  name="fpublish" value="First Publish"/></div>
                                                <div class="chk-botton">First Publish</div>

                                        </div>
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox"  <?php if ($radio ['lpublish']){ ?> checked <?php } ?>  name="lpublish" value="LAST Publish"/></div>
                                                <div class="chk-botton">Last Publish</div>

                                        </div>
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox"  <?php if ($radio ['alxrank']){ ?> checked <?php } ?> name="alxrank" value="Alexa Rank"/></div>
                                                <div class="chk-botton">Alexa Rank</div>

                                        </div>
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox"   <?php if ($radio ['link']){ ?> checked <?php } ?> name="link" value="Inbound Links"/></div>
                                                <div class="chk-botton">Inbound Links</div>

                                        </div>
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox"  <?php if ($radio ['fb']){ ?> checked <?php } ?> name="fb" value="Facebook"/></div>
                                                <div class="chk-botton">Facebook Like</div>

                                        </div>
                                        <div class="check-box">
                                                <div class="chk"><input type="checkbox"  <?php if ($radio ['tw']){ ?> checked <?php } ?>  name="tw" value="Twitter"/></div>
                                                <div class="chk-botton">Twitter Like</div>
                                        </div>

                                        <div class="check-box">
                                                <div class="text-botton" style="margin-left:20px;">Background Color</div>
                                                <div class="chk" style="float:left;"><input type="text" name="bg" value="<?php if(isset($_POST['submit'])){echo $_POST['bg']; if(isset($_POST['default'])){echo $x['bg'];}} else{ echo "#0059b3";}?>"/></div>
                                        </div>

                                        <div class="check-box">
                                                <div class="text-botton" style="margin-left:20px;">Foreground Color</div>
                                                <div class="chk"><input type="text" name="fg" value="<?php if(isset($_POST['submit'])){echo $_POST['fg'];if(isset($_POST['default'])){echo $x['fg'];}} else{echo "#FFFFFF";}?>"/></div>
                                        </div>

                                        <div class="check-box">
                                        <div class="header-save"><input type="submit" class="button-primary button" name="submit" value="Save"/></div>

                                        <div class="header-default"><input type="submit" class="button-primary button" name="default" value="Default"/></div>

                                        </div>
                                        </div>
                                        </form>




                                <?


                }
        } //class ends
} //class exists ends
new Agile_wp_enhance();

?>