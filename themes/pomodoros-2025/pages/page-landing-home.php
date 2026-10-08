

<div id="home-landing-page">
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg m-3">
        <!-- Layout com 2 colunas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Coluna Principal -->
            <div class="col-span-1 p-6">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Relaxa e Foca</h2>
                <p class="text-gray-700 mb-4">A chave para o sucesso é investir bem seu recurso mais valioso, seu tempo!</p>
				<p class="text-gray-700 mb-4">Cronômetro online para tarefas e projetos, você e seu time mais produtivos do que nunca</p>
                <p class="text-gray-700"><a href="/register" class="inline-block bg-green-800 text-white font-semibold py-2 px-8 rounded-lg hover:bg-green-600 transition duration-300">🚀 Registre-se Grátis</a></p>
            </div>

            <!-- Coluna Secundária -->
            <div class="col-span-1 bg-gray-200 p-6 shadow-md">
                <?php if (!is_user_logged_in()) { ?>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Entrar</h2>
                    <div id="loginlogbox">
                        <?php wp_login_form(); ?>
                        <div style="margin-top:-10px;">
                            <?php do_action('wordpress_social_login'); ?>
                            <div style="margin-top: -40px;">
                                <?php do_action('bp_after_sidebar_login_form'); ?>
                            </div>
                        </div>
                    </div>
				<?php } else { ?>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4"><?php echo 'Olá, ' . wp_get_current_user()->display_name; ?> </h2>
                    
                    <p class="text-gray-700 mb-4">Você já fez seus pomodoros hoje?</p>
                    <p class="text-gray-700"><a class="rounded-md bg-purple-700 px-3 py-2 text-sm font-medium text-white" title="Focus" href="/focus/">
							<span class="fas fa-stopwatch" aria-hidden="true"></span>
							Focar
						</a></p>
                    
                <?php } ?>
            </div>
        </div>
    </div>
	
    <div id="funcionalidades" class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg m-3">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6 pb-3">🛠️ Funcionalidades</h2>
        <!-- Abas -->
        <div class="flex flex-wrap border-b border-gray-300 w-full overflow-x-auto px-1">
            <!-- Aba Google Calendar -->
            <button class="tab-button px-4 py-2 text-lg font-semibold text-gray-600 focus:ring-2 flex items-center gap-2 sm:flex-grow w-full justify-center" data-tab="tab1">
                <i class="fas fa-calendar-alt"></i> Google
            </button>
            <!-- Aba Timer Pomodoros -->
            <button class="tab-button px-4 py-2 text-lg font-semibold text-gray-600 focus:ring-2 flex items-center gap-2 sm:flex-grow w-full justify-center" data-tab="tab2">
                <i class="fas fa-clock"></i> Timer
            </button>
            <!-- Aba Calendário Comunidade -->
            <button class="tab-button px-4 py-2 text-lg font-semibold text-gray-600 focus:ring-2 flex items-center gap-2 sm:flex-grow w-full justify-center" data-tab="tab3">
                <i class="fas fa-users"></i> Comunidade
            </button>
            <!-- Aba Ranking e Prêmios -->
            <button class="tab-button px-4 py-2 text-lg font-semibold text-gray-600 focus:ring-2 flex items-center gap-2 sm:flex-grow w-full justify-center" data-tab="tab4">
                <i class="fas fa-trophy"></i> Prêmios
            </button>
            <!-- Aba Relatórios Fantásticos -->
            <button class="tab-button px-4 py-2 text-lg font-semibold text-gray-600 focus:ring-2 flex items-center gap-2 sm:flex-grow w-full justify-center" data-tab="tab5">
                <i class="fas fa-chart-line"></i> Relatórios
            </button>
        </div>

        <!-- Conteúdo das abas -->
        <div class="tab-content md:text-xl lg:text-2xl active" id="tab1">
            <div class="p-4">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/images/banners/gcal.jpg" alt="Imagem 1" class="w-full h-64 object-cover rounded-lg mb-4">
                <p class="text-gray-700">Com a exportação do iCal feed, você pode visualizar seus pomodoros nos principais calendários, como Google, Apple e Outlook, permitindo integração e organização perfeitas entre suas tarefas e compromissos diários.</p>
            </div>
        </div>
        <div class="tab-content md:text-xl lg:text-2xl" id="tab2">
            <div class="p-4">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/images/banners/timer.jpg" alt="Imagem 2" class="w-full h-64 object-cover rounded-lg mb-4">
                <p class="text-gray-700">O coração do Pomodoros.com.br é o timer exclusivo de pomodoros. Ele ajuda a melhorar sua produtividade ao dividir seu tempo em blocos de trabalho e descanso, otimizando o desempenho ao longo do dia.</p>
            </div>
        </div>
        <div class="tab-content md:text-xl lg:text-2xl" id="tab3">
            <div class="p-4">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/images/banners/calendar.jpg" alt="Imagem 3" class="w-full h-64 object-cover rounded-lg mb-4">
                <p class="text-gray-700">A comunidade se sente mais motivada e engajada ao compartilhar seus resultados no calendário, incentivando um ambiente colaborativo e positivo para o crescimento de todos.</p>
            </div>
        </div>
        <div class="tab-content md:text-xl lg:text-2xl" id="tab4">
            <div class="p-4">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/images/banners/ranking.jpg" alt="Imagem 4" class="w-full h-64 object-cover rounded-lg mb-4">
                <p class="text-gray-700">Nosso sistema de ranking único permite acompanhar seu desempenho em tempo real e ganhar prêmios conforme sua produtividade, transformando a organização de tarefas em um jogo de conquistas.</p>
            </div>
        </div>
        <div class="tab-content md:text-xl lg:text-2xl" id="tab5">
            <div class="p-4">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/images/banners/tasks.jpg" alt="Imagem 5" class="w-full h-64 object-cover rounded-lg mb-4">
                <p class="text-gray-700">Com os relatórios fantásticos gerados automaticamente, você consegue acompanhar sua produtividade, identificar padrões e aprimorar a gestão do seu tempo ao longo do tempo.</p>
            </div>
        </div>

        <style>
            /* Aba selecionada - Destaque */
            .tab-button.active {
                background-color: rgb(196, 225, 254);
                border-bottom: 2px solid #007bff;
                color: #007bff;
            }

            /* Aba não selecionada */
            .tab-button:not(.active) {
                background-color: #fafafa;
                color: #b0b0b0;
            }

            /* Ajuste da largura das abas */
            .tab-button {
                flex-grow: 1; /* As abas ocupam o espaço disponível de maneira proporcional */
                flex-basis: 20%; /* Cada aba tem um tamanho base de 20% */
                white-space: nowrap;
                justify-content: center;
                border-top-left-radius: 12px;
                border-top-right-radius: 12px;
            }

            /* Ajustes para a área de abas em telas menores */
            @media (max-width: 640px) {
                .tab-button {
                    flex-basis: 100%; /* Cada aba ocupa 100% da largura */
                }
            }

            /* Evita que as abas empilhem e permite o scroll horizontal */
            .tab-content {
                display: none; /* Oculta todas as abas inicialmente */
            }

            .tab-content.active {
                display: block; /* Exibe a aba ativa */
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Definir o primeiro botão e seu conteúdo como ativos
                const firstButton = document.querySelector('.tab-button');
                firstButton.classList.add('active');
                const firstTabContent = document.getElementById(firstButton.getAttribute('data-tab'));
                firstTabContent.classList.add('active');

                // Script para alternar a classe ativa
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.addEventListener('click', () => {
                        // Remove a classe 'active' de todas as abas
                        document.querySelectorAll('.tab-button').forEach(tab => {
                            tab.classList.remove('active');
                        });

                        // Adiciona a classe 'active' à aba clicada
                        button.classList.add('active');

                        // Oculta o conteúdo de todas as abas
                        document.querySelectorAll('.tab-content').forEach(content => {
                            content.classList.remove('active');
                        });

                        // Exibe o conteúdo da aba clicada
                        const tabContent = document.getElementById(button.getAttribute('data-tab'));
                        tabContent.classList.add('active');
                    });
                });
            });
        </script>
    </div>

    <div id="comunidades" class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg m-3">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6 pb-3">📊 Estatísticas da Comunidade</h2>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <div class="flex items-center p-4 bg-blue-50 rounded-lg shadow-sm">
                <i class="fas fa-users text-blue-600 text-xl mr-3"></i>
                <div>
                    <span class="text-xl font-bold text-blue-600 counter" data-target="225">0</span>
                    <p class="text-sm text-gray-700">Usuários Ativos</p>
                </div>
            </div>
            
            <div class="flex items-center p-4 bg-green-50 rounded-lg shadow-sm">
                <i class="fas fa-stopwatch text-green-600 text-xl mr-3"></i>
                <div>
                    <span class="text-xl font-bold text-green-600 counter" data-target="12997">0</span>
                    <p class="text-sm text-gray-700">Pomodoros Feitos</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-yellow-50 rounded-lg shadow-sm">
                <i class="fas fa-clock text-yellow-600 text-xl mr-3"></i>
                <div>
                    <span class="text-xl font-bold text-yellow-600 counter" data-target="6499">0</span>
                    <p class="text-sm text-gray-700">Tempo Cronometrado</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-purple-50 rounded-lg shadow-sm">
                <i class="fas fa-tags text-purple-600 text-xl mr-3"></i>
                <div>
                    <span class="text-xl font-bold text-purple-600 counter" data-target="564">0</span>
                    <p class="text-sm text-gray-700">Tags dos Projetos</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-red-50 rounded-lg shadow-sm">
                <i class="fas fa-city text-red-600 text-xl mr-3"></i>
                <div>
                    <span class="text-xl font-bold text-red-600 counter" data-target="19">0</span>
                    <p class="text-sm text-gray-700">Cidades Rankeadas</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-indigo-50 rounded-lg shadow-sm">
                <i class="fas fa-language text-indigo-600 text-xl mr-3"></i>
                <div>
                    <span class="text-xl font-bold text-indigo-600 counter" data-target="5">0</span>
                    <p class="text-sm text-gray-700">Traduções</p>
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
                        
                        // Ajusta o incremento baseado no tamanho do número
                        const increment = target / 100;
                        
                        // Tempo base de atualização (ajustável para suavidade)
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
    </div>

    <div id="historico" class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg m-3">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6 pb-3">📆 Breve Histórico</h2>
            <div class="relative">
                <!-- Botões de navegação -->
                <button id="prevBtn" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-2 rounded-full shadow-lg z-10">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <button id="nextBtn" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-2 rounded-full shadow-lg z-10">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <!-- Slider container -->
                <div id="slider" class="flex space-x-8 overflow-x-hidden scroll-smooth snap-x snap-mandatory">
                    <!-- Evento 2010 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-blue-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2010 - Planos Iniciais</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Francisco, CEO e fundador, testou muitos softwares de pomodoros e decidiu construir o seu próprio, para ter registro digital das tarefas feitas.</p>
                    </div>

                    <!-- Evento 2011 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-red-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2011 - Pomodoros Red</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-red.jpg" alt="Pomodoros Red" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Primeira versão, já online, social e com cronômetro em JavaScript assíncrono, baseado em WordPress e BuddyPress.</p>
                    </div>

                    <!-- Evento 2012 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-red-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2012 - Pomodoros Red</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-red.jpg" alt="Pomodoros Red" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Crescimento significativo baseado em reviews espontâneos em blogs, sem investimento em marketing.</p>
                    </div>

                    <!-- Evento 2013 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-green-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2013 - Pomodoros Green</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-green.jpg" alt="Pomodoros Green" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Muitos updates para participar de um concurso de startups no Brasil, mas sem atrair investidores.</p>
                    </div>

                    <!-- Evento 2014 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-green-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2014 - Pomodoros Green</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-green.jpg" alt="Pomodoros Green" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Crescimento orgânico. Fundador parou o projeto para se dedicar ao mestrado. Serviço estável e operacional.</p>
                    </div>

                    <!-- Evento 2015 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-green-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2015 - Pomodoros Green</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-green.jpg" alt="Pomodoros Green" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Alto custo de manutenção, muitas migrações e quedas do serviço. Perda rápida de usuários.</p>
                    </div>

                    <!-- Evento 2016 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-yellow-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2016 - Laboratório</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">O serviço foi desativado devido a falta de recursos, resultando na perda de todos os usuários.</p>
                    </div>

                    <!-- Evento 2017 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-yellow-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2017 - Laboratório</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center"> Muitos testes e experiências, instabilidade frequente. Nova configuração de servidor, foco em escalabilidade.</p>
                    </div>

                    <!-- Evento 2018 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-black rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2018 - Pomodoros Black</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-black.jpg" alt="Pomodoros Black" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Finalmente voltamos 'mobile first', com aplicativo web e mobile. Palestras Treinamento em Foco.</p>
                    </div>

                    <!-- Evento 2019 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-black rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2019 - Pomodoros Black</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-black.jpg" alt="Pomodoros Black" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Novamente fundador precisou se dedicar a projetos de terceiros e novo hiato acontece.</p>
                    </div>

                    <!-- Evento 2020 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-yellow-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2020 - Laboratório</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">O site estava funcionando, porém somente o fundador conseguia usar devido a bugs.</p>
                    </div>

                    <!-- Evento 2021 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-yellow-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2021 - Laboratório</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Completa falta de recursos deixa o site parado no ar sem atualizações.</p>
                    </div>

                    <!-- Evento 2022 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-yellow-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2022 - Laboratório</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">O site recebe apenas manutenção básica para permanecer no ar, preservando o domínio</p>
                    </div>

                    <!-- Evento 2023 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-yellow-500 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2023 - Laboratório</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-offline.jpg" alt="Pomodoros Offline" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Devido a tecnologia já ultrapassada, PHP e WordPress, o pomodoros vira um problema técnico</p>
                    </div>

                    <!-- Evento 2024 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-purple-600 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2024 - Pomodoros Purple</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-purple-lq.png" alt="Pomodoros Global" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">O projeto ganha atualizações dentro do contexto da consultoria de lançamento de 90 dias, projetos da f5sites</p>
                    </div>

                    <!-- Evento 2025 -->
                    <div class="flex flex-col items-center">
                        <div class="w-6 h-6 mt-2 bg-purple-600 rounded-full border-4 border-white shadow-xl"></div>
                        <div class="w-32 h-2 bg-gray-300 rounded-lg mt-2"></div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-2">2025 - Pomodoros Purple</h3>
                        <img src="https://www.pomodoros.com.br/wp-content/themes/pomodoros-2025/images/pomo-versions/pomodoros-purple-lq.png" alt="Pomodoros Global" class="mt-2 w-full max-w-xs rounded-lg shadow-md">
                        <p class="text-gray-600 text-center">Começa o enorme esforço de migração para um contexto tecnológico moderno e atualizações para marketing</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const slider = document.getElementById('slider');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
        
            function getItemWidth() {
                return slider.children[0].offsetWidth + 32; // Largura do item + espaçamento (8 * 4px)
            }
        
            nextBtn.addEventListener('click', () => {
                slider.scrollBy({ left: getItemWidth(), behavior: 'smooth' });
            });
        
            prevBtn.addEventListener('click', () => {
                slider.scrollBy({ left: -getItemWidth(), behavior: 'smooth' });
            });
        </script>
    </div>

    <div id="depoimentos" class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg m-3">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6 pb-3">💬 Depoimentos</h2>

        <div class="space-y-8">
            <!-- Depoimento 1 -->
            <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                <p class="text-xl text-gray-700 italic">"Vou ser o primeiro do ranking."</p>
                <p class="mt-4 font-bold text-lg text-gray-800">Sérgio Rodrigues Amorin</p>
            </div>

            <!-- Depoimento 2 -->
            <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                <p class="text-xl text-gray-700 italic">"A aprendizagem é um processo contínuo. Devemos estudar diariamente, analisar os resultados regularmente e aplicar métodos para melhorar os nossos resultados anteriores."</p>
                <p class="mt-4 font-bold text-lg text-gray-800">Victor</p>
            </div>

            <!-- Depoimento 3 -->
            <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                <p class="text-xl text-gray-700 italic">"Com o Pomodoros.com.br consigo ter mais controle sobre meu tempo, ser mais produtivo e realizar melhor minhas tarefas."</p>
                <p class="mt-4 font-bold text-lg text-gray-800">Francisco Mat</p>
            </div>

            <!-- Depoimento 4 -->
            <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                <p class="text-xl text-gray-700 italic">"Utilizava o Pomodoros.com.br há alguns anos, diariamente. Fiquei feliz de saber que o site voltou, espero que as pessoas voltem a usar, vou tentar pegar o hábito também porque 'super' me ajudava!"</p>
                <p class="mt-4 font-bold text-lg text-gray-800">Camila Almeida Magalhães</p>
            </div>
        </div>
    </div>
</div>