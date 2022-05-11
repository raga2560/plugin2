<?php
/**
 * Plugin Name: Wordpress Login
 * Description: This is an example WP Login
 * Version: 1.0.1
 * Author: Srirajan
 * Author URI:
 * License: GPL
 */
 add_action( 'my_login', 'my_login' );

 add_shortcode( 'my_login', 'my_login' );




 function my_login_plugin_scripts() {
     wp_enqueue_script( 'jquery', plugin_dir_url( __FILE__ ) . '/js/jquery-3.6.0.min.js', array( 'jquery' ), '1.0.0', true );
     wp_enqueue_script( 'mylogin', plugin_dir_url( __FILE__ ) . '/js/mylogin.js' );
     wp_enqueue_script( 'customlogout', plugin_dir_url( __FILE__ ) . '/js/customlogout.js' );
	 wp_enqueue_script( 'mytest', plugin_dir_url( __FILE__ ) . '/js/mytest.js' );
	 wp_enqueue_script( 'mnemoniclogin10', plugin_dir_url( __FILE__ ) . '/js/mnemoniclogin10.js', "", null );
	 wp_enqueue_script( 'extensionlogin09', plugin_dir_url( __FILE__ ) . '/js/extensionlogin09.js', "", null );
	 wp_enqueue_script( 'emaillogin25', plugin_dir_url( __FILE__ ) . '/js/emaillogin25.js', "", null );
	 wp_enqueue_script( 'scanlogin36', plugin_dir_url( __FILE__ ) . '/js/scanlogin36.js', "", null );
     wp_localize_script( 'mylogin', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

//     wp_register_script('prefix_uid', '//cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuidv4.min.js'); 
//     wp_enqueue_script('prefix_uid');

//     wp_register_script('prefix_qrcode', '//cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.js');
//     wp_enqueue_script('prefix_qrcode');

//    wp_enqueue_script( 'socketfun5', plugin_dir_url( __FILE__ ) . '/js/socketfun5.js', "", null );
//     wp_enqueue_script('socketfun5');

     wp_register_script('prefix_bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js');
     wp_enqueue_script('prefix_bootstrap');
     wp_register_style('prefix_bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
     wp_enqueue_style('prefix_bootstrap');
	 
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
 add_action( 'wp_enqueue_scripts', 'my_login_plugin_scripts' );

 add_action( 'wp_ajax_login_action', 'login_action' );
 add_action( 'wp_ajax_nopriv_login_action', 'login_action' );
 add_action( 'wp_logout', 'logout_action' );

 function login_action(){
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
 
 

 function logout_action(){

     $method = "POST";
     $url = "http://student.selendra.com:4000/logoutstatus";
     $data = "test";


     $post = [
    'username' => 'user1',
    'password' => 'passuser1',
    'gender'   => 1,
    ];

$ch = curl_init('http://137.184.224.174:4000/logoutstatus');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

var_dump($ch);

// execute!
$response = curl_exec($ch);

// close the connection, release resources used
curl_close($ch);

// do anything you want with your response
var_dump($response);



 }

 function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    echo $curl;
    echo "<script> console.log($curl);  </script>";

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
 




 function my_login ( $content ) {
   if(!is_user_logged_in()){
?>

<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-util.js?ver=5.9.3' id='polkadotUtil-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-util-crypto.js?ver=5.9.3' id='polkadotUtilCrypto-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-keyring.js?ver=5.9.3' id='polkadotKeyring-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-types.js?ver=5.9.3' id='polkadotTypes-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-api.js?ver=5.9.3' id='polkadotApi-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-extension-dapp.js?ver=5.9.3' id='polkadotExtensionDapp-js'></script>


 <link
            href="https://cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css"
            rel="stylesheet"
            type="text/css"
        />
        <script src="https://cdn.tailwindcss.com"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.js"
            integrity="sha512-is1ls2rgwpFZyixqKFEExPHVUUL+pPkBEPw47s/6NDQ4n1m6T/ySeDW3p54jp45z2EJ0RSOgilqee1WhtelXfA=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuidv4.min.js"
            integrity="sha512-BCMqEPl2dokU3T/EFba7jrfL4FxgY6ryUh4rRC9feZw4yWUslZ3Uf/lPZ5/5UlEjn4prlQTRfIPYQkDrLCZJXA=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
		
		<script type="module" src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/socketfun5.js' >

        </script>


<script>


const { bnToBn, u8aToHex } = polkadotUtil;
const { sha256AsU8a, blake2AsHex, randomAsHex, selectableNetworks } = polkadotUtilCrypto;
const { Keyring } = polkadotKeyring;
const { cryptoWaitReady } = polkadotUtilCrypto;
const { ApiPromise, WsProvider } = polkadotApi; //require('@polkadot/api');
//const { Keyring } = require('@polkadot/keyring');
const { randomAsU8a, randomAsNumber, signatureVerify } = polkadotUtilCrypto; // require( '@polkadot/util-crypto');
const { stringToU8a, stringToHex, hexToString } = polkadotUtil;
const { web3Accounts, web3Enable, web3FromAddress,
  web3ListRpcProviders,
        web3FromSource,
  web3UseRpcProvider
 } = polkadotExtensionDapp ; 

 
</script>

<script> 
   function notimplemented() {
     alert("Not implemented");
   }
   function registerinmobile() {
     alert("Register in studentid-app");
   }

</script>

      <div class="container-main revers">
      <div>
        <h4><b>Selendra Account Login</b></h4>
      </div>
      <br />
      <br />
      <div class="row gx-5">
        <div class="col-lg-7">
          <div>
            <button type="button" class="button-email">Email</button>
            <a class="button-phone" onclick="notimplemented();" >Phone Number</a>
            <a class="button-phone" onclick="notimplemented();" >Extension </a>
          </div>
          <br />
          <br />
          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
          <form id="emailloginform" role="form">
            <div class="mb-4">
              <label for="emailloginform" class="form-label">Email</label>
              <input id="txtUser" name="txtUser" type="email" class="form-control"  value="" placeholder="Email" />
            </div>
            <div class="mb-4">
              <label for="emailloginform" class="form-label">Password</label>
              <input id="txtPass" name="txtPass" type="password" class="form-control"  placeholder="Password" />
            </div>
            <button type="button" class="submit-btn" onclick="emaillogin();">Submit</button>
          </form>

        <br />
          <div  id="message" class="alert-danger " name="message" ></div>

        <div>
          <h6  onclick="registerinmobile();" >Register Now</h6>
        </div>
      </div>

      <div class="col-lg-5">
        <div>
          <center>
            <!-- div><img src="<?php echo plugin_dir_url( __FILE__ );?>/images/qr.png" height="150" /></div -->
				<div style="float:right; display:none; " id="qrcode"></div>
      <div style="display:block"     id="qrcodeloading"  class="spinner-border text-primary"     >  </div>
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


	  
	  
	  
<?php
    }
    else{
?>
        <center>Click <a href="<?php echo wp_logout_url();?>">here</a> to logout</center>
				  <a id="logout" name="logout" onclick="logout();" class="btn btn-success">Logout for testing  </a>
<?php
    }
 }
