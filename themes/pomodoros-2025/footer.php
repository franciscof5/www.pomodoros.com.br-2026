			
			<!-- </div>  -->
		
		<?php do_action( 'bp_after_container' ) ?>

		<?php do_action( 'bp_before_footer' ) ?>


		<footer class="bg-gray-800 text-gray-300 py-8">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<!-- Links do footer -->
				<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
					<div>
						<a href="https://www.pomodoros.com.br/focar" class="text-white hover:text-gray-400">Focar</a>
					</div>
					<div>
						<a href="https://www.pomodoros.com.br/ranking" class="text-white hover:text-gray-400">Ranking</a>
					</div>
					<div>
						<a href="https://www.pomodoros.com.br/users" class="text-white hover:text-gray-400">Amigos</a>
					</div>
					<div>
						<a href="https://www.pomodoros.com.br/calendar" class="text-white hover:text-gray-400">Calendário</a>
					</div>
					<div>
						<a href="https://www.pomodoros.com.br/users/francisco" class="text-white hover:text-gray-400">Stats</a>
					</div>
				</div>

				<!-- Contato e créditos -->
				<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
					<div>
						<p class="text-sm text-gray-400">
							<a href="https://www.franciscomatelli.com.br" class="hover:text-white">Francisco Matelli</a> 
							| 
							<a href="https://www.f5sites.com.br" class="hover:text-white">F5 Sites</a>
						</p>
					</div>
					<div class="text-right">
						<p class="text-sm text-gray-400">
							<a href="https://www.pomodoros.com.br/done/pomodoros-2" class="hover:text-white">Projeto Pomodoros</a> | 
							<a href="https://angel.co/projects/68620-pomodoros-com-br" class="hover:text-white">AngelList</a> | 
							<a href="http://carreirasolo.org/novas/site-usa-tecnica-dos-pomodoros-para-agilizar-produtividade#.W_PWZ6uQxpg" class="hover:text-white">CarreiraSolo</a>
						</p>
					</div>
				</div>

				<!-- Powered by -->
				<div class="text-center">
					<p class="text-sm text-gray-400">
						Pomodoros is proudly powered by 
						<a href="http://www.wordpress.org" class="hover:text-white">WordPress</a>, 
						<a href="http://buddypress.org" class="hover:text-white">BuddyPress</a> | 
						Fork us 
						<a href="https://github.com/franciscof5/sistema-focalizador-javascript" class="hover:text-white">on GitHub</a>
					</p>
				</div>
			</div>
		</footer>

		<?php /*
		<div>
			<?php if ( is_user_logged_in() ) { ?>
			<div class="row">
				<!-- <div class="col"><a href="<?php bloginfo('url'); ?>">Início</a></div> -->
				<div class="col"><a href="<?php bloginfo('url'); ?>/focar">Focar</a></div>
				<div class="col"><a href="<?php bloginfo('url'); ?>/ranking">Ranking</a></div>
				<div class="col"><a href="<?php bloginfo('url'); ?>/users">Amigos</a></div>
				<div class="col"><a href="<?php bloginfo('url'); ?>/calendar">Calendário</a></div>
				<div class="col"><a href="<?php bloginfo('url'); ?>/users/<?php $current_user = wp_get_current_user(); echo $current_user->user_login?>">Stats</a></div>
			</div>
			<?php } ?>
			<div class="row justify-content-between">
				<div class="col">
					<p>
						<a href="https://www.franciscomatelli.com.br">Francisco Matelli</a>
						| <a href="https://www.f5sites.com.br">F5 Sites</a>
					</p>
				</div>
				<?php
				<br /> Hosted by <a href="https://www.f5sites.com/pomodoros">F5 Sites</a>
				?>
				<div class="col">
					<p style="text-align: right;"><a href="<?php bloginfo('url'); ?>/done/pomodoros-2"><?php _e("Project Pomodoros", "sis-foca-js"); ?></a> | <a href="https://angel.co/projects/68620-pomodoros-com-br">AngelList</a> | <a href="http://carreirasolo.org/novas/site-usa-tecnica-dos-pomodoros-para-agilizar-produtividade#.W_PWZ6uQxpg">CarreiraSolo</a></p>
				</div>
			</div>
			<div class="row">
				<p><?php printf( __( '%s is proudly powered by <a href="http://www.wordpress.org">WordPress</a>, <a href="http://buddypress.org">BuddyPress</a>', 'buddypress' ), bloginfo('name') ); ?> | Fork us <a href="https://github.com/franciscof5/sistema-focalizador-javascript">on GitHub</a></p>
			</div>
		</div> 
		*/ ?>
	</div><!-- main-cotainer -->
	<!--a class="github-fork-ribbon right-bottom" href="http://url.to-your.repo" title="Fork me on GitHub">Fork me on GitHub</a-->
					
<?php do_action( 'bp_after_footer' ) ?>

<?php wp_footer(); ?>

<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  const firebaseConfig = {
    apiKey: "",
    authDomain: "pomodoros-com-br.firebaseapp.com",
    databaseURL: "https://pomodoros-com-br.firebaseio.com",
    projectId: "pomodoros-com-br",
    storageBucket: "pomodoros-com-br.appspot.com",
    messagingSenderId: "52781640120",
    appId: "1:52781640120:web:237e1b0da33b36ca10074d"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
</script>

</body>
</html>