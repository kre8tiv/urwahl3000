				<div id="sidebar1" class="sidebar threecol last clearfix" role="complementary">
					

					<?php if ( is_active_sidebar('infospalte') ) : ?>
						<ul>
						<?php dynamic_sidebar('infospalte'); ?>
						</ul>
					<?php else : ?>

						<!-- This content shows up if there are no widgets defined in the backend. -->
						
						<ul>
							<li class="widget">
								<h3 class="widgettitle">Hier ist nichts</h3>
								<p>Bitte füge unter "Design » Widgets" Inhalte hinzu.</p>
							</li>
						</ul>
							
						

					<?php endif; ?>

				</div>