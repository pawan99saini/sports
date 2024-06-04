<div class="dso-main">
	<div class="dso-support-header">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<div class="dso-lg-content">
	                    <h1>
	                        Hello!
	                        <span>How Can We Help</span>
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
			<div class="verticle-heading">
                <span class="text-rotate text-white text-upercase">Articles</span>
                <div class="dso-sec-heading">
                    <h2>Search Results</h2>
                </div>
            </div>

			<div class="sp-wrap">
				<ul class="article-list">
					<?php foreach($articlesData as $article): ?>
					<li class="article-list-item">
						<?php 
							$title = str_replace($userSearch, '<strong>' . $userSearch . '</strong>', $article->title);
						?>
						<a href="<?= base_url(); ?>support/<?= $article->category_slug; ?>/<?= $article->slug; ?>"><?= $title; ?></a>
					</li>
					<?php endforeach; ?>
              	</ul>
			</div>	

			<div class="mg-t-80">
				<div class="row align-items-center">
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