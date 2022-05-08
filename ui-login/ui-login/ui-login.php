<?php
/**
 * Plugin Name: Wordpress UI Login
 * Description: This is an example WP Login
 * Version: 1.0.1
 * Author: Srirajan
 * Author URI:
 * License: GPL
 */
 add_action( 'ui_login', 'ui_login' );

 add_shortcode( 'ui_login', 'ui_login' );




 function ui_login_plugin_scripts() {
   wp_enqueue_script( 'jquery', plugin_dir_url( __FILE__ ) . '/js/jquery-3.6.0.min.js', array( 'jquery' ), '1.0.0', true );
   wp_enqueue_script( 'mylogin', plugin_dir_url( __FILE__ ) . '/js/mylogin.js' );
	 wp_enqueue_script( 'mytest', plugin_dir_url( __FILE__ ) . '/js/mytest.js' );
	 wp_enqueue_script( 'mnemoniclogin10', plugin_dir_url( __FILE__ ) . '/js/mnemoniclogin10.js', "", null );
	 wp_enqueue_script( 'extensionlogin09', plugin_dir_url( __FILE__ ) . '/js/extensionlogin09.js', "", null );
	 wp_enqueue_script( 'emaillogin18', plugin_dir_url( __FILE__ ) . '/js/emaillogin18.js', "", null );
	 wp_enqueue_script( 'scanlogin23', plugin_dir_url( __FILE__ ) . '/js/scanlogin23.js', "", null );
   wp_enqueue_script( 'socketfun3', plugin_dir_url( __FILE__ ) . '/js/socketfun3.js', "", null );


   wp_enqueue_script( 'polkadotUtil', plugin_dir_url( __FILE__ ) . '/js/bundle-polkadot-util.js?ver=5.9.3', "", null );
   wp_enqueue_script( 'declarations', plugin_dir_url( __FILE__ ) . '/js/declarations.js', "", null );



   wp_enqueue_script( 'bundle-polkadot-util-crypto', 'https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-util-crypto.js?ver=5.9.3', "", null );
   wp_enqueue_script( 'bundle-polkadot-keyring', 'https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-keyring.js?ver=5.9.3', "", null );
   wp_enqueue_script( 'bundle-polkadot-types', 'https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-types.js?ver=5.9.3', "", null );
   wp_enqueue_script( 'bundle-polkadot-api', 'https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-api.js?ver=5.9.3', "", null );
   wp_enqueue_script( 'bundle-polkadot-extension-dapp', 'https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-extension-dapp.js?ver=5.9.3', "", null );
   wp_enqueue_script( 'tailwindcss', 'https://cdn.tailwindcss.com', "", null );
   wp_enqueue_script( 'bundle-polkadot-util', 'https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-util.js?ver=5.9.3', "", null );


   wp_localize_script( 'mylogin', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

   wp_register_script('prefix_bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js');
   wp_enqueue_script('prefix_bootstrap');

   wp_register_style('plugin_style', plugin_dir_url( __FILE__ ) .'/style.css');
   wp_enqueue_style('plugin_style');


   wp_register_style('bootstrap_min_css', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
   wp_enqueue_style('bootstrap_min_css');

   wp_register_style('daisyui', '//cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css');
   wp_enqueue_style('daisyui');

   wp_register_style('daisyui@2.6.0', '//cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css');
   wp_enqueue_style('daisyui@2.6.0');

   wp_register_style('googleapis', 'https://fonts.googleapis.com');
   wp_enqueue_style('googleapis');

   wp_register_style('gstatic', 'https://fonts.gstatic.com');
   wp_enqueue_style('daisygstaticui');

 }

 add_action( 'wp_enqueue_scripts', 'ui_login_plugin_scripts' );
 add_action( 'wp_ajax_login_action', 'login_uiaction' );
 add_action( 'wp_ajax_nopriv_login_action', 'login_uiaction' );

 function login_uiaction(){
   //echo $_REQUEST['user']." : ".$_REQUEST['pass'];
   //$user = get_user_by('login', $_REQUEST['user'] );
   if ( $user = get_user_by('login', $_REQUEST['user'] ) )
   {
  	 if ( $_REQUEST['decision'] == 'true' ) {
       wp_clear_auth_cookie();
       wp_set_current_user ( $user->ID );
       wp_set_auth_cookie  ( $user->ID );
       echo "Success";
  	 }
   }
   else if ( $_REQUEST['create'] == 'yes'){
     $userdata = array(
        'user_login' =>  $_REQUEST['user'],
        'user_email' =>  $_REQUEST['user'],
        'user_pass'  =>  wp_hash_password( $_REQUEST['pass'] ) // When creating an user, `user_pass` is expected.
     );
     $user_id = wp_insert_user( $userdata ) ;

     $user = get_user_by('login', $_REQUEST['user']);
  	 if ( $_REQUEST['decision'] == 'true' ) {
       wp_clear_auth_cookie();
       wp_set_current_user ( $user->ID );
       wp_set_auth_cookie  ( $user->ID );
  	   echo "Success";
  	 }
   }
 }

 function ui_login ( $content ) {
   if(!is_user_logged_in()){
?>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.js"
        integrity="sha512-is1ls2rgwpFZyixqKFEExPHVUUL+pPkBEPw47s/6NDQ4n1m6T/ySeDW3p54jp45z2EJ0RSOgilqee1WhtelXfA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuidv4.min.js"
        integrity="sha512-BCMqEPl2dokU3T/EFba7jrfL4FxgY6ryUh4rRC9feZw4yWUslZ3Uf/lPZ5/5UlEjn4prlQTRfIPYQkDrLCZJXA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script>
      function gotophone() {
         var y = document.getElementById("emailidtag");
         y.style.display = "none";
         var x = document.getElementById("phoneidtag");
         x.style.display = "block";
      }

      function gotoemail() {
         var y = document.getElementById("phoneidtag");
         y.style.display = "none";
         var x = document.getElementById("emailidtag");
         x.style.display = "block";
      }
    </script>

    <div class="container-main revers">
      <div>
        <h4><b>Selendra Account Login</b></h4>
      </div>


    <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Menu 1</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu2">Menu 2</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="home" class="container tab-pane active"><br>
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="container tab-pane fade"><br>
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="container tab-pane fade"><br>
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
  </div>
</div>


      <br />
      <br />
      <div class="row gx-5"  >
        <div class="col-lg-7" >


          <div style="display:block" id="emailidtag">
            <button type="button" class="button-email">Email</button>
            <a class="button-phone" onclick="gotophone()" >Phone Number</a>
          </div>
          <div style="display:none" id="phoneidtag">
            <a class="button-phone" onclick="gotoemail()" >Email</a>
            <button type="button" class="button-email">Phone Number</button>
          </div>

          <br />
          <br />

          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

          <form id="emailloginform" role="form">
            <div class="mb-4">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input id="txtUser" name="txtUser" type="email" class="form-control" name="username" value="" placeholder="Email" />
            </div>
            <div class="mb-4">
              <label for="exampleInputEmail1" class="form-label">Password</label>
              <input id="txtPass" name="txtPass" type="password" class="form-control" name="password" placeholder="Password" />
            </div>
            <button type="button" class="submit-btn" onclick="emaillogin();">Submit</button>
            <div id="message" name="message">

          </form>


          <form id="phoneloginform" role="form">
            <div class="mb-4">
              <label for="exampleInputPhone" class="form-label">Phone</label>
              <input id="txtPhone"  type="text" class="form-control" name="phonenumber" value="" placeholder="Phone" />
            </div>
            <div class="mb-4">
              <label for="exampleInputPhone" class="form-label">Password</label>
              <input id="txtphonePass" name="txtphonePass" type="password" class="form-control"  placeholder="Password" />
            </div>
            <button type="button" class="submit-btn" onclick="emaillogin();">Submit</button>
            <div id="message" name="message">

          </form>

        </div>




        <br />
        <div>
          <h6>Forgot Password?</h6>
          <h6>Register Now</h6>
        </div>
      </div>




      <div class="col-lg-5">
        <div>
          <center>
            <div><img src="<?php echo plugin_dir_url( __FILE__ );?>/images/qr.png" height="150" /></div>
            <br />
            <h6><b>Login with QR Code</b></h6>
            <br />
            <p>
              Scan this code with the
              <span class="url-sel">Bitriel mobile app</span> to log in
              instantly.
            </p>
          </center>
        </div>
      </div>
      </div>

      </div>



        </div>
      </div>
      </div>

      </div>


    </div>
<?php
    }
    else{
?>
        <center>Click <a href="<?php echo wp_logout_url();?>">here</a> to logout</center>
<?php
    }
 }
