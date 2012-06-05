<?php 
function updateHeader()
{
	global $user_ID, $current_user;
	get_currentuserinfo();
	?>
	<div id="iRToppanel"> 
<?php 
	global $user_identity, $user_ID;	
	// If user is logged in or registered, show dashboard links in panel
	if (is_user_logged_in()) { 
?>
	<div id="iRPanel">
		<div class="content clearfix">
			
            <div class="left border">
			<img src="<?php bloginfo('wpurl') ?>/wp-content/plugins/buddypress-sliding-login-panel/images/logo.png"  alt="Logo" />
				<h2>欢迎回来, <?php echo ucwords($user_identity) ?>!</h2>				
				<h2 style="border-top:1px dotted #fff;">我的消息</h2>
	<div class="msgs">			
	<?php if ( bp_has_message_threads('per_page=2') ) : ?>
 	<ul id="message-threads">
 		<?php while ( bp_message_threads() ) : bp_message_thread(); ?>

    	<li<?php if ( bp_message_thread_has_unread() ) : ?> class="unread"<?php else: ?> class="read"<?php endif; ?>>
      
     		<div class="message-subject"> 
     			<?php bp_message_thread_avatar('type=full&width=35&height=35') ?>
      			<?php bp_message_thread_subject() ?>
    		 </div>
    
     		<div class="message-meta">
     			<p><a class="button view" title="查看消息" href="<?php bp_message_thread_view_link() ?>">查看消息</a> <a class="button view" title="Send Reply" href="<?php bp_message_thread_view_link() ?>/#send-reply">回复</a></p>
   			</div>
    	</li>   
  		<?php endwhile; ?>
 
  	</ul>
	<?php else: ?>
 	<div>   
    <p class="msg"><img src="<?php bloginfo('wpurl') ?>/wp-content/plugins/buddypress-sliding-login-panel/images/msg.png"  alt="消息" class="msg" /> 你有0条新消息.</p>

  	</div>	
	<?php endif;?>
</div>				
				
                
			</div>
			
            <div class="left narrow">			
				<h2>我的大头贴</h2>
				<a href="<?php echo bp_loggedin_user_domain() ?>profile">
			<?php bp_loggedin_user_avatar('type=full&width=117&height=117') ?>
			</a>
			
			<ul>
			<li>&nbsp; &nbsp; </li>
			<li><a id="avtext" href="<?php echo bp_loggedin_user_domain() . BP_XPROFILE_SLUG ?>/change-avatar">修改大头贴 &rarr; </a></li>
			</ul>
			</div>
		
			
            <div class="left narrow">			
				<h2>我的信息</h2>				
				<ul>					
					<li><a href="<?php echo bp_loggedin_user_domain() . BP_XPROFILE_SLUG ?>">查看我的信息</a></li>
					<li><a href="<?php echo bp_loggedin_user_domain() . BP_XPROFILE_SLUG ?>/edit">修改我的信息</a></li>
						<li><a href="<?php echo bp_loggedin_user_domain() . BP_XPROFILE_SLUG ?>/change-avatar">修改大头贴</a></li>
	        		<li><a href="<?php echo wp_logout_url(get_permalink()); ?>" rel="nofollow" title="<?php _e('Log out'); ?>"><?php _e('Log out'); ?></a></li>
				</ul>
				
				<h2>我的活动</h2>				
				<ul>						
					<li><a href="<?php echo bp_loggedin_user_domain() . BP_ACTIVITY_SLUG ?>">我要更新状态</a></li>
					<li><a href="/<?php echo BP_ACTIVITY_SLUG ?>">全站活动</a></li>
				
				</ul>
				
			
			</div>
		
			
			
            <div class="left narrow">
				<h2>我的提及</h2>				
			
<a href="<?php echo bp_loggedin_user_domain() . BP_ACTIVITY_SLUG . '/mentions/' ?>" title="<?php _e( '提及我的文章/活动.', 'buddypress' ) ?>"><?php printf( __( '@%s Mentions', 'buddypress' ), bp_get_loggedin_user_username() ) ?></a>
					
				<h2>群组</h2>	
				<ul>
					<li><a href="<?php echo bp_loggedin_user_domain() . BP_GROUPS_SLUG ?>">我的群组</a></li>
					<li><a href="/groups">加入群组</a></li>
					<li><a href="<?php echo bp_loggedin_user_domain() . BP_GROUPS_SLUG ?>/create">创建群组</a></li>
				</ul>
			
				
			</div>
			
	
			
            <div class="left narrow">			
				
 
<h2>好友</h2>				
				<ul>		
					<li><a href="<?php echo bp_loggedin_user_domain() . BP_FRIENDS_SLUG ?>">我的好友</a></li>
					<li><a href="/<?php echo BP_MEMBERS_SLUG ?>">Meet Friends</a></li>
				</ul> 
 <h2>好友请求</h2>
 <?php do_action( 'bp_before_member_friend_requests_content' ) ?>
<?php if ( bp_has_members( 'include=' . bp_get_friendship_requests() . '&max=1' ) && bp_get_friendship_requests () ) : ?>


	<ul id="friend-list" class="item-list">
		<?php while ( bp_members() ) : bp_the_member(); ?>
		
				<div>
				<p><a href="<?php bp_member_link() ?>"><?php bp_member_name() ?></a></p>
				<p>	<a href="<?php bp_member_link() ?>"><?php bp_member_avatar() ?></a></p>
				</div>


				<?php do_action( 'bp_friend_requests_item' ) ?>

				<div class="action" style="float: right; padding: 4px;">
					<a class="accept" href="<?php bp_friend_accept_request_link() ?>"><?php _e( 'Accept', 'buddypress' ); ?></a><br/>
					<a class="reject" href="<?php bp_friend_reject_request_link() ?>"><?php _e( 'Reject', 'buddypress' ); ?></a>

					<?php do_action( 'bp_friend_requests_item_action' ) ?>
						<p><a id="whitetext" href="<?php echo bp_loggedin_user_domain() . BP_FRIENDS_SLUG ?>/requests">更多 &rarr; </a></p>
				</div>
			

		<?php endwhile; ?>
	
	</ul>

	<?php do_action( 'bp_friend_requests_content' ) ?>


<?php else : ?>

	<div>
		<p><?php _e( ':0噢亲，还没有人申请加你的好友噢～', 'buddypress' ); ?></p>
	</div>
	
	

	

<?php endif;?>

<?php do_action( 'bp_after_member_friend_requests_content' ) ?>			
			</div>
			
	
		</div>
         
	</div> <!-- /login -->	

    <!-- The tab on top -->	
	<div class="tab">
		<ul class="login" style="margin-right:-10%;">
	    	<li class="left">&nbsp;</li>
	    	<!-- Logout -->
	        <li><a class="close" style="width:50px;" href="<?php echo wp_logout_url(get_permalink()); ?>" rel="nofollow" title="<?php _e('Log out'); ?>"><?php _e('Log out'); ?></a></li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#">我的账户</a>
				<a id="close" style="display: none;" class="close" href="#">关闭面板</a>	
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->

<?php 
	// Else if user is not logged in, show login and register forms
	} else {	
?>
	<div id="iRPanel">
		<div class="content clearfix">
			
            <div class="left border" style="width:250px;">
				<img src="<?php bloginfo('wpurl') ?>/wp-content/plugins/buddypress-sliding-login-panel/images/logo.png"  alt="Logo" />
				<h2>亲，欢迎来到 <? bloginfo('name'); ?> 极客的博客平台
</h2>		
				<p>想要拥有自己的开放博客吗？想要获得 至高权限的个人空间吗？想要体验讨论社交博客一体化的一站式服务吗?赶快加入我们吧～ </p><br/>
				
			</div>
			     
			
            <div class="left" style="width:195px;">
						<?php if (get_option('users_can_register')) : ?>	
				<!-- Register Form -->
				<form name="registerform" id="registerform" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" method="post">
					<h2>立即注册</h2>	
					注册，畅想数字生活. <br/>
					<input type="submit" name="wp-submit" id="wp-submit" value="<?php _e('Register'); ?>" class="bt_register" />
			     </form>
			<?php else : ?>
				<h1>立即注册</h1>
				<p>马上注册，加入我们吧!</p>
				<p><a href="javascript:alert('网站建设中，注册请联系运维
');" >即刻加入</a></b>.</p>
				
				<!-- Admin, delete text below later when you are done with configuring this panel 
				<p style="border-top:1px solid #333;border-bottom:1px solid #333;padding:10px 0;margin-top:10px;color:white"><em>Note: If you are the admin and want to display the register form here, log in to your dashboard, and go to <b>Settings</b> > <b>General</b> and click "Anyone can register".</em></p>-->
			<?php endif ?>			
			</div>
            <div class="left right" style="width:195px;">
            <form class="clearfix" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post">
					<h2>:( 忘记密码了吗？</h2>
					<label class="grey" for="user_login">只需输入用户名或邮箱
:</label>
					<input class="field" type="text" name="user_login" id="user_login_FP" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="23" />        			
                    <div class="clear"></div>
                     <p>就能即可回到我们的怀抱.</p>
					<input type="submit" name="submit" value="Retrieve" class="bt_register" />
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
			</form>
            </div>
             
			<div class="left right" style="width:195px;">
				<!-- Login Form -->
				<form class="clearfix" action="<?php bloginfo('wpurl') ?>/wp-login.php" method="post">
					<h2> 亲，回来了？</h2>
					<label class="grey" for="log">用户名:</label>
					<input class="field" type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="23" />
					<label class="grey" for="pwd">密码:</label>
					<input class="field" type="password" name="pwd" id="pwd" size="23" />
	            	<label><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" />记住我吧！</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Login" class="bt_login" />
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
				</form>
			</div>			 
		</div>
	</div> <!-- /login -->	

    <!-- The tab on top -->	
	<div class="tab">
		<ul class="login" style="margin-right:-10%;">
	    	<li class="left">&nbsp;</li>
	    	<!-- Login / Register -->
			<li id="toggle">
				<a id="open" class="open" href="#">我回来啦~</a>
				<a id="close" style="display: none;" class="close" href="#"> 关闭面板</a>			
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->	
    		
<?php } ?>	

</div> <!--END panel -->	

<!-- End of login page -->

<?php
}
?>
