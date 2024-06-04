<div class="dso-main">
	<div class="dso-support-header">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<div class="dso-lg-content">
	                    <h1>
	                        Hello!
	                        <span>How can we help?</span>
	                    </h1>
	                    <p data-aos-delay="300" data-aos="fade-up">Search our knowledge base or browse categories below.</p>
	                </div>
				</div>

				<div class="col-md-5">
					<div class="search-wrap">
						<form method="POST" action="<?= base_url(); ?>support/search" class="search-support">
							<input type="search" name="query" id="query" class="form-control" placeholder="Ask a question or search for a keyword" autocomplete="off" aria-label="">
							<button type="button"><i class="fa fa-search"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="pad-120">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="dso-articles-sidebar">
						 <div class="content-wrapper">
	            			<h3>Articles in this section</h3>
	            		</div>

	            		<ul class="sidebar-nav">
							<?php foreach($allArticles as $article): ?>		
							<?php 
								$current = ($article->slug == $articlesData[0]->slug) ? 'class="article-nav-current"' : '';
							?>
							<li>
								<a href="<?= base_url(); ?>support/<?= $ct_slug; ?>/<?= $article->slug; ?>" <?= $current; ?>><?= $article->title; ?></a>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

				<div class="col-md-8">
					<div class="article">
				    	<div class="article-header">
					        <h1 title="How can I contact you?" class="article-title"><?= $articlesData[0]->title; ?></h1>
				      	</div>

				      	<div class="article-info">
				        	<div class="article-content">
				          		<div class="article-body">
				          			<?= $articlesData[0]->answer; ?>
								</div>
				        	</div>
				      	</div>
				    </div>

				    <div class="article-votes">
			            <h4 class="title-small">Was this article helpful?</h4>

			            <div class="article-votes-controls">
			            	<a href="<?= base_url() . 'login'; ?>" class="btn dso-ebtn dso-ebtn-outline">
                                <span class="dso-btn-text"><i class="fa fa-check"></i> Yes</span>
                                <div class="dso-btn-bg-holder"></div>
                            </a>

                            <a href="<?= base_url() . 'login'; ?>" class="btn dso-ebtn dso-ebtn-solid">
                                <span class="dso-btn-text"><i class="fa fa-times"></i> No</span>
                                <div class="dso-btn-bg-holder"></div>
                            </a>
			            </div>
			            <p class="article-votes-count">
			             	<span class="article-vote-label">0 out of 0 found this helpful</span>
			            </p>
			       </div>
				</div>
			</div>

			<div class="row align-items-center mg-t-80">
				<div class="col-md-7">
					<div class="content-wrapper" data-aos="zoom-in-right">
						<h3>Still Need Help?</h3>

						<p>Don't know what to look for? Have a specific question?</p>
						<a href="<?= base_url(); ?>support/requests/new" class="btn dso-ebtn dso-ebtn-solid">
	                        <span class="dso-btn-text">Contact Us</span>
	                        <div class="dso-btn-bg-holder"></div>
	                    </a>
					</div>
				</div>

				<div class="col-md-5">
					<div class="img-full" data-aos="zoom-in-left">
						<img src="<?= base_url(); ?>assets/frontend/images/support-2.png" />
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>