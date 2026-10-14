<div id="home-landing-page" class="bg-gray-900 text-gray-100 min-h-screen pt-24 pb-16">
	<style>
		#loginlogbox p {
			margin: 0 0 12px;
		}

		#loginlogbox label {
			display: block;
			margin-bottom: 4px;
			color: #9aa7b4;
			font-size: 13px;
		}

		#loginlogbox input[type="text"],
		#loginlogbox input[type="email"],
		#loginlogbox input[type="password"] {
			width: 100%;
			background: #0b0f14;
			border: 1px solid #374151;
			border-radius: 10px;
			padding: 10px 12px;
			color: #e6edf3;
		}

		#loginlogbox input[type="submit"] {
			width: 100%;
			background: #16a34a;
			border: 0;
			border-radius: 10px;
			padding: 11px 16px;
			color: #04140a;
			font-weight: 700;
			cursor: pointer;
		}

		#loginlogbox input[type="submit"]:hover {
			background: #22c55e;
		}
	</style>
	<div class="mx-auto max-w-7xl px-4 sm:px-6 space-y-8">

		<!-- Hero / Login -->
		<section class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-800 border border-gray-700 rounded-2xl p-6 sm:p-8 shadow-xl">
			<div class="p-2 sm:p-6">
				<span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-green-400 mb-4">
					<span class="fas fa-bolt" aria-hidden="true"></span> Pomodoros.com.br
				</span>
				<h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Relaxa e Foca</h2>
				<p class="text-gray-300 mb-4">A chave para o sucesso é investir bem seu recurso mais valioso, seu tempo!</p>
				<p class="text-gray-300 mb-6">Cronômetro online para tarefas e projetos, você e seu time mais produtivos do que nunca</p>
				<p>
					<a href="/register" class="inline-block bg-green-600 hover:bg-green-500 text-white font-semibold py-3 px-8 rounded-xl transition duration-300">🚀 Registre-se Grátis</a>
				</p>
			</div>

			<div class="rounded-2xl bg-gray-900 border border-gray-700 p-6 sm:p-8">
				<?php if (!is_user_logged_in()) { ?>
					<h2 class="text-2xl font-bold text-white mb-5">Entrar</h2>
					<div id="loginlogbox">
						<?php wp_login_form(); ?>
						<div class="mt-3">
							<?php do_action('wordpress_social_login'); ?>
							<div class="mt-2">
								<?php do_action('bp_after_sidebar_login_form'); ?>
							</div>
						</div>
					</div>
				<?php } else { ?>
					<h2 class="text-2xl font-bold text-white mb-4"><?php echo 'Olá, ' . esc_html(wp_get_current_user()->display_name); ?> </h2>
					<p class="text-gray-300 mb-5">Você já fez seus pomodoros hoje?</p>
					<p>
						<a class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold py-3 px-6 rounded-xl transition" title="Focus" href="/focus/">
							<span class="fas fa-stopwatch" aria-hidden="true"></span> Focar
						</a>
					</p>
				<?php } ?>
			</div>
		</section>

		<!-- Funcionalidades -->
		<section id="funcionalidades" class="bg-gray-800 border border-gray-700 rounded-2xl p-6 sm:p-8 shadow-xl">
			<h2 class="text-2xl font-bold text-white text-center mb-6 pb-3 border-b border-gray-700">🛠️ Funcionalidades</h2>

			<div class="flex flex-wrap gap-2 mb-6 w-full overflow-x-auto">
				<button class="tab-button px-4 py-2 text-base font-semibold rounded-xl flex items-center gap-2 sm:flex-grow w-full justify-center" data-tab="tab1">
					<i class="fas fa-calendar-alt"></i> Google
				</button>
				<button class="tab-button px-4 py-2 text-base font-semibold rounded-xl flex items-center gap-2 sm:flex-grow w-full justify-center" data-tab="tab2">
					<i class="fas fa-clock"></i> Timer
				</button>
				<button class="tab-button px-4 py-2 text-base font-semibold rounded-xl flex items-center gap-2 sm:flex-grow w-full justify-center" data-tab="tab3">
					<i class="fas fa-users"></i> Comunidade
				</button>
				<button class="tab-button px-4 py-2 text-base font-semibold rounded-xl flex items-center gap-2 sm:flex-grow w-full justify-center" data-tab="tab4">
					<i class="fas fa-trophy"></i> Prêmios
				</button>
				<button class="tab-button px-4 py-2 text-base font-semibold rounded-xl flex items-center gap-2 sm:flex-grow w-full justify-center" data-tab="tab5">
					<i class="fas fa-chart-line"></i> Relatórios
				</button>
			</div>

			<div class="tab-content" id="tab1">
				<div class="p-1 sm:p-4">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/banners/gcal.jpg" alt="Imagem 1" class="w-full h-64 object-cover rounded-xl mb-4 border border-gray-700">
					<p class="text-gray-300 text-lg">Com a exportação do iCal feed, você pode visualizar seus pomodoros nos principais calendários, como Google, Apple e Outlook, permitindo integração e organização perfeitas entre suas tarefas e compromissos diários.</p>
				</div>
			</div>
			<div class="tab-content" id="tab2">
				<div class="p-1 sm:p-4">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/banners/timer.jpg" alt="Imagem 2" class="w-full h-64 object-cover rounded-xl mb-4 border border-gray-700">
					<p class="text-gray-300 text-lg">O coração do Pomodoros.com.br é o timer exclusivo de pomodoros. Ele ajuda a melhorar sua produtividade ao dividir seu tempo em blocos de trabalho e descanso, otimizando o desempenho ao longo do dia.</p>
				</div>
			</div>
			<div class="tab-content" id="tab3">
				<div class="p-1 sm:p-4">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/banners/calendar.jpg" alt="Imagem 3" class="w-full h-64 object-cover rounded-xl mb-4 border border-gray-700">
					<p class="text-gray-300 text-lg">A comunidade se sente mais motivada e engajada ao compartilhar seus resultados no calendário, incentivando um ambiente colaborativo e positivo para o crescimento de todos.</p>
				</div>
			</div>
			<div class="tab-content" id="tab4">
				<div class="p-1 sm:p-4">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/banners/ranking.jpg" alt="Imagem 4" class="w-full h-64 object-cover rounded-xl mb-4 border border-gray-700">
					<p class="text-gray-300 text-lg">Nosso sistema de ranking único permite acompanhar seu desempenho em tempo real e ganhar prêmios conforme sua produtividade, transformando a organização de tarefas em um jogo de conquistas.</p>
				</div>
			</div>
			<div class="tab-content" id="tab5">
				<div class="p-1 sm:p-4">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/banners/tasks.jpg" alt="Imagem 5" class="w-full h-64 object-cover rounded-xl mb-4 border border-gray-700">
					<p class="text-gray-300 text-lg">Com os relatórios fantásticos gerados automaticamente, você consegue acompanhar sua produtividade, identificar padrões e aprimorar a gestão do seu tempo ao longo do tempo.</p>
				</div>
			</div>

			<style>
				.tab-button {
					flex-grow: 1;
					flex-basis: 20%;
					white-space: nowrap;
					justify-content: center;
					background-color: transparent;
					color: #9aa7b4;
					border: 1px solid #374151;
					transition: background-color 0.15s ease, color 0.15s ease, border-color 0.15s ease;
				}

				.tab-button:hover {
					color: #e6edf3;
					border-color: #4b5563;
				}

				.tab-button.active {
					background-color: rgba(34, 197, 94, 0.15);
					border-color: #22c55e;
					color: #22c55e;
				}

				@media (max-width: 640px) {
					.tab-button {
						flex-basis: 100%;
					}
				}

				.tab-content {
					display: none;
				}

				.tab-content.active {
					display: block;
				}
			</style>

			<script>
				document.addEventListener('DOMContentLoaded', () => {
					const firstButton = document.querySelector('.tab-button');
					if (!firstButton) return;
					firstButton.classList.add('active');
					const firstTabContent = document.getElementById(firstButton.getAttribute('data-tab'));
					if (firstTabContent) firstTabContent.classList.add('active');

					document.querySelectorAll('.tab-button').forEach(button => {
						button.addEventListener('click', () => {
							document.querySelectorAll('.tab-button').forEach(tab => {
								tab.classList.remove('active');
							});
							button.classList.add('active');

							document.querySelectorAll('.tab-content').forEach(content => {
								content.classList.remove('active');
							});
							const tabContent = document.getElementById(button.getAttribute('data-tab'));
							if (tabContent) tabContent.classList.add('active');
						});
					});
				});
			</script>
		</section>

		<!-- Preço -->
		<section id="precos" class="bg-gray-800 border border-gray-700 rounded-2xl p-6 sm:p-8 shadow-xl">
			<h2 class="text-2xl font-bold text-white text-center mb-6 pb-3 border-b border-gray-700">💳 Preço</h2>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
				<!-- Grátis -->
				<div class="flex flex-col bg-gray-900 border border-gray-700 rounded-xl p-6 sm:p-8">
					<span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3">
						<i class="fas fa-seedling" aria-hidden="true"></i> Grátis
					</span>
					<p class="text-4xl font-bold text-white mb-1">R$ 0</p>
					<p class="text-gray-400 mb-6">para começar agora</p>

					<ul class="space-y-3 text-gray-300 flex-1">
						<li class="flex items-start gap-3">
							<i class="fas fa-check text-green-400 mt-1" aria-hidden="true"></i>
							<span>1 usuário</span>
						</li>
						<li class="flex items-start gap-3">
							<i class="fas fa-check text-green-400 mt-1" aria-hidden="true"></i>
							<span>Sem limite de uso</span>
						</li>
					</ul>

					<a href="/register" class="mt-8 inline-flex items-center justify-center gap-2 bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-xl transition">
						<i class="fas fa-rocket" aria-hidden="true"></i> Criar conta grátis
					</a>
				</div>

				<!-- Assinatura -->
				<div class="relative flex flex-col bg-gray-900 border-2 border-green-500 rounded-xl p-6 sm:p-8 shadow-2xl">
					<span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-green-500 text-gray-900 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full">Recomendado</span>
					<span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-green-400 mb-3">
						<i class="fas fa-star" aria-hidden="true"></i> Assinatura
					</span>
					<p class="mb-1"><span class="text-4xl font-bold text-white">R$ 29</span><span class="text-lg text-gray-400">/mês</span></p>
					<p class="text-gray-400 mb-6">para quem quer ir além</p>

					<ul class="space-y-3 text-gray-300 flex-1">
						<li class="flex items-start gap-3">
							<i class="fas fa-check text-green-400 mt-1" aria-hidden="true"></i>
							<span>Acesso a provas de concursos</span>
						</li>
						<li class="flex items-start gap-3">
							<i class="fas fa-check text-green-400 mt-1" aria-hidden="true"></i>
							<span>Grupos</span>
						</li>
						<li class="flex items-start gap-3">
							<i class="fas fa-check text-green-400 mt-1" aria-hidden="true"></i>
							<span>Calendário</span>
						</li>
						<li class="flex items-start gap-3">
							<i class="fas fa-check text-green-400 mt-1" aria-hidden="true"></i>
							<span>Ranking</span>
						</li>
						<li class="flex items-start gap-3">
							<i class="fas fa-check text-green-400 mt-1" aria-hidden="true"></i>
							<span>Concorre a prêmios</span>
						</li>
					</ul>

					<a href="/register" class="mt-8 inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold py-3 px-6 rounded-xl transition">
						<i class="fas fa-crown" aria-hidden="true"></i> Assinar agora
					</a>
				</div>
			</div>
		</section>

		<!-- Comunidade -->
		<section id="comunidades" class="bg-gray-800 border border-gray-700 rounded-2xl p-6 sm:p-8 shadow-xl">
			<h2 class="text-2xl font-bold text-white text-center mb-6 pb-3 border-b border-gray-700">📊 Estatísticas da Comunidade</h2>

			<div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
				<div class="flex items-center p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl">
					<i class="fas fa-users text-blue-400 text-xl mr-3"></i>
					<div>
						<span class="block text-xl font-bold text-blue-300 counter" data-target="225">0</span>
						<p class="text-sm text-gray-300">Usuários Ativos</p>
					</div>
				</div>

				<div class="flex items-center p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
					<i class="fas fa-stopwatch text-green-400 text-xl mr-3"></i>
					<div>
						<span class="block text-xl font-bold text-green-300 counter" data-target="12997">0</span>
						<p class="text-sm text-gray-300">Pomodoros Feitos</p>
					</div>
				</div>

				<div class="flex items-center p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-xl">
					<i class="fas fa-clock text-yellow-400 text-xl mr-3"></i>
					<div>
						<span class="block text-xl font-bold text-yellow-300 counter" data-target="6499">0</span>
						<p class="text-sm text-gray-300">Tempo Cronometrado</p>
					</div>
				</div>

				<div class="flex items-center p-4 bg-purple-500/10 border border-purple-500/20 rounded-xl">
					<i class="fas fa-tags text-purple-400 text-xl mr-3"></i>
					<div>
						<span class="block text-xl font-bold text-purple-300 counter" data-target="564">0</span>
						<p class="text-sm text-gray-300">Tags dos Projetos</p>
					</div>
				</div>

				<div class="flex items-center p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
					<i class="fas fa-city text-red-400 text-xl mr-3"></i>
					<div>
						<span class="block text-xl font-bold text-red-300 counter" data-target="19">0</span>
						<p class="text-sm text-gray-300">Cidades Rankeadas</p>
					</div>
				</div>

				<div class="flex items-center p-4 bg-indigo-500/10 border border-indigo-500/20 rounded-xl">
					<i class="fas fa-language text-indigo-400 text-xl mr-3"></i>
					<div>
						<span class="block text-xl font-bold text-indigo-300 counter" data-target="5">0</span>
						<p class="text-sm text-gray-300">Traduções</p>
					</div>
				</div>
			</div>
			<script>
				document.addEventListener("DOMContentLoaded", () => {
					const counters = document.querySelectorAll(".counter");

					counters.forEach(counter => {
						const updateCount = () => {
							const target = +counter.getAttribute("data-target");
							const count = +counter.innerText;
							const increment = target / 100;
							const time = target > 1000 ? 15 : 50;

							if (count < target) {
								counter.innerText = Math.ceil(count + increment);
								setTimeout(updateCount, time);
							} else {
								counter.innerText = target;
							}
						};

						updateCount();
					});
				});
			</script>
		</section>

		<!-- Histórico -->
		<section id="historico" class="bg-gray-800 border border-gray-700 rounded-2xl p-6 sm:p-8 shadow-xl">
			<h2 class="text-2xl font-bold text-white text-center mb-6 pb-3 border-b border-gray-700">📆 Breve Histórico</h2>
			<div class="relative">
				<button id="prevBtn" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-900 border border-gray-700 text-white px-3 py-2 rounded-full shadow-lg z-10 hover:bg-gray-700">
					<i class="fas fa-chevron-left"></i>
				</button>

				<button id="nextBtn" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-900 border border-gray-700 text-white px-3 py-2 rounded-full shadow-lg z-10 hover:bg-gray-700">
					<i class="fas fa-chevron-right"></i>
				</button>

				<div id="slider" class="flex space-x-8 overflow-x-hidden scroll-smooth snap-x snap-mandatory px-6">
					<!-- Evento 2010 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-blue-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2010 - Planos Iniciais</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Francisco, CEO e fundador, testou muitos softwares de pomodoros e decidiu construir o seu próprio, para ter registro digital das tarefas feitas.</p>
					</div>

					<!-- Evento 2011 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-red-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2011 - Pomodoros Red</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-red.jpg" alt="Pomodoros Red" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Primeira versão, já online, social e com cronômetro em JavaScript assíncrono, baseado em WordPress e BuddyPress.</p>
					</div>

					<!-- Evento 2012 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-red-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2012 - Pomodoros Red</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-red.jpg" alt="Pomodoros Red" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Crescimento significativo baseado em reviews espontâneos em blogs, sem investimento em marketing.</p>
					</div>

					<!-- Evento 2013 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-green-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2013 - Pomodoros Green</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-green.jpg" alt="Pomodoros Green" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Muitos updates para participar de um concurso de startups no Brasil, mas sem atrair investidores.</p>
					</div>

					<!-- Evento 2014 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-green-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2014 - Pomodoros Green</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-green.jpg" alt="Pomodoros Green" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Crescimento orgânico. Fundador parou o projeto para se dedicar ao mestrado. Serviço estável e operacional.</p>
					</div>

					<!-- Evento 2015 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-green-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2015 - Pomodoros Green</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-green.jpg" alt="Pomodoros Green" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Alto custo de manutenção, muitas migrações e quedas do serviço. Perda rápida de usuários.</p>
					</div>

					<!-- Evento 2016 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-yellow-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2016 - Laboratório</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">O serviço foi desativado devido a falta de recursos, resultando na perda de todos os usuários.</p>
					</div>

					<!-- Evento 2017 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-yellow-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2017 - Laboratório</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Muitos testes e experiências, instabilidade frequente. Nova configuração de servidor, foco em escalabilidade.</p>
					</div>

					<!-- Evento 2018 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-gray-100 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2018 - Pomodoros Black</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-black.jpg" alt="Pomodoros Black" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Finalmente voltamos 'mobile first', com aplicativo web e mobile. Palestras Treinamento em Foco.</p>
					</div>

					<!-- Evento 2019 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-gray-100 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2019 - Pomodoros Black</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-black.jpg" alt="Pomodoros Black" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Novamente fundador precisou se dedicar a projetos de terceiros e novo hiato acontece.</p>
					</div>

					<!-- Evento 2020 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-yellow-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2020 - Laboratório</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">O site estava funcionando, porém somente o fundador conseguia usar devido a bugs.</p>
					</div>

					<!-- Evento 2021 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-yellow-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2021 - Laboratório</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Completa falta de recursos deixa o site parado no ar sem atualizações.</p>
					</div>

					<!-- Evento 2022 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-yellow-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2022 - Laboratório</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">O site recebe apenas manutenção básica para permanecer no ar, preservando o domínio</p>
					</div>

					<!-- Evento 2023 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-yellow-500 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2023 - Laboratório</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Devido a tecnologia já ultrapassada, PHP e WordPress, o pomodoros vira um problema técnico</p>
					</div>

					<!-- Evento 2024 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-purple-600 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2024 - Pomodoros Purple</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-purple-lq.png" alt="Pomodoros Global" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">O projeto ganha atualizações dentro do contexto da consultoria de lançamento de 90 dias, projetos da f5sites</p>
					</div>

					<!-- Evento 2025 -->
					<div class="flex flex-col items-center min-w-[240px] bg-gray-900 border border-gray-700 rounded-xl p-4">
						<div class="w-6 h-6 bg-purple-600 rounded-full border-4 border-gray-800 shadow-xl"></div>
						<div class="w-24 h-1 bg-gray-700 rounded-lg mt-3"></div>
						<h3 class="text-lg font-semibold text-white mt-3 text-center">2025 - Pomodoros Purple</h3>
						<img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-purple-lq.png" alt="Pomodoros Global" class="mt-3 w-full max-w-xs rounded-lg shadow-md">
						<p class="text-gray-400 text-center text-sm mt-2">Começa o enorme esforço de migração para um contexto tecnológico moderno e atualizações para marketing</p>
					</div>
				</div>
			</div>
			<script>
				const slider = document.getElementById('slider');
				const prevBtn = document.getElementById('prevBtn');
				const nextBtn = document.getElementById('nextBtn');

				function getItemWidth() {
					return slider.children[0].offsetWidth + 32;
				}

				nextBtn.addEventListener('click', () => {
					slider.scrollBy({ left: getItemWidth(), behavior: 'smooth' });
				});

				prevBtn.addEventListener('click', () => {
					slider.scrollBy({ left: -getItemWidth(), behavior: 'smooth' });
				});
			</script>
		</section>

		<!-- Depoimentos -->
		<section id="depoimentos" class="bg-gray-800 border border-gray-700 rounded-2xl p-6 sm:p-8 shadow-xl">
			<h2 class="text-2xl font-bold text-white text-center mb-6 pb-3 border-b border-gray-700">💬 Depoimentos</h2>

			<div class="space-y-6">
				<div class="p-6 bg-gray-900 border border-gray-700 rounded-xl">
					<p class="text-lg text-gray-300 italic">"Vou ser o primeiro do ranking."</p>
					<p class="mt-4 font-bold text-lg text-white">Sérgio Rodrigues Amorin</p>
				</div>

				<div class="p-6 bg-gray-900 border border-gray-700 rounded-xl">
					<p class="text-lg text-gray-300 italic">"A aprendizagem é um processo contínuo. Devemos estudar diariamente, analisar os resultados regularmente e aplicar métodos para melhorar os nossos resultados anteriores."</p>
					<p class="mt-4 font-bold text-lg text-white">Victor</p>
				</div>

				<div class="p-6 bg-gray-900 border border-gray-700 rounded-xl">
					<p class="text-lg text-gray-300 italic">"Com o Pomodoros.com.br consigo ter mais controle sobre meu tempo, ser mais produtivo e realizar melhor minhas tarefas."</p>
					<p class="mt-4 font-bold text-lg text-white">Francisco Mat</p>
				</div>

				<div class="p-6 bg-gray-900 border border-gray-700 rounded-xl">
					<p class="text-lg text-gray-300 italic">"Utilizava o Pomodoros.com.br há alguns anos, diariamente. Fiquei feliz de saber que o site voltou, espero que as pessoas voltem a usar, vou tentar pegar o hábito também porque 'super' me ajudava!"</p>
					<p class="mt-4 font-bold text-lg text-white">Camila Almeida Magalhães</p>
				</div>
			</div>
		</section>

	</div>
</div>
